@extends('layouts.app')

@section('title', 'Donation History')

@section('content')
<div class="card">
    <h1>Donation History</h1>

    <div class="table-wrap mt-16">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Group</th>
                    <th>District</th>
                    <th>Last Donation</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td>{{ $donation->id }}</td>
                        <td>{{ $donation->name }}</td>
                        <td>{{ $donation->blood_group }}</td>
                        <td>{{ $donation->district }}</td>
                        <td>{{ optional($donation->last_donation_date)->format('M j, Y g:i a') ?? 'N/A' }}</td>
                        <td>{{ $donation->is_active ? 'Yes' : 'No' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No donation records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
