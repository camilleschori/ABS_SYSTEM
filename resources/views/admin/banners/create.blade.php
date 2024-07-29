@section('title', 'اضافة إعلان');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="الإعلانات" sub1url="{{ route('admin.banners.index') }}" sub2="اضافة إعلان" />
            <div class="card p-5">

                <x-form action="{{ route('admin.banners.store') }}" :back="$back" method="POST">

                    @php
                        $type_options = [
                            'general' => 'عام',
                            'item' => 'مادة',
                            'category' => 'تصنيف',
                            'brand' => 'وكالة',
                        ];
                        $visible_options = [1 => 'مرئي', 0 => 'مخفي'];

                        $locations = [
                            'home_top' => 'اعلى الصفحة',
                            'home_bottom' => 'اسفل الصفحة',
                            'home_middle' => 'منتصف الصفحة',
                        ];
                    @endphp
                    <x-form-input name="name" label=" الاسم" class="col-md-3" type="text" />
                    <x-form-input name="location" label="الظهور في التطبيق" class="col-md-3" type="select"
                        :options="$locations" />

                    <x-form-input name="sequence" label="الترتيب" class="col-md-3" type="number" />
                    <x-form-input name="type" label="نوع الاعلان" class="col-md-3" type="select" :options="$type_options" />

                    <x-form-input name="item_id" label="المنتج الهدف" class="col-md-3" type="select" :options="$items" />

                    <x-form-input name="brand_id" label="الوكالة الهدف" class="col-md-3" type="select" :options="$brands" />

                    <x-form-input name="category_id" label="التصنيف الهدف" class="col-md-3" type="select"
                        :options="$categories" />


                    <x-form-input name="is_visible" label="حالة الظهور" class="col-md-3" type="select" :options="$visible_options" />

                    <x-form-input name="expiry_date" label="تاريخ الانتهاء" class="col-md-3" type="datetime-local" />

                    <x-form-input name="image" label="الصورة" class="col-md-3" type="file" />



                </x-form>

            </div>

        </div>



    </div>

@endsection
