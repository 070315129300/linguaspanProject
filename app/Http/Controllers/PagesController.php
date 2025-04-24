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
    $currentYear = Carbon::now()->year;
    $currentMonth = Carbon::now()->month;

    $months = [];
    $totalHoursData = [];
    $approvedHoursData = [];

    for ($month = 1; $month <= $currentMonth; $month++) {
        $monthLabel = Carbon::createFromDate($currentYear, $month, 1)->format('F');
        $months[] = $monthLabel;

        $totalHours = Transcription::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $month)
            ->sum('hours');

        $approvedHours = Transcription::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $month)
            ->where('status', 'approved')
            ->sum('hours');

        $totalHoursData[] = $totalHours ?? 0;
        $approvedHoursData[] = $approvedHours ?? 0;
    }

    // ========== DAILY TRANSCRIPTIONS ==========

    $language = $request->query('language'); // ?language=yoruba

    $todayStart = Carbon::today();
    $todayEnd = Carbon::today()->endOfDay();

    $intervals = [];
    $dailyTotalHoursData = [];

    for ($i = 0; $i < 24; $i += 2) {
        $start = $todayStart->copy()->addHours($i);
        $end = $start->copy()->addHours(2);

        $label = $start->format('H:i') . ' - ' . $end->format('H:i');
        $intervals[] = $label;

        $query = Transcription::whereBetween('created_at', [$start, $end]);

        if ($language) {
            $query->where('language', $language);
        }

        $dailyTotalHoursData[] = $query->sum('hours') ?? 0;
    }

    $languages = Transcription::distinct()->pluck('language');

    return response()->json([
        'status' => 'success',
        'message' => 'Analytics data fetched successfully',
        'data' => [
            'months' => $months,
            'totalHoursData' => $totalHoursData,
            'approvedHoursData' => $approvedHoursData,
            'intervals' => $intervals,
            'dailyTotalHoursData' => $dailyTotalHoursData,
            'languages' => $languages
        ]
    ]);
}



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
            $bucketName = 'transcribedfile';
            $region = env('AWS_DEFAULT_REGION', 'eu-central-1');
            $language = 'yoruba'; // Or get from request
            $s3Path = "{$language}/all_audio/";

            // Get files from S3
            $files = Storage::disk('s3')->files($s3Path);
            shuffle($files); // Randomize file order

            $transcription = null; // Default value if none found

            foreach ($files as $file) {
                $objectUrl = "https://{$bucketName}.s3.{$region}.amazonaws.com/{$file}";

                // Find matching transcription
                $transcription = Transcription::where('fileurl', $objectUrl)
                    ->where(function($query) {
                        $query->whereNull('status')
                            ->orWhere('status', '0');
                    })
                    ->first();

                if ($transcription) {
                    // Generate temporary URL
                    $audioUrl = Storage::disk('s3')->temporaryUrl($file, now()->addHour());


                    // Prepare data structure matching your working example
                    $sentence = [
                        'id' => uniqid(),
                        'sentence' => $transcription->sentence,
                        'file_name' => $transcription->fileName,
                        'file_url' => $audioUrl,
                        'language' => $transcription->language
                    ];

                    return view('listen', compact('sentence'));
                }
            }

            // If no matches found
            return view('listen', ['sentence' => null]);

        } catch (\Exception $e) {
            \Log::error("Listen Error: " . $e->getMessage());
            return view('listen', ['sentence' => null]);
        }
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
            // Get pending transcription record
            $transcription = Transcription::where(function($q) {
                $q->whereNull('status')->orWhere('status', '0');
            })
                ->where('language', $language)
                ->first();

            if (!$transcription) {
                return response()->json([
                    'success' => false,
                    'message' => 'No sentences available for review'
                ], 404);
            }

            // Extract filename from S3 URL
            $filePath = parse_url($transcription->fileurl, PHP_URL_PATH);
            $fileKey = ltrim($filePath, '/'); // Remove leading slash

            // Verify file exists in S3
            if (!Storage::disk('s3')->exists($fileKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audio file not found in storage'
                ], 404);
            }

            // Generate temporary URL
            $audioUrl = Storage::disk('s3')->temporaryUrl(
                $fileKey,
                now()->addHour()
            );

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $transcription->id,
                    'sentence' => $transcription->sentence,
                    'audio_url' => $audioUrl,
                   // 'expires_at' => now()->addHour()->toDateTimeString(),
                    'language' => $transcription->language,
                    'file_name' => $transcription->fileName
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error("Listen Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error processing request',
                'error' => $e->getMessage()
            ], 500);
        }
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

    public function language()
    {
        $languages = Transcription::select(
            'language',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "approved" THEN CAST(hours AS DECIMAL(10,2)) ELSE 0 END) as approved_hours'),
            DB::raw('COUNT(CASE WHEN type = "speak" THEN 1 END) as speakers'),
            DB::raw('COUNT(CASE WHEN type = "write" THEN 1 END) as writers')
        )
        ->whereNotNull('language')
        ->groupBy('language')
        ->get();
    
        return response()->json([
            'data' => $languages
        ]);
    }
    

    public function dataCollection()
{
    // Get total hours transcribed
    $totalHours = Transcription::sum('hours');

    // Get total approved hours
    $approvedHours = Transcription::where('status', 'approved')->sum('hours');

    // Get unique languages
    $languages = Transcription::distinct()->pluck('language')->toArray();
    $totalLanguages = count($languages);

    // Return JSON response
    return response()->json([
        'totalHours' => $totalHours,
        'approvedHours' => $approvedHours,
        'totalLanguages' => $totalLanguages,
        'languages' => $languages
    ]);
}


    public function stats(Request $request)
    {
        // Accepting JSON input
        $language = $request->input('language');
    
        // Get the authenticated user manually (for API)
        $user = User::find($request->input('user_id'));
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $intervals = [];
        $dailyTotalHoursData = [];
    
        for ($i = 0; $i < 24; $i += 2) {
            $start = Carbon::today()->startOfDay()->addHours($i);
            $end = $start->copy()->addHours(2);
    
            $label = $start->format('H:i') . ' - ' . $end->format('H:i');
            $intervals[] = $label;
    
            $query = Transcription::where('userid', $user->id)
                ->whereBetween('created_at', [$start, $end]);
    
            if ($language) {
                $query->where('language', $language);
            }
    
            $totalHours = $query->sum('hours');
            $dailyTotalHoursData[] = $totalHours ?? 0;
        }
    
        $totalUserTranscriptions = Transcription::where('userid', $user->id);
        if ($language) {
            $totalUserTranscriptions->where('language', $language);
        }
        $totalUserTranscriptions = $totalUserTranscriptions->count();
    
        $totalUserApprovedTranscriptions = Transcription::where('userid', $user->id)
            ->where('status', 'approved');
        if ($language) {
            $totalUserApprovedTranscriptions->where('language', $language);
        }
        $totalUserApprovedTranscriptions = $totalUserApprovedTranscriptions->count();
    
        $totalTranscriptions = Transcription::query();
        if ($language) {
            $totalTranscriptions->where('language', $language);
        }
        $totalTranscriptions = $totalTranscriptions->count();
    
        $totalApprovedTranscriptions = Transcription::where('status', 'approved');
        if ($language) {
            $totalApprovedTranscriptions->where('language', $language);
        }
        $totalApprovedTranscriptions = $totalApprovedTranscriptions->count();
    
        $topContributors = Transcription::select('userid', DB::raw('SUM(hours) as total_hours'))
            ->groupBy('userid')
            ->orderByDesc('total_hours')
            ->limit(5)
            ->get();
    
        foreach ($topContributors as $contributor) {
            $contributorUser = User::find($contributor->userid);
            $contributor->fullName = $contributorUser ? $contributorUser->fullName : 'Unknown';
        }
    
        $languages = Transcription::whereNotNull('language')->distinct()->pluck('language');
    
        // JSON response
        return response()->json([
            'intervals' => $intervals,
            'dailyTotalHoursData' => $dailyTotalHoursData,
            'languages' => $languages,
            'totalUserTranscriptions' => $totalUserTranscriptions,
            'totalUserApprovedTranscriptions' => $totalUserApprovedTranscriptions,
            'totalTranscriptions' => $totalTranscriptions,
            'totalApprovedTranscriptions' => $totalApprovedTranscriptions,
            'topContributors' => $topContributors
        ]);
    }
    



}
