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
