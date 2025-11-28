@extends('layouts.app')

@section('content')
<h1>Surveys</h1>

<div class="grid">
    @forelse($surveys as $survey)
        <div class="card">
            <h3>{{ $survey->reservation->foodListing->bakery_name }}</h3>
            <p><strong>Food:</strong> {{ $survey->reservation->foodListing->food_name }}</p>
            <p><strong>User:</strong> {{ $survey->user->name }}</p>
            <p><strong>Food Quality:</strong> 
                <span style="color: {{ $survey->food_quality === 'good' ? 'green' : 'red' }}">
                    {{ ucfirst($survey->food_quality) }}
                </span>
            </p>
            <p><strong>Staff Friendliness:</strong> 
                <span style="color: {{ $survey->staff_friendliness === 'friendly' ? 'green' : 'red' }}">
                    {{ ucfirst($survey->staff_friendliness) }}
                </span>
            </p>
            @if($survey->comment)
                <p><strong>Comment:</strong> {{ $survey->comment }}</p>
            @endif
            <p><small>Submitted: {{ $survey->created_at->format('d.m.Y H:i') }}</small></p>
        </div>
    @empty
        <p>No surveys yet.</p>
    @endforelse
</div>
@endsection