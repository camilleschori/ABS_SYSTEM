@section('title', 'اضافة عملة');

@extends('admin.layout')


@section('content')



    @php
        $is_foreign_options = [1 => 'نعم', 0 => 'لا'];
    @endphp


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="العملات" sub1url="{{ route('admin.currencies.index') }}" sub2="اضافة عملة" />
            <div class="card p-5">

                <x-form action="{{ route('admin.currencies.store') }}" :back="$back" method="POST">

                    <x-form-input name="name" label="الاسم" class="col-md-12" type="text" />
                    <x-form-input name="symbol" label="الرمز" class="col-md-12" type="text" />
                    <x-form-input name="is_foreign" label="هل هي عملة محلية؟" class="col-md-12" type="select"
                        :options="$is_foreign_options" />
                    <x-form-input name="exchange_rate" label="سعر الصرف" class="col-md-12" type="number" />

                </x-form>

            </div>

        </div>



    </div>

@endsection
