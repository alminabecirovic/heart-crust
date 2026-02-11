@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; color: #D6A99D; margin-bottom: 8px;">Ankete korisnika</h1>
        <p style="color: #8B6F5E; font-size: 14px;">Pregled svih prikupljenih povratnih informacija</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        @forelse($surveys as $survey)
            <div class="card" style="transition: box-shadow 0.25s ease;">
                <!-- Header -->
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 2px solid #F7F1DE;">
                    <h3 style="font-size: 20px; color: #D6A99D; margin-bottom: 8px;">
                        {{ $survey->reservation->foodListing->bakery_name }}
                    </h3>
                    <p style="color: #8B6F5E; font-size: 14px; margin: 0;">
                        <span style="background: #F7F1DE; padding: 4px 10px; border-radius: 6px; font-weight: 500; color: #8B6F5E;">
                            {{ $survey->reservation->foodListing->food_name }}
                        </span>
                    </p>
                </div>

                <!-- User Info -->
                <div style="margin-bottom: 20px;">
                    <p style="color: #8B6F5E; font-size: 13px; margin: 0;">
                        <svg style="display: inline-block; width: 14px; height: 14px; margin-right: 6px; vertical-align: text-bottom;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        {{ $survey->user->name }}
                    </p>
                </div>

                <!-- Ratings -->
                <div style="background: #F7F1DE; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                    <div style="margin-bottom: 12px;">
                        <p style="font-size: 13px; color: #8B6F5E; margin: 0 0 6px 0; font-weight: 600;">Kvalitet hrane:</p>
                        <span style="display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 6px; font-size: 14px; font-weight: 600; background: {{ $survey->food_quality === 'good' ? '#D6A99D' : '#C4957F' }}; color: white;">
                            <span style="font-size: 16px; margin-right: 6px;">{{ $survey->food_quality === 'good' ? '✓' : '✗' }}</span>
                            {{ $survey->food_quality === 'good' ? 'Dobar' : 'Loš' }}
                        </span>
                    </div>
                    
                    <div>
                        <p style="font-size: 13px; color: #8B6F5E; margin: 0 0 6px 0; font-weight: 600;">Ljubaznost osoblja:</p>
                        <span style="display: inline-flex; align-items: center; padding: 6px 12px; border-radius: 6px; font-size: 14px; font-weight: 600; background: {{ $survey->staff_friendliness === 'friendly' ? '#D6A99D' : '#C4957F' }}; color: white;">
                            <span style="font-size: 16px; margin-right: 6px;">{{ $survey->staff_friendliness === 'friendly' ? '✓' : '✗' }}</span>
                            {{ $survey->staff_friendliness === 'friendly' ? 'Ljubazno' : 'Neljubazno' }}
                        </span>
                    </div>
                </div>

                <!-- Comment -->
                @if($survey->comment)
                    <div style="background: white; border-left: 3px solid #D6A99D; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                        <p style="font-size: 13px; color: #D6A99D; font-weight: 600; margin: 0 0 6px 0;">💬 Komentar:</p>
                        <p style="font-size: 14px; color: #8B6F5E; margin: 0; line-height: 1.5;">{{ $survey->comment }}</p>
                    </div>
                @endif

                <!-- Footer -->
                <div style="padding-top: 12px; border-top: 1px solid #D6A99D;">
                    <p style="font-size: 12px; color: #8B6F5E; margin: 0;">
                        <svg style="display: inline-block; width: 12px; height: 12px; margin-right: 4px; vertical-align: text-bottom;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        {{ $survey->created_at->format('d.m.Y H:i') }}
                    </p>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #FAF7F3; border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); border: 2px solid #D6A99D;">
                <div style="font-size: 48px; margin-bottom: 16px; opacity: 0.4;">📋</div>
                <p style="font-size: 18px; color: #D6A99D; font-weight: 500; margin: 0;">Još uvek nema anketa.</p>
                <p style="font-size: 14px; color: #8B6F5E; margin: 8px 0 0 0;">Povratne informacije će se pojaviti ovde kada korisnici popune ankete.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card:hover {
        box-shadow: 0 8px 20px rgba(214, 169, 157, 0.2);
    }
</style>
@endsection