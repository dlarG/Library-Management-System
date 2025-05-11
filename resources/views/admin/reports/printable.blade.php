<!DOCTYPE html>
<html>
<head>
    <title>Library Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 25px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LibraLynx Report</h1>
        <p>Generated on: {{ $printDate }}</p>
        <p>Date Range: {{ $filters['start_date'] }} to {{ $filters['end_date'] }}</p>
    </div>

    <div class="section">
        <h2>Loan Statistics</h2>
        <table>
            <tr><th>Total Loans</th><td>{{ $loanStats['total_loans'] }}</td></tr>
            <tr><th>Overdue Loans</th><td>{{ $loanStats['overdue'] }}</td></tr>
            <tr><th>Average Loan Duration</th><td>{{ number_format($loanStats['avg_loan_duration'], 1) }} days</td></tr>
            <tr><th>Total Fines</th><td>₱{{ number_format($loanStats['total_fines'], 2) }}</td></tr>
            <tr><th>Late Returns</th><td>{{ $loanStats['late_returns'] }}</td></tr>
            <tr><th>Peak Period</th><td>{{ $loanStats['peak_period'] }}</td></tr>
        </table>
    </div>

    <div class="section">
        <h2>Most Borrowed Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Book Title</th>
                    <th>Total Loans</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                @foreach($popularBooks as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->loans_count }}</td>
                    <td>{{ $book->available }}/{{ $book->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h2>Most Active Users</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Total Loans</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userActivity as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->loans_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>