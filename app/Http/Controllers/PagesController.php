<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transcription;
use App\Models\User;
use App\Models\Write;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;




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
//    public function contribute(Request $request)
//    {
//        try {
//            // ✅ Fetch a random sentence, prioritizing English first
//            $sentence = Write::where(function ($query) {
//                $query->whereNull('status')
//                    ->orWhere('status', 'approved');
//            })
//                ->orderByRaw("CASE WHEN language = 'english' THEN 1 ELSE 2 END") // Prioritize English
//                ->inRandomOrder()
//                ->first(); // Get ONE sentence
//
//        } catch (\Exception $e) {
//            \Log::error("Database Fetch Error: " . $e->getMessage());
//            $sentence = null;
//        }
//
//        return view('contribute', compact('sentence'));
//    }



    public function contribute(Request $request)
    {
        try {
            // Initialize AWS S3 Client
            $s3Client = new S3Client([
                'region'      => env('AWS_DEFAULT_REGION', 'eu-central-1'),
                'version'     => 'latest',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $bucketName = 'transcribedfile';

            // Step 1: Fetch from 'english/reviews/'
            $englishPrefix = 'english/reviews/';
            $englishFiles = $this->listS3Files($s3Client, $bucketName, $englishPrefix);

            // Step 2: If no English files, fetch from other folders
            $otherFiles = empty($englishFiles) ? $this->listS3Files($s3Client, $bucketName, '') : [];

            // Step 3: Prioritize English files, fallback to others
            $randomS3File = !empty($englishFiles) ? $englishFiles[array_rand($englishFiles)] : ($otherFiles[array_rand($otherFiles)] ?? null);

            $sentence = null; // Default value if no file is found

            if ($randomS3File) {
                // Fetch file content
                $result = $s3Client->getObject([
                    'Bucket' => $bucketName,
                    'Key'    => $randomS3File,
                ]);

                $fileContent = trim($result['Body']->getContents()); // Clean up content

                // Prepare data for view
                $sentence = [
                    'id'        => uniqid(),
                    'sentence'  => $fileContent,
                    'file_name' => $randomS3File,
                ];
            }

            // Return the Blade view with the sentence data
            return view('contribute', compact('sentence'));

        } catch (\Exception $e) {
            Log::error("S3 Fetch Error: " . $e->getMessage());

            // Return the view with an error message
            return view('contribute')->with('error', 'Error fetching sentence');
        }
    }

    /**
     * Helper function to list files from S3 with a specific prefix
     */
    private function listS3Files($s3Client, $bucketName, $prefix)
    {
        try {
            $objects = $s3Client->listObjects([
                'Bucket' => $bucketName,
                'Prefix' => $prefix,
            ]);

            $s3Files = [];
            if (isset($objects['Contents'])) {
                foreach ($objects['Contents'] as $object) {
                    $s3Files[] = $object['Key'];
                }
            }
            return $s3Files;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Helper function to list files from S3 with a specific prefix
     */

    public function getnextcontribute(Request $request)
    {
        $language = $request->query('language');

        // ✅ Initialize S3 variables
        $randomS3File = null;
        $fileContent = null;
        $fileUrl = null;

        // ✅ Fetch from S3 (only if a language is selected)
        try {
            if ($language) {
                $bucketName = 'transcribedfile'; // Same bucket for now
                $s3Path = strtolower($language) === 'yoruba' ? '' : "{$language}/reviews/";
                $region = env('AWS_DEFAULT_REGION', 'eu-central-1');

                // ✅ Initialize AWS S3 Client
                $s3Client = new S3Client([
                    'region'      => $region,
                    'version'     => 'latest',
                    'credentials' => [
                        'key'    => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                ]);

                // ✅ Fetch files from S3 with the given prefix
                $objects = $s3Client->listObjects([
                    'Bucket' => $bucketName,
                    'Prefix' => $s3Path,
                ]);

                $s3Files = [];
                if (isset($objects['Contents'])) {
                    foreach ($objects['Contents'] as $object) {
                        $s3Files[] = $object['Key'];
                    }
                }

                // ✅ Select a random file and get its content and URL
                if (!empty($s3Files)) {
                    $randomS3File = $s3Files[array_rand($s3Files)];

                    // ✅ Fetch file content
                    $result = $s3Client->getObject([
                        'Bucket' => $bucketName,
                        'Key'    => $randomS3File,
                    ]);
                    $fileContent = trim($result['Body']->getContents());

                    // ✅ Get the file URL
                    $fileUrl = $s3Client->getObjectUrl($bucketName, $randomS3File);
                }
            }
        } catch (\Exception $e) {
            \Log::error("S3 Fetch Error: " . $e->getMessage());
            return response()->json(['message' => 'Error fetching sentence'], 500);
        }

        // ✅ Return structured response
        if (!$randomS3File) {
            return response()->json(['message' => 'Not available'], 404);
        }

        return response()->json([
            'message' => 'Success',
            'sentence' => [
                'id'        => uniqid(),
                'sentence'  => $fileContent,
                'file_name' => $randomS3File,
            ],
            'fileUrl' => $fileUrl,
        ]);
    }



    public function saverecordings(Request $request)
    {
        $language   = $request->input('language');
        $recordings = $request->file('recordings', []); // Ensure it's an array
        $sentences  = $request->input('sentences', []);
        $fileNames  = $request->input('file_names', []);


        if (empty($recordings)) {
            return response()->json(['error' => 'No recordings uploaded'], 400);
        }

        $bucketName = 'transcribedfile';
        $s3Path     = "{$language}/all_audio/";
        $region     = env('AWS_DEFAULT_REGION', 'eu-central-1');

        foreach ($recordings as $index => $file) {
            if (!$file) continue; // Skip invalid files

            $sentence = $sentences[$index] ?? null;
            $fileName = $fileNames[$index] ?? 'audio_' . time() . '_' . $index . '.wav';
            $filePath = $s3Path . $fileName;

            // Upload to S3
            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

            // Generate S3 URL
            $objectUrl = "https://{$bucketName}.s3.{$region}.amazonaws.com/{$filePath}";

            // Save to database
            Transcription::create([
                'user_id'   => auth()->id(),
                'language'  => $language,
                'fileName' => $fileName,
                'fileurl'  => $objectUrl,
                'sentence'  => $sentence,
                'status'    => '0',
            ]);
        }

        return response()->json(['message' => 'Recordings saved successfully']);
    }

    public function listen()
    {
        try {
            // ✅ Get all files from 'english/all_audio/' folder in S3
            $files = Storage::disk('s3')->files('english/all_audio');

            if (!empty($files)) {
                $bucketName = 'transcribedfile';
                $region = env('AWS_DEFAULT_REGION', 'eu-central-1'); // Ensure region matches

                do {
                    // ✅ Pick a random file
                    $randomFile = $files[array_rand($files)];

                    // ✅ Convert relative path to full Object URL
                    $objectUrl = "https://{$bucketName}.s3.{$region}.amazonaws.com/{$randomFile}";


                    // ✅ Check if the file exists in the Write table
                    $fileRecord = Transcription::where('file_path', $objectUrl)


                        ->where(function ($query) {
                            $query->whereNull('status')->orWhere('status', '');
                        })

                        ->where(function ($query) {
                            $query->whereNull('transcribe')->orWhere('transcribe', 0);
                        })
                        ->first();

                    // ✅ If a matching file is found, generate a temporary URL
                    if ($fileRecord) {
                        $audioUrl = Storage::disk('s3')->temporaryUrl($randomFile, now()->addHour());
                        break; // Stop loop when a valid file is found
                    }

                } while (count($files) > 1); // Keep looping until a valid file is found


                // ✅ If no valid file is found, set null
                if (!$fileRecord) {
                    $audioUrl = null;
                }
            } else {
                $fileRecord = null;
                $audioUrl = null;
            }


        } catch (\Exception $e) {
            \Log::error("S3 Fetch Error: " . $e->getMessage());
            $fileRecord = null;
            $audioUrl = null;
        }

        return view('listen', compact('fileRecord', 'audioUrl'));
    }



    public function savelistening(Request $request)
    {
        // Get inputs from the request
        $language    = $request->input('language');
        $recordings  = $request->file('recordings');
        $sentences   = $request->input('sentences');
        $fileNames   = $request->input('file_names', []);
        $sentenceId  = $request->input('sentence_id'); // ID to update if exists

        // Validate that sentence_id is provided
        if (!$sentenceId) {
            return response()->json(['error' => 'Sentence ID is required for updating.'], 400);
        }

        // Retrieve the existing record
        $existingRecord = Write::find($sentenceId);
        if (!$existingRecord) {
            return response()->json(['error' => 'Record not found.'], 404);
        }

        // Determine S3 bucket and folder based on language
        if (strtolower($language) === 'yoruba') {
            $bucketName = 'transcribedfile';
            $s3Path = ''; // No subfolder for Yoruba
            $region = 'eu-central-1';
        } else {
            $bucketName = 'linguaspanproject';
            $s3Path = "{$language}/all_audio/";
            $region = env('AWS_DEFAULT_REGION', 'us-east-1');
        }

        // Loop through each recording and update it
        foreach ($recordings as $index => $file) {
            $sentence = $sentences[$index] ?? null;

            // Skip if sentence or file is missing
            if (!$sentence || !$file) {
                continue;
            }

            // Determine the file name
            $fileName = isset($fileNames[$index]) && !empty($fileNames[$index])
                ? $fileNames[$index]
                : 'audio_' . time() . '_' . $index . '.wav';

            // Build the full path in S3
            $filePath = $s3Path . $fileName;

            // Upload the file to S3
            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

            // Update existing record
            $existingRecord->update([
                'sentence' => $sentence,
                'file_path' => $filePath, // Update with the new S3 path
                'status' => 'updated'
            ]);
        }

        return response()->json(['message' => 'Record updated successfully']);
    }


    public function getnextlisten(Request $request)
    {
        $language = $request->query('language');

        try {
            // ✅ Query for an untranscribed sentence in the database
            $query = Write::where(function ($q) {
                $q->whereNull('status')->orWhere('status', 'pending');
            })->where(function ($q) {
                $q->whereNull('transcribe')->orWhere('transcribe', 0); // Only untranscribed files
            });

            if ($language) {
                $query->where('language', $language);
            }

            $sentence = $query->inRandomOrder()->first();

            if (!$sentence) {
                return response()->json(['message' => 'Not available'], 404);
            }

            // ✅ Determine the correct S3 bucket and path
            $bucketName = 'transcribedfile';
            $s3Path = "{$language}/all_audio/";
            $region = env('AWS_DEFAULT_REGION', 'eu-central-1');

            // ✅ Initialize S3 client
            $s3Client = new S3Client([
                'region'      => $region,
                'version'     => 'latest',
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            // ✅ Fetch all files from S3
            $objects = $s3Client->listObjects([
                'Bucket' => $bucketName,
                'Prefix' => $s3Path,
            ]);

            $s3Files = [];
            if (isset($objects['Contents'])) {
                foreach ($objects['Contents'] as $object) {
                    $s3Files[] = $object['Key']; // Store the relative path
                }
            }

            // ✅ Pick a file that hasn't been transcribed
            $randomS3File = null;
            $fileUrl = null;

            if (!empty($s3Files)) {
                do {
                    $randomFile = $s3Files[array_rand($s3Files)];

                    // ✅ Convert to full Object URL before querying
                    $objectUrl = "https://{$bucketName}.s3.{$region}.amazonaws.com/{$randomFile}";

                    // ✅ Check if the file exists in the Write table and is untranscribed
                    $fileRecord = Write::where('file_path', $objectUrl)
                        ->where(function ($q) {
                            $q->whereNull('status')->orWhere('status', 'approved');
                        })
                        ->where(function ($q) {
                            $q->whereNull('transcribe')->orWhere('transcribe', 0);
                        })
                        ->first();

                    if ($fileRecord) {
                        $randomS3File = $randomFile;
                        $fileUrl = Storage::disk('s3')->temporaryUrl($randomFile, now()->addHour()); // Generate temporary URL
                        break;
                    }

                } while (count($s3Files) > 1);
            }

            // If no valid file found, return null
            if (!$randomS3File) {
                return response()->json(['message' => 'No available audio files'], 404);
            }

        } catch (\Exception $e) {
            \Log::error("S3 Fetch Error: " . $e->getMessage());
            return response()->json(['message' => 'Error fetching files'], 500);
        }

        return response()->json([
            'sentence'      => $sentence,
            'randomS3File'  => $randomS3File,
            'fileUrl'       => $fileUrl,
        ]);
    }



    public function review()
    {
        // Prioritize English sentences
        $sentence = Write::where(function ($query) {
            $query->whereNull('status')->orWhere('status', 'pending');
        })
            ->where('language', 'english') // ✅ Prioritize English
            ->inRandomOrder()
            ->first();

        // If no English sentence is found, fetch any available sentence
        if (!$sentence) {
            $sentence = Write::whereNull('status')
                ->orWhere('status', 'pending')
                ->inRandomOrder()
                ->first();
        }

        if (!$sentence) {
            return response()->json(['message' => 'No review available'], 404);
        }

        return view('review', compact('sentence'));
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
