@extends('layouts.admin-index')

@section('styles')
    <style>
        #search {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .messages{
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }

    </style>
@endsection

@section('body')
    <div class="row" style="height: calc(100svh - 150px)">

        <div class="col-12 col-md-3 border-end">

            <form class="form mb-2">
                <label for="search">Search User</label>
                <div class="bg-white form-control d-flex gap-1 align-items-center">
                    <i class="bi bi-search"></i>
                    <input class="overflow-hidden" value="{{$app->request->search}}" autocomplete="off" id="search"
                           name="search" type="search" placeholder="Search User">
                </div>
            </form>

            <ul class="list-group">
                @forelse($users as $user)
                    <li class="list-group-item overflow-auto">
                        <a class="text-secondary" href="/admin/messages/{{$user->id}}">
                            {{$user->name}}
                        </a>
                    </li>
                @empty
                    <div class="h-100 d-flex align-items-center justify-content-center">
                        <h4 class="text-secondary">No recent messages</h4>
                    </div>
                @endforelse
            </ul>
        </div>
        <div class="d-none d-md-block col-9 bg-light">
            <div class="h-100 d-flex align-items-center justify-content-center">
                <p class="text-secondary">No chat selected</p>
            </div>
            <div class="bg-white pt-2">
                <form id="messageForm" class="d-flex align-items-center justify-content-between gap-2">
                    <input type="text" id="inputMessage" class="form-control" name="message">
                    <div>
                        <button class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
