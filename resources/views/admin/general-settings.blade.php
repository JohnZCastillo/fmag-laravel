@extends('layouts.admin-index')

@section('body')

<h2>General Settings</h2>
<hr>
<form method="POST" action="/admin/general-settings" enctype="multipart/form-data">

    @csrf
    <div class="form-group mb-2">
        <label for="logo" class="form-check-label">Logo</label>
        <input class="form-control" name="logo" type="file" id="logo" accept="image/*">
    </div>

    <div class="form-group mb-2">
        <label for="hotline" class="form-check-label">Contact</label>
        <input class="form-control" name="mobile" type="text" id="hotline" value="{{$settings->mobile}}">
    </div>

    <div class="row">
        <div class="col-sm form-group mb-2">
            <label for="fb" class="form-check-label">Fb Link</label>
            <input class="form-control" name="fb" type="text" id="fb" value="{{$settings->fb}}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm form-group mb-2">
            <label for="address" class="form-check-label">Address</label>
            <input class="form-control" name="address" type="text" id="address" value="{{$settings->address}}">
        </div>
    </div>

    <section class="mb-2">
        <hr>
        <small>Email Configuration</small>
        <div class="row">
            <div class="col-12 col-md-4">
                <label for="host" class="form-check-label">Host</label>
                <input placeholder="smtp.gmail.com"  class="form-control" name="host" type="text" id="host" value="{{$settings->host}}">
            </div>
            <div class="col-12 col-md-4">
                <label for="email" class="form-check-label">Email</label>
                <input placeholder="fmag@gmail.com" class="form-control" name="email" type="text" id="email" value="{{$settings->email}}">
            </div>
            <div class="col-12 col-md-4">
                <label for="password" class="form-check-label">Password</label>
                <input placeholder="email password" class="form-control" name="password" type="password" id="password">
            </div>
        </div>
    </section>

    <section class="mb-2">
        <hr>
        <div class="form-group mb-2">
            <label for="policy">Privacy Policy</label>
            <textarea name="policy" class="form-control" id="policy" rows="10">{{$settings->policy}}</textarea>
        </div>
    </section>

    <button class="btn btn-primary" type="submit">Save Changes</button>
</form>
@endsection
