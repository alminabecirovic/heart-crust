@extends('layouts.app')

@section('content')
<h1>Dostupna hrana</h1>

@guest
    <div class="alert" style="background-color: #e7f3ff; color: #004085; border: 1px solid #b3d7ff;">
        <a href="{{ route('register') }}">Registruj se</a> ili 
        <a href="{{ route('login') }}">Prijavi se</a> da bi rezervisao/la hranu.
    </div>
@endguest

<div class="grid">
    @forelse($listings as $listing)
        <div class="card">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->food_name }}">
            @endif
            
            <h3>{{ $listing->food_name }}</h3>
            <p><strong>Pekara:</strong> {{ $listing->bakery_name }}</p>
            <p><strong>Adresa:</strong> {{ $listing->pickup_address }}</p>
            <p><strong>Količina:</strong> {{ $listing->quantity }} dostupno</p>
            <p><strong>Pripremljeno:</strong> {{ $listing->made_at->format('d.m.Y H:i') }}</p>
            <p><strong>Sastojci:</strong> {{ $listing->ingredients }}</p>
            
            @auth
                @if(auth()->user()->isUser())
                    <form action="{{ route('reservations.store') }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        <input type="hidden" name="food_listing_id" value="{{ $listing->id }}">
                        <div class="form-group">
                            <label for="quantity_{{ $listing->id }}">Količina za rezervaciju</label>
                            <input type="number" name="quantity" id="quantity_{{ $listing->id }}" 
                                   min="1" max="{{ $listing->quantity }}" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-success">Rezerviši</button>
                    </form>
                @elseif(auth()->user()->isGuest())
                    <p style="color: #666; margin-top: 15px;">
                        Registruj se kao korisnik da bi mogao/la da rezervišeš hranu.
                    </p>
                @endif

                @if(auth()->user()->isAdmin())
                    <form action="{{ route('admin.delete-listing', $listing->id) }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni?')">
                            Obriši
                        </button>
                    </form>
                @endif
            @else
                <p style="color: #666; margin-top: 15px;">
                    <a href="{{ route('login') }}">Prijavi se</a> ili 
                    <a href="{{ route('register') }}">Registruj se</a> da bi rezervisao/la hranu.
                </p>
            @endauth
        </div>
    @empty
        <p>Trenutno nema dostupne hrane.</p>
    @endforelse
</div>
@endsection
