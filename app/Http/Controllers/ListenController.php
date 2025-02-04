<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ListenController extends Controller
{

    public function createUser(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Use 'password_confirmation' field for confirmation
            'age' => 'nullable|string|max:3',
            'phone' => 'nullable|string|max:15',
            'sex' => 'nullable|string|in:male,female,other',
            'profession' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'role' => 'nullable|in:admin,agent,user',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Create the user
        $user = User::create([
            'fullName' => $validated['fullName'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Hash the password
            'age' => $validated['age'],
            'phone' => $validated['phone'],
            'sex' => $validated['sex'],
            'profession' => $validated['profession'],
            'language' => $validated['language'],
            'ethnicity' => $validated['ethnicity'],
            'nationality' => $validated['nationality'],
            'address' => $validated['address'],
            'role' => $validated['role'] ?? 'user', // Default to 'user' if not provided
            'status' => $validated['status'] ?? 'active', // Default to 'active' if not provided
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function getUserById($id)
    {
        $user = User::find($id); // Returns the user or null if not found
        return $user;
    }

    public function getAllUsers()
    {
        $users = User::all(); // Returns a collection of all users
        return $users;
    }

    public function deleteUser($id)
    {
        $user = User::find($id); // Find the user
        if ($user) {
            $user->delete(); // Delete the user
            return response()->json(['message' => 'User deleted successfully.']);
        }
        return response()->json(['message' => 'User not found.'], 404);
    }

    public function editUser(Request $request, $id)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Ignore current user's email for uniqueness
            'age' => 'nullable|string|max:3',
            'phone' => 'nullable|string|max:15',
            'sex' => 'nullable|string|in:male,female,other',
            'profession' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'role' => 'nullable|in:admin,agent,user',
            'status' => 'nullable|in:active,inactive',
        ]);
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update($validated);
        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
}
