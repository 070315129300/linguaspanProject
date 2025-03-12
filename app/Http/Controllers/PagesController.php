<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transcription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        // Get current year and month
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Initialize arrays for months and values
        $months = [];
        $totalHoursData = [];
        $approvedHoursData = [];

        // Loop through each month from January to the current month
        for ($month = 1; $month <= $currentMonth; $month++) {
            $monthLabel = Carbon::createFromDate($currentYear, $month, 1)->format('F'); // E.g., "January", "February"
            $months[] = $monthLabel;

            // Get total hours for this month
            $totalHours = Transcription::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('hours');

            // Get approved hours for this month
            $approvedHours = Transcription::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'approved')
                ->sum('hours');

            // Push data to arrays
            $totalHoursData[] = $totalHours ?? 0;
            $approvedHoursData[] = $approvedHours ?? 0;
        }

        // ============================ DAILY TRANSCRIPTIONS ============================

        // Get the selected language from the request (default to empty for all languages)
        $language = $request->query('language');

        // Get today's start and end time
        $todayStart = Carbon::today(); // Start of today (00:00)
        $todayEnd = Carbon::today()->endOfDay(); // End of today (23:59)

        // Initialize data for the daily chart
        $intervals = [];
        $dailyTotalHoursData = [];

        // Loop through 24 hours in 2-hour intervals
        for ($i = 0; $i < 24; $i += 2) {
            // Define the start and end times for the 2-hour interval
            $start = $todayStart->copy()->addHours($i);
            $end = $start->copy()->addHours(2);

            // Format the interval label (e.g., "00:00 - 02:00")
            $label = $start->format('H:i') . ' - ' . $end->format('H:i');
            $intervals[] = $label;

            // Query to fetch transcriptions within the current 2-hour window
            $query = Transcription::whereBetween('created_at', [$start, $end]);

            // Apply language filter if a specific language is selected
            if ($language) {
                $query->where('language', $language);
            }

            // Sum the transcription hours for this interval
            $dailyTotalHoursData[] = $query->sum('hours') ?? 0;
        }

        // ============================ FETCH AVAILABLE LANGUAGES ============================

        $languages = Transcription::distinct()->pluck('language');

        // Return view with all required data
        return view('index', compact(
            'months',
            'totalHoursData',
            'approvedHoursData',
            'intervals',
            'dailyTotalHoursData',
            'languages' // Now available for the dropdown
        ));
    }


    public function login(){
        return view('auth/login');
    }
    public function userlogin(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Attempt to retrieve the user by email
        $user = User::where('email', $request->email)->first();
        // Check if the user exists
        if (!$user) {
            return back()->with('fail', 'This email is not registered');
        }
        // Check if the provided password matches the hashed password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('fail', 'Password mismatch');
        }
        // Log the user in
        Auth::login($user);

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('admindashboard'); // Redirect to admin dashboard
        } else {
            return redirect()->route('index'); // Redirect to index for regular users
        }
    }

    public function resetpassword(){
        return view('auth/reset-password');
    }
    public function forgetpassword(){
        return view('auth/forgot-password');
    }
    public function contribute()
    {
        // Fetch all sentences from the database
        $sentences = Review::pluck('sentence'); // Get only the 'sentence' column

        return view('contribute', compact('sentences'));
    }
    public function listen()
    {
        set_time_limit(300);

        // Create an S3 client instance
        $s3Client = new \Aws\S3\S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $bucket = env('AWS_BUCKET');
        $prefix = 'yoruba/all_audio/';
        $maxKeys = 1000; // Adjust if needed

        try {
            // Fetch all files from S3 without pagination
            $result = $s3Client->listObjectsV2([
                'Bucket' => $bucket,
                'Prefix' => $prefix,
                'MaxKeys' => $maxKeys,
            ]);

            $files = $result['Contents'] ?? [];
            $fileList = [];

            foreach ($files as $file) {
                $fileList[] = [
                    'name' => basename($file['Key']),
                    'url' => Storage::disk('s3')->url($file['Key'])
                ];
            }

            // Shuffle files to randomize order
            shuffle($fileList);

            return view('listen', compact('fileList'));

        } catch (\Aws\Exception\AwsException $e) {
            return view('listen')->with('error', 'Failed to fetch files from S3: ' . $e->getMessage());
        }
    }



    public function review(){
        return view('review');
    }
    public function write(){
        return view('write');
    }
