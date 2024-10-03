@extends('layouts.user-account')

@section('files')
{{--    <script src="/js/jquery-3.4.1.min.js"></script>--}}
{{--    <script src="/js/just-validate.js"></script>--}}
{{--    <script src="/ph-json/ph-address-selector.js"></script>--}}
    <script src="/js/ph-address-selector.js"></script>
@endsection

@section('body')

    <div>
        <h4>Address</h4>
        <hr>
        <ul class="list-group list-group-flush">
            @foreach($addresses as $address)
                <li class="list-group-item d-flex justify-content-between">
                    <p>
                        <span class="text-capitalize" id="location{{$address->id}}">{!! \App\Helper\AddressParser::parseAddress($address) !!}</span>

                        @if($address->active)
                            <span class="message-holder badge bg-success">Default</span>
                        @endif

                    </p>
                    <div>
                        <div class="mb-2 d-flex gap-2">

                            <form method="POST" action="/address/{{$address->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                            <button data-bs-toggle="modal" data-bs-target="#editAddress" class="btn btn-secondary">Edit</button>
                        </div>

                        @if(!$address->active)
                            <form method="POST" action="/default-address/{{$address->id}}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Set As Default</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
        <button data-bs-toggle="modal" data-bs-target="#addAddress" class="btn btn-primary">Add Address</button>
    </div>

    <div class="modal fade" id="addAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/new-address">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="editAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="/address">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-2">
                                <label for="region" class="form-label">Region</label>
                                <select name="region" class="form-control" id="editRegion" required></select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="province" class="form-label">Province</label>
                                <select name="province" class="form-control" id="editProvince" required></select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="city" class="form-label">City/Municipality</label>
                                <select name="city" class="form-control" id="editCity" required></select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="barangay" class="form-label">Barangay</label>
                                <select name="barangay" class="form-control" id="editBarangay" required></select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="street" class="form-label">Postal Code</label>
                                <input value="" class="form-control" type="text" name="postal" id="street" placeholder="(Optional)">
                            </div>

                            <div class="form-group mb-2">
                                <label for="property" class="form-label">Street Name, building, House No.</label>
                                <input value="" class="form-control" type="text" name="property" id="property" required>
                            </div>
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

@section('script')

    <script>
        phAddress({
            'regionSelector': '#editRegion',
            'provinceSelector':'#editProvince',
            'citySelector':'#editCity',
            'brgySelector':'#editBarangay',
        });
    </script>

{{--    <script>--}}
{{--        $('#region').on('change', my_handlers.fill_provinces);--}}
{{--        window.addEventListener('load', () => {--}}
{{--            let dropdown = $('#region');--}}
{{--            dropdown.empty();--}}
{{--            dropdown.append('<option selected="true" disabled>Choose Region</option>');--}}
{{--            dropdown.prop('selectedIndex', 0);--}}
{{--            const url = '/ph-json/region.json';--}}
{{--            $.getJSON(url, function (data) {--}}
{{--                $.each(data, function (key, entry) {--}}
{{--                    dropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));--}}
{{--                })--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
