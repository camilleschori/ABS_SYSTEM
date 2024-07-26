@section('title', 'تعديل زبون');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">

            <x-breadcrumb sub1="الزبائن" sub1url="{{ route('admin.customers.index') }}" sub2=" تعديل زبون" />
            <div class="card p-5">
                @php
                    $status_options = [
                        'active' => 'مفعل',
                        'inactive' => 'غير مفعل',
                        'suspended' => 'معلق',
                    ];

                @endphp
                <x-form action="{{ route('admin.customers.update', $customer->id) }}" :back="$back" method="PUT">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" :required="true"
                        :value="$customer->name" />

                    <x-form-input name="phone" label="رقم الهاتف" class="col-md-4" type="text" :required="true"
                        :value="$customer->phone" />

                    <x-form-input name="email" label="البريد الالكتروني" class="col-md-4" type="email"
                        :value="$customer->email" />

                    <x-form-input name="address" label="العنوان" class="col-md-4" type="text" :value="$customer->address" />

                    <x-form-input name="country_id" label="الدولة" class="col-md-4" type="select" :options="$country_options"
                        :value="$customer->country_id" />

                    <x-form-input name="province_id" label="المحافظة" class="col-md-4" type="select" :options="$province_options"
                        :value="$customer->province_id" />

                    <x-form-input name="area_id" label="المنطقة" class="col-md-4" type="select" :options="$area_options"
                        :value="$customer->area_id" />

                    <x-form-input name="sub_area_id" label="المنطقة الفرعية" class="col-md-4" type="select"
                        :options="$sub_area_options" :value="$customer->sub_area_id" />

                    <x-form-input name="price_group_id" label="فئة السعر" class="col-md-4" type="select"
                        :options="$price_group_options" :value="$customer->price_group_id" />

                    <x-form-input name="balance_iqd" label="الرصيد بالعراقي" class="col-md-4" type="number"
                        :readonly="true" :value="$customer->balance_iqd" />

                    <x-form-input name="balance_usd" label="الرصيد بالدولار" class="col-md-4" type="number"
                        :readonly="true" :value="$customer->balance_usd" />


                    <x-form-input name="status" label="حالة الزبون" class="col-md-4" type="select" :options="$status_options"
                        :value="$customer->status" />

                    <div class="col-md-12 mt-3">
                        <div id="map" class="col-md-4" style="height: 400px;"></div>
                    </div>
                    <x-form-input name="latitude" label="خط العرض (Latitude)" class="col-md-4" type="hidden"
                        :value="$customer->latitude" />
                    <x-form-input name="longitude" label="خط الطول (Longitude)" class="col-md-4" type="hidden"
                        :value="$customer->longitude" />



                </x-form>

            </div>




        </div>
    </div>

    <script>
        var map = L.map('map').setView([{{ $customer->latitude }}, {{ $customer->longitude }}],
            13); // Set initial coordinates and zoom level

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $customer->latitude }}, {{ $customer->longitude }}]).addTo(
            map); // Default marker position

        map.on('click', function(e) {
            marker.setLatLng(e.latlng); // Update marker position on map click
            // Update latitude and longitude input values
            $('input[name="latitude"]').val(e.latlng.lat.toFixed(6));
            $('input[name="longitude"]').val(e.latlng.lng.toFixed(6));
        });

        // Optionally, set marker and map initial positions based on existing latitude and longitude values
        var latitude = $('input[name="latitude"]').val();
        var longitude = $('input[name="longitude"]').val();
        if (latitude && longitude) {
            marker.setLatLng([latitude, longitude]);
            map.setView([latitude, longitude], 13);
        }
    </script>
@endsection
