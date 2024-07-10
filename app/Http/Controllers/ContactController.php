<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::send([], [], function ($message) use ($details) {
            $message->to(env('MAIL_TO_ADDRESS', 'recipient-email@example.com'))
                ->from($details['email'], $details['name'])
                ->subject($details['subject'])
                ->html(
                    'Name: ' . $details['name'] . '<br>' .
                        'Email: ' . $details['email'] . '<br>' .
                        'Message: ' . $details['message']
                );
        });

        return back()->with('success', 'Your message has been sent. Thank you!');
    }
}
