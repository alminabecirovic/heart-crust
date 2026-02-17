@extends('layouts.app')

@section('content')
<div class="card" style="margin: 0 auto;">
    <h2>Izmena oglasa hrane</h2>
    
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <p><strong>Naziv hrane:</strong> {{ $listing->food_name }}</p>
        <p><strong>Početna količina:</strong> {{ $listing->original_quantity }}</p>
        <p><strong>Trenutna količina:</strong> 
            <span style="color: green; font-weight: bold;">
                {{ $listing->quantity }}
            </span>
        </p>
        <p><strong>Rezervisano od strane korisnika:</strong> 
            {{ $listing->original_quantity - $listing->quantity }}
        </p>
    </div>

    <form action="{{ route('food.update', $listing->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="quantity">Izmeni količinu</label>
            <input type="number" name="quantity" id="quantity"
                   value="{{ old('quantity', $listing->quantity) }}" min="0" required>
            <small>Možeš ručno povećati (dodati još hrane) ili smanjiti ovu vrednost</small>
        </div>

        <div class="form-group">
            <label for="is_available">Dostupnost</label>
            <select name="is_available" id="is_available" required>
                <option value="1" {{ old('is_available', $listing->is_available) == 1 ? 'selected' : '' }}>
                    Dostupno
                </option>
                <option value="0" {{ old('is_available', $listing->is_available) == 0 ? 'selected' : '' }}>
                    Nedostupno
                </option>
            </select>
            <small>Postavi na „Nedostupno“ da privremeno sakriješ ovaj oglas</small>
        </div>

        <button type="submit" class="btn btn-success">Sačuvaj izmene</button>
        <a href="{{ route('food.my-listings') }}" class="btn">Otkaži</a>
    </form>

    <hr style="margin: 30px 0;">

    <form action="{{ route('food.destroy', $listing->id) }}" method="POST"
          onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovaj oglas?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Obriši oglas</button>
    </form>
</div>
@endsection
