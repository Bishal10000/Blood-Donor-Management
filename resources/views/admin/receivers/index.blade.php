@extends('layouts.app')

@section('title', 'Manage Receiver Requests')

@section('content')
<div class="card">
    <h1>Manage Blood Requests</h1>
    <div class="table-wrap mt-16">
        <table>
            <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Blood Group</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->phone }}</td>
                        <td>{{ $request->blood_group }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.receivers.edit', $request) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.receivers.verify', $request) }}" class="inline-form">
                                @csrf
                                <button class="btn" type="submit">Verify</button>
                            </form>
                            <form method="POST" action="{{ route('admin.receivers.destroy', $request) }}" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No requests found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
