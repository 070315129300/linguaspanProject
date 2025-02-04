<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomMail;

class EmailController extends Controller
{
    /**
     * Send an email.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $emailData = [
            'to' => $request->input('to'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
        ];

        Mail::to($emailData['to'])->send(new CustomMail($emailData));

        return response()->json([
            'message' => 'Email sent successfully!',
        ]);
    }
}
