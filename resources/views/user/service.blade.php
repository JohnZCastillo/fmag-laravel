@extends('layouts.user-index')

@section('title', $service->title)

@section('body')
    <section class="stack-bg">
        <div class="container mx-auto">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mx-2">{{$service->title}}</h5>
                        <p>{{$service->description}}</p>
                        <video width="100%" height="450" controls autoplay muted>
                            <source src="{{\Illuminate\Support\Facades\Storage::url($service->video)}}"
                                    type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <form method="POST" action="/inquire/{{$service->id}}">
                            @csrf

                            @if($available)
                                <button type="submit" class="btn btn-primary">Inquire</button>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



