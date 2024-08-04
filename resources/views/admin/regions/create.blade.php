@extends('admin.layout')

@section('title', ' اضافة منطقة')

@section('content')
    <div id="app">
        <x-sidebar />



        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المناطق" sub1url="{{ route('admin.regions.index') }}" sub2="اضافة منطقة" />
            <div class="card p-5">
                <x-form action="{{ route('admin.regions.store') }}" :back="$back" method="POST">

                    <x-form-input name="type" label="نوع المنطقة" class="col-md-7" type="select" :options="$type_options" />

                    <div id="type-specific-inputs" class="col-md-7">
                        <!-- Country select (for province) -->
                        <div id="country-select" style="display: none;">
                            <x-form-input name="country_id" label="الدولة" class="col-md-12" type="select"
                                :options="$country_options" />
                            <x-form-input name="delivery_fees" label="تكاليف التوصيل" type="number" class="col-md-12" />
                        </div>

                        <!-- Province select (for area) -->
                        <div id="province-select" style="display: none;">
                            <x-form-input name="province_id" label="المحافظة" type="select" class="col-md-12"
                                :options="$province_options" />


                        </div>

                        <!-- Area select (for sub_area) -->
                        <div id="area-select" style="display: none;">
                            <x-form-input name="area_id" label="المنطقة" type="select" class="col-md-12"
                                :options="$area_options" />
                        </div>
                    </div>

                    <div class="col-md-7">
                        <x-form-input name="name" label=" الاسم" type="text" class="col-md-12" />
                    </div>


                </x-form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            const $typeSelect = $('select[name="type"]');
            const $countrySelect = $('#country-select');
            const $provinceSelect = $('#province-select');
            const $areaSelect = $('#area-select');

            function toggleInputs(type) {
                $countrySelect.hide();
                $provinceSelect.hide();
                $areaSelect.hide();

                if (type === 'province') {
                    $countrySelect.show();
                    $(document).find('#country_id').parent().css('display', 'grid');
                } else if (type === 'area') {
                    $provinceSelect.show();
                    $(document).find('#province_id').parent().css('display', 'grid');
                } else if (type === 'sub_area') {
                    $areaSelect.show();
                    $(document).find('#area_id').parent().css('display', 'grid');
                }
            }

            toggleInputs($typeSelect.val());

            $typeSelect.on('change', function() {
                toggleInputs($(this).val());
            });



        });
    </script>
@endsection
