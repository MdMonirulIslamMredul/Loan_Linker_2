@extends('layouts.admin')

@section('title', 'Add Payment Method')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Add Payment Method</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('super-admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Number</label>
                    <input type="text" name="number" class="form-control" value="{{ old('number') }}">
                    @error('number')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.payment-methods.index') }}" class="btn btn-outline-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save Payment Method</button>
                </div>
            </form>
        </div>
    </div>
@endsection
