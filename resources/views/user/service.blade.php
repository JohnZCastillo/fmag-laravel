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
                            <h5 class="card-title">{{$service->title}} <span
                                    class="text-dark">({{$service->acronym}})</span></h5>

                            <p>Estimated Price: {{\App\Helper\CurrencyHelper::currency($service->price)}}</p>
                            <p id="description" class="card-text text-truncate mb-0"
                               style='max-with: 100ch'>{{$service->description}}</p>

                            @if(strlen($service->description) > 100)
                                <button id="descriptionBtn" class="btn btn-link text-secondary" onclick="showDescription()">See more
                                </button>
                            @endif

                            @if($available)
                                <form method="POST" action="/inquire/{{$service->id}}">
                                    @csrf

                                    <button type="submit" class="rounded-pill btn btn-primary">Inquire</button>
                                </form>
                            @else
                                <button disabled type="button" class="rounded-pill btn btn-primary">Inquire</button>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <p class="mb-0">
                                        <i class="bi bi-journal-check mb-0"></i>
                                        Learn
                                    </p>
                                    Enroll in our training program to acquire expertise in swift evaluation, efficient
                                    collaboration, specialized methods, flexibility, and continuous skill refinement.
                                </div>

                                <div class="col-12 col-md-4 ">
                                    <p class="mb-0">
                                        <i class="bi bi-mortarboard"></i>
                                        Instruct
                                    </p>
                                    Through dynamic simulations, practical application, collaborative learning, ongoing
                                    feedback, integration of technology,
                                    and tailored approaches for effective rescue strategies.
                                </div>
                                <div class="col-12 col-md-4">
                                    <p class="mb-0">
                                        <i class="bi bi-backpack"></i>
                                        Materials
                                    </p>
                                    Visual aids, hands-on materials, interactive workbooks, live demonstrations,
                                    role-playing exercises,
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
@section('script')
    <script>

        const description = document.querySelector('#description');
        const descriptionBtn = document.querySelector('#descriptionBtn');

        function showDescription() {

            description.classList.toggle('text-truncate');

            if (description.classList.contains('text-truncate')) {
                descriptionBtn.innerText = 'See More';
            } else {
                descriptionBtn.innerText = 'See Less';
            }
        }

    </script>
@endsection



