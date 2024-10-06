@extends('layouts.user-index')

@section('body')

<section class="stack-bg" style="min-height: 400px">

<div class="container py-4 bg-light border shadow rounded" style="max-width: 600px">
    <h2 class="text-center">Forgot Password</h2>
    <p>To help keep your account safe, Please Enter the code </p>
    <form method="POST" action="/verify-pin">
        @csrf
        <div class="mb-2">
            <label for="code">An email with a verification code was just sent to you</label>
            <input id="code" type="text" class="form-control" name="pin">
            <input id="email" type="hidden" class="d-none" name="email" value="{{$email}}">
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</section>

@endsection
