@extends('layouts.user-account')

@section('body')

    <div>
        <h4>Address</h4>
        <hr>
        <ul class="list-group list-group-flush">
            @foreach($addresses as $address)
                <li class="list-group-item d-flex justify-content-between">
                    <p>
                        <span id="location{{$address->id}}">{{$address->id}}</span>

                        @if($address->active)
                            <span class="message-holder badge bg-success">Default</span>
                        @endif

                    </p>
                    <div>
                        <div class="mb-2 d-flex gap-2">

                            <form method="POST" action="/address/{{$address->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                            <a href="/address/{{$address->id}}" class="btn btn-secondary">Edit</a>
                        </div>

                        @if(!$address->active)
                            <form method="POST" action="/default-address/{{$address->id}}">
                                <button type="submit" class="btn btn-primary">Set As Default</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
        <a href="add-address" class="btn btn-primary">Add Address</a>
    </div>

@endsection
