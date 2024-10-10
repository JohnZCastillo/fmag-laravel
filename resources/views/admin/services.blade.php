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

@section('files')
    <script src="/js/pristine.min.js"></script>
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
            <form id="addForm" method="POST" action="/admin/services" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Video</label>
                            <input class="form-control" type="file" accept="video/mp4" name="video" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="title">Title</label>
                            <input id="title" class="form-control" type="text" name="title" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description">Description</label>
                            <textarea minlength="20" maxlength="300" class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="price">Price</label>
                            <input type="number" min="0" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="acronym">Acronym</label>
                            <input id="acronym" class="form-control" type="text" name="acronym" required>
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
            <form id="editForm" method="POST" action="/admin/services" enctype="multipart/form-data">
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
                            <input id="editTitle" class="form-control" type="text" name="title" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editDescription">Description</label>
                            <textarea  minlength="20" maxlength="300"  class="form-control" id="editDescription" name="description"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editPrice">Price</label>
                            <input type="number" min="0" class="form-control" id="editPrice" name="price" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="editAcronym">Acronym</label>
                            <input id="editAcronym" class="form-control" type="text" name="acronym" required>
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

                document.querySelector('#editID').value = service.id;
                document.querySelector('#editTitle').value = service.title;
                document.querySelector('#editAcronym').value = service.acronym;
                document.querySelector('#editDescription').innerText = service.description;
                document.querySelector('#editPrice').value = service.price;

                editServiceModal.show();

            }catch (err){
                // console.log(`Unable to get service with an ID of ${serviceID}`)
                console.log(err.message)
            }
        }
    </script>

    <script>
        window.onload = function () {

            const editForm = document.getElementById("editForm");
            const addForm = document.getElementById("addForm");

            function validate(form){
                const pristine = new Pristine(form);

                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    if(pristine.validate()){
                        form.submit();
                    }

                });
            }

            validate(editForm);
            validate(addForm);

        };
    </script>
@endsection
