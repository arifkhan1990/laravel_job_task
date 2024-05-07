<?php
// TaskReminderCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Mail\TaskReminderMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TaskReminderCommand extends Command
{
    protected $signature = 'reminders:send';

    protected $description = 'Task Pending reminder emails to this the tasks deadline!';

    public function handle()
    {
        // Retrieve tasks created today (assuming 'due_date' is the task creation date)
        $tomorrow = Carbon::tomorrow()->toDateString();
        $tasks = QueryBuilder::for(Task::class)->with('creator')
            ->whereDate('due_date', $tomorrow)
            ->withoutGlobalScope('creator')
            ->get();

        foreach ($tasks as $task) {
            Mail::to($task->creator->email)->send(new TaskReminderMail($task));
        }
        // $this->info('Count of tasks: ' . $tasks);
        $this->info('Reminder emails sent for tasks due today.');
    }
}
