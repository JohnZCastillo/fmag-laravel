@extends('layouts.user-index')

@section('body')

    <div class="container-fluid py-2 px-4">
        <form enctype="multipart/form-data" action="/order/checkout/{{$order->id}}" method="POST" id="checkoutForm">
            <div id="initialPage" class="row">
                <div class="col-md-8">
                    <section id="cart">
                        <h2>Checkout Page</h2>
                        <div class="card">
                            @foreach($order->items as $item)
                                <div class="row g-0 mb-2">
                                    <div class="col-md-4">
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($item->product->image)}}"
                                             class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body ">
                                            <h5 class="card-title">{{$item->product->name}}</h5>
                                            <p class="card-text mb-0">Price: {{$item->product->price}}</p>
                                            <p id="remain" class="card-text mb-0">Remaining
                                                Stock: {{$item->product->stock}}</p>
                                            <div class="mt-1 row ">
                                                <div class="col-sm">
                                                    <label>Quantity:</label>
                                                    <input type="number" class="form-control quantity"
                                                           value="{{$item->quantity}}">
                                                </div>
                                                <div class="col-sm">
                                                    <label for="subTotal">Sub total:</label>
                                                    <input type="text" class="d-none" value="{{$item->quantity}}"
                                                           readonly>
                                                    <input type="number" class="form-control" value="{{$item->total}}"
                                                           readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
                <div class="col-md-4">
                    <section id="checkout-form">

                        <h2>Shipping Information</h2>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                   value="{{$user->name}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="address">Address:</label>
                            <select class="form-control" id="address" name="address">
                                @foreach($user->addresses as $address)
                                    <option value="{{$address->id}}">{{$address->location}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="payment">Payment Method:</label>
                            <select class="form-control" id="payment" name="payment" required>
                                @foreach(\App\Enums\PaymentMethod::cases() as $method)
                                    <option value="{{$method->name}}">{{$method->value}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-2 form-group">
                            <label for="shippingFee">Shipping Fee:</label>
                            <input name="shippingFee" id="shippingFee" readonly class="form-control">
                        </div>

                        <div class="mt-2 form-group">
                            <label for="total">Total Amount:</label>
                            <input id="total" readonly value="{{$total}}" class="form-control">
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-2 ">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#cancelOrderModal">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#confirmOrderModal">
                                Place Order
                            </button>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Cancel Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <a class="btn btn-primary" href="/shop">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Confirmation Modal -->
    <div class="modal fade" id="confirmOrderModal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with this order?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No
                    </button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection

{% block body %}


{% endblock %}

{% block javascript %}
<script>

    // const orderConfirmationModal = new bootstrap.Modal(document.getElementById('confirmOrderModal'));
    {{--const checkoutForm = document.querySelector('#checkoutForm');--}}
    {{--const shippingFeeField = document.querySelector('#shippingFee');--}}
    {{--const shippingAddress = document.querySelector('#address');--}}
    {{--const paymentMethod = document.querySelector('#payment');--}}
    {{--const initialPage = document.querySelector('#initialPage');--}}
    {{--const gcashPage = document.querySelector('#gcashPage');--}}
    {{--const totalInput = document.querySelector('#total');--}}
    {{--const gcashReceiptImgInput = document.querySelector('#gcashReceiptImg');--}}

    {{--shippingAddress.addEventListener('change', updateShippingFee);--}}

    {{--async function updateShippingFee() {--}}

    {{--    const result = await fetch(`{{base_path()}}/api/shipping-rate/${shippingAddress.value}`);--}}
    {{--    const data = await result.json();--}}

    {{--    if (result.ok) {--}}
    {{--        shippingFeeField.value = data.rate;--}}
    {{--        totalInput.value = parseInt('{{total}}') + data.rate;--}}
    {{--    } else {--}}
    {{--        alert("Something went wrong while configuring shipping rate, please try again");--}}
    {{--    }--}}
    {{--}--}}

    {{--checkoutForm.addEventListener('submit', (e) => {--}}

    {{--    e.preventDefault();--}}

    {{--    orderConfirmationModal.hide();--}}

    {{--    if (paymentMethod.value === 'GCASH') {--}}

    {{--        initialPage.classList.add('d-none');--}}
    {{--        gcashPage.classList.remove('d-none');--}}

    {{--        document.querySelector('#gcashTotal').innerHTML = totalInput.value;--}}
    {{--    } else {--}}
    {{--        checkoutForm.submit();--}}
    {{--    }--}}

    {{--})--}}

    {{--function submitForm() {--}}
    {{--    if (gcashReceiptImgInput.value) {--}}
    {{--        checkoutForm.submit();--}}
    {{--        document.querySelector('#gcashReceiptImgError').classList.add('d-none');--}}
    {{--    } else {--}}
    {{--        document.querySelector('#gcashReceiptImgError').classList.remove('d-none');--}}
    {{--    }--}}
    {{--}--}}

    {{--window.addEventListener('load', updateShippingFee);--}}

    {{--function reloadPage() {--}}
    {{--    location.reload();--}}
    {{--}--}}

</script>

{% endblock %}
