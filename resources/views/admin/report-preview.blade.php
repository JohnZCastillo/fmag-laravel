{{--<p>Report Coverage: {{$from->format('M d Y')}} - {{$to->format('M d Y')}}</p>--}}

<div class="table-responsive">
    <table class="table table-bordered">
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

{{--<div class="modal-footer">--}}
{{--    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--    <form method="POST" action="/admin/download-report/{{from}}/{{to}}">--}}
{{--        <button type="submit" class="btn btn-primary">Download</button>--}}
{{--    </form>--}}
{{--</div>--}}
