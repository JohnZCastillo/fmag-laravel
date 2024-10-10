@extends('layouts.user-index')

@section('body')
    <div class="stack-bg">
        <div class="container my-1 bg-light">
            <div class="shadow rounded p-3">
                <h3>Privacy Policy</h3>
                <p class="text-dark" style="white-space: pre-line">{!! $settings->policy !!}</p>
                <button class="btn btn-primary" onclick="history.back()">Back</button>
            </div>
        </div>
    </div>

@endsection

