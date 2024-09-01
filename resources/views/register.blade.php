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


        .eye {
            position: absolute;
            top: 35px;
            right: 10px;
        }

    </style>
@endsection


@section('body')
    <div class="stack-bg">
        <div class="container pb-3 mx-auto bg-light">
            <div class="text-center">
                <h2>Create your account</h2>
                <p>Create an account if you wish to order or inquire about service.</p>
            </div>
            <form id="registerForm" class="mx-auto" action="/register" method="POST"
                  style="max-width: 400px">

                @csrf

                <div class="mt-2">
                    <label for="email">Email</label>
                    <input value="{{old('email')}}" class="form-control" type="text" id="email" name="email" required>
                </div>

                <div class="mt-2 position-relative">
                    <label for="password">Password</label>
                    <input class="form-control" name="password" id="password" type="password" required>
                    <span class="eye pointer bg-transparent p-0 no-border input-group-text"><i id="togglePassword"
                                                                                               class="bi bi-eye-fill"></i></span>
                </div>

                <div class="mt-2 position-relative">
                    <label for="password_confirmation">Confirm Password</label>
                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password"
                           required>
                    <span class="eye pointer bg-transparent p-0 no-border input-group-text">
                        <i id="togglePassword2" class="bi bi-eye-fill"></i></span>
                </div>

                <div>
                    <p>By registering, you agree to our <a href="/policy">terms and conditions</a></p>
                </div>

                @if($errors->any())
                    <section class="mb-3 text-center text-danger small">
                        {{$errors->first()}}
                    </section>
                @endif

                <button class="d-block w-100 mt-2 btn btn-primary py-2" type="submit">Create your account</button>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        const validator = new JustValidate('#registerForm', {
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
            .addField('#password', [
                {
                    rule: 'required',
                },
                {
                    rule: 'password',
                },
            ])
            .addField('#password_confirmation', [
                {
                    rule: 'required',
                },
                {
                    rule: 'password',
                },
                {
                    validator: (value, context) => {

                        let password = document.getElementById('password');

                        return value === password.value;

                    },
                }
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

        const togglePasswordElement2 = document.querySelector('#togglePassword2');
        const passwordElement2 = document.querySelector('#password_confirmation');

        togglePasswordElement2.addEventListener('click', () => {
            const type = passwordElement2
                .getAttribute('type') === 'password' ?
                'text' : 'password';

            passwordElement2.setAttribute('type', type);

            if (type === 'text') {
                togglePasswordElement2.classList.replace('bi-eye-fill', 'bi-eye-slash')
            } else {
                togglePasswordElement2.classList.replace('bi-eye-slash', 'bi-eye-fill')
            }
        });

    </script>
@endsection
