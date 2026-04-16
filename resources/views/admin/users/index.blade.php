@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="card">
    <h1>Manage Users</h1>
    <div class="table-wrap mt-16">
        <table>
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Type</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_type }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
