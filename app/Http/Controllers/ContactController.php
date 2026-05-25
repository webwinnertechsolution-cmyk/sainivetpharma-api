<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\ContactConfirmationMail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validation - Data check karna
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'product_name' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        // Database mein save karein
        $contact = Contact::create($validated);

        // 1. Admin ko email bhejein (full details)
        try {
            Mail::to('developer.deepak56256@gmail.com')->send(new ContactFormMail($contact));
        } catch (\Exception $e) {
            \Log::error('Admin email failed: ' . $e->getMessage());
        }

        // 2. User ko confirmation email bhejein (thank you message)
        try {
            Mail::to($contact->email)->send(new ContactConfirmationMail($contact));
        } catch (\Exception $e) {
            \Log::error('User confirmation email failed: ' . $e->getMessage());
        }

        // Success message ke saath redirect karein
        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
