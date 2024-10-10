@extends('layouts.user-account')


@section('styles')
    <style>

        #changeImage:hover {
            cursor: pointer;
        }

        .account {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }

    </style>
@endsection

@section('body')
    <div class="pb-3">
        <h4>User Profile</h4>
        <hr>
        <div class="row">
            <div class="col-12 col-md-4">
                <img class="d-block mx-auto" src="{{\Illuminate\Support\Facades\Storage::url(auth()->user()->profile)}}"
                     id="profileImage" style="width: 200px; height: 200px">
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group column align-items-center">
                    <label for="email" class="col-2">Email:</label>
                    <input readonly type="email" class="col form-control" id="email" value="{{auth()->user()->email}}">
                </div>
                <div class="form-group column align-items-center">
                    <label for="name" class="col-2">Name:</label>
                    <input name="name" readonly type="text" class="col form-control" id="name"
                           value="{{auth()->user()->full_name}}">
                </div>
                <div class="form-group column align-items-center">
                    <label for="name" class="col-2">Contact No.</label>
                    <input readonly type="text" class="col form-control" id="mobile"
                           value="{{auth()->user()->contact_number}}">
                </div>
                <div class="mt-2 form-group align-items-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfile">Update
                        Profile
                    </button>
                </div>
            </div>
        </div>

        @if($errors->any())
            <span class="text-danger">{{$errors->first()}}</span>
        @endif
    </div>

    <div class="modal fade" id="updateProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form enctype="multipart/form-data" method="POST" action="/profile">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group column align-items-center">
                            <label for="email" class="col-2">Profile:</label>
                            <input accept=".jpg, .jpeg, .png" type="file" class="col form-control" name="profile">
                        </div>
                        <div class="form-group column align-items-center">
                            <label for="email" class="col-2">Email:</label>
                            <input name="email" type="email" class="col form-control" id="email"
                                   value="{{auth()->user()->email}}">
                        </div>

                        <div class="row mt-2">

                            <div class="col-4 form-group column align-items-center">
                                <label for="name">First Name:</label>
                                <input name="name" value="{{auth()->user()->name}}" type="text" class="col form-control"
                                       id="name" required>
                            </div>

                            <div class="col-4 form-group column align-items-center">
                                <label for="name">Middle Name:</label>
                                <input name="middle_name" value="{{auth()->user()->middle_name}}" type="text"
                                       class="col form-control"
                                       id="name" placeholder="Optional">
                            </div>

                            <div class="col-4 form-group column align-items-center">
                                <label for="name">Last Name:</label>
                                <input name="last_name" value="{{auth()->user()->last_name}}" type="text"
                                       class="col form-control"
                                       id="name" required>
                            </div>

                        </div>

                        <div class="form-group column align-items-center">
                            <label for="name">Contact No.</label>
                            <input name="contact_number" value="{{auth()->user()->contact_number}}" type="text"
                                   class="col form-control"
                                   id="mobile" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('javascript')

    <script>

        $('#updateProfile').find('#mobile').on('input', function () {
            let value = $(this).val();
            value = value.replace(/[^0-9()+\-\s]/g, '');
            const plusIndex = value.lastIndexOf('+');
            if (value.split('+').length - 1 > 1) {
                value = value.slice(0, plusIndex) + value.slice(plusIndex + 1);
            }
            $(this).val(value);
        });

        const profileImage = document.querySelector("#profileImage");
        const inputProfile = document.querySelector("#changePicture");
        const changeProfileLabel = document.querySelector("#changeProfileLabel");

        const profileForm = document.getElementById("profileForm");

        profileImage.addEventListener('click', (event) => {
            inputProfile.click();
        })

        profileImage.addEventListener('mouseover', (event) => {
            changeProfileLabel.classList.remove('d-none');
        })

        profileImage.addEventListener('mouseleave', (event) => {
            changeProfileLabel.classList.add('d-none');
        });

        inputProfile.addEventListener("change", async (event) => {
            profileForm.submit();
        })
    </script>

@endsection
