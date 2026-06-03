@extends('layouts.admin')

@section('title', 'Edit Payment Method')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Edit Payment Method</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('super-admin.payment-methods.update', $paymentMethod) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $paymentMethod->name) }}" required>
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Number</label>
                    <input type="text" name="number" class="form-control" value="{{ old('number', $paymentMethod->number) }}">
                    @error('number')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if ($paymentMethod->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $paymentMethod->image) }}" alt="{{ $paymentMethod->name }}" style="width:480px; height:480px; object-fit:contain;" />
                        </div>
                    @endif
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('super-admin.payment-methods.index') }}" class="btn btn-outline-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Payment Method</button>
                </div>
            </form>
        </div>
    </div>
@endsection
