@extends('layouts.app')

@section('content')
<h1>Rezervacije za moju hranu</h1>

<table>
    <thead>
        <tr>
            <th>Hrana</th>
            <th>Korisnik</th>
            <th>Email korisnika</th>
            <th>Količina</th>
            <th>Status</th>
            <th>Datum rezervacije</th>
            <th>Akcije</th>
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
                        <span>Na čekanju</span>
                    @elseif($reservation->status === 'completed')
                        <span>Završeno</span>
                    @else
                        <span>Otkazano</span>
                    @endif
                </td>
                <td>{{ $reservation->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if($reservation->status === 'pending')
                        <form action="{{ route('reservations.complete', $reservation->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Označi kao završeno
                            </button>
                        </form>
                    @elseif($reservation->status === 'completed')
                        <span>Završeno</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Još uvek nema rezervacija.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
