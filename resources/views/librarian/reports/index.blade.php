@extends('layouts.librarian')

@section('title', 'Reports')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold">Generate Reports</h2>
    </div>

    <div class="p-6">
        <form action="{{ route('librarian.reports.generate') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Report Type</label>
                    <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="loans">Loan History</option>
                        <option value="fines">Fines Collected</option>
                        <option value="overdue">Overdue Books</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Date Range</label>
                    <div class="mt-1 flex gap-2">
                        <input type="date" name="start_date" class="rounded-md border-gray-300 shadow-sm" required>
                        <input type="date" name="end_date" class="rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Generate Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection