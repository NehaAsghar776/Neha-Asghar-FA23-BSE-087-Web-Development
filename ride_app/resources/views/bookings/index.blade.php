<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">My Bookings</h3>
        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pickup</th>
                        <th>Dropoff</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Passengers</th>
                        <th>Fare</th>
                        <th>Driver</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($bookings as $b)
                    <tr>
                        <td>{{ $b->id }}</td>
                        <td>{{ $b->pickup }}</td>
                        <td>{{ $b->dropoff }}</td>
                        <td>{{ $b->date?->format('Y-m-d') }}</td>
                        <td>{{ $b->time }}</td>
                        <td>{{ $b->passengers }}</td>
                        <td>PKR {{ number_format($b->fare, 2) }}</td>
                        <td>{{ $b->driver_name ?? '-' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $b->status }}</span></td>
                        <td>{{ $b->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No bookings yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>

