@extends('layouts.admin-index')

@section('styles')
    <style>
        .link-btn {
            border: none !important;
            outline: none !important;
            background-color: transparent !important;
        }

        .unread {
            background-color: var(--bs-secondary);
        }
    </style>
@endsection


@section('body')
    <h4 class="pb-1 mb-4 border-bottom">Notifications</h4>
    <section class="container-fluid mb-2">
        <ol class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <form class="ms-auto" method="POST" action="/read-all-notifications">
                    <button type="submit" class="btn btn-secondary">Mark all read</button>
                </form>
            </li>

            @forelse($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between gap-1 {{$notification->read ? 'read' : 'unread'}}">
                    <div class="ms-2 me-auto">
                        <p class="mb-0 fw-bold">{{$notification->title}}</p>
                        <p>{{$notification->content}}</p>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a href="/view-notification-link/{{$notification->id}}"
                           class="btn btn-primary rounded"
                           style="width: max-content">View Details</a>
                        <small class="text-secondary">{{$notification->created_at|date('F j, Y')}}</small>
                    </div>
                </li>
            @empty
                <li style="height: 300px" class="list-group-item d-flex justify-content-center align-items-center">
                    <span class="text-secondary">Empty</span>
                </li>
            @endforelse
        </ol>
    </section>
@endsection
