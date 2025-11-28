@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Create Survey</h2>
    
    <p><strong>Bakery:</strong> {{ $reservation->foodListing->bakery_name }}</p>
    <p><strong>Food:</strong> {{ $reservation->foodListing->food_name }}</p>
    
    <form action="{{ route('surveys.store') }}" method="POST">
        @csrf
        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
        
        <div class="form-group">
            <label for="food_quality">Food Quality</label>
            <select name="food_quality" id="food_quality" required>
                <option value="">Select</option>
                <option value="good">Good</option>
                <option value="bad">Bad</option>
            </select>
        </div>

        <div class="form-group">
            <label for="staff_friendliness">Staff Friendliness</label>
            <select name="staff_friendliness" id="staff_friendliness" required>
                <option value="">Select</option>
                <option value="friendly">Friendly</option>
                <option value="unfriendly">Unfriendly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="comment">Comment (Optional)</label>
            <textarea name="comment" id="comment"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Survey</button>
        <a href="{{ route('reservations.index') }}" class="btn">Cancel</a>
    </form>
</div>
@endsection