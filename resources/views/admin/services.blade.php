@extends('layouts.admin-index')

@section('body')

    <h4>Services</h4>
    <hr>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#serviceModal">
        Add Service
    </button>

    <!-- Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/admin/services" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Video</label>
                            <input class="form-control" type="file" accept="video/mp4" name="video">
                        </div>
                        <div class="form-group mb-2">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" type="text" name="title">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <section class="d-block d-md-none">

        @foreach($services as $service)

            <div class="card mb-3">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Service Name:</strong> {{$service->name}}</li>
                        <li class="list-group-item"><strong>Acronym:</strong> {{$service->acronym}}</li>
                        <li class="list-group-item"><strong>Description:</strong> {{$service->description}}</li>
                    </ul>
                    <div class="d-flex align-items-center gap-1">
                        <a href="/admin/service/{{$service->id}}" class="btn btn-primary">Edit</a>
                        <form class="confirmation" data-message="Are you sure you want to archive {{$service->name}}?"
                              method="POST" action="/admin/archive-service/{{$service->id}}">
                            <button type="submit" class="btn btn-secondary">Archive</button>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach
    </section>

    <div class="d-none d-md-block">
        <table class="table table-bordered table-light">
            <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Acronym</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>

                    <td>{{$service->name}}</td>
                    <td>{{$service->acronym}}</td>
                    <td>{{$service->description}}</td>
                    <td>
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                            <a href="/admin/service/{{$service->id}}" class="btn btn-primary">Edit</a>
                            <form class="confirmation"
                                  data-message="Are you sure you want to archive {{$service->name}}?" method="POST"
                                  action="/admin/archive-service/{{$service->id}}">
                                <button type="submit" class="btn btn-secondary">Archive</button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container-fluid">
        {{$services->links()}}
    </div>

@endsection
