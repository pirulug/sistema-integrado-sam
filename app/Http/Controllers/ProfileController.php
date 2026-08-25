<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view("profile.edit", [
            "user" => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->name = $request->validated("name");
        $user->save();

        return Redirect::route("profile.edit")
            ->with("status", "profile-updated")
            ->with("success", "Información del perfil actualizada exitosamente.");
    }

    /**
     * Delete the user's account (Disabled).
     */
    public function destroy(Request $request): RedirectResponse
    {
        abort(403, "La eliminación de cuentas de usuario está deshabilitada desde el perfil. Esta acción solo puede ser gestionada por el administrador.");
    }
}
