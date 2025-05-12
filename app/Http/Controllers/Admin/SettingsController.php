<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sabberworm\CSS\Settings;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'settings' => $this->getSettings()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'library_name' => 'required|string|max:255',
            'library_email' => 'required|email|max:255',
            'library_phone' => 'nullable|string|max:20',
            'library_address' => 'required|string',
            'fine_rate_filipiniana' => 'required|numeric|min:0',
            'fine_rate_general' => 'required|numeric|min:0',
            'fine_rate_reserve' => 'required|numeric|min:0',
            'default_loan_period' => 'required|integer|min:1',
            'max_renewals' => 'required|integer|min:0',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i|after:opening_time',
            'enable_email_notifications' => 'sometimes|boolean'
        ]);

        foreach ($validated as $key => $value) {
            setting([$key => $value]);
        }

        setting()->save();

        return back()->with('success', 'Settings updated successfully!');
    }

    private function getSettings()
    {
        return [
            'library_name' => setting('library_name', 'LibraLynx'),
            'library_email' => setting('library_email', 'info@libralynx.com'),
            'library_phone' => setting('library_phone'),
            'library_address' => setting('library_address'),
            'fine_rate_filipiniana' => setting('fine_rate_filipiniana', 2.00),
            'fine_rate_general' => setting('fine_rate_general', 2.00),
            'fine_rate_reserve' => setting('fine_rate_reserve', 50.00),
            'default_loan_period' => setting('default_loan_period', 14),
            'max_renewals' => setting('max_renewals', 2),
            'opening_time' => setting('opening_time', '08:00'),
            'closing_time' => setting('closing_time', '17:00'),
            'enable_email_notifications' => setting('enable_email_notifications', true)
        ];
    }
}
