@extends('layouts.app')

@section('title', 'Manage Donors')

@section('content')
<div class="card">
    <h1>Manage Donors</h1>
    <div class="table-wrap mt-16">
        <table>
            <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Blood Group</th><th>District</th><th>Action</th></tr></thead>
            <tbody>
                @forelse($donors as $donor)
                    <tr>
                        <td>{{ $donor->id }}</td>
                        <td>{{ $donor->name }}</td>
                        <td>{{ $donor->phone }}</td>
                        <td>{{ $donor->blood_group }}</td>
                        <td>{{ $donor->district }}</td>
                        <td>
                            <a class="btn" href="{{ route('admin.donors.edit', $donor) }}">Edit</a>
                            <form method="POST" action="{{ route('admin.donors.verify', $donor) }}" class="inline-form">
                                @csrf
                                <button class="btn" type="submit">Verify</button>
                            </form>
                            <form method="POST" action="{{ route('admin.donors.destroy', $donor) }}" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No donors found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
