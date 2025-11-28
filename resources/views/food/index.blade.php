@extends('layouts.app')

@section('content')
<h1>Available Food</h1>

@guest
    <div class="alert" style="background-color: #e7f3ff; color: #004085; border: 1px solid #b3d7ff;">
        You are browsing as a guest. <a href="{{ route('register') }}">Register</a> or <a href="{{ route('login') }}">Login</a> to reserve food.
    </div>
@endguest

<div class="grid">
    @forelse($listings as $listing)
        <div class="card">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->food_name }}">
            @endif
            
            <h3>{{ $listing->food_name }}</h3>
            <p><strong>Bakery:</strong> {{ $listing->bakery_name }}</p>
            <p><strong>Address:</strong> {{ $listing->pickup_address }}</p>
            <p><strong>Quantity:</strong> {{ $listing->quantity }} available</p>
            <p><strong>Made:</strong> {{ $listing->made_at->format('d.m.Y H:i') }}</p>
            <p><strong>Ingredients:</strong> {{ $listing->ingredients }}</p>
            
            @auth
                @if(auth()->user()->isUser())
                    <form action="{{ route('reservations.store') }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        <input type="hidden" name="food_listing_id" value="{{ $listing->id }}">
                        <div class="form-group">
                            <label for="quantity_{{ $listing->id }}">Quantity to reserve</label>
                            <input type="number" name="quantity" id="quantity_{{ $listing->id }}" 
                                   min="1" max="{{ $listing->quantity }}" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-success">Reserve</button>
                    </form>
                @elseif(auth()->user()->isGuest())
                    <p style="color: #666; margin-top: 15px;">Register as a User to reserve food.</p>
                @endif

                @if(auth()->user()->isAdmin())
                    <form action="{{ route('admin.delete-listing', $listing->id) }}" method="POST" style="margin-top: 15px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                @endif
            @else
                <p style="color: #666; margin-top: 15px;">
                    <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to reserve food.
                </p>
            @endauth
        </div>
    @empty
        <p>No food available at the moment.</p>
    @endforelse
</div>
@endsection