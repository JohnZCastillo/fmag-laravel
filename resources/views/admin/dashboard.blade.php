@extends('layouts.admin-index')

@section('style')
    <style>
        .dashboard {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid pt-1 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today's Sale</p>
                        <h6 class="mb-0">{{$sales}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today's Orders</p>
                        <h6 class="mb-0">{{$orders}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today's Products</p>
                        <h6 class="mb-0">{{$products}}</h6>
                    </div>
                </div>
            </div>
        </div>

        <h6 class="mb-0">Monthly Sales</h6>

        <div class="chart-container" style="position: relative; height:100vh; max-height: 400px; width:100%">
            <canvas id="worldwide-sales"></canvas>
        </div>

        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Top Products</h6>
            </div>
            <div class="d-block d-md-none">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>

                    @foreach($salesData as $sales)
                        <tr class="text-dark">
                        <tr>
                            <th>Name</th>
                            <th>{{$sales->product}}</th>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <th>{{$sales->pice}}</th>
                        </tr>

                        <tr>
                            <th>Sold</th>
                            <th>{{$sales->sold}}</th>
                        </tr>

                        <tr>
                            <th>Sales</th>
                            <th>{{$sales->total}}</th>
                        </tr>
                    @endforeach
                    </thead>
                </table>
            </div>

            <div class="d-none d-md-block">
                <table class="table text-start align-middle table-bordered table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Sold</th>
                        <th>Sales</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($salesData as $sales)
                        <tr>
                            <td>{{$sales->name}}</td>
                            <td>{{$sales->price}}</td>
                            <td>{{$sales->sold}}</td>
                            <td>{{$sales->total}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        (function ($) {
            // Worldwide Sales Chart
            var ctx1 = $("#worldwide-sales").get(0).getContext("2d");
            var myChart1 = new Chart(ctx1, {
                type: "bar",
                data: {
                    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    datasets: [{
                        label: "Monthly Sales",
                        data: @json($monthlySales),
                        {{--data: ["{{yearlySales.Jan}}", "{{yearlySales.Feb}}", "{{yearlySales.Mar}}", "{{yearlySales.Apr}}", "{{yearlySales.May}}", "{{yearlySales.Jun}}", "{{yearlySales.Jul}}", "{{yearlySales.Aug}}", "{{yearlySales.Sep}}", "{{yearlySales.Oct}}", "{{yearlySales.Nov}}", "{{yearlySales.Dec}}"],--}}
                        backgroundColor: "rgba(0, 156, 255, .7)"
                    },]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        })(jQuery);

    </script>
@endsection
