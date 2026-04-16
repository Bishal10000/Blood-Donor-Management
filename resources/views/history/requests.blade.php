@extends('layouts.app')

@section('title', 'Request History')

@section('content')
<div class="card">
    <h1>Request History</h1>

    <div class="table-wrap mt-16">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Group</th>
                    <th>Phone</th>
                    <th>Requested At</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->blood_group }}</td>
                        <td>{{ $request->phone }}</td>
                        <td>{{ optional($request->requested_at)->format('M j, Y g:i a') ?? $request->created_at?->format('M j, Y g:i a') }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No request records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
