@section('title', 'اضافة فئة سعر');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="فئات الاسعار" sub1url="{{ route('admin.price_groups.index') }}" sub2="اضافة فئة سعر" />
            <div class="card p-5">

                <x-form action="{{ route('admin.price_groups.store') }}" :back="$back" method="POST">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" />

                    <x-form-input name="notes" label="ملاحظات" class="col-md-4" type="text" />

                </x-form>

            </div>

        </div>



    </div>

@endsection
