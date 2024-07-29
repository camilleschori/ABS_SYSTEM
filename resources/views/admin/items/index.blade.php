@section('title', 'المواد')

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المواد" />

            <div class="card">

                <x-index-buttons :buttons="$buttons" />

                <x-dynamic-table :rows="$items" :headers="$headers" :route="$route" />

            </div>
        </div>
        @php
            $brands = \App\Models\Brand::pluck('name', 'id')->toArray();
        @endphp





        {{-- <div class="modal fade" id="importModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">استيراد</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.items.import') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf

                            <div class="mb-3">
                                <label for="file" class="form-label">الملف</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">استيراد</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="importPricesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">استيراد الأسعار</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.items.importPrices') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf

                            <div class="mb-3">
                                <label for="file" class="form-label">الملف</label>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">استيراد</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                        </div>

                    </form>
                </div>
            </div>
        </div> --}}





        <x-filter-modal action="{{ route('admin.items.index') }}">

            <x-form-input name="brand_id" label="الوكالة" class="col-md-12 " type="select" :options="$brands"
                value="{{ request()->brand_id ?? '' }}" />

            <x-form-input name="is_out_of_stock" label="نافذ الكمية في المخزون" class="col-md-12 " type="select"
                :options="['all' => 'الكل', '1' => 'نافذ', '0' => 'غير نافذ']" value="all" value="{{ request()->is_out_of_stock ?? '' }}" />

            <x-form-input name="filter" label="البحث" class="col-md-6" type="hidden" value="1" />
            {{-- value="{{ request()->filter }}" --}}

        </x-filter-modal>

    </div>

    <script>
        $(document).ready(function() {
            $('#filterModal select').parent().css('display', 'grid');
        });
    </script>
@endsection
