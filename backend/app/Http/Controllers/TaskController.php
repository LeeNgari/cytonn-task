<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssigned;

class TaskController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return response()->json(Task::with('assignedUser')->get());
        } else {
            return response()->json($user->assignedTasks()->with('assignedUser')->get());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'deadline' => 'required|date',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'deadline' => $request->deadline,
            'status' => $request->status ?? 'pending',
        ]);

        $assignedUser = User::find($request->assigned_to);
        if ($assignedUser) {
            Mail::to($assignedUser->email)->send(new TaskAssigned($task, $assignedUser));
        }

        return response()->json($task->load('assignedUser'), 201);
    }

    public function show(Task $task)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->id !== $task->assigned_to) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return response()->json($task->load('assignedUser'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'sometimes|required|exists:users,id',
            'deadline' => 'sometimes|required|date',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        $task->update($request->all());

        return response()->json($task->load('assignedUser'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $user = Auth::user();
        if ($user->id !== $task->assigned_to) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json($task->load('assignedUser'));
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
