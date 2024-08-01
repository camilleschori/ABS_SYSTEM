@section('title', 'تعديل وكالة');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="الوكالات" sub1url="{{ route('admin.brands.index') }}" sub2="تعديل وكالة" />
            <div class="card p-5">

                <x-form action="{{ route('admin.brands.update', $brand->id) }}" :back="$back" method="PUT">


                    <x-form-input name="name" label="الاسم" class="col-md-12" type="text"
                        value="{{ $brand->name }}" />




                    <x-form-input name="code" label="الكود" class="col-md-12" type="text" value="{{ $brand->code }}"
                        readonly />


                    <x-form-input name="logo" label="الشعار" class="col-md-12" type="file" />

                    <x-form-input name="status" label="الحالة" class="col-md-12" type="select" :options="$status_options"
                        :value="$brand->status" />


                    <div class="col-3">
                        <img src="{{ url('ABS_SYSTEM/public/uploads/brands/' . $brand->logo) }}" class="mt-3 border"
                            width="400" alt="" srcset="">
                    </div>



                </x-form>

            </div>

        </div>



    </div>

@endsection
