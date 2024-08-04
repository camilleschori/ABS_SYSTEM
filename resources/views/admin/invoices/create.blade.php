@section('title', 'انشاء فاتورة');

@extends('admin.layout')


@section('content')


    @php
        $invoice_types = [
            'sales' => 'فاتورة مبيعات',
            'purchase' => 'فاتورة مشتريات',
            'sales_return' => 'فاتورة مرتجع مبيعات',
            'purchase_return' => 'فاتورة مرتجع مشتريات',
        ];

        $effection_type = [
            'sales' => 'in',
            'purchase' => 'out',
            'sales_return' => 'in_return',
            'purchase_return' => 'out_return',
        ];

        $items = \Illuminate\Support\Facades\DB::table('items')->get();
    @endphp


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="الفواتير" sub1url="{{ route('admin.invoices.index') }}" sub2="انشاء فاتورة" />
            <div class="card p-5">

                <x-form action="{{ route('admin.invoices.store') }}" :back="$back" method="POST">



                    <div class="col-2">
                        <label class="mb-2" for="type">نوع الفاتورة</label>
                        <select class="form-select" name="type" id="type" required>
                            <option value="">--</option>
                            @foreach ($invoice_types as $key => $invoice_type)
                                <option effection_type={{ $effection_type[$key] }} value="{{ $key }}">
                                    {{ $invoice_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- <x-form-input name="number" label="رقم القائمة" class="col-md-2" type="text" readonly /> --}}

                    <x-form-input name="date" label="تاريخ القائمة" class="col-md-2" type="date"
                        value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" />


                    <div class="col-2">
                        <label class="mb-2" for="profile_id">العميل</label>
                        <select class="form-select" name="profile_id" id="profile_id" required>
                            <option value="">--</option>
                           
                        </select>
                    </div>

                    <div class="col-2">
                        <label class="mb-2" for="currency_id">العملة</label>
                        <select class="form-select" name="currency_id" id="currency_id" required>
                            <option value="">--</option>
                            @foreach ($currencies as $currency)
                                <option data-is_forign="{{ $currency->is_foreign }}"
                                    data-exchange_rate="{{ $currency->exchange_rate }}" value="{{ $currency->id }}">
                                    {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <x-form-input name="exchange_rate" label="سعر الصرف" class="col-md-2" type="number" />

                    <x-form-input name="notes" label="ملاحظات" class="col-md-2" type="text" />


                    <x-form-input name="effection_type" label="التاثير" class="col-md-2" type="hidden" readonly />


                    <div class="col-12">

                        <button type="button" class="btn btn-primary mb-2" id="add_row">Add Row</button>

                        <div class="table-responsive overflow-auto" style="height: 65vh">
                        
                            <table class="table table-bordered table-hover table-striped table-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th scope="col">اسم المادة</th>
                                        <th scope="col">الكمية</th>
                                        <th scope="col">السعر</th>
                                        <th scope="col">المجموع</th>
                                        <th scope="col">الملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                    </div>


                    


                </x-form>

            </div>

        </div>


    </div>


    <script>
        $(document).ready(function() {



            var items = @json($items);

            $('#add_row').on('click', function() {


                var row = `
                    <tr>
                        
                        <td>
                            <select class="form-select select2" name="item_id[]">
                                <option value="">--</option>
                                ${items.map(item => `<option value="${item.id}">${item.name}</option>`).join('')}
                                
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="item_quantity[]">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="item_price[]">
                        </td>
                       
                        <td>
                            <input type="number" class="form-control" name="grand_total[]" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="notes[]">
                        </td>
                        </tr>
                    `;


                $('tbody').append(row);

                $('.select2').select2({
                    placeholder: 'اختر التصنيف'
                });
                
            });


            $('#currency_id').on('change', function() {

                exchange_rate = $(this).find(':selected').data('exchange_rate');
                $('#exchange_rate').val(exchange_rate);
            });

            $('#type').on('change', function() {

                effection_type = $(this).find(':selected').attr('effection_type');
                $('#effection_type').val(effection_type);
            });

            $('#profile_id').select2({
                placeholder: 'اختر العميل',
                minimumInputLength: 3,
                ajax: {
                    type: 'POST',
                    url: '{{ route('admin.invoices.AjaxSearch') }}',
                    dataType: 'json',
                    delay: 250,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data) {

                        console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

        });
    </script>


@endsection
