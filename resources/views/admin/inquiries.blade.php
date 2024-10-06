@extends('layouts.admin-index')

@section('style')
    <style>
        .inquiries{
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

@section('body')
    <h4>Services Inquire</h4>
    <div>
        <form class="mb-2 autoSubmitForm">
            <input name="search" class="form-control autoSubmitInput" type="search" placeholder="Search by Class"
                   value="{{$app->request->search}}">
        </form>

        <section class="d-block d-md-none">
            @forelse($inquiries as $inquiry)
                <div class="card mb-3">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>User Name:</strong> {{$inquiry->user->name}}</li>
                            <li class="list-group-item"><strong>Service Acronym:</strong> {{$inquiry->service->title}}
                            </li>
                            <li class="list-group-item"><strong>User Address:</strong> {{$inquiry->user->address}}
                            </li>
                            <li class="list-group-item"><strong>User Email:</strong> {{$inquiry->user->email}}</li>
                        </ul>
                        <div class="d-flex align-items-center mt-3">
                            <a href="/admin/messages/{{$inquiry->user->id}}">
                                <img style="width: 27px; height: 27px" src="/assets/bot.svg">
                            </a>
                            <form data-message="are you sure you want to delete {{$inquiry->service->acronym}}?"
                                  class="confirmation"
                                  method="POST" action="/admin/inquiries/{{$inquiry->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-light">
                                    <i class="text-danger h3 mb-0 bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex align-items-center justify-content-center" style="height: 300px">
                    <h3 class="text-center text-secondary">Empty Result</h3>
                </div>
            @endforelse
        </section>

        <section class="d-none d-md-block">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                <tr>
                    <th>Customer Name</th>
                    <th>Choose Class</th>
                    <th>Location</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($inquiries as $inquiry)
                    <tr>
                        <td>{{$inquiry->user->name}}</td>
                        <td>{{$inquiry->service->title}}</td>
                        <td>{{$inquiry->user->address}}</td>
                        <td>{{$inquiry->user->email}}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">

                                <a href="/admin/messages/{{$inquiry->user->id}}">
                                    <img style="width: 27px; height: 27px" src="/assets/bot.svg">
                                </a>
                                <form data-message="are you sure you want to delete {{$inquiry->service->acronym}}?"
                                      class="confirmation"
                                      method="POST" action="/admin/inquiries/{{$inquiry->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-light">
                                        <i class="text-danger h3 mb-0 bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>

        <div class="container-fluid">
            {{$inquiries->links()}}
        </div>
    </div>
@endsection
