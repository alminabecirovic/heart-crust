@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h2>Edit Food Listing</h2>
    
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <p><strong>Food Name:</strong> {{ $listing->food_name }}</p>
        <p><strong>Original Quantity:</strong> {{ $listing->original_quantity }}</p>
        <p><strong>Current Quantity:</strong> <span style="color: green; font-weight: bold;">{{ $listing->quantity }}</span></p>
        <p><strong>Reserved by customers:</strong> {{ $listing->original_quantity - $listing->quantity }}</p>
    </div>

    <form action="{{ route('food.update', $listing->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="quantity">Update Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $listing->quantity) }}" min="0" required>
            <small>You can increase (add more food) or decrease this number manually</small>
        </div>

        <div class="form-group">
            <label for="is_available">Availability</label>
            <select name="is_available" id="is_available" required>
                <option value="1" {{ old('is_available', $listing->is_available) == 1 ? 'selected' : '' }}>Available</option>
                <option value="0" {{ old('is_available', $listing->is_available) == 0 ? 'selected' : '' }}>Not Available</option>
            </select>
            <small>Set to "Not Available" to temporarily hide this listing</small>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('food.my-listings') }}" class="btn">Cancel</a>
    </form>

    <hr style="margin: 30px 0;">

    <form action="{{ route('food.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Listing</button>
    </form>
</div>
@endsection