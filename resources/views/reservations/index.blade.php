@extends('layouts.app')

@section('content')
<h1>My Reservations</h1>

<table>
    <thead>
        <tr>
            <th>Food</th>
            <th>Bakery</th>
            <th>Pickup Address</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Reserved At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reservations as $reservation)
            <tr>
                <td>{{ $reservation->foodListing->food_name }}</td>
                <td>{{ $reservation->foodListing->bakery_name }}</td>
                <td>{{ $reservation->foodListing->pickup_address }}</td>
                <td>{{ $reservation->quantity }}</td>
                <td>
                    @if($reservation->status === 'pending')
                        <span style="color: orange;">Pending</span>
                    @elseif($reservation->status === 'completed')
                        <span style="color: green;">Completed</span>
                    @else
                        <span style="color: red;">Cancelled</span>
                    @endif
                </td>
                <td>{{ $reservation->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if($reservation->status === 'completed' && !$reservation->survey)
                        <a href="{{ route('surveys.create', $reservation->id) }}" class="btn">Create Survey</a>
                    @elseif($reservation->survey)
                        <span style="color: green;">Survey completed</span>
                    @else
                        <span style="color: gray;">Waiting for pickup</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No reservations yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection