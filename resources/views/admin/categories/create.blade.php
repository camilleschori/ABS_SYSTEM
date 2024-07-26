@section('title', 'اضافة تصنيف');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="التصنيفات" sub1url="{{ route('admin.categories.index') }}" sub2="اضافة تصنيف" />
            <div class="card p-5">

                <x-form action="{{ route('admin.categories.store') }}" :back="$back" method="POST">

                    @php
                        $type_options = ['main' => 'تصنيف رئيسي', 'sub' => 'تصنيف فرعي'];
                        $visible_options = [1 => 'مرئي', 0 => 'مخفي'];
                    @endphp
                    <x-form-input name="type" label="النوع" class="col-md-12" type="select" :options="$type_options" />

                    <x-form-input name="parent_id" label="التصنيف الرئيسي" class="col-md-12" type="select"
                        :options="$parent_options" />

                    <x-form-input name="name" label="الاسم" class="col-md-12" type="text" />

                    <x-form-input name="is_visible" label="حالة الظهور" class="col-md-12" type="select"
                        :options="$visible_options" />


                    <x-form-input name="image" label="الصورة" class="col-md-12" type="file" />



                </x-form>

            </div>

        </div>



    </div>

@endsection
