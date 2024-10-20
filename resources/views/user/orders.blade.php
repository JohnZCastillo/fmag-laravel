@extends('layouts.user-account')

@section('styles')
    <style>
        .orders {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }

    </style>
@endsection


@section('body')
    <div>
        <section class="d-none d-md-block">
            <table class="table text-dark">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{$order->reference}}</td>
                        <td><span>{{$order->status->value}}</span>
                        </td>
                        <td>
                            @if($order->payment && $order->payment->payment_method)
                                {{$order->payment->payment_method->value}}
                            @endif
                        </td>
                        <td>
                            <div>
                                <a role="button" href="/order/{{$order->id}}" class="btn btn-primary">view</a>

                                @if($order->status == \App\Enums\OrderStatus::COMPLETED)
                                    @foreach($order->items as $loopItem)
                                        @if($order->canReview($loopItem->product_id))
                                            <a class="btn btn-secondary"
                                               href="/review/{{$order->id}}/{{$loopItem->product_id}}">Review</a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6" style="height: 300px; vertical-align: middle">Empty Result
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </section>

        <section class="d-block d-md-none">
            @forelse($orders as $order)
                <div class="card mb-2">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="font-weight-bold">Order ID:</span>
                                <span class="float-right">ORDR{{$order->id}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">Status:</span>
                                <span class="float-right">{{$order->status->value}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="font-weight-bold">Payment Method:</span>
                                <span class="float-right">{{$order->payment->payment_method->value}}</span>
                            </li>
                            <li class="list-group-item">
                                <a href="/order/{{$order->id}}" class="btn btn-primary">View</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="d-flex align-items-center justify-content-center" style="height: 300px">
                    <h3 class="text-center text-secondary">Empty Result</h3>
                </div>
            @endforelse
        </section>

        <div class="container-fluid">
            {{$orders->links()}}
        </div>
    </div>
@endsection
