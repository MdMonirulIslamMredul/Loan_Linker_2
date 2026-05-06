@extends('layouts.landing')

@section('title', isset($title) ? $title . ' - Customer' : 'Customer Dashboard')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Account</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item"><a href="{{ route('customer.dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                            <li class="nav-item"><a href="{{ route('customer.profile') }}" class="nav-link">Profile</a></li>
                            <li class="nav-item"><a href="{{ route('customer.applications') }}" class="nav-link">My
                                    Applications details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                @yield('customer-content')
            </div>
        </div>
    </div>
@endsection
