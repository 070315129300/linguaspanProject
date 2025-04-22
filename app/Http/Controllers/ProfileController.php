<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function updateprofile(Request $request)
    {
        $user = User::find($request->input('user_id'));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->update($request->only([
            'fullName', 'username', 'age', 'phone', 'sex', 'profession', 'ethnicity', 'nationality',
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'User profile updated successfully',
            'data' => $user
        ]);
    }

    public function updatechangeinfo(Request $request)
    {
        $user = User::find($request->input('user_id'));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->update($request->only([
            'username', 'email',
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'User information updated successfully',
            'data' => $user
        ]);
    }

    public function updatedelete(Request $request)
    {
        $user = User::find($request->input('user_id'));

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile deleted successfully'
        ]);
    }
}
