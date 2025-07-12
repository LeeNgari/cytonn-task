<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        // No middleware registration in constructor
    }

    /**
     * Display a listing of users (Admin only)
     */
    public function index(Request $request)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(User::all());
    }

    /**
     * Create a new user (Admin only)
     */
    public function store(Request $request)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display user details
     */
    public function show(Request $request, User $user)
    {
        if (!$request->user() || ($request->user()->id !== $user->id && $request->user()->role !== 'admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($user);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Non-admin users can only update themselves
        if ($request->user()->role !== 'admin' && $request->user()->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validationRules = [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
        ];

        // Only admin can change roles
        if ($request->user()->role === 'admin') {
            $validationRules['role'] = 'sometimes|required|in:admin,user';
        }

        $request->validate($validationRules);

        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * Delete user (Admin only)
     */
    public function destroy(Request $request, User $user)
    {
        if (!$request->user() || $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
