@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">System Settings</h2>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Loan Settings Card -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-4">📚 Loan Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2">Loan Period (Days)</label>
                    <input type="number" name="loan_period" 
                           value="{{ old('loan_period', $settings->loan_period) }}"
                           class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Max Books Per User</label>
                    <input type="number" name="max_books_per_user" 
                           value="{{ old('max_books_per_user', $settings->max_books_per_user) }}"
                           class="w-full p-2 border rounded">
                </div>
            </div>
        </div>

        <!-- Fine Settings Card -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-4">⚖️ Fine Settings</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 mb-2">Daily Fine Rate ($)</label>
                    <input type="number" step="0.01" name="daily_fine_rate" 
                           value="{{ old('daily_fine_rate', $settings->daily_fine_rate) }}"
                           class="w-full p-2 border rounded">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Grace Period (Days)</label>
                    <input type="number" name="grace_period" 
                           value="{{ old('grace_period', $settings->grace_period) }}"
                           class="w-full p-2 border rounded">
                </div>
            </div>
        </div>

        <!-- Notification Settings Card -->
        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="text-lg font-semibold mb-4">🔔 Notifications</h3>
            
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="enable_email_notifications" 
                           id="enable_email" value="1"
                           {{ $settings->enable_email_notifications ? 'checked' : '' }}>
                    <label class="text-gray-700">Enable Email Notifications</label>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Send Reminder (Days Before Due)</label>
                    <input type="number" name="reminder_days_before_due" 
                           value="{{ old('reminder_days_before_due', $settings->reminder_days_before_due) }}"
                           class="w-full p-2 border rounded">
                </div>
            </div>
        </div>

        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            Save Changes
        </button>
    </form>
</div>
@endsection