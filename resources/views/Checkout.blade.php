@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            Checkout
        </div>

        <div class="card-body">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Shirt</th>
                                <th>Size</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th width="120">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shirts as $shirt)
                                <tr>
                                    <td class="fw-semibold">{{ $shirt->name }}</td>
                                    <td>{{ $shirt->size }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $shirt->stock }}
                                        </span>
                                    </td>
                                    <td class="text-success">
                                        ${{ number_format($shirt->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $shirt->description }}
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            name="items[{{ $shirt->id }}][qty]" 
                                            class="form-control"
                                            min="0" 
                                            max="{{ $shirt->stock }}"
                                            value="0"
                                        >

                                        <input 
                                            type="hidden" 
                                            name="items[{{ $shirt->id }}][shirt_id]" 
                                            value="{{ $shirt->id }}"
                                        >
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Checkout
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

