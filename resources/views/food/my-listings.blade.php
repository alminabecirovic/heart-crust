@extends('layouts.app')

@section('content')
<h1>My Food Listings</h1>

<a href="{{ route('food.create') }}" class="btn" style="margin-bottom: 20px;">Add New Food</a>

<div class="grid">
    @forelse($listings as $listing)
        <div class="card">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->food_name }}">
            @endif
            
            <h3>{{ $listing->food_name }}</h3>
            <p><strong>Quantity:</strong> 
                <span style="color: {{ $listing->quantity > 0 ? 'green' : 'red' }};">
                    {{ $listing->quantity }}
                </span> 
                / {{ $listing->original_quantity }}
            </p>
            <p><strong>Reserved:</strong> {{ $listing->original_quantity - $listing->quantity }}</p>
            <p><strong>Status:</strong> 
                @if($listing->is_available && $listing->quantity > 0)
                    <span style="color: green;">Available</span>
                @elseif($listing->quantity == 0)
                    <span style="color: red;">Sold Out</span>
                @else
                    <span style="color: orange;">Hidden</span>
                @endif
            </p>
            <p><strong>Made:</strong> {{ $listing->made_at->format('d.m.Y H:i') }}</p>
            <p><strong>Posted:</strong> {{ $listing->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Expires:</strong> {{ $listing->created_at->addDays(2)->format('d.m.Y H:i') }}</p>
            
            <div style="margin-top: 15px;">
                <a href="{{ route('food.edit', $listing->id) }}" class="btn">Manage</a>
                <form action="{{ route('food.destroy', $listing->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p>You have no food listings yet.</p>
    @endforelse
</div>
@endsection