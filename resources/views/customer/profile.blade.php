@extends('layouts.customer')

@section('customer-content')
    <div class="mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('customer.profile.edit') }}" class="btn btn-primary me-2">Edit Profile</a>
        <a href="{{ route('customer.profile.password.edit') }}" class="btn btn-warning">Change Password</a>
    </div>


    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">Your Profile</h4>

            <table class="table table-borderless">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr>
                    <th>Joined</th>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
