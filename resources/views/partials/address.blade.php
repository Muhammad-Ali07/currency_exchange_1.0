@php
    $data['countries'] = \App\Models\Country::OrderByName()->get();
    $country_id = isset($current->addresses->country_id)?$current->addresses->country_id:"";
    $region_id = isset($current->addresses->region_id)?$current->addresses->region_id:"";
    $city_id = isset($current->addresses->city_id)?$current->addresses->city_id:"";
    $city_id = isset($current->addresses->city_id)?$current->addresses->city_id:"";
    $address = isset($current->addresses->address)?$current->addresses->address:"";
@endphp
<div class="row">
    <div class="col-sm-12">
        <div class="mb-1 row">
            <div class="col-sm-3">
                <label class="col-form-label">Country <span class="required">*</span></label>
            </div>
            <div class="col-sm-9">
                <select class="select2 form-select countryList" id="country_id" name="country_id">
                    <option value="0" selected>Select</option>
                    @foreach($data['countries'] as $country)
                        <option value="{{$country->id}}" {{$country_id == $country->id?"selected":""}}> {{$country->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="mb-1 row">
            <div class="col-sm-3">
                <label class="col-form-label">Region <span class="required">*</span></label>
            </div>
            <div class="col-sm-9">
                @php
                    $regions = \App\Models\Region::where(['country_id'=>$country_id])->get()
                @endphp
                <select class="select2 form-select regionList" id="region_id" name="region_id">
                    <option value="0" selected>Select</option>
                    @foreach($regions as $region)
                        <option value="{{$region->id}}" {{$region_id == $region->id?"selected":""}}> {{$region->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="mb-1 row">
            <div class="col-sm-3">
                <label class="col-form-label">City <span class="required">*</span></label>
            </div>
            <div class="col-sm-9">
                @php
                    $cities = \App\Models\City::where(['country_id'=>$country_id,'region_id'=>$region_id])->get()
                @endphp
                <select class="select2 form-select cityList" id="city_id" name="city_id">
                    <option value="0" selected>Select</option>]
                    @foreach($cities as $city)
                        <option value="{{$city->id}}" {{$city_id == $city->id?"selected":""}}> {{$city->name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="mb-1 row">
            <div class="col-sm-3">
                <label class="col-form-label">Address <span class="required">*</span></label>
            </div>
            <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="address" name="address" value="{{$address}}">
            </div>
        </div>
    </div>
</div>
