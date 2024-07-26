@section('title', 'العملات')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="العملات" />

            <div class="card">
                <x-index-buttons :buttons="$buttons" />
                <x-dynamic-table :rows="$currencies" :headers="$headers" :route="$route" />
            </div>
        </div>

    </div>

@endsection
