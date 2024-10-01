@extends('layouts.admin-index')

@section('files')
    <script src="/js/InputOnChangeSubmit.js"></script>
@endsection

@section('style')
    <style>

        .pending {
            background-color: var(--bs-secondary);
        }

        .completed {
            background-color: var(--bs-primary);
        }

        .failed {
            background-color: var(--bs-danger);
        }

        .cancelled {
            background-color: var(--bs-info);
        }

        .delivery {
            background-color: var(--bs-warning);
        }

    </style>
@endsection


@section('body')

    <h4>Order List</h4>
    <section class="container-fluid mb-2">
        <form class="form row w-100 autoSubmitForm" enctype="multipart/form-data">
            <div class="mb-2 col-sm col-md-5 form-group d-flex align-items-center bg-dark p-2 gap-1 rounded-2">
                <input value="{{$app->request->search}}"
                       name="search"
                       class="form-control text-white bg-transparent border-0 autoSubmitInput"
                       id="searchBox"
                       type="search"
                       style="box-shadow: none"
                       placeholder="Search..."
                >
            </div>
            <div class="col-sm col-md-4 form-group d-flex align-items-center ">

                <label for="status">Status</label>

                <select class="text-capitalize form-select" name="status" id="status">
                    <option value="all">All</option>
                    @foreach(\App\Enums\OrderStatus::cases() as $status)
                        <option class="text-capitalize"
                                @selected($app->request->status == $status->name) value="{{$status->name}}">{{$status->value}}</option>
                    @endforeach
                </select>
            </div>
        </form>
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
                            <span
                                class="badge {{strtolower($order->status->name)}} float-right">{{$order->status->value}}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">User:</span>
                            <span class="float-right">{{$order->user->name}}</span>
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Address:</span>
                            {{--                            <span class="float-right">{{$order->address.location}}</span>--}}
                        </li>
                        <li class="list-group-item">
                            <span class="font-weight-bold">Payment Method:</span>
                            {{--                            <span class="float-right">{{$order->paymentMethod|upper}}</span>--}}
                        </li>
                        <li class="list-group-item">
                            <a href="/admin/orders/{{$order->id}}" class="btn btn-primary">Manage</a>
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

    <div class="d-none d-md-block">
        <table class="table table-light table-hover">
            <thead class="table-dark">
            <tr>
                <th>Order ID</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Location</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="infScroll">
            @forelse($orders as $order)
                <tr>
                    <td>ORDR{{$order->id}}</td>
                    <td><span class="badge {{$order->status}}">{{$order->status->name}}</span>
                    </td>
                    <td>{{$order->user->name}}</td>
                    <td>
                        @if($order->address)
                            {!! App\Helper\AddressParser::parseAddress($order->address) !!}
                        @endif
                    </td>
                    <td>
                        @if($order->payment)
                            {{$order->payment->payment_method->name}}
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="/admin/messages/{{$order->user->id}}">
                                <img style="width: 27px; height: 27px" src="/assets/bot.svg" alt="">
                            </a>
                            <a href="/admin/orders/{{$order->id}}" class="btn btn-primary">Manage</a>
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td class="text-center" colspan="6" style="height: 350px; vertical-align: middle">Empty Result</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="container-fluid">
            {{$orders->links()}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.addEventListener('load', () => {
            handleInputsChange('.form', 'change', '#status');
            handleInputChange('.form', 'change', '#searchBox', (search) => !search.length);
        })
    </script>
@endsection

