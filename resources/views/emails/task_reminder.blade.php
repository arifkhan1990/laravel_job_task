<!DOCTYPE html>
<html>

<head>
    <title>Task Reminder</title>
</head>

<body>
    <h1>Task Reminder</h1>
    <p>Hello,</p>
    <p>This is a reminder for your task.</p>
    <p>Task Name: {{ $task->title }}</p>
    <p>Task Description: {{ $task->description }}</p>
    <p>Thank you!</p>
</body>

</html>
