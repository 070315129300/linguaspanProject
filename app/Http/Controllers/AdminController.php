<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Review;
use App\Models\Speak;
use App\Models\User;
use App\Models\Transcription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\AdminService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function __construct(AdminService $adminService)
    {
        $this->AdminService = $adminService;
    }

//    public function get_language(): JsonResponse
//    {
//        $languages = $this->AdminService->getAllLanguages();
//        return response()->json(['success' => true, 'data' => $languages]);
//    }

    /**
     * Create a new language.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create_language(Request $request)
    {
        $request->validate([
            'language' => 'required|string|unique:languages,language',
            'status' => 'required|in:1,0',
        ]);

        $language = $this->AdminService->createLanguage($request->all());

        return redirect()->back()->with('success', 'Language created successfully');
    }


  public function login(){
    return view('dashboard/adminlogin');
}

    public function admindashboard()
    {
        $users = User::all(); // Retrieve all users
        $userCount = User::count(); // Count total users
        $pendingReviews = Review::where('status', 'pending')->count(); // Count pending reviews
        $totalTranscriptions = Transcription::count(); // Count all transcriptions
        $totalSpeak = Speak::count(); // Count 'speak' transcriptions
        $totalLanguage = Language::count(); // Count total languages

        // Count Approved and Rejected transcriptions
        $approvedCount = Transcription::where('status', 'approved')->count();
        $rejectedCount = Transcription::where('status', 'rejected')->count();
        $pendingCount = Transcription::where('status', 'pending')->count();

        // Calculate percentages
        $approvedPercentage = $totalTranscriptions > 0 ? ($approvedCount / $totalTranscriptions) * 100 : 0;
        $rejectedPercentage = $totalTranscriptions > 0 ? ($rejectedCount / $totalTranscriptions) * 100 : 0;
        $pendingPercentage = $totalTranscriptions > 0 ? ($pendingCount / $totalTranscriptions) * 100 : 0;

        // Count quality ratings
        $badCount = Transcription::whereBetween('quality', [0, 2])->count();
        $fairCount = Transcription::whereBetween('quality', [3, 5])->count();
        $goodCount = Transcription::whereBetween('quality', [6, 7])->count();
        $excellentCount = Transcription::where('quality', '>', 7)->count();

        // Calculate quality percentages
        $badPercentage = $totalTranscriptions > 0 ? ($badCount / $totalTranscriptions) * 100 : 0;
        $fairPercentage = $totalTranscriptions > 0 ? ($fairCount / $totalTranscriptions) * 100 : 0;
        $goodPercentage = $totalTranscriptions > 0 ? ($goodCount / $totalTranscriptions) * 100 : 0;
        $excellentPercentage = $totalTranscriptions > 0 ? ($excellentCount / $totalTranscriptions) * 100 : 0;

        // Count unique transcribed languages
        $uniqueTranscribedLanguages = DB::table('transcriptions')
            ->whereNotNull('language')
            ->distinct('language')
            ->count('language');

        // Fetch transcribed language statistics
        $languages = DB::table('transcriptions')
            ->whereNotNull('language')
            ->select(
                'language',
                DB::raw('COUNT(DISTINCT userId) as user_count'),
                DB::raw('SUM(hours) as total_hours'),
                DB::raw('COUNT(*) as total_transcriptions')
            )
            ->groupBy('language')
            ->paginate(10);

        // Get transcription type counts for each language
        $languageTypes = DB::table('transcriptions')
            ->whereNotNull('language')
            ->select(
                'language',
                DB::raw("SUM(CASE WHEN type = 'write' THEN 1 ELSE 0 END) as write_count"),
                DB::raw("SUM(CASE WHEN type = 'speak' THEN 1 ELSE 0 END) as speak_count"),
                DB::raw("SUM(CASE WHEN type = 'listen' THEN 1 ELSE 0 END) as listen_count"),
                DB::raw("SUM(CASE WHEN type = 'review' THEN 1 ELSE 0 END) as review_count")
            )
            ->groupBy('language')
            ->get();

        // Merge language data with type counts
        $transcribedLanguages = $languages->map(function ($lang) use ($languageTypes) {
            $types = $languageTypes->firstWhere('language', $lang->language);
            return [
                'language' => $lang->language,
                'user_count' => $lang->user_count,
                'total_hours' => $lang->total_hours,
                'total_transcriptions' => $lang->total_transcriptions,
                'write_count' => $types->write_count ?? 0,
                'speak_count' => $types->speak_count ?? 0,
                'listen_count' => $types->listen_count ?? 0,
                'review_count' => $types->review_count ?? 0,
            ];
        });

        // ✅ Fetch transcriptions for all users (monthly)
        $monthlyTranscriptions = Transcription::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // Generate labels for all months (Jan - Dec)
        $months = collect(range(1, 12))->map(function ($month) use ($monthlyTranscriptions) {
            return [
                'label' => Carbon::create()->month($month)->format('M'), // "Jan", "Feb", etc.
                'total' => $monthlyTranscriptions[$month] ?? 0, // Default to 0 if no data
            ];
        });

        // Return view with data
        return view('dashboard.admin_dashboard', compact(
            'users',
            'userCount',
            'pendingReviews',
            'totalTranscriptions',
            'totalSpeak',
            'totalLanguage',
            'uniqueTranscribedLanguages',
            'transcribedLanguages',
            'months', // ✅ Monthly transcriptions for all users
            'approvedPercentage',
            'rejectedPercentage',
            'pendingPercentage', // ✅ Added pending percentage
            'badPercentage',
            'fairPercentage',
            'goodPercentage',
            'excellentPercentage'
        ));
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
        $search = $request->query('search');

        // Query users with filters
        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('fullName', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        // Fetch users and calculate their favorite language
        $users = $query->paginate(10);

        // Process each user to determine their favorite language
        foreach ($users as $user) {
            $favoriteLanguage = DB::table('transcriptions')
                ->where('userid', $user->id)
                ->select('language', DB::raw('COUNT(language) as language_count'))
                ->groupBy('language')
                ->orderByDesc('language_count')
                ->limit(1)
                ->value('language'); // Get the most used language or null

            $user->favorite_language = $favoriteLanguage ?? ''; // Default to empty string
        }

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
        $query = Transcription::query()
            ->leftJoin('users', 'transcriptions.userId', '=', 'users.id') // Join users table
            ->select('transcriptions.*', 'users.fullName'); // Select fullName from users

        if ($quality) {
            $query->where('transcriptions.quality', $quality);
        }



        if ($date) {
            $query->whereDate('transcriptions.created_at', $date);
        }

        if ($language) {
            $query->where('transcriptions.language', $language);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.fullName', 'like', "%$search%") // Search by full name
                ->orWhere('users.email', 'like', "%$search%"); // Search by email
            });
        }

        // Paginate the filtered results (10 results per page)
        $users = $query->paginate(10);
        $usr = $query->get(); // Get all filtered results without pagination

        // Return to the view with filtered data
        return view('dashboard.transcriptionMgt', compact('users', 'usr'));
    }

    public function languagemanagement()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized access!');
        }


        // Fetch unique languages and their total transcription count
        $languages = Transcription::select('language', DB::raw('COUNT(*) as total'))
            ->whereNotNull('language') // Ensure no null values
            ->groupBy('language') // Group by language to get unique entries
            ->get();

        return view('dashboard.LanguageMgt', compact('languages'));
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
        $user->password = Hash::make('password'); // Use bcrypt to hash the password
        $user->save();

        return redirect()->back()->with('success', 'User password has been reset successfully!');
    }


    public function suspendUser(Request $request, $userId)
    {



        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access!'], 403);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }

        $user->status = 'inactive';
        $user->save();

        return response()->json(['success' => true, 'message' => 'User suspended successfully!']);
    }
    public function deleteUser(Request $request, $userId)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access!'], 403);
        }
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }
        // Permanently delete the user
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
    }
    public function resetPassword(Request $request, $userId)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access!'], 403);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }

        // Hash the new password and update it
        $user->password = Hash::make('12345');
        $user->save();

        return response()->json(['success' => true, 'message' => 'User password reset successfully!']);
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
        return response()->json(['success' => true, 'message' => 'User activated successfully!']);
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
    public function assignRole(Request $request, $userId)
    {
        // Ensure only admin can access this functionality
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access!'], 403);
        }

        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found!'], 404);
        }

        // Get role from JSON request
        $role = $request->input('role');
        if (!$role) {
            return response()->json(['error' => 'Role is required!'], 400);
        }

        $user->role = $role;
        $user->save();

        return response()->json(['success' => true, 'message' => "User role updated to {$role} successfully!"]);
    }


    public function inviteAdmin(Request $request)
    {
        // Parse JSON data from the request
        $data = $request->json()->all();

        // Save data to the database (e.g., create a new User)
        $user = User::create([
            'fullname' => $data['fullname'],
            'role' => $data['user_type'],
            'email' => $data['email'],
            'status'=> 'active',
            'password' => Hash::make("1234567890"), // Encrypt password
        ]);

        // Send an email to the invited admin (uncomment if needed)
        // Mail::to($user->email)->send(new AdminInviteMail($user));

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Admin invited successfully!'
        ]);
    }

    public function createlanguage(Request $request)
    {
        // Parse JSON data from the request
        $data = $request->json()->all();

        // Save data to the database (e.g., create a new User)
        $user = Language::create([
            'language' => $data['language'],
            'status'=> '1',

        ]);

        // Send an email to the invited admin (uncomment if needed)
        // Mail::to($user->email)->send(new AdminInviteMail($user));

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Language created successfully!'
        ]);
    }

}

