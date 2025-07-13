<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Task Assigned</title>
    <style type="text/css">
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #4a6baf;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 30px;
        }

        .task-details {
            background-color: #f9f9f9;
            border-left: 4px solid #4a6baf;
            padding: 15px;
            margin: 20px 0;
        }

        .task-details p {
            margin: 8px 0;
        }

        .task-label {
            font-weight: bold;
            color: #4a6baf;
            display: inline-block;
            width: 100px;
        }

        .deadline {
            color: #d9534f;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            background-color: #4a6baf;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            color: #777777;
            font-size: 14px;
            border-top: 1px solid #eeeeee;
        }

        .highlight {
            font-weight: bold;
            color: #4a6baf;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>New Task Assigned</h1>
        </div>

        <div class="email-body">
            <p>Dear {{ $user->name }},</p>

            <p>A new task has been assigned to you in the Task Management System:</p>

            <div class="task-details">
                <p><span class="task-label">Title:</span> <span class="highlight">{{ $task->title }}</span></p>
                <p><span class="task-label">Description:</span> {{ $task->description }}</p>
                <p><span class="task-label">Deadline:</span> <span
                        class="deadline">{{ $task->deadline->format('M d, Y H:i A') }}</span></p>
            </div>

            <p>Please log in to the system to view more details and update the task status.</p>



            <p>If you have any questions about this task, please contact your manager.</p>

            <p>Best regards,</p>
            <p><strong>Task Management Team</strong></p>
        </div>

        <div class="email-footer">
            <p>This is an automated notification. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Task Management System. All rights reserved.</p>
        </div>
    </div>
</body>

</html>