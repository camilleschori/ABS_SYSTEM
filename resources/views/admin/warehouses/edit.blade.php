@section('title', 'تعديل مستودع');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">

            <x-breadcrumb sub1="فئات السعر" sub1url="{{ route('admin.warehouses.index') }}" sub2="تعديل مستودع" />

            <div class="card p-5">

                <x-form action="{{ route('admin.warehouses.update', $warehouses->id) }}" :back="$back" method="PUT">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text"
                        value="{{ $warehouses->name }}" />


                </x-form>

            </div>

        </div>



    </div>

@endsection
