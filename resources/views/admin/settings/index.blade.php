@section('title', 'الاعدادات')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">

            <x-breadcrumb sub1="الاعدادات" />

            <div class="card p-5">
                <x-form action="{{ route('admin.settings.update' , $settings->first()->id) }}" :back="$back" method="PUT">


                    <x-form-input name="logo" label="الشعار" class="col-md-6" type="file" value="" />

                    <x-form-input name="phone" label="رقم الهاتف" class="col-md-6" type="text" value="{{ $settings->first()->phone }}" />

                    <x-form-input name="email" label="البريد الالكتروني" class="col-md-6" type="text" value="{{ $settings->first()->email }}" />

                    <x-form-input name="address" label="العنوان" class="col-md-6" type="text" value="{{ $settings->first()->address }}" />


                    <div class="col-4">
                        <img src="{{ url('uploads/settings/' . $settings->first()->logo) }}" width="200" alt="" srcset="">
                    </div>



                </x-form>
            </div>
        </div>

    </div>

@endsection
