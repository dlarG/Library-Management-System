<!DOCTYPE html>
<html>
<head>
    <title>{{ ucfirst($validated['type']) }} Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { border-bottom: 2px solid #333; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px solid #333; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="text-xl">{{ ucfirst($validated['type']) }} Report</h1>
        <p>
            {{ Carbon\Carbon::parse($validated['start_date'])->format('M d, Y') }} - 
            {{ Carbon\Carbon::parse($validated['end_date'])->format('M d, Y') }}
        </p>
    </div>

    @if($validated['type'] === 'loans')
        <!-- Loans Table -->
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book</th>
                    <th>Checkout Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $loan)
                <tr>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->created_at->format('M d, Y') }}</td>
                    <td>{{ $loan->due_date->format('M d, Y') }}</td>
                    <td>{{ $loan->return_date ? $loan->return_date->format('M d, Y') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($validated['type'] === 'fines')
        <!-- Fines Table -->
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Loan Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $fine)
                <tr>
                    <td>{{ $fine->user->name }}</td>
                    <td>${{ number_format($fine->amount, 2) }}</td>
                    <td>{{ $fine->paid_at?->format('M d, Y') ?? 'Unpaid' }}</td>
                    <td>
                        Book: {{ $fine->loan->book->title }}<br>
                        Due Date: {{ $fine->loan->due_date->format('M d, Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($validated['type'] === 'overdue')
        <!-- Overdue Table -->
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Book</th>
                    <th>Checkout Date</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $loan)
                <tr>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->created_at->format('M d, Y') }}</td>
                    <td>{{ $loan->due_date->format('M d, Y') }}</td>
                    <td>{{ now()->diffInDays($loan->due_date) }} days</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        Generated on {{ now()->format('M d, Y h:i A') }}
    </div>
</body>
</html>