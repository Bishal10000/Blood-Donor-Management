@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="card">
    <h1>Notifications</h1>

    <div class="table-wrap mt-16">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                    <tr class="{{ $notification->status === 'unread' ? 'status-unread' : '' }}">
                        <td>{{ $notification->id }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>{{ $notification->created_at?->format('M j, Y g:i a') }}</td>
                        <td>{{ ucfirst($notification->status) }}</td>
                        <td>
                            @if($notification->status === 'unread')
                                <form action="{{ route('notifications.read', $notification) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn" type="submit">Mark as Read</button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline-form-spaced">
                                @csrf
                                @method('DELETE')
                                <button class="btn" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No notifications found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
