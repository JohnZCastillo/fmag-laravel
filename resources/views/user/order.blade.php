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

        <a href="/orders" role="button" class="btn btn-primary mb-2">Back</a>

        <div class="card h-100">

            <div class="card-body">

                @if($order->status == \App\Enums\OrderStatus::COMPLETED)
                    <div class="alert alert-success mt-2" role="alert">
                        Transaction Completed
                    </div>
                @endif

                @if($order->status == \App\Enums\OrderStatus::FAILED)
                    <div class="mt-2 mt-md-0 col-sm">
                        <h2 class="text-danger">Order has been Rejected!</h2>
                        <p><strong>Reason:</strong> {{$order->reason}}</p>
                    </div>
                @endif

                @if($order->status == \App\Enums\OrderStatus::CANCELLED)
                    <div class="mt-2 mt-md-0 col-sm">
                        <h2 class="text-danger">Order has been Cancelled!</h2>
                        <p><strong>Reason:</strong> {{$order->reason}}</p>
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
                            <td>{{ \App\Helper\CurrencyHelper::currency($item->price) }}</td>
                            <td>{{ \App\Helper\CurrencyHelper::currency($item->total) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">Shipping Fee</td>
                        @if($order->address)
                            <td>{{ \App\Helper\CurrencyHelper::currency($order->address->shipping_fee) }}</td>
                        @else
                            <td></td>
                        @endif
                    </tr>

                    <tr>
                        <td colspan="3">Total</td>
                        <td>{{ \App\Helper\CurrencyHelper::currency($total) }}</td>
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

                                @if($order->payment && $order->payment->file)
                                    <div class="col-sm form-group">
                                        <div class="form-group">
                                            <label for="receipt">Payment Proof</label>
                                            <img
                                                onclick="showImageModal('{{\Illuminate\Support\Facades\Storage::url($order->payment->file)}}')"
                                                id="receipt" class="img-thumbnail"
                                                src="{{\Illuminate\Support\Facades\Storage::url($order->payment->file)}}">
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </form>
                    @endif
                </div>


                @if($order->status == \App\Enums\OrderStatus::DELIVERY)
                    <form method="POST" action="/order-complete/{{$order->id}}">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Order Complete
                        </button>
                    </form>
                @endif


                @if($order->status == \App\Enums\OrderStatus::PENDING)
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Cancel Order
                    </button>
                @endif

                @if($order->refunded)
                    <hr>
                    <p class="small text-dark mt-1">
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
        <form id="denyForm" method="POST" action="/order-cancel/{{$order->id}}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cancel Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" class="d-none" name="reason" id="hiddenReason">

                        <label for="reason">Reason for cancelling</label>
                        <select id="reason" class="form-control" required>
                            <option value="Don’t want to buy anymore">Don’t want to buy anymore</option>
                            <option value="Need to change Delivery address">Need to change Delivery address</option>
                            <option value="Need to modify order (Quantity, Size, etc.)">Need to modify order (Quantity,
                                Size, etc.)
                            </option>
                            <option value="others">Others</option>
                        </select>

                        <div class="d-none mt-2" id="specifyReason">
                            <label for="others">Please Specify</label>
                            <textarea rows="4" id="others" class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>

        console.log('hello world');

        const denyForm = document.querySelector('#denyForm');
        const denyReason = document.querySelector('#reason');
        const otherReason = document.querySelector('#others');
        const specifyReason = document.querySelector('#specifyReason');
        const othersOption = document.querySelector('#othersOption');
        const hiddenReason = document.querySelector('#hiddenReason');

        denyForm.addEventListener('submit', (e) => {
            e.preventDefault();

            if (denyReason.value === 'others') {
                hiddenReason.value = otherReason.value;
            } else {
                hiddenReason.value = denyReason.value;
            }

            denyForm.submit();
        })

        denyReason.addEventListener('change', (e) => {
            if (denyReason.value === 'others') {
                specifyReason.classList.remove('d-none');
            } else {
                specifyReason.classList.add('d-none');
            }
        })

    </script>
@endsection