//    public function language(){
//
//        return view('languages');
//    }

    public function language()
    {
//        if (auth()->user()->role !== 'admin') {
//            return redirect()->route('index')->with('error', 'Unauthorized access!');
//        }

        $languages = Transcription::select(
            'language',
            DB::raw('COUNT(*) as total'),
//            DB::raw(SUM(CAST(hours AS DECIMAL(10,2))) as total_hours),
            DB::raw('SUM(CASE WHEN status = "approved" THEN CAST(hours AS DECIMAL(10,2)) ELSE 0 END) as approved_hours'),
            DB::raw('COUNT(CASE WHEN type = "speak" THEN 1 END) as speakers'),
            DB::raw('COUNT(CASE WHEN type = "write" THEN 1 END) as writers')
        )
            ->whereNotNull('language')
            ->groupBy('language')
            ->get();

        return view('languages',compact('languages'));
    }
    public function dataCollection()
    {
        // Get total hours transcribed
        $totalHours = Transcription::sum('hours');

        // Get total approved hours
        $approvedHours = Transcription::where('status', 'approved')->sum('hours');

        // Get unique languages
        $languages = Transcription::distinct()->pluck('language')->toArray(); // Unique languages
        $totalLanguages = count($languages); // Count of unique languages

        return view('data_collection', compact('totalHours', 'approvedHours', 'totalLanguages', 'languages'));
    }

    public function about(){
        return view('about');
    }
    public function stats(Request $request)
    {
        // Get the logged-in user
        $user = auth()->user();

        // Get selected language (default: all)
        $language = $request->query('language');

        // Fix: Use fresh Carbon instances to avoid mutation issues
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        // Initialize data for the bar chart
        $intervals = [];
        $dailyTotalHoursData = [];

        // Loop through 24 hours in 2-hour intervals
        for ($i = 0; $i < 24; $i += 2) {
            $start = Carbon::today()->startOfDay()->addHours($i);
            $end = $start->copy()->addHours(2);

            // Format label (e.g., "00:00 - 02:00")
            $label = $start->format('H:i') . ' - ' . $end->format('H:i');
            $intervals[] = $label;

            // Query transcriptions
            $query = Transcription::where('userid', $user->id)
                ->whereBetween('created_at', [$start, $end]);

            // Apply language filter if needed
            if ($language) {
                $query->where('language', $language);
            }

            // Sum transcription hours for the interval
            $totalHours = $query->sum('hours');

            // Ensure value is at least 0 (avoid null issues)
            $dailyTotalHoursData[] = $totalHours ?? 0;
        }

        // ✅ Fetch total transcriptions by user
        $totalUserTranscriptions = Transcription::where('userid', $user->id);
        if ($language) {
            $totalUserTranscriptions->where('language', $language);
        }
        $totalUserTranscriptions = $totalUserTranscriptions->count();

        // ✅ Fetch total approved transcriptions by user
        $totalUserApprovedTranscriptions = Transcription::where('userid', $user->id)
            ->where('status', 'approved');
        if ($language) {
            $totalUserApprovedTranscriptions->where('language', $language);
        }
        $totalUserApprovedTranscriptions = $totalUserApprovedTranscriptions->count();

        // ✅ Fetch total transcriptions overall
        $totalTranscriptions = Transcription::query();
        if ($language) {
            $totalTranscriptions->where('language', $language);
        }
        $totalTranscriptions = $totalTranscriptions->count();

        // ✅ Fetch total approved transcriptions overall
        $totalApprovedTranscriptions = Transcription::where('status', 'approved');
        if ($language) {
            $totalApprovedTranscriptions->where('language', $language);
        }
        $totalApprovedTranscriptions = $totalApprovedTranscriptions->count();

        // ✅ Fetch top 5 contributors by total transcription hours
        $topContributors = Transcription::select('userid', DB::raw('SUM(hours) as total_hours'))
            ->groupBy('userid')
            ->orderByDesc('total_hours')
            ->limit(5)
            ->get();

        // Attach user full names
        foreach ($topContributors as $contributor) {
            $user = User::find($contributor->userid);
            $contributor->fullName = $user ? $user->fullName : 'Unknown';
        }

        // Get available languages for dropdown
        $languages = Transcription::whereNotNull('language')->distinct()->pluck('language');

        return view('stats', compact(
            'intervals',
            'dailyTotalHoursData',
            'languages',
            'totalUserTranscriptions',
            'totalUserApprovedTranscriptions',
            'totalTranscriptions',
            'totalApprovedTranscriptions',
            'topContributors'
        ));
    }



//    public function profiles(){
//
//        return view('profile');
//    }
    public function profiles()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return view('profile', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function changeinfo(){
        if (Auth::check()) {
            $user = Auth::user();
            return view('change_info', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function delete_profile(){
        if (Auth::check()) {
            $user = Auth::user();
            return view('delete_profile', ['user' => $user]);
        }
        return redirect()->route('login')->with('error', 'You must be logged in to view your profile.');
    }
    public function download(){
        return view('download_data');
    }

}
