@extends('layouts.user-account')

@section('styles')
<style>
    .password {
        color: var(--primary) !important;
        background: #FFFFFF !important;
        border-color: var(--primary) !important;
    }
</style>
@endsection

@section('body')
    <div>
        <h4>Change Password</h4>
        <hr>
        <form method="POST" action="/password">
            @csrf
            <span class="small text-success" id="changeSuccessMessage"></span>
            <span class="small text-danger" id="changeErrorMessage"></span>
            <div class="form-group mb-2">
                <label for="password">Old Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group mb-2">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="new_password" required>
            </div>
            <div class="form-group mb-3">
                <label for="confirmPassword">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirm</button>
        </form>

        @if($errors->any())
            <span class="text-danger">{{$errors->first()}}</span>
        @endif

    </div>
@endsection('body')
