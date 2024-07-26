@section('title', 'اضافة مستودع');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المستودعات" sub1url="{{ route('admin.warehouses.index') }}" sub2="اضافة مستودع" />
            <div class="card p-5">

                <x-form action="{{ route('admin.warehouses.store') }}" :back="$back" method="POST">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" />


                </x-form>

            </div>

        </div>



    </div>

@endsection
