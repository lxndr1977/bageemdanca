<?php

namespace Tests\Feature;

use App\Models\Registration;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_user_without_registrations(): void
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_cannot_delete_user_with_registrations(): void
    {
        $user = User::factory()->create();
        $school = School::factory()->create(['user_id' => $user->id]);
        Registration::factory()->create(['school_id' => $school->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível excluir: este usuário possui inscrições vinculadas através de suas escolas.');

        $user->delete();

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
