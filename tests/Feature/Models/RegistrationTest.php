<?php

namespace Tests\Feature\Models;

use App\Enums\RegistrationStatusEnum;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_check_if_it_is_a_draft(): void
    {
        $registration = new Registration(['status_registration' => RegistrationStatusEnum::Draft]);

        $this->assertTrue($registration->isDraft());
        $this->assertFalse($registration->isFinished());
    }

    public function test_it_can_check_if_it_is_finished(): void
    {
        $registration = new Registration(['status_registration' => RegistrationStatusEnum::Finished]);

        $this->assertTrue($registration->isFinished());
        $this->assertFalse($registration->isDraft());
    }

    public function test_it_returns_false_for_other_statuses(): void
    {
        $registration = new Registration(['status_registration' => RegistrationStatusEnum::Cancelled]);

        $this->assertFalse($registration->isDraft());
        $this->assertFalse($registration->isFinished());
    }
}
