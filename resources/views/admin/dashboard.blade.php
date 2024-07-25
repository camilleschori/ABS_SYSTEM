@section('title', 'Dashboard')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />


        <div id="main" class="vh-100 overflow-auto">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="container">
                <div class="row">
                    @php
                        $cards = [
                            ['name' => 'الرئيسية', 'icon' => 'bi-house', 'route' => route('admin.dashboard')],
                        ];

                    @endphp

                    @foreach ($cards as $card)
                        <div class="col-md-3 mb-2">
                            <a href="{{ $card['route'] }}" class="text-decoration-none text-dark ">
                                <div class="card bg-primary">
                                    <div class="card-body text-center">
                                        <i class="bi text-white {{ $card['icon'] }} fs-1"></i>
                                        <h5 class="card-title mt-3 text-white">{{ $card['name'] }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>




@endsection