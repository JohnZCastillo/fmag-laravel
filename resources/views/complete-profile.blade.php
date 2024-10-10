@extends('layouts.user-index')

@section('files')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/just-validate.js"></script>
    <script src="/ph-json/ph-address-selector.js"></script>
@endsection

@section('body')
    <section class="stack-bg">

        <div class="container pb-4">
            <h2 class="text-center">Personal Information</h2>
            <form id="detailsForm" method="POST" action="/complete-profile" onsubmit="removeStorage()">
                @csrf
                <div class="row">
                    <div class="col-sm col-md-4">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name:</label>
                            <input value="{{old('firstName')}}" type="text" class="form-control" id="firstName"
                                   name="firstName"
                                   placeholder="Enter First Name" required>
                        </div>
                    </div>

                    <div class="col-sm col-md-4">
                        <div class="mb-3">
                            <label for="middleName" class="form-label">Middle Name:</label>
                            <input value="{{old('middleName')}}" type="text" class="form-control" id="middleName"
                                   name="middleName"
                                   placeholder="(Optional)">
                        </div>
                    </div>

                    <div class="col-sm col-md-4">
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name:</label>
                            <input value="{{old('lastName')}}" type="text" class="form-control" id="lastName"
                                   name="lastName"
                                   placeholder="Enter Last Name" required>
                        </div>
                    </div>

                    <div class="col-sm col-12">
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number:</label>
                            <input value="{{old('contactNumber')}}" type="text" class="form-control" id="mobile"
                                   name="contactNumber"
                                   placeholder="Enter Mobile Number" required>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group mb-2">
                        <label for="region" class="form-label">Region</label>
                        <select name="region" class="form-control" id="region" required></select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="province" class="form-label">Province</label>
                        <select name="province" class="form-control" id="province" required></select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="city" class="form-label">City/Municipality</label>
                        <select name="city" class="form-control" id="city" required></select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="barangay" class="form-label">Barangay</label>
                        <select name="barangay" class="form-control" id="barangay" required></select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="street" class="form-label">Postal Code</label>
                        <input value="{{old('postal')}}" class="form-control" type="text" name="postal" id="street" placeholder="(Optional)">
                    </div>

                    <div class="form-group mb-2">
                        <label for="property" class="form-label">Street Name, building, House No.</label>
                        <input value="{{old('property')}}" class="form-control" type="text" name="property" id="property" required>
                    </div>

                    @if($errors->any())
                        <div class="mt-2">
                            <p class="text-danger text-center">{{$errors->first()}}</p>
                        </div>
                    @endif

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <form class="mt-2" method="POST" action="/logout">
                @csrf
                <button type="submit" class="btn btn-secondary">Exit</button>
            </form>

        </div>
    </section>
@endsection

@section('javascript')
    <script>

        function removeStorage() {
            window.localStorage.removeItem('firstName');
            window.localStorage.removeItem('middleName');
            window.localStorage.removeItem('lastName');
            window.localStorage.removeItem('mobile');
        }

        $(window).on('load', function() {
            if (window.localStorage.getItem('firstName')) {
                $('#firstName').val(window.localStorage.getItem('firstName'));
            }

            if (window.localStorage.getItem('middleName')) {
                $('#middleName').val(window.localStorage.getItem('middleName'));
            }

            if (window.localStorage.getItem('lastName')) {
                $('#lastName').val(window.localStorage.getItem('lastName'));
            }

            if (window.localStorage.getItem('mobile')) {
                $('#mobile').val(window.localStorage.getItem('mobile'));
            }
        })

        $('#firstName').on('change', function() {
            window.localStorage.setItem('firstName', $(this).val());
        });

        $('#middleName').on('change', function() {
            window.localStorage.setItem('middleName', $(this).val());
        });

        $('#lastName').on('change', function() {
            window.localStorage.setItem('lastName', $(this).val());
        });

        $('#mobile').on('change', function() {
            window.localStorage.setItem('mobile', $(this).val());
        });

        $('#mobile').on('input', function() {
            let value = $(this).val();
            value = value.replace(/[^0-9()+\-\s]/g, '');
            const plusIndex = value.lastIndexOf('+');
            if (value.split('+').length - 1 > 1) {
                value = value.slice(0, plusIndex) + value.slice(plusIndex + 1);
            }
            $(this).val(value);
        });

        // load provinces
        $('#region').on('change', my_handlers.fill_provinces);

        window.addEventListener('load', () => {

            // load region
            let dropdown = $('#region');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Choose Region</option>');
            dropdown.prop('selectedIndex', 0);
            const url = '/ph-json/region.json';
            // Populate dropdown with list of regions
            $.getJSON(url, function (data) {
                $.each(data, function (key, entry) {
                    dropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));
                })
            });

        });

        const validator = new JustValidate('#detailsForm', {
            submitFormAutomatically: true,
        });

        validator
            .addField('#firstName', [
                {
                    rule: 'required',
                },
                {
                    rule: 'minLength',
                    value: 3,
                    validator: (value, context) => {
                        value.split('').forEach(letter => {
                            if (isNaN(parseInt(letter, 10))) {
                                return false;
                            }
                        })
                        return true;
                    },
                },
            ])
            .addField('#lastName', [
                {
                    rule: 'required',
                },
                {
                    rule: 'minLength',
                    value: 3
                },
            ]).addField('#property', [
            {
                rule: 'required',
            },
            {
                rule: 'minLength',
                value: 3
            },
        ]);
    </script>
@endsection
