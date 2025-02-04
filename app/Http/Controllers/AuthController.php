<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
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
