<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function updateprofile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->update($request->only([
            'fullName', 'username', 'age', 'phone', 'sex', 'profession', 'ethnicity', 'nationality',
        ]));
        return redirect()->back()->with('success', 'User profile updated successfully');
    }
    public function updatechangeinfo(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->update($request->only([
             'username', 'email',
        ]));
        return redirect()->back()->with('success', 'User profile updated successfully');
    }
 public function updatedelete(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User profile delete successfully');
    }
}
