@section('title', 'اضافة وكالة');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="الوكالات" sub1url="{{ route('admin.brands.index') }}" sub2="اضافة وكالة" />
            <div class="card p-5">

                <x-form action="{{ route('admin.brands.store') }}" :back="$back" method="POST">


                    <x-form-input name="name" label="الاسم" class="col-md-3" type="text" />


                    <x-form-input name="code" label="الكود" class="col-md-3" type="text" />


                    <x-form-input name="logo" label="الشعار" class="col-md-3" type="file" />

                    <x-form-input name="status" label="الحالة" class="col-md-3" type="select" :options="$status_options" />


                </x-form>

            </div>

        </div>



    </div>


    
@endsection
