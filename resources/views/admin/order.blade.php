@extends('layouts.admin-index')

@section('files')
    <script src="/js/InputOnChangeSubmit.js"></script>
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

    <div class="card-body text-dark">

        {% if order.completed %}
        <div class="alert alert-success mt-2" role="alert">
            Transaction Completed
        </div>
        {% endif %}

        {% if order.status == "Failed" %}
        <div class="alert alert-danger mt-2" role="alert">
            Transaction Denied
        </div>
        {% endif %}

        <div class="row">
            <div class="col-sm">
                <h2>Order Details</h2>
                <h5 class="card-title">Order ID: {{order.id}}</h5>
                <p class="card-text">Customer Name: {{order.user.firstName}} {{order.user.lastName}}</p>
                <p class="card-text">Customer Email: {{order.user.email}}</p>
                <p class="card-text">Shipping Address: {{order.user.getActiveAddress().getLocation()}}</p>
            </div>

            {% if order.status|lower == 'failed'  %}
                <div class="mt-2 mt-md-0 col-sm">
                    <h2>Order has been Rejected!</h2>
                    <p><strong>Reason:</strong> {{order.reason}}</p>
                </div>
            {% endif %}

            {% if order.status|lower == 'cancelled' %}
                <div class="mt-2 mt-md-0 col-sm">
                    <h2>Order has been Cancelled!</h2>
                    <p><strong>Reason:</strong> {{order.reason}}</p>
                </div>
            {% endif %}

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

            {% for product in order.content %}
            <tr>

                <td>{{product.product.name}}</td>
                <td>{{product.quantity}}</td>
                <td>{{product.product.price|format_currency('PHP')}}</td>
                <td>{{(product.product.price * product.quantity )|format_currency('PHP')}}</td>
            </tr>
            {% endfor %}

            <tr>
                <td colspan="3">Shipping Fee</td>
                <td>{{order.shippingFee|format_currency('PHP')}}</td>
            </tr>

            <tr>
                <td colspan="3">Total</td>
                <td>{{total|format_currency('PHP')}}</td>
            </tr>
            </tbody>
        </table>

        <div class="row">
            <form class="col-sm p-2 bg-light" id="deliveryForm" method="POST"
                  action="{{base_path()}}/admin/order/delivery/{{order.id}}">
                <h2>Delivery Information</h2>
                <span class="small text-success" id="deliverySuccessMessage"></span>
                <span class="small text-danger" id="deliveryErrorMessage"></span>
                <input name="orderId" type="text" class="d-none" value="{{order.id}}" required>
                <div class="form-group">
                    <label for="logisticCompany">Logistic Company</label>
                    <input type="text" class="form-control" id="logisticCompany" name="logisticCompany"
                           placeholder="Enter Logistic Company" value="{{order.logistic}}" required
                           oninput="allowLettersAndSpaces(event)">
                </div>
                <div class="form-group">
                    <label for="trackingNumber">Tracking Number</label>
                    <input type="text" class="form-control" id="trackingNumber" name="trackingNumber"
                           placeholder="Enter Tracking Number" value="{{order.trackingNumber}}" required
                           oninput="allowNumbersWithSpaces(event)">
                </div>

                {% if order.status|lower == "pending" %}
                <button type="submit" id="updateBtn" class="btn btn-primary mt-2">Update</button>
                <p class="mb-0 small ">Click Update to Enable the Completed button</p>
                {% endif %}

            </form>


            <form class="col-sm pt-2 bg-light" id="paymentForm">

                <h2>Payment Details</h2>

                <div class="row">
                    <div class="col-sm form-group mb-2">
                        <label for="paymentMethod">Payment Method</label>
                        <input class="form-control" id="paymentMethod" name="paymentMethod"
                               value="{{order.paymentMethod}}" readonly>
                    </div>

                    {% if order.paymentMethod|lower == 'gcash' %}

                    {% set receipt = base_path() ~ '/uploads/' ~ order.receiptImg %}
                    <div class="col-sm form-group">
                        <div class="form-group">
                            <label for="receipt">Payment Proof</label>
                            <img onclick="showImageModal('{{receipt}}')" id="receipt" class="img-thumbnail" src="{{receipt}}">
                        </div>
                    </div>
                    {% endif %}
                </div>
            </form>


        </div>

        <div class="mt-2 d-flex gap-2 {{completed}}">

            {% if order.status|lower == "delivery"%}
            <form  class="confirmation" data-message="Are you sure you want to mark this order as completed?"  method="POST" action="{{base_path()}}/admin/complete-order/{{order.id}}">
                <button class="btn btn-success" type="submit">Mark as Completed</button>
            </form>
            {% endif %}

            {% if order.status|lower == "pending" or order.status|lower == "delivery"%}
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Mark as Denied
            </button>
            {% endif %}

        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="denyForm" method="POST" action="{{base_path()}}/admin/deny-order/{{order.id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deny Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="reason">Reason for denying order</label>
                    <select id="reason" class="form-control" name="reason" required>
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

    denyForm.addEventListener('submit', (e) => {
        e.preventDefault();

        console.log(denyReason.value);

        if (denyReason.value === 'others') {
            othersOption.value = otherReason.value;
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
