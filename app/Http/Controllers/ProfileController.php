<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateprofile(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

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
        $user = Auth::user(); // Get the authenticated user

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
        $user = Auth::user(); // Get the authenticated user

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile deleted successfully'
        ]);
    }
}
