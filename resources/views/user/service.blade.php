@extends('layouts.user-index')

@section('title', $service->title)

@section('body')

<section class="stack-bg text-dark">
    <div class="container mx-auto">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-5 dot">
                    <video width="100%" height="450" controls autoplay muted>
                        <source src="{{\Illuminate\Support\Facades\Storage::url($service->video)}}"
                                type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h5 class="card-title">{{$service->title}}    <span class="text-dark">({{$service->acronym}})</span></h5>

                        <p>Estimated Price: {{\App\Helper\CurrencyHelper::currency($service->price)}}</p>
                        <p class="card-text">{{$service->description}}</p>

                        <form method="POST" action="/inquire/{{$service->id}}">
                            @csrf

                            @if($available)
                                <button type="submit" class="rounded-pill btn btn-primary">Inquire</button>
                            @endif

                        </form>

                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <p class="mb-0">
                                    <i class="bi bi-journal-check mb-0"></i>
                                    Learn
                                </p>
                                Enroll in our training program to acquire expertise in swift evaluation, efficient collaboration, specialized methods, flexibility, and continuous skill refinement.
                            </div>

                            <div class="col-12 col-md-4 ">
                                <p class="mb-0">
                                    <i class="bi bi-mortarboard"></i>
                                    Instruct
                                </p>
                                Through dynamic simulations, practical application, collaborative learning, ongoing feedback, integration of technology,
                                and tailored approaches for effective rescue strategies.
                            </div>
                            <div class="col-12 col-md-4">
                                <p class="mb-0">
                                    <i class="bi bi-backpack"></i>
                                    Materials
                                </p>
                                Visual aids, hands-on materials, interactive workbooks, live demonstrations, role-playing exercises,
                                safety guidelines, and supplemental materials
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



