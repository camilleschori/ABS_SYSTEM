@section('title', 'المبيعات')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المبيعات" />

            <div class="card">


                <x-index-buttons :buttons="$buttons" />

                <x-dynamic-table :rows="$invoices" :headers="$headers" :route="$route" />


            </div>


        </div>


        <x-filter-modal action="{{ route('admin.sales.index') }}">

            <x-form-input name="start_date" label="من" class="col-md-6" type="date" />
            <x-form-input name="end_date" label="الى" class="col-md-6" type="date" />

        </x-filter-modal>

    </div>

@endsection
