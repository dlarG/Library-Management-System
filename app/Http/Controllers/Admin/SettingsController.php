<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        // Get the first settings record or create a default one
        $settings = Setting::firstOrCreate();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // Existing
            'daily_fine_rate' => 'required|numeric|min:0',
            'loan_period' => 'required|integer|min:1',
            
            // New rules
            'max_books_per_user' => 'required|integer|min:1',
            'grace_period' => 'required|integer|min:0',
            'renewal_limit' => 'required|integer|min:0',
            'reminder_days_before_due' => 'required|integer|min:0',
            'enable_email_notifications' => 'sometimes|boolean'
        ]);

        Setting::first()->update($validated);

        return redirect()->back()->with('success', 'Settings updated!');
    }
}