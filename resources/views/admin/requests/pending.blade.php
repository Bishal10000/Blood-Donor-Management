@extends('layouts.app')

@section('title', 'Pending Blood Requests')

@section('content')
<div class="card">
    <h1>Pending Blood Requests</h1>

    @if($requests->isEmpty())
        <p>No pending approvals.</p>
    @else
        <div class="table-wrap mt-16">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Blood Group</th>
                        <th>Location</th>
                        <th>Requisition</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>{{ $request->blood_group }}</td>
                            <td>{{ $request->province }}, {{ $request->district }}</td>
                            <td>
                                @if($request->requisition_file)
                                    <a href="{{ asset('storage/' . $request->requisition_file) }}" target="_blank">View</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.requests.approve', $request) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn primary" type="submit">Approve</button>
                                </form>
                                <form action="{{ route('admin.requests.reject', $request) }}" method="POST" class="inline-form-spaced">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn" type="submit">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
