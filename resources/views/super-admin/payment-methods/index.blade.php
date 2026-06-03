@extends('layouts.admin')

@section('title', 'Payment Methods')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Payment Methods</h5>
                <small class="text-muted">Manage payment channels used by branch admins for package purchases.</small>
            </div>
            <a href="{{ route('super-admin.payment-methods.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Payment Method
            </a>
        </div>
        <div class="card-body">
            @if ($paymentMethods->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Image</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentMethods as $method)
                                <tr>
                                    <td>{{ $method->name }}</td>
                                    <td>{{ $method->number ?? 'N/A' }}</td>
                                    <td>
                                        @if ($method->image)
                                            <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->name }}"
                                                style="width:40px; height:40px; object-fit:contain;" />
                                        @else
                                            <span class="text-muted">None</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('super-admin.payment-methods.edit', $method) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                        <form action="{{ route('super-admin.payment-methods.destroy', $method) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this payment method?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $paymentMethods->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center text-muted py-5">
                    No payment methods have been added yet.
                </div>
            @endif
        </div>
    </div>
@endsection
