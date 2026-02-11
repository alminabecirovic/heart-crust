@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Dodaj novu hranu</h2>
    
    <form action="{{ route('food.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="food_name">Naziv hrane</label>
            <input type="text" name="food_name" id="food_name" value="{{ old('food_name') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Slika</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>

        <div class="form-group">
            <label for="pickup_address">Adresa preuzimanja</label>
            <input type="text" name="pickup_address" id="pickup_address"
                   value="{{ old('pickup_address', auth()->user()->address) }}" required>
        </div>

        <div class="form-group">
            <label for="quantity">Količina</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="made_at">Vreme pripreme</label>
            <input type="datetime-local" name="made_at" id="made_at" value="{{ old('made_at') }}" required>
        </div>

        <div class="form-group">
            <label for="ingredients">Sastojci</label>
            <textarea name="ingredients" id="ingredients" required>{{ old('ingredients') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Kreiraj oglas</button>
        <a href="{{ route('food.my-listings') }}" class="btn">Otkaži</a>
    </form>
</div>
@endsection
