@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Kreiraj anketu</h2>
    
    <p><strong>Pekara:</strong> {{ $reservation->foodListing->bakery_name }}</p>
    <p><strong>Proizvod:</strong> {{ $reservation->foodListing->food_name }}</p>
    
    <form action="{{ route('surveys.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
        
        <div class="form-group">
            <label for="food_quality">Kvalitet hrane</label>
            <select name="food_quality" id="food_quality" required>
                <option value="">Izaberite</option>
                <option value="good">Dobar</option>
                <option value="bad">Loš</option>
            </select>
        </div>

        <div class="form-group">
            <label for="staff_friendliness">Ljubaznost osoblja</label>
            <select name="staff_friendliness" id="staff_friendliness" required>
                <option value="">Izaberite</option>
                <option value="friendly">Ljubazno</option>
                <option value="unfriendly">Nelјubazno</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comment">Komentar (opciono)</label>
            <textarea name="comment" id="comment"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Pošalji anketu</button>
        <a href="{{ route('reservations.index') }}" class="btn">Otkaži</a>
    </form>
</div>
@endsection
