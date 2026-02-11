@extends('layouts.app')

@section('content')

<a href="{{ route('food.create') }}" class="btn" style="margin-bottom: 20px;">
    Dodaj novu hranu
</a>

<div class="grid">
    @forelse($listings as $listing)
        <div class="card">
            @if($listing->image)
                <img src="{{ asset('storage/' . $listing->image) }}" alt="{{ $listing->food_name }}">
            @endif
            
            <h3>{{ $listing->food_name }}</h3>

            <p><strong>Količina:</strong> 
                <span>{{ $listing->quantity }}</span> / {{ $listing->original_quantity }}
            </p>

            <p><strong>Rezervisano:</strong> 
                {{ $listing->original_quantity - $listing->quantity }}
            </p>

            <p><strong>Status:</strong> 
                @if($listing->is_available && $listing->quantity > 0)
                    <span>Dostupno</span>
                @elseif($listing->quantity == 0)
                    <span>Rasprodato</span>
                @else
                    <span>Sakriveno</span>
                @endif
            </p>

            <p><strong>Pripremljeno:</strong> 
                {{ $listing->made_at->format('d.m.Y H:i') }}
            </p>

            <p><strong>Objavljeno:</strong> 
                {{ $listing->created_at->format('d.m.Y H:i') }}
            </p>

            <p><strong>Ističe:</strong> 
                {{ $listing->created_at->addDays(2)->format('d.m.Y H:i') }}
            </p>
            
            <div style="margin-top: 15px;">
                <a href="{{ route('food.edit', $listing->id) }}" class="btn">
                    Upravljaj
                </a>

                <form action="{{ route('food.destroy', $listing->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Da li ste sigurni?')">
                        Obriši
                    </button>
                </form>
            </div>
        </div>
    @empty
        <p>Još uvek nemaš objavljene oglase za hranu.</p>
    @endforelse
</div>
@endsection
