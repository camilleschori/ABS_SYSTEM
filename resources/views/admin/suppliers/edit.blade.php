@section('title', 'تعديل مورد');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">

            <x-breadcrumb sub1="الموردين" sub1url="{{ route('admin.suppliers.index') }}" sub2=" تعديل مورد" />
            <div class="card p-5">
                @php
                    $status_options = [
                        'active' => 'مفعل',
                        'inactive' => 'غير مفعل',
                        'suspended' => 'معلق',
                    ];

                @endphp
                <x-form action="{{ route('admin.suppliers.update', $supplier->id) }}" :back="$back" method="PUT">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" :required="true"
                        :value="$supplier->name" />

                    <x-form-input name="phone" label="رقم الهاتف" class="col-md-4" type="text" :required="true"
                        :value="$supplier->phone" />

                    <x-form-input name="email" label="البريد الالكتروني" class="col-md-4" type="email"
                        :value="$supplier->email" />

                    <x-form-input name="address" label="العنوان" class="col-md-4" type="text" :value="$supplier->address" />

                    <x-form-input name="country_id" label="الدولة" class="col-md-4" type="select" :options="$country_options"
                        :value="$supplier->country_id" />

                    <x-form-input name="province_id" label="المحافظة" class="col-md-4" type="select" :options="$province_options"
                        :value="$supplier->province_id" />

                    <x-form-input name="area_id" label="المنطقة" class="col-md-4" type="select" :options="$area_options"
                        :value="$supplier->area_id" />

                    <x-form-input name="sub_area_id" label="المنطقة الفرعية" class="col-md-4" type="select"
                        :options="$sub_area_options" :value="$supplier->sub_area_id" />

                    <x-form-input name="price_group_id" label="فئة السعر" class="col-md-4" type="select"
                        :options="$price_group_options" :value="$supplier->price_group_id" />

                    <x-form-input name="balance_iqd" label="الرصيد بالعراقي" class="col-md-4" type="number"
                        :readonly="true" :value="$supplier->balance_iqd" />

                    <x-form-input name="balance_usd" label="الرصيد بالدولار" class="col-md-4" type="number"
                        :readonly="true" :value="$supplier->balance_usd" />


                    <x-form-input name="status" label="حالة المورد" class="col-md-4" type="select" :options="$status_options"
                        :value="$supplier->status" />





                </x-form>

            </div>




        </div>
    </div>


@endsection
