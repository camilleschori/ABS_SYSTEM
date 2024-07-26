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
                            ['name' => 'الوكالات', 'icon' => 'bi-tags', 'route' => route('admin.brands.index')],
                            ['name' => 'الزبائن', 'icon' => 'bi-people', 'route' => route('admin.customers.index')],
                            [
                                'name' => 'الموردين',
                                'icon' => 'bi-person-video2',
                                'route' => route('admin.suppliers.index'),
                            ],
                            [
                                'name' => 'فئات السعر',
                                'icon' => 'bi-cash-coin',
                                'route' => route('admin.price_groups.index'),
                            ],
                            [
                                'name' => 'المستخدمين',
                                'icon' => 'bi-person-circle',
                                'route' => route('admin.users.index'),
                            ],
                            ['name' => 'الاعدادات', 'icon' => 'bi-sliders', 'route' => route('admin.settings.index')],

                            ['name' => 'المناطق', 'icon' => 'bi-map', 'route' => route('admin.regions.index')],

                            ['name' => 'التصنيفات', 'icon' => 'bi-list', 'route' => route('admin.categories.index')],
                            ['name' => 'المستودعات', 'icon' => 'bi-boxes', 'route' => route('admin.warehouses.index')],
                            ['name' => 'العملات', 'icon' => 'bi-currency-exchange', 'route' => route('admin.currencies.index')],
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
