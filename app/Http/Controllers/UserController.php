<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $search = $request->query("search");
        $roleFilter = $request->query("role");

        $query = User::with("teacher")->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%")
                    ->orWhere("dni", "like", "%{$search}%");
            });
        }

        if (!empty($roleFilter) && in_array($roleFilter, ["admin", "teacher", "auditor", "student"])) {
            $query->where("role", $roleFilter);
        }

        $users = $query->paginate(15)->withQueryString();

        // Statistics
        $totalUsers = User::count();
        $totalAdmins = User::where("role", "admin")->count();
        $totalAuditors = User::where("role", "auditor")->count();
        $totalTeachersWithUser = User::where("role", "teacher")->count();
        $totalTeachersWithoutUser = Teacher::whereNull("user_id")->count();

        return view("users.index", compact(
            "users",
            "search",
            "roleFilter",
            "totalUsers",
            "totalAdmins",
            "totalAuditors",
            "totalTeachersWithUser",
            "totalTeachersWithoutUser"
        ));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(Request $request): View
    {
        $selectedTeacherId = $request->query("teacher_id");
        $selectedTeacher = null;

        if ($selectedTeacherId) {
            $selectedTeacher = Teacher::find($selectedTeacherId);
        }

        // Unassigned teachers list for easy selection
        $unassignedTeachers = Teacher::whereNull("user_id")->orderBy("paternal_last_name")->get();

        return view("users.create", compact("unassignedTeachers", "selectedTeacher"));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $role = $request->input("role", "admin");

        if ($role === "teacher") {
            $request->validate([
                "teacher_id" => "required|exists:teachers,id",
                "password" => ["required", "confirmed", Password::min(6)],
            ], [
                "teacher_id.required" => "Debe seleccionar un profesor registrado en la base de datos.",
                "teacher_id.exists" => "El profesor seleccionado no es válido.",
                "password.required" => "La contraseña es obligatoria.",
                "password.min" => "La contraseña debe tener al menos 6 caracteres.",
                "password.confirmed" => "La confirmación de contraseña no coincide.",
            ]);

            $teacher = Teacher::findOrFail($request->input("teacher_id"));

            // If teacher already has user account
            if ($teacher->user_id) {
                return back()->withInput()->withErrors([
                    "teacher_id" => "Este profesor ya cuenta con una cuenta de usuario asignada.",
                ]);
            }

            // Check if institutional email is already taken by another user
            $existingUserWithEmail = User::where("email", $teacher->institutional_email)->first();
            if ($existingUserWithEmail) {
                return back()->withInput()->withErrors([
                    "teacher_id" => "El correo institucional del profesor ({$teacher->institutional_email}) ya está registrado como usuario.",
                ]);
            }

            $user = User::create([
                "name" => $teacher->full_name,
                "dni" => $teacher->dni,
                "email" => $teacher->institutional_email,
                "password" => Hash::make($request->input("password")),
                "role" => "teacher",
                "photo_path" => $teacher->photo_path,
            ]);

            $teacher->update([
                "user_id" => $user->id,
            ]);

            return redirect()->route("users.index")
                ->with("success", "Usuario creado y asignado exitosamente al profesor {$teacher->full_name}. Correo de acceso: {$teacher->institutional_email}");
        }

        // Generic user creation (Admin, Auditor or standalone Teacher)
        $rules = [
            "name" => "required|string|max:255",
            "dni" => "nullable|string|max:20|unique:users,dni",
            "role" => "required|in:admin,teacher,auditor",
            "password" => ["required", "confirmed", Password::min(6)],
            "photo" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
        ];

        if ($role === "teacher") {
            $rules["email"] = "required|email|ends_with:@sam.edu.pe|unique:users,email|max:255";
        } else {
            $rules["email"] = "required|email|unique:users,email|max:255";
        }

        $validated = $request->validate($rules, [
            "email.ends_with" => "Para usuarios con rol de profesor, el correo debe ser institucional (@sam.edu.pe).",
            "email.unique" => "Este correo electrónico ya se encuentra registrado.",
            "password.confirmed" => "La confirmación de contraseña no coincide.",
        ]);

        if ($request->hasFile("photo")) {
            $validated["photo_path"] = $request->file("photo")->store("users", "public");
        }

        $validated["password"] = Hash::make($validated["password"]);

        User::create($validated);

        return redirect()->route("users.index")
            ->with("success", "Usuario {$validated['name']} ({$validated['role']}) creado exitosamente.");
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $user->load("teacher");
        return view("users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $user->load("teacher");
        $unassignedTeachers = Teacher::whereNull("user_id")
            ->orWhere("user_id", $user->id)
            ->orderBy("paternal_last_name")
            ->get();

        return view("users.edit", compact("user", "unassignedTeachers"));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // For teacher users: personal data comes from teachers table, here only password can be updated
        if ($user->role === "teacher") {
            $validated = $request->validate([
                "password" => ["nullable", "confirmed", Password::min(6)],
            ], [
                "password.min" => "La contraseña debe tener al menos 6 caracteres.",
                "password.confirmed" => "La confirmación de la contraseña no coincide.",
            ]);

            if (!empty($validated["password"])) {
                $user->update([
                    "password" => Hash::make($validated["password"]),
                ]);
                return redirect()->route("users.index")
                    ->with("success", "Contraseña del profesor {$user->name} actualizada exitosamente.");
            }

            return redirect()->route("users.index")
                ->with("info", "No se realizaron cambios en el usuario {$user->name}. Para editar sus datos personales, use el módulo de Profesores.");
        }

        // For admin and auditor users: allow editing name, dni, email, role, password
        $rules = [
            "name" => "required|string|max:255",
            "dni" => "nullable|string|max:20|unique:users,dni," . $user->id,
            "role" => "required|in:admin,auditor,student",
            "email" => "required|email|max:255|unique:users,email," . $user->id,
            "password" => ["nullable", "confirmed", Password::min(6)],
            "photo" => "nullable|image|mimes:jpeg,png,jpg,webp|max:2048",
            "remove_photo" => "nullable|boolean",
        ];

        $validated = $request->validate($rules, [
            "email.unique" => "Este correo electrónico ya pertenece a otro usuario.",
            "password.confirmed" => "La confirmación de contraseña no coincide.",
        ]);

        if ($request->boolean("remove_photo")) {
            if ($user->photo_path) {
                Storage::disk("public")->delete($user->photo_path);
            }
            $validated["photo_path"] = null;
        } elseif ($request->hasFile("photo")) {
            if ($user->photo_path) {
                Storage::disk("public")->delete($user->photo_path);
            }
            $validated["photo_path"] = $request->file("photo")->store("users", "public");
        }

        if (!empty($validated["password"])) {
            $validated["password"] = Hash::make($validated["password"]);
        } else {
            unset($validated["password"]);
        }

        $user->update($validated);

        return redirect()->route("users.index")
            ->with("success", "Usuario {$user->name} actualizado exitosamente.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with("error", "Acción no permitida: No puede eliminar su propia cuenta de usuario.");
        }

        // Unlink associated teacher
        if ($user->teacher) {
            $user->teacher->update(["user_id" => null]);
        }

        if ($user->photo_path) {
            Storage::disk("public")->delete($user->photo_path);
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route("users.index")
            ->with("success", "Usuario {$name} eliminado exitosamente.");
    }

    /**
     * Reset user password by administrator.
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            "password" => ["required", "confirmed", Password::min(6)],
        ], [
            "password.required" => "La nueva contraseña es obligatoria.",
            "password.min" => "La nueva contraseña debe tener al menos 6 caracteres.",
            "password.confirmed" => "La confirmación de la contraseña no coincide.",
        ]);

        $user->update([
            "password" => Hash::make($request->input("password")),
        ]);

        ActivityLog::record(
            action: "password_reset",
            module: "Usuarios",
            description: "Restableció la contraseña del usuario: {$user->name} ({$user->email})",
            subjectLabel: "{$user->name} ({$user->email})",
            subject: $user
        );

        return back()->with("success", "La contraseña del usuario {$user->name} ({$user->email}) fue restablecida exitosamente.");
    }

    /**
     * Quick action to create user account for teacher from teachers list.
     */
    public function quickCreateTeacherUser(Request $request, Teacher $teacher): RedirectResponse
    {
        if ($teacher->user_id) {
            return back()->with("info", "El profesor {$teacher->full_name} ya cuenta con un usuario asignado.");
        }

        $existingUser = User::where("email", $teacher->institutional_email)->first();
        if ($existingUser) {
            // Link existing user if found
            $teacher->update(["user_id" => $existingUser->id]);
            return back()->with("success", "Se vinculó el usuario existente ({$existingUser->email}) al profesor {$teacher->full_name}.");
        }

        $password = $request->input("password", "docente123");

        $user = User::create([
            "name" => $teacher->full_name,
            "dni" => $teacher->dni,
            "email" => $teacher->institutional_email,
            "password" => Hash::make($password),
            "role" => "teacher",
            "photo_path" => $teacher->photo_path,
        ]);

        $teacher->update([
            "user_id" => $user->id,
        ]);

        ActivityLog::record(
            action: "created",
            module: "Usuarios",
            description: "Creación rápida de cuenta de usuario para docente: {$teacher->full_name} ({$user->email})",
            subjectLabel: "{$teacher->full_name} ({$user->email})",
            subject: $user
        );

        return back()->with("success", "Cuenta de usuario creada exitosamente para {$teacher->full_name}. Email: {$teacher->institutional_email} | Contraseña temporal: {$password}");
    }
}
