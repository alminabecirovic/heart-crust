@extends('layouts.app')

@section('content')
<h1>Moje rezervacije</h1>

<table>
    <thead>
        <tr>
            <th>Hrana</th>
            <th>Pekara</th>
            <th>Adresa za preuzimanje</th>
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
                <td>{{ $reservation->foodListing->bakery_name }}</td>
                <td>{{ $reservation->foodListing->pickup_address }}</td>
                <td>{{ $reservation->quantity }}</td>
                <td>
                    @if($reservation->status === 'pending')
                        <span style="color: orange;">Na čekanju</span>
                    @elseif($reservation->status === 'completed')
                        <span style="color: green;">Završeno</span>
                    @else
                        <span style="color: red;">Otkazano</span>
                    @endif
                </td>
                <td>{{ $reservation->created_at->format('d.m.Y H:i') }}</td>
                <td>
                    @if($reservation->status === 'completed' && !$reservation->survey)
                        <a href="{{ route('surveys.create', $reservation->id) }}" class="btn">
                            Popuni anketu
                        </a>
                    @elseif($reservation->survey)
                        <span style="color: green;">Anketa popunjena</span>
                    @else
                        <span style="color: gray;">Čeka se preuzimanje</span>
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
