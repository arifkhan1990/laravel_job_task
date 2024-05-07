<?php
// TaskReminderCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class TaskReminderCommand extends Command
{
    protected $signature = 'reminder:daily';

    protected $description = 'Task Pending reminder emails to this the tasks deadline!';

    public function handle()
    {
        // Retrieve tasks created today (assuming 'due_date' is the task creation date)
        $tomorrow = Carbon::tomorrow()->toDateString();
        $tasks = Task::whereDate('due_date', $tomorrow)->get();

        foreach ($tasks as $task) {
            // Send reminder email to the user who created the task
            Mail::to($task->creator->email)->send(new TaskReminderMail($task));
        }

        $this->info('Reminder emails sent for tasks due today.');
    }
}
