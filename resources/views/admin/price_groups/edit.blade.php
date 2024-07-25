@section('title', 'تعديل فئة سعر');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">

            <x-breadcrumb sub1="فئات السعر" sub1url="{{ route('admin.price_groups.index') }}" sub2="تعديل فئة سعر" />

            <div class="card p-5">

                <x-form action="{{ route('admin.price_groups.update', $price_groups->id) }}" :back="$back" method="PUT">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text"
                        value="{{ $price_groups->name }}" />

                    <x-form-input name="notes" label="الملاحظات" class="col-md-4" type="text"
                        value="{{ $price_groups->notes }}" />

                </x-form>

            </div>

        </div>



    </div>

@endsection
