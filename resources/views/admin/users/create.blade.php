@section('title', ' اضافة مستخدم');

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المستخدمين" sub1url="{{ route('admin.users.index') }}" sub2="اضافة مستخدم" />
            <div class="card p-5">
                @php
                    $status_options = [
                        'active' => 'مفعل',
                        'inactive' => 'غير مفعل',
                        'suspended' => 'معلق',
                    ];
                    $user_type_options = [
                        'admin' => 'مدير',
                        'customer' => 'زبون',
                        'supplier' => 'مورد',
                    ];
                @endphp
                <x-form action="{{ route('admin.users.store') }}" :back="$back" method="POST">

                    <x-form-input name="name" label="الاسم" class="col-md-4" type="text" />

                    <x-form-input name="phone" label="رقم الهاتف" class="col-md-4" type="text" />

                    <x-form-input name="email" label="البريد الالكتروني" class="col-md-4" type="email" />

                    <x-form-input name="password" label="كلمة المرور" class="col-md-4" type="password" />


                    <x-form-input name="type" label="نوع المستخدم" class="col-md-4" type="select" :options="$user_type_options" />

                    <x-form-input name="status" label="حالة المستخدم" class="col-md-4" type="select" :options="$status_options" />


                </x-form>

            </div>

        </div>



    </div>

@endsection
