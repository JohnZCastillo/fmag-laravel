@extends('layouts.admin-index')


@section('style')
    <style>
        .services{
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection

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
                        <div class="form-group mb-2">
                            <label for="acronym">Acronym</label>
                            <input id="acronym" class="form-control" type="text" name="acronym">
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

    <!-- Edit Service Modal -->
    <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/admin/services" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input id="editID" type="hidden" name="id" class="d-none">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Video</label>
                            <input class="form-control" type="file" accept="video/mp4" name="video">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editTitle">Title</label>
                            <input id="editTitle" class="form-control" type="text" name="title">
                        </div>
                        <div class="form-group mb-2">
                            <label for="editAcronym">Acronym</label>
                            <input id="editAcronym" class="form-control" type="text" name="acronym">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
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
                        <li class="list-group-item"><strong>Service Name:</strong> {{$service->title}}</li>
                        <li class="list-group-item"><strong>Acronym:</strong> {{$service->acronym}}</li>
                    </ul>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" onclick="editService('{{$service->id}}')" class="btn btn-primary">Edit</button>
                        <form class="confirmation"
                              data-message="Are you sure you want to archive {{$service->title}}?"
                              method="POST"
                              action="/admin/services/{{$service->id}}">
                            @csrf
                            @method('DELETE')
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
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $service)
                <tr>

                    <td>{{$service->title}}</td>
                    <td>{{$service->acronym}}</td>
                    <td>
                        <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                            <button type="button" onclick="editService('{{$service->id}}')" class="btn btn-primary">Edit</button>
                            <form class="confirmation"
                                  data-message="Are you sure you want to archive {{$service->title}}?"
                                  method="POST"
                                  action="/admin/services/{{$service->id}}">
                                @csrf
                                @method('DELETE')
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
@section('script')
    <script>

        const editServiceModal = new bootstrap.Modal(document.getElementById('editServiceModal'));

        async function editService(serviceID){
            try {

                const response = await fetch(`/admin/services/${serviceID}`);
                const service = await response.json();

                document.querySelector('#editID').value = service.id
                document.querySelector('#editTitle').value = service.title
                document.querySelector('#editAcronym').value = service.acronym

                editServiceModal.show();

            }catch (err){
                // console.log(`Unable to get service with an ID of ${serviceID}`)
                console.log(err.message)
            }
        }

    </script>
@endsection
