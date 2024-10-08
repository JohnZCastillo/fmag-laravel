@extends('layouts.user-index')

@section('body')
    <div class="container-fluid py-2 px-4">
        <div class="w-75 mx-auto">
            <h1 class="display-4">GCash Receipt Submission</h1>
            <p class="lead">Scan the QR code below to pay using GCash amounting to <strong
                        class="text-success">{{$order->payment->amount}}</strong></p>

            <div class="row">
                <div class="col-12 col-md-6 text-center">
                    <img src="/assets/fmag-qr.png" class="img-fluid d-block mx-auto"
                         style="width: 300px; height: 300px" alt="GCash QR Code">
                </div>
                <form  class="col-12 col-md-6" enctype="multipart/form-data" id="gcashReceiptForm" method="POST"
                      action="/payments/gcash/{{$order->id}}">
                    @csrf

                    <div class="form-group">
                        <label for="gcashReceiptImg">Upload your Gcash proof of payment</label>
                        <input type="file" id="gcashReceiptImg" name="image" class="form-control"
                               accept="image/*" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" maxlength="50" minlength="10" placeholder="Optional message"></textarea>
                        <span id="messageCounter">0/50</span>
                    </div>

                    <div class="d-flex gap-2">
                        <button onclick="backReload()" type="button" class="btn btn-secondary mt-2">Back</button>
                        <button type="submit" class="btn btn-primary mt-2 d-block">Confirm</button>
                    </div>
                </form>
            </div>
            <p class="text-center">Your order would take up to 3-7 Working days.</p>
        </div>
    </div>
@endsection

@section('script')
<script>

    const messageCounter = document.querySelector('#messageCounter');
    const message = document.querySelector('#message');

    message.addEventListener('input',()=>{
        const count = message.value.length;
        messageCounter.innerText = `${count}/50`
    })

</script>
@endsection
