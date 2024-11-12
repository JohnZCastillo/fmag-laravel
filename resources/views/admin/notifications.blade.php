@extends('layouts.admin-index')

@section('styles')
    <style>
        .link-btn {
            border: none !important;
            outline: none !important;
            background-color: transparent !important;
        }
    </style>
@endsection


@section('body')
    <h4 class="pb-1 mb-4 border-bottom">Notifications</h4>
    <section class="container-fluid mb-2">
        <ol class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <form class="ms-auto" method="POST" action="/read-all-notifications" >
                    @csrf
                    <button type="submit" class="btn btn-secondary">Mark all read</button>
                </form>
            </li>

            @forelse($notifications as $notification)
                @if($notification->read)
                    <li class="list-group-item d-flex justify-content-between gap-1">
                        <div class="ms-2 me-auto">
                            <h6 class="mb-0 text-capitalize fw-normal">{{$notification->title}}</h6>
                            <p class="small">{{$notification->content}}</p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <a href="/view-notification-link/{{$notification->id}}"
                               class="btn btn-primary rounded"
                               style="width: max-content">View Details</a>
                            <small class="text-secondary">{{$notification->created_at->format('F j, Y')}}</small>
                        </div>
                    </li>
                @else
                    <li class="list-group-item d-flex justify-content-between gap-1">
                        <div class="ms-2 me-auto">
                            <h6 class="mb-0 fw-bold text-capitalize">{{$notification->title}}</h6>
                            <p class="fw-bold small">{{$notification->content}}</p>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <a href="/view-notification-link/{{$notification->id}}"
                               class="btn btn-primary rounded"
                               style="width: max-content">View Details</a>
                            <small class="text-secondary">{{$notification->created_at->format('F j, Y')}}</small>
                        </div>
                    </li>
                @endif
            @empty
                <li style="height: 300px" class="list-group-item d-flex justify-content-center align-items-center">
                    <span class="text-secondary">Empty</span>
                </li>
            @endforelse
        </ol>

        <div class="mt-2 container-fluid">
            {{$notifications->links()}}
        </div>
    </section>
@endsection
