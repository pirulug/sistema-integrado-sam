<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicLookupTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('landing');
        $response->assertSee('SISAM');
    }

    public function test_public_lookup_with_empty_dni_redirects_home(): void
    {
        $response = $this->get('/consulta');

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'Por favor, ingrese un número de DNI.');
    }

    public function test_public_lookup_with_invalid_dni_redirects_home(): void
    {
        $response = $this->get('/consulta?dni=99999999');

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error', 'El DNI ingresado no corresponde a ningún estudiante registrado.');
    }

    public function test_public_lookup_with_valid_dni_shows_student_graduation(): void
    {
        $student = Student::create([
            'dni' => '91578591',
            'student_code' => 'EST2019001',
            'study_program' => 'Diseño y programación web',
            'paternal_last_name' => 'Towne',
            'maternal_last_name' => 'Smith',
            'first_name' => 'Marcelina',
            'personal_email' => 'marcelina.towne@gmail.com',
            'institutional_email' => 'mtowne@instituto.edu.pe',
            'phone' => '014567890',
            'mobile' => '959705580',
            'admission_date' => '2019-03-15',
        ]);

        $response = $this->get("/consulta?dni={$student->dni}");

        $response->assertStatus(200);
        $response->assertViewIs('graduation.public_show');
        $response->assertViewHas('student');
        $response->assertSee('Marcelina');
    }
}
