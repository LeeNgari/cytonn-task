<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Task Assigned</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .email-header {
            background-color: #4a6baf;
            padding: 20px;
            color: white;
            text-align: center;
        }

        .email-header img {
            max-height: 40px;
            margin-bottom: 10px;
        }

        .email-header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 600;
        }

        .email-body {
            padding: 30px 25px;
        }

        .email-body p {
            font-size: 15px;
            margin-bottom: 16px;
        }

        .task-box {
            background-color: #f9f9f9;
            border-left: 4px solid #4a6baf;
            padding: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .task-box p {
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

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a6baf;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .email-footer {
            font-size: 13px;
            text-align: center;
            color: #777;
            padding: 20px;
            border-top: 1px solid #eaeaea;
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">

            <img src="https://res.cloudinary.com/du74ofrgc/image/upload/v1752508081/Screenshot_from_2025-07-14_15-16-08_qlidps.png"
                alt="TaskFlow Logo" style="max-height: 40px; margin-bottom: 10px;" />
            <h1>New Task Assigned</h1>
        </div>

        <div class="email-body">
            <p>Dear {{ $user->name }},</p>

            <p>A new task has been assigned to you in <strong>TaskFlow</strong>:</p>

            <div class="task-box">
                <p><span class="task-label">Title:</span> <span>{{ $task->title }}</span></p>
                <p><span class="task-label">Description:</span> {{ $task->description }}</p>
                <p><span class="task-label">Deadline:</span> <span
                        class="deadline">{{ $task->deadline->format('M d, Y H:i A') }}</span></p>
            </div>

            <p>Please log in to your dashboard to view the task details and update its status.</p>


            <p>If you have any questions, feel free to contact your manager.</p>

            <p>Best regards,<br /><strong>TaskFlow Team</strong></p>
        </div>

        <div class="email-footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} TaskFlow. All rights reserved.</p>
        </div>
    </div>
</body>

</html>