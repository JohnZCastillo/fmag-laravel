@extends('layouts.user-index')


@section('files')
    <script src="/js/just-validate.js"></script>
@endsection


@section('style')
    <style>
        .no-border {
            border: none;
            outline: none;
        }

        .pointer {
            cursor: pointer !important;
        }
    </style>
@endsection


@section('body')
    <div class="stack-bg">
        <div class="container mx-auto bg-light mb-4" style="max-width: 600px">
            <form id="loginForm" method="POST" action="/login" class="p-2 pt-3 p-md-5 rounded shadow rounded">
                @csrf
                <section class="form-group mb-3">
                    <input value="{{old('email')}}" name="email" id="email" type="text"
                           class="form-control rounded-pill" placeholder="Enter Email" required>
                </section>

                <section class="form-group mb-3">

                    <div class="input-group form-control rounded-pill d-flex gap-1 bg-white">
                        <input class="bg-transparent flex-fill no-border" name="password" id="password" type="password"
                               placeholder="Enter Password" required>
                        <span class="pointer bg-transparent p-0 no-border input-group-text" id="basic-addon2"><i
                                id="togglePassword"
                                class="bi bi-eye-fill"></i></span>
                    </div>

                </section>

                <button class="mb-3 d-block px-5 py-2 btn rounded-pill mx-auto btn-primary" type="submit">Login</button>

                @if($errors->any())
                    <section class="mb-3 text-center text-danger small">
                        {{$errors->first()}}
                    </section>
                @endif


                <hr>

                <section class="row">
                    <a class="col-6 btn btn-success d-block mx-auto mb-2" href="/register">Create
                        account</a>
                    <a class="col-12 text-blue text-decoration-none text-center text-secondary "
                       href="/forgot-password">Forgot your password?</a>
                </section>
            </form>
        </div>
    </div>
@endsection


@section('javascript')
    <script>

        const validator = new JustValidate('#loginForm', {
            submitFormAutomatically: true,
        });

        validator
            .addField('#email', [
                {
                    rule: 'required',
                },
                {
                    rule: 'email',
                },
            ])

        const togglePasswordElement = document.querySelector('#togglePassword');
        const passwordElement = document.querySelector('#password');

        togglePasswordElement.addEventListener('click', () => {
            const type = password
                .getAttribute('type') === 'password' ?
                'text' : 'password';

            passwordElement.setAttribute('type', type);

            if (type === 'text') {
                togglePasswordElement.classList.replace('bi-eye-fill', 'bi-eye-slash')
            } else {
                togglePasswordElement.classList.replace('bi-eye-slash', 'bi-eye-fill')
            }
        });

    </script>
@endsection
