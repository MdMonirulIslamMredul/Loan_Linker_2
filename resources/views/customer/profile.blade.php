@extends('layouts.customer')

@section('customer-content')
    <div class="mt-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('customer.profile.edit') }}" class="btn btn-primary me-2">Edit Profile</a>
        <a href="{{ route('customer.profile.password.edit') }}" class="btn btn-warning me-2">Change Password</a>
        <a href="{{ route('customer.documents') }}" class="btn btn-info me-2">Upload Documents</a>
        <a href="{{ route('customer.financial') }}" class="btn btn-success">Financial Info</a>

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
                    <th>Date of Birth</th>
                    <td>{{ $user->dob ? $user->dob->format('M d, Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Contact Address</th>
                    <td>{{ $user->contact_address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Permanent Address</th>
                    <td>{{ $user->permanent_address ?? '-' }}</td>
                </tr>   
                <tr>
                    <th>Education</th>
                    <td>{{ $user->education ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Profession</th>
                    <td>{{ $user->profession ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Organization</th>
                    <td>{{ $user->organization_name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Designation</th>
                    <td>{{ $user->designation ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Date of Joining</th>
                    <td>{{ $user->date_of_joining ? $user->date_of_joining->format('M d, Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Working Experience</th>
                    <td>{{ $user->total_working_experience ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>{{ $user->role }}</td>
                </tr>
                <tr>
                    <th>Joined</th>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $user->updated_at->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
