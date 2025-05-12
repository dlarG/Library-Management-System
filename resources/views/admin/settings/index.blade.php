@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-lg font-semibold">System Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Manage library-wide configurations and preferences</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-8">
        @csrf
        @method('PUT')

        <!-- General Settings -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium">General Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Library Name</label>
                    <input type="text" name="library_name" value="{{ $settings->library_name ?? 'LibraLynx' }}">
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Email</label>
                    <input type="email" name="library_email" value="{{ $settings['library_email'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="library_phone" value="{{ $settings['library_phone'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="library_address" class="mt-1 block w-full rounded-lg border-gray-300" 
                              rows="3">{{ $settings['library_address'] }}</textarea>
                </div>
            </div>
        </div>

        <!-- Operational Hours -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium">Operational Hours</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Opening Time</label>
                    <input type="time" name="opening_time" value="{{ $settings['opening_time'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Closing Time</label>
                    <input type="time" name="closing_time" value="{{ $settings['closing_time'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
            </div>
        </div>

        <!-- Fine Rates -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium">Fine Rates (per day)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Filipiniana Books</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">₱</span>
                        </div>
                        <input type="number" step="0.01" name="fine_rate_filipiniana" 
                               value="{{ $settings['fine_rate_filipiniana'] }}" 
                               class="block w-full pl-7 pr-12 rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">General Circulation</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">₱</span>
                        </div>
                        <input type="number" step="0.01" name="fine_rate_general" 
                               value="{{ $settings['fine_rate_general'] }}" 
                               class="block w-full pl-7 pr-12 rounded-lg border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Reserve Books</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">₱</span>
                        </div>
                        <input type="number" step="0.01" name="fine_rate_reserve" 
                               value="{{ $settings['fine_rate_reserve'] }}" 
                               class="block w-full pl-7 pr-12 rounded-lg border-gray-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Policies -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium">Loan Policies</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Default Loan Period (days)</label>
                    <input type="number" name="default_loan_period" 
                           value="{{ $settings['default_loan_period'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Maximum Renewals</label>
                    <input type="number" name="max_renewals" 
                           value="{{ $settings['max_renewals'] }}" 
                           class="mt-1 block w-full rounded-lg border-gray-300">
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="space-y-6">
            <h3 class="text-lg font-medium">Notifications</h3>
            <div class="flex items-center">
                <input type="checkbox" name="enable_email_notifications" id="enable_email" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm" 
                       {{ $settings['enable_email_notifications'] ? 'checked' : '' }}>
                <label for="enable_email" class="ml-2 text-sm text-gray-700">
                    Enable Email Notifications
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-200">
            <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection