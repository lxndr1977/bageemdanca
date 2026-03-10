<?php

namespace Tests\Feature;

use App\Models\DanceStyle;
use App\Models\Choreography;
use App\Models\ChoreographyCategory;
use App\Models\ChoreographyType;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DanceStyleResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_delete_dance_style_without_choreographies(): void
    {
        $danceStyle = DanceStyle::create(['name' => 'Style 1']);

        $this->assertDatabaseHas('dance_styles', ['id' => $danceStyle->id]);

        $danceStyle->delete();

        $this->assertDatabaseMissing('dance_styles', ['id' => $danceStyle->id]);
    }

    public function test_cannot_delete_dance_style_with_choreographies(): void
    {
        $user = User::factory()->create();
        $school = School::create([
            'user_id' => $user->id,
            'name' => 'Test School',
            'responsible_name' => 'Resp',
            'responsible_email' => 'resp@example.com',
            'responsible_phone' => '123',
            'city' => 'Test City',
            'state' => 'TS',
        ]);
        $type = ChoreographyType::create([
            'name' => 'Type 1',
            'min_dancers' => 1,
            'max_dancers' => 10,
        ]);
        $category = ChoreographyCategory::create(['name' => 'Category 1']);
        $danceStyle = DanceStyle::create(['name' => 'Style 1']);
        
        Choreography::forceCreate([
            'dance_style_id' => $danceStyle->id,
            'name' => 'Test Choreography',
            'music' => 'Test Music',
            'duration' => '03:00',
            'music_composer' => 'Test Composer',
            'school_id' => $school->id,
            'choreography_type_id' => $type->id,
            'choreography_category_id' => $category->id,
        ]);

        $this->assertDatabaseHas('dance_styles', ['id' => $danceStyle->id]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Não é possível excluir: esta modalidade possui coreografias associadas.');

        $danceStyle->delete();

        $this->assertDatabaseHas('dance_styles', ['id' => $danceStyle->id]);
    }
}
