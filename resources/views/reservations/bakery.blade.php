@extends('layouts.app')

@section('content')
<h1>Reservations for My Food</h1>

<table>
    <thead>
        <tr>
            <th>Food</th>
            <th>Customer</th>
            <th>Customer Email</th>
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
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->user->email }}</td>
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
                    @if($reservation->status === 'pending')
                        <form action="{{ route('reservations.complete', $reservation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Mark as Completed</button>
                        </form>
                    @elseif($reservation->status === 'completed')
                        <span style="color: green;">✓ Completed</span>
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