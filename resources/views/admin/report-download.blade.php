<!DOCTYPE html>
<html lang="eng">
<head>
    <title>Sales Report</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="container-fluid d-flex align-items-center justify-content-center gap-2" style="height: 150px">


        <div class="position-relative">
            <div class="position-absolute" style="left: -30%; top: -10%">
                <img src="/assets/report-logo.png" style="width: 100px; height: 100px">
            </div>

            <div class="d-flex flex-column text-center text-dark">
                <h3>FMAG RESCUE PHILIPPINES INC</h3>
                <span>Sales Report</span>
                <span>Generate on {{\Carbon\Carbon::now()->format('M d, Y h:i a')}}</span>
            </div>
        </div>

    </div>

    <div class="mt-3 d-flex flex-column text-dark">
        <span>Report Coverage: <strong>{{$coverage}}</strong></span>
        <span>Total sales: <strong>{{\App\Helper\CurrencyHelper::currency($total)}}</strong></span>
    </div>
    <div class="table-responsive mt-2">
        <table class="table table-bordered text-dark border-dark">
            <thead>
            <tr>
                <th>Item Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Sub Total</th>
            </tr>
            </thead>
            <tbody>

            @foreach($items as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->sold}}</td>
                    <td>{{$item->sales}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">Total</td>
                <td>{{$total}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>


