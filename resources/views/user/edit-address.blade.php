@extends('layouts.user-account')

@section('files')
    <script src="/js/jquery-3.4.1.min.js"></script>
    <script src="/js/just-validate.js"></script>
    <script src="/ph-json/ph-address-selector.js"></script>
@endsection

@section('body')
    <div>
        <h4>Edit Address</h4>
        <hr>

        <form method="POST" action="/address/{{$address->id}}">
            @csrf
            @method('PATCH')
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
                    <input value="{{$address->postal}}" class="form-control" type="text" name="postal" id="street"
                           placeholder="(Optional)">
                </div>

                <div class="form-group mb-2">
                    <label for="property" class="form-label">Street Name, building, House No.</label>
                    <input value="{{$address->property}}" class="form-control" type="text" name="property" id="property"
                           required>
                </div>

                @if($errors->any())
                    <div class="mt-2">
                        <p class="text-danger text-center">{{$errors->first()}}</p>
                    </div>
                @endif

            </div>


            <button type="submit" class="rounded-pill btn btn-primary">Update</button>
        </form>

    </div>
@endsection

@section('script')
    <script>
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
    </script>
@endsection
