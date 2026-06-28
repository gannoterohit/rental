<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $message = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject ?? 'New Inquiry from Contact Form',
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'is_read' => false,
        ]);

        // Attempt to send email to admin
        try {
            $adminEmail = \App\Models\Setting::get('contact_email', config('mail.from.address'));

            Mail::raw("New Contact Message from: {$request->name} ({$request->email})\n\nMessage:\n{$request->message}", function ($mail) use ($request, $adminEmail) {
                $mail->to($adminEmail)
                    ->subject($request->subject ?? 'New Website Inquiry');
            });
        } catch (\Exception $e) {
            // Log error but don't stop the user
            \Log::error("Failed to send contact email: " . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
