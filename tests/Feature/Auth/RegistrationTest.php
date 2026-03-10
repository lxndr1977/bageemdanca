<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        \App\Models\SystemConfiguration::factory()->create([
            'registration_start_date' => now()->subDays(1),
            'registration_end_date' => now()->addDays(1),
        ]);

        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_registration_screen_is_redirected_when_period_is_closed(): void
    {
        \App\Models\SystemConfiguration::factory()->closedPast()->create();

        $response = $this->get(route('register'));

        $response->assertRedirect(route('welcome'));
    }

    public function test_registration_button_is_hidden_on_login_page_when_period_is_closed(): void
    {
        \App\Models\SystemConfiguration::factory()->closedPast()->create();

        $response = $this->get('/login');

        $response->assertDontSee('Registrar-se');
        $response->assertDontSee(route('register'));
    }

    public function test_registration_button_is_visible_on_login_page_when_period_is_open(): void
    {
        \App\Models\SystemConfiguration::factory()->create([
            'registration_start_date' => now()->subDays(1),
            'registration_end_date' => now()->addDays(1),
        ]);

        $response = $this->get('/login');

        $response->assertSee('Registrar-se');
        $response->assertSee(route('register'));
    }

    public function test_new_users_can_register(): void
    {
        \App\Models\SystemConfiguration::factory()->create([
            'registration_start_date' => now()->subDays(1),
            'registration_end_date' => now()->addDays(1),
        ]);

        $response = Volt::test('auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register');

        $response
            ->assertHasNoErrors()
            ->assertRedirect(route('site', absolute: false));

        $this->assertAuthenticated();
    }
}
