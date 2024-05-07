<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Console\Commands\TaskReminderCommand;
use App\Mail\TaskReminderMail;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class TaskReminderTest extends TestCase
{
    use RefreshDatabase;

    public function test_reminder_email_sent_for_due_tasks()
    {
        // Mock the Mail facade
        Mail::fake();

        // Create a user
        $user = User::factory()->create();

        // Create a task due tomorrow
        $dueDateTomorrow = Carbon::tomorrow()->toDateString();
        $task = Task::factory()->create([
            'due_date' => $dueDateTomorrow,
            'created_by' => $user->id,
        ]);

        // Run the task reminder command
        $this->artisan('reminders:send');

        // Assert that the reminder email was sent for the due task
        Mail::assertSent(TaskReminderMail::class, function ($mail) use ($task) {
            return $mail->task->id === $task->id;
        });
    }
}
