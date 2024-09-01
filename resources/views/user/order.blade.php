@extends('layouts.user-account')



@section('styles')
    <style>
        .admin-content {
            flex-basis: 80%;
        }

        /* Mobile view */
        @media (max-width: 991.98px) {

            .table {
                border-color: black;
            }

            .table th {
                vertical-align: middle;
                text-align: center;
                font-size: 55%;
                align-content: center;
            }

            .table td {
                font-size: 70%;
            }

            tr:hover {
                background-color: #f2f2f2;
            }

        }
    </style>
@endsection

@section('body')
    <div class="admin-content bg-white h-100 text-dark">

        <a onclick="back()" role="button" class="btn btn-primary mb-2">Back</a>

        <div class="card h-100">

            <div class="card-body">

                @if($order->status == \App\Enums\OrderStatus::COMPLETED)
                    <div class="alert alert-success mt-2" role="alert">
                        Transaction Completed
                    </div>
                @endif

                <div class="row">

                    <div class="col-sm mb-2">
                        <h2>Order Details</h2>
                        <h5 class="card-title">Order ID: {{$order->id}}</h5>
                        <p class="card-text mb-1">Customer Name: {{$order->user->name}}</p>
                        <p class="card-text mb-1">Customer Email: {{$order->user->email}}</p>
                        @if($order->address)
                            <p class="card-text mb-1">Shipping Address: {{$order->address->location}}</p>
                        @else
                            <p class="card-text mb-1">Shipping Address:</p>
                        @endif
                    </div>

                    @if($order->action)
                        <div class="mt-2 mt-md-0 col-sm">
                            <h2>Your order has been {{$order->action->status}}!</h2>
                            <p><strong>Reason:</strong> {{$order->action->reason}}</p>
                        </div>
                    @endif

                </div>

                <table class="table table-bordered text-dark">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Shipping Fee</td>
                        @if($order->address)
                            <td>{{ $order->address->shipping_fee }}</td>
                        @else
                            <td></td>
                        @endif
                    </tr>

                    <tr>
                        <td colspan="3">Total</td>
                        @if($order->address)
                            <td>{{ $order->address->shipping_fee + $total}}</td>
                        @else
                            <td>{{ $total }}</td>
                        @endif
                    </tr>
                    </tbody>
                </table>

                <div class="row">

                    @if($order->delivery)
                        <form class="col-sm p-2 bg-light" id="deliveryForm">
                            <h2>Delivery Information</h2>
                            <div class="form-group mb-2">
                                <label for="logisticCompany">Logistic Company</label>
                                <input type="text" class="form-control" id="logisticCompany" name="logisticCompany"
                                       placeholder="" value="{{$order->delivery->logistic}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="trackingNumber">Tracking Number</label>
                                <input type="text" class="form-control" id="trackingNumber" name="trackingNumber"
                                       placeholder="" value="{{$order->delivery->tracking}}" readonly>
                            </div>
                        </form>
                    @endif

                    @if($order->payment)
                        <form class="col-sm pt-2 bg-light" id="paymentForm">

                            <h2>Payment Details</h2>

                            <div class="row">
                                <div class="col-sm form-group mb-2">
                                    <label for="paymentMethod">Payment Method</label>
                                    <input class="form-control" id="paymentMethod" name="paymentMethod"
                                           value="{{$order->payment->payment_method->value}}" readonly>
                                </div>

                                @if($order->payment->payment_method == \App\Enums\PaymentMethod::GCASH)
                                    <div class="col-sm form-group">
                                        <div class="form-group">
                                            <label for="receipt">Payment Proof</label>
                                            {{--                                        <img onclick="showImageModal('{{receipt}}')" id="receipt" class="img-thumbnail"--}}
                                            {{--                                             src="{{receipt}}">--}}
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </form>
                    @endif
                </div>

                @if($order->status == \App\Enums\OrderStatus::PENDING)
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Cancel Order
                    </button>
                @endif

                @if($order->refund)
                    <p class="text-secondary mt-1">
                        Your refund will be processed as soon as possible, and you will receive an e-mail notification
                        once
                        it
                        has been complete. if you have more question please direct message.
                        Thank you for choosing FMAG SHOP, and we are looking forward to serving you better in the
                        future.
                    </p>
                @endif

            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="POST" action="/order/{{$order->id}}">
            @csrf
            @method('PATCH')
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Cancellation Reason</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to cancel?
                            Sorry to see you cancel. Please tell us the reason, and we will try
                            to make your next shopping experience better! </p>

                        <select id="selectReason" name="reason" class="form-control mb-1">
                            <option value="1">Don’t want to buy anymore</option>
                            <option value="2">Need to change Delivery address</option>
                            <option value="3">Need to modify order (Quantity, Size, etc.)</option>
                            <option value="0">Other</option>
                        </select>

                        <div class="other-reason d-none">
                            <label>Other Reason</label>
                            <textarea rows="6" class="form-control" id="reason" name="otherReason"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('javascript')
    <script>
        const cancelOrder = document.querySelector('#selectReason');
        const otherReasonHolder = document.querySelector('.other-reason');

        cancelOrder.addEventListener('change', () => {
            if (Number(cancelOrder.value)) {
                otherReasonHolder.classList.add('d-none');
            } else {
                otherReasonHolder.classList.remove('d-none');
            }
        })

    </script>
@endsection
