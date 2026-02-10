<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        // Les nouveaux clients sont redirigés vers la page d'accueil
        $response->assertRedirect(route('home', absolute: false));

        // Vérifier que l'utilisateur a bien le rôle CLIENT
        $user = User::where('email', 'test@example.com')->first();
        $this->assertEquals('CLIENT', $user->role);
    }
}
