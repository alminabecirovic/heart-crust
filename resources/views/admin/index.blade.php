@extends('layouts.app')

@section('content')

<div class="card">
    <h2>Korisnici koji čekaju odobrenje</h2>
    
    <table>
        <thead>
            <tr>
                <th>Ime</th>
                <th>Email</th>
                <th>Uloga</th>
                <th>Naziv pekare</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->bakery_name ?? 'Nema podataka' }}</td>
                    <td>
                        <form action="{{ route('admin.approve-user', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Odobri</button>
                        </form>
                        
                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                Obriši
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nema korisnika za odobravanje.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card" style="margin-top: 2rem;">
    <h2>Odobreni korisnici</h2>
    
    <table>
        <thead>
            <tr>
                <th>Ime</th>
                <th>Email</th>
                <th>Uloga</th>
                <th>Naziv pekare</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approvedUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->bakery_name ?? 'Nema podataka' }}</td>
                    <td>
                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?')">
                                Obriši
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nema odobrenih korisnika.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection