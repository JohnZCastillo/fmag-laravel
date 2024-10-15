<div class="modal fade" id="editAddress{{$myAddress->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="/address/{{$myAddress->id}}">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group mb-2">
                            <label class="form-label">Region</label>
                            <select name="region" class="form-control" required>
                                @foreach($regions as $region)
                                    <option @selected($region->region_code == $myAddress->region) value="{{$region->region_code}}">{{$region->region_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-label">Province</label>
                            <select name="province" class="form-control" required>
                                @foreach($provinces as $province)
                                    <option @selected($province->province_code == $myAddress->province) value="{{$province->province_code}}">{{$province->province_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="city" class="form-label">City/Municipality</label>
                            <select name="city" class="form-control" id="editCity" required>
                                @foreach($cities as $city)
                                    <option @selected($city->city_code == $myAddress->city) value="{{$city->city_code}}">{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="form-label">Barangay</label>
                            <select name="barangay" class="form-control" required>
                                @foreach($barangays as $barangay)
                                    <option @selected($barangay->brgy_code == $myAddress->barangay) value="{{$barangay->brgy_code}}">{{$barangay->brgy_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="street" class="form-label">Postal Code</label>
                            <input value="{{$myAddress->postal}}" class="form-control" type="text" name="postal" id="street"
                                   placeholder="(Optional)">
                        </div>

                        <div class="form-group mb-2">
                            <label for="property" class="form-label">Street Name, building, House No.</label>
                            <input value="{{$myAddress->property}}" class="form-control" type="text" name="property" id="property" required>
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
