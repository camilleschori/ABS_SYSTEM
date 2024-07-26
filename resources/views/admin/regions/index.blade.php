@section('title', 'المناطق')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المناطق" />

            <div class="card">


                <x-index-buttons :buttons="$buttons" />

                <x-dynamic-table :rows="$regions" :headers="$headers" :route="$route" />


            </div>

        </div>


        <x-filter-modal action="{{ route('admin.regions.index') }}">

            <x-form-input name="type" label="نوع المنطقة" class="col-md-6" type="select" :options="$type_options" />
            <x-form-input name="filter" label="البحث" class="col-md-6" type="hidden" value="1" />


        </x-filter-modal>

    </div>

    <script>
        $(document).ready(function() {
            let select = $('#type');
            select.parent().css('display', 'grid');
        });
    </script>
@endsection
