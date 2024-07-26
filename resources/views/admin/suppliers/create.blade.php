@section('title', ' اضافة مورد');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="الموردين" sub1url="{{ route('admin.suppliers.index') }}" sub2="اضافة مورد" />
            <div class="card p-5">
                @php
                    $status_options = [
                        'active' => 'مفعل',
                        'inactive' => 'غير مفعل',
                        'suspended' => 'معلق',
                    ];

                @endphp
                <x-form action="{{ route('admin.suppliers.store') }}" :back="$back" method="POST">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" :required="true" />

                    <x-form-input name="phone" label="رقم الهاتف" class="col-md-4" type="text" :required="true" />

                    <x-form-input name="email" label="البريد الالكتروني" class="col-md-4" type="email" />

                    <x-form-input name="address" label="العنوان" class="col-md-4" type="text" />

                    <x-form-input name="country_id" label="الدولة" class="col-md-4" type="select" :options="$country_options" />

                    <x-form-input name="province_id" label="المحافظة" class="col-md-4" type="select" :options="$province_options" />

                    <x-form-input name="area_id" label="المنطقة" class="col-md-4" type="select" :options="$area_options" />

                    <x-form-input name="sub_area_id" label="المنطقة الفرعية" class="col-md-4" type="select"
                        :options="$sub_area_options" />

                    <x-form-input name="price_group_id" label="فئة السعر" class="col-md-4" type="select"
                        :options="$price_group_options" />

                    <x-form-input name="balance_iqd" label="الرصيد بالعراقي" class="col-md-4" type="number"
                        :readonly="true" />

                    <x-form-input name="balance_usd" label="الرصيد بالدولار" class="col-md-4" type="number"
                        :readonly="true" />


                    <x-form-input name="status" label="حالة المورد" class="col-md-4" type="select" :options="$status_options" />



                </x-form>

            </div>

        </div>



    </div>

@endsection
