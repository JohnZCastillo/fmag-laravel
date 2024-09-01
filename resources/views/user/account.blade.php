@extends('layouts.user-account')


@section('styles')
    <style>

        #changeImage:hover {
            cursor: pointer;
        }

    </style>
@endsection

@section('body')
    <div class="pb-3">
        <h4>User Profile</h4>
        <hr>
        <div class="row">
            <div class="col-12 col-md-4">
                <img class="d-block mx-auto" src="" id="profileImage" style="width: 200px; height: 200px">
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group column align-items-center">
                    <label for="email" class="col-2">Email:</label>
                    <input readonly type="email" class="col form-control" id="email" placeholder="Enter email"
                           value="">
                </div>
                <div class="form-group column align-items-center">
                    <label for="name" class="col-2">Name:</label>
                    <input readonly type="text" class="col form-control" id="name" placeholder="Enter your name"
                           value="">
                </div>
                <div class="form-group column align-items-center">
                    <label for="name" class="col-2">Contact No.</label>
                    <input readonly type="text" class="col form-control" id="mobile" value="">
                </div>
                <div class="mt-2 form-group align-items-center">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfile">Update
                        Profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/account">
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
                            <input type="email" class="col form-control" id="email" placeholder="Enter email"
                                   value="">
                        </div>
                        <div class="form-group column align-items-center">
                            <label for="name">Name:</label>
                            <input type="text" class="col form-control" id="name" placeholder="Enter your name"
                                   value="">
                        </div>
                        <div class="form-group column align-items-center">
                            <label for="name">Contact No.</label>
                            <input type="text" class="col form-control" id="mobile" value="">
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
