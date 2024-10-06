@extends('layouts.user-index')

@section('body')
<div class="stack-bg">
    <div class="container mx-auto bg-light" style="max-width: 600px">
        <form id="loginBox"  method="POST" action="/forgot-password" class="p-2 rounded login-form">
            @csrf
            <section class="form-group mb-3">
                <label for="email">Enter Email</label>
                <input name="email" id="email" type="text" class="form-control rounded-pill">
            </section>
            <button class="mb-3 d-block px-5 py-2 btn rounded-pill mx-auto btn-primary" type="submit">Send Code</button>

            <hr>

            @if($errors->any())
                <p class="mb-2 text-danger text-center">{{$errors->first()}}</p>
            @endif

            <section class="row">
                <a class="col-6 btn btn-success d-block mx-auto mb-2" href="/register">Create account</a>
                <a class="col-12 text-blue text-decoration-none text-center " href="/login">Have an Account?</a>
            </section>
        </form>
    </div>
</div>
@endsection
