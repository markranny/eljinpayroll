<!DOCTYPE html>
<html>
<head>
    <title>Attendance Logs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Attendance Logs</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $log)
                    <tr>
                        <td>{{ $log['id'] }}</td>
                        <td>{{ $log['name'] }}</td>
                        <td>{{ $log['timestamp'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
