<p>Dear {{ $user->name }},</p>

<p>A new task has been assigned to you:</p>

<p><strong>Title:</strong> {{ $task->title }}</p>
<p><strong>Description:</strong> {{ $task->description }}</p>
<p><strong>Deadline:</strong> {{ $task->deadline->format('M d, Y H:i A') }}</p>

<p>Please log in to the system to view more details and update the task status.</p>

<p>Thank you,</p>
<p>Your Task Management Team</p>