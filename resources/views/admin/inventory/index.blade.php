@extends('layouts.app')

@section('title', 'Blood Inventory')

@section('content')
<div class="card">
    <h1>Blood Inventory</h1>

    <h3 class="mt-16">Add Inventory</h3>
    <form method="POST" action="{{ route('admin.inventory.store') }}" class="grid two">
        @csrf
        <div class="field"><label>Blood Group</label><input name="blood_group" value="{{ old('blood_group') }}" required></div>
        <div class="field"><label>Units</label><input type="number" name="available_units" value="{{ old('available_units', 0) }}" required></div>
        <div class="field"><label>Address</label><input name="address" value="{{ old('address') }}" required></div>
        <div class="field"><label>District</label><input name="district" value="{{ old('district') }}" required></div>
        <div class="field"><label>Province</label><input name="province" value="{{ old('province') }}"></div>
        <div class="field"><label>Municipality</label><input name="municipality" value="{{ old('municipality') }}"></div>
        <div class="field"><label>Health Post</label><input name="health_post" value="{{ old('health_post') }}"></div>
        <div class="field"><label>Contact</label><input name="contact" value="{{ old('contact') }}" required></div>
        <div class="field"><button class="btn primary" type="submit">Add</button></div>
    </form>

    <div class="table-wrap mt-20">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Blood Group</th>
                    <th>Units</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr>
                        <td>{{ $inventory->id }}</td>
                        <td>{{ $inventory->blood_group }}</td>
                        <td>{{ $inventory->available_units }}</td>
                        <td>{{ $inventory->address }}</td>
                        <td>{{ $inventory->contact }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.inventory.destroy', $inventory) }}" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No inventory records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
