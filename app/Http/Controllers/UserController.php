<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset;

class UserController extends Controller
{
    /**
     * USER REGISTRATION
     */
    
     public function createUser(Request $request)
     {
         $email = $request->input('email');
     
         // Check if email is already taken
         if (User::where('email', $email)->exists()) {
             return response()->json([
                 'message' => 'Email has already been taken',
             ], 409); // 409 Conflict
         }
     
         // Create user if email is unique
         $user = User::create([
             'fullName'    => $request['fullName'],
             'username'    => $request['username'] ?? null,
             'email'       => $email,
             'password'    => Hash::make($request['password']),
             'age'         => $request['age'] ?? null,
             'phone'       => $request['phone'] ?? null,
             'sex'         => $request['sex'] ?? null,
             'profession'  => $request['profession'] ?? null,
             'language'    => $request['language'] ?? null,
             'ethnicity'   => $request['ethnicity'] ?? null,
             'nationality' => $request['nationality'] ?? null,
             'address'     => $request['address'] ?? null,
             'role'        => $request['role'] ?? 'user',
             'status'      => $request['status'] ?? 'active',
         ]);
     
         return response()->json([
             'message' => 'User created successfully',
             'user'    => $user
         ], 201);
     }

     

    /**
     * LOGIN
     */
     
     public function login(Request $request)
     {
         $credentials = $request->validate([
             'email' => 'required|email',
             'password' => 'required|string',
         ]);
     
         $user = User::where('email', $credentials['email'])->first();
     
         if (!$user || !Hash::check($credentials['password'], $user->password)) {
             return response()->json(['message' => 'Invalid credentials'], 401);
         }
     
         // Sanctum token generation
         $token = $user->createToken('api-token')->plainTextToken;
     
         return response()->json([
             'message' => 'Login successful',
             'user' => $user,
             'token' => $token, // This is the Bearer token to be used in Authorization header
         ]);
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

    public function getUserById($id)
    {
        $user = User::find($id); // Returns the user or null if not found
        return $user;
    }
    
     

    /**
     * LOGOUT
     */
   
     public function logout(Request $request)
     {
         $request->user()->currentAccessToken()->delete();
     
         return response()->json([
             'message' => 'Logout successful'
         ]);
     }

    /**
     *  FORGOT PASSWORD (SEND OTP)
     */
    
    public function forgetpassword(Request $request)
    {
        // Validate email
        // $request->validate([
        //     'email' => 'required|email|exists:users,email',
        // ]);
    
        // Generate 4-digit OTP
        $otp = rand(1000, 9999);
    
        // Update the OTP directly on the user
        $user = User::where('email', $request->email)->first();
        $user->otp = $otp;
        $user->save();
    
        // Send OTP via email
        Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset OTP');
        });
    
        return response()->json(['message' => 'OTP sent to your email.']);
    }
    
    /**
     * RESET PASSWORD (WITH OTP)
     */
    
     public function resetPassword(Request $request)
     {
        //  $request->validate([
        //      'email' => 'required|email|exists:users,email',
        //      'otp' => 'required|digits:4',
        //      'password' => 'required|string|min:8|confirmed',
        //  ]);
     
         // Find user by email and OTP
         $user = User::where('email', $request->email)
                     ->where('otp', $request->otp)
                     ->first();
     
         if (!$user) {
             return response()->json(['message' => 'Invalid OTP or email'], 400);
         }
     
         // Update password and clear OTP
         $user->password = Hash::make($request->password);
         $user->otp = null;
         $user->save();
     
         return response()->json(['message' => 'Password reset successful']);
     }

     


    
}
