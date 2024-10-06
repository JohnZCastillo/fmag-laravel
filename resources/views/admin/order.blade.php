@extends('layouts.admin-index')

@section('files')
    <script src="/js/InputOnChangeSubmit.js"></script>
    <script src="/js/pristine.min.js"></script>
@endsection

@section('style')
    <style>
        .orders {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

@section('styles')
    <style>
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

    <a class="btn btn-primary mb-2" href="#" onclick="back()">Back</a>

    <div class="card">

        @if($errors->any())
            @if($order->status == \App\Enums\OrderStatus::COMPLETED)
                <div class="container-fluid mt-2">
                    <div class="alert alert-danger" role="alert">
                        Transaction Completed
                    </div>
                </div>
            @endif
        @endif

        <div class="card-body text-dark">

            @if($order->status == \App\Enums\OrderStatus::FAILED)
                <div class="alert alert-danger mt-2" role="alert">
                    Transaction Denied
                </div>
            @endif

            <div class="row">
                <div class="col-sm">
                    <h2>Order Details</h2>
                    <h5 class="card-title">Order ID: {{$order->id}}</h5>
                    <p class="card-text">Customer Name: {{$order->user->name}} {{$order->user->last_name}}</p>
                    <p class="card-text">Customer Email: {{$order->user->email}}</p>
                    @if($order->address)
                        <p class="card-text text-capitalize">Shipping Address: {{$order->address->address}}</p>
                    @endif
                </div>

                @if($order->status == \App\Enums\OrderStatus::FAILED)
                    <div class="mt-2 mt-md-0 col-sm">
                        <h2>Order has been Rejected!</h2>
                        <p><strong>Reason:</strong> {{$order->reason}}</p>
                    </div>
                @endif

                @if($order->status == \App\Enums\OrderStatus::CANCELLED)
                    <div class="mt-2 mt-md-0 col-sm">
                        <h2>Order has been Cancelled!</h2>
                        <p><strong>Reason:</strong> {{$order->reason}}</p>
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
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{\App\Helper\CurrencyHelper::currency($item->price)}}</td>
                        <td>{{\App\Helper\CurrencyHelper::currency($item->total)}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Shipping Fee</td>
                    @if($order->address)
                        <td>{{\App\Helper\CurrencyHelper::currency($order->address->shipping_fee)}}</td>
                    @else
                        <td></td>
                    @endif
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">Total</td>
                    <td>{{\App\Helper\CurrencyHelper::currency($total)}}</td>
                </tr>
                </tfoot>
            </table>

            <div class="row">
                <form  class="col-sm p-2 bg-light" id="deliveryForm" method="POST" action="/admin/order/delivery">
                    @csrf
                    <h2>Delivery Information</h2>
                    <input name="order_id" type="hidden" class="d-none" value="{{$order->id}}" required>
                    <div class="form-group">
                        <label for="logisticCompany">Logistic Company</label>

                        @if($order->delivery && $order->delivery->logistic)
                            <input type="text" class="form-control" id="logisticCompany" name="logistic"
                                   placeholder="Enter Logistic Company" value="{{$order->delivery->logistic}}" required>
                        @else
                            <input type="text" class="form-control" id="logisticCompany" name="logistic"
                                   placeholder="Enter Logistic Company" required>
                        @endif


                    </div>
                    <div class="form-group">
                        <label for="trackingNumber">Tracking Number</label>

                        @if($order->delivery && $order->delivery->logistic)
                            <input maxlength="100" data-pristine-required-message="logistic company is required" type="text" class="form-control" id="trackingNumber" name="tracking"
                                   placeholder="Enter Tracking Number" value="{{$order->delivery->tracking}}" required>
                        @else
                            <input maxlength="100" data-pristine-pattern-message="invalid input" data-pristine-required-message="tracking number is required" pattern="/^[a-z0-9]+$/i" type="text" class="form-control" id="trackingNumber" name="tracking" placeholder="Enter Tracking Number" required>
                        @endif

                    </div>

                    @if($order->status == \App\Enums\OrderStatus::PENDING && !$order->delivery)
                        <button type="submit" id="updateBtn" class="btn btn-primary mt-2">Update</button>
                        <p class="mb-0 small ">Click Update to Enable the Completed button</p>
                    @endif

                </form>

                <form class="col-sm pt-2 bg-light" id="paymentForm">

                    <h2>Payment Details</h2>

                    <div class="row">

                        @if($order->payment && $order->payment->payment_method)
                            <div class="col-sm form-group mb-2">
                                <label for="paymentMethod">Payment Method</label>
                                <input class="form-control text-dark" id="paymentMethod" name="paymentMethod"
                                       value="{{$order->payment->payment_method}}" readonly>

                                @if($order->payment->message)
                                    <label class="mt-2">message</label>
                                    <textarea class="form-control text-dark"
                                              readonly>{{$order->payment->message}}</textarea>
                                @endif

                            </div>
                        @endif

                        @if($order->payment && $order->payment->file)
                            <div class="col-sm form-group">
                                <div class="form-group">
                                    <label for="receipt">Payment Proof</label>
                                    <img id="receipt" class="img-thumbnail"
                                         src="{{\Illuminate\Support\Facades\Storage::url($order->payment->file)}}">
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

            <div class="mt-2 d-flex gap-2">
                @if($order->status == \App\Enums\OrderStatus::PENDING || $order->status == \App\Enums\OrderStatus::DELIVERY)
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Mark as Denied
                    </button>
                @endif
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="denyForm" method="POST" action="/order-failed/{{$order->id}}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Deny Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" class="d-none" name="reason" id="hiddenReason">

                        <label for="reason">Reason for denying order</label>
                        <select id="reason" class="form-control" required>
                            <option value="" disabled selected> -- Select --</option>
                            <option value="Chosen payment method Failed">Chosen payment method Failed</option>
                            <option value="Exceed Product Limit">Exceed Product Limit</option>
                            <option value="Your account has been Limited">Your account has been Limited</option>
                            <option value="Out of Stock">Out of Stock</option>
                            <option id="othersOption" value="others">Others</option>
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

        window.onload = function () {

            const form = document.getElementById("deliveryForm");

            // create the pristine instance
            const pristine = new Pristine(form);

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (pristine.validate()) {
                    form.submit();
                }

            });
        };
    </script>
@endsection
