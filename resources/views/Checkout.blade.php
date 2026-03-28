@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            Checkout
        </div>

        <div class="card-body">
            <form action="{{ route('shirts.create-dummy') }}" method="POST">
                @csrf
                <input type="number" name="count" class="form-control w-25 d-inline-block" value="1" min="1" max="5">
                <button type="submit" class="btn btn-sm btn-outline-secondary m-3">
                    Create Dummy Shirts
                </button>
            </form>
        </div>  

        <div class="card-body">
            <form id="payment-form" action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <!-- PRODUCT LIST -->
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

                <!-- PAYMENT SECTION -->
                <hr>

                <h5 class="mb-3">Payment</h5>

                <div class="mb-3">
                    <label class="form-label">Card Details</label>
                    <div id="card-element" class="form-control p-2"></div>
                </div>

                <div id="card-errors" class="text-danger mb-3"></div>

                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Pay & Checkout
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();

    const card = elements.create('card');
    card.mount('#card-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
            return;
        }

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'payment_method';
        hiddenInput.value = paymentMethod.id;
        form.appendChild(hiddenInput);

        form.submit();
    });
});
</script>
@endpush