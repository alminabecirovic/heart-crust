@extends('layouts.app')

@section('content')
<h1>Admin Panel</h1>

<div class="card">
    <h2>Pending User Approvals</h2>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bakery Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendingUsers as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>{{ $user->bakery_name ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.approve-user', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                        
                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No pending approvals.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection