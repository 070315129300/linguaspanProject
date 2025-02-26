<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transcription;
use Illuminate\Http\Request;
use hash;

class AdminController extends Controller
{
  public function login(){
    return view('dashboard/adminlogin');
}
public function admindashboard(){
    return view('dashboard/admin_dashboard');
}
    public function role()
    {
        // Ensure only admins can access this functionality
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }

        // Count the number of users for each role
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'users')->count();
        $moderatorCount = User::where('role', 'moderator')->count();
        $transcriberCount = User::where('role', 'transcriber')->count();

        // Fetch only users with the role 'admin' and paginate
        $users = User::where('role', 'admin')->paginate(2);

        return view('dashboard/Roles', compact('users', 'adminCount', 'userCount', 'moderatorCount', 'transcriberCount'));
    }

public function permission(){
    return view('dashboard/permissions');
}

    public function userManagement(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }

        // Get filter parameters
        $role = $request->query('role');
        $status = $request->query('status');
        $language = $request->query('language');
        $search = $request->query('search');

        // Query the database with optional filters
        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($language) {
            $query->where('language', $language);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('fullName', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }
        // Paginate the filtered users (10 users per page)
        $users = $query->paginate(10);

        // Pass data to the view
        return view('dashboard/UserMgt', compact('users'));
    }


    public function transcriptionmanagement(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        // Get filter parameters
        $quality = $request->query('quality');
        $date = $request->query('created_at');
        $language = $request->query('language');
        $search = $request->query('search');

        // Query the database with optional filters
        $query = Transcription::query();

        if ($quality) {
            $query->where('quality', $quality);
        }

        if ($date) {
            $query->where('created_at', $date);
        }

        if ($language) {
            $query->where('language', $language);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

//         Paginate the filtered users (10 users per page)
        $users = $query->paginate(10);
        $usr = $query->get();
        // Return to the view with filtered data
        return view('dashboard.transcriptionMgt', compact('users', 'usr'));
    }

public function languagemanagement(){
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('index')->with('error', 'Unauthorized access!');
    }

    return view('dashboard/LanguageMgt');
}
public function rewardmanagement(){
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('index')->with('error', 'Unauthorized access!');
    }
    $users = User::where('role', 'user')->paginate(10);
    return view('dashboard/rewardMgt', compact('users'));
}
public function settingsmanagement(){
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('index')->with('error', 'Unauthorized access!');
    }

    return view('dashboard/settingsMgt');
}

    public function changepassword(Request $request, $userId)
    {
        // Ensure only admins can access this functionality
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }

        // Find the user by ID
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }

        // Reset the password to a default value
        $user->password = Hash('password'); // Use bcrypt to hash the password
        $user->save();

        return redirect()->back()->with('success', 'User password has been reset successfully!');
    }


    public function suspendUser($userId)
    {

        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->status = 'suspended';
        $user->save();
        return redirect()->back()->with('success', 'User suspended successfully!');
    }

    public function activateUser(Request $request, $userId)
    {
        // Ensure only admin can access this functionality
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->status = 'active';
        $user->save();
        return redirect()->back()->with('success', 'User actvated successfully!');
    }
    public function deleteAdmin(Request $request, $userId)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
    public function makeadmin(Request $request, $userId)
    {
        // Ensure only admin can access this functionality
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->role = 'admin';
        $user->save();
        return redirect()->back()->with('success', 'User is now an admin!');
    }
    public function assignrole(Request $request, $userId)
    {
        // Ensure only admin can access this functionality
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }
        $user = User::find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found!');
        }
        $user->role =$request->role;
        $user->save();
        return redirect()->back()->with('success', "User role updated to {$request->role} successfully!");
    }

    public function inviteAdmin(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'fullname' => 'required|string|max:255',
            'user_type' => 'required|string',
            'email' => 'required|email|unique:users,email',
        ]);

        // Save data to the database (e.g., create a new User)
        $user = User::create([
            'fullname' => $request->fullname,
            'user_type' => $request->user_type,
            'email' => $request->email,
            'password' => "1234567890",
        ]);

//        // Send an email to the invited admin
//        Mail::to($user->email)->send(new AdminInviteMail($user));

        // Return a success message or redirect
        return back()->with('success', 'Admin invited successfully!');
    }

}
