@section('title', 'تعديل فاتورة')

@extends('admin.layout')

@section('content')
    @php
        $invoice_types = [
            'sales' => 'مبيعات',
            'sales_return' => 'مردود مبيعات',
        ];

        $effection_type = [
            'sales' => 'in',
            'sales_return' => 'in_return',
        ];

        $payment_methods = [
            'credit' => 'أجل',
            'cash' => 'نقدا',
        ];

        $status = [
            'pending' => 'قيد المراجعة',
            'confirmed' => 'تمت الموافقة',
            'on_the_way' => 'في الطريق',
            'delivered' => 'تم تسليمه',
            'canceled' => 'ملغي',
        ];

        $payment_status = [
            'unpaid' => 'غير مدفوع',
            'paid' => 'مدفوع',
        ];
    @endphp

    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المبيعات" sub1url="{{ route('admin.sales.index') }}" sub2="تعديل فاتورة" />
            <div class="card p-4">


                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif



                <x-form action="{{ route('admin.sales.update', $invoice->id) }}" :back="$back" method="PUT">


                    <div class="col-12 p-2 border rounded mb-2">
                        <div class="row">

                            <x-form-input name="number" label="رقم الفاتورة" class="col-md-2" type="text" value="{{ $invoice->number }}" readonly />
                            <x-form-input name="date" label="تاريخ الفاتورة" class="col-md-2" type="date" value="{{ $invoice->date }}" />
        
                            <div class="col-2">
                                <label class="mb-2" for="type">نوع الفاتورة</label>
                                <select class="form-select" name="type" id="type" required>
                                    @foreach ($invoice_types as $key => $invoice_type)
                                        <option 
                                        
                                        {{ $invoice->type == $key ? 'selected' : '' }}
                                        effection_type="{{ $effection_type[$key] }}" 
                                        value="{{ $key }}">
                                            {{ $invoice_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="col-2">
                                <label class="mb-2" for="profile_id">الزبون</label>
                                <select class="form-select" name="profile_id" id="profile_id" required>
                                    <option value="{{ $invoice->profile_id }}">{{ $invoice->profile->name }}</option>
                                </select>
                            </div>

                            <div class="col-2">
                                <label class="mb-2" for="currency_id">العملة</label>
                                <select class="form-select" name="currency_id" id="currency_id" required>
                                    <option value="">--</option>
                                    @foreach ($currencies as $currency)
                                        <option 
                                        
                                         
                                        {{ $invoice->currency_id == $currency->id ? 'selected' : '' }}
                                        data-is_forign="{{ $currency->is_foreign }}" 
                                        data-exchange_rate="{{ $currency->exchange_rate }}" 
                                        value="{{ $currency->id }}">
                                            {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
        
                            <x-form-input name="exchange_rate" label="سعر الصرف" class="col-md-2" type="number" value="{{ $invoice->exchange_rate }}" readonly />

                        </div>
                    </div>


                    <div class="col-12 p-2 border rounded mb-2">

                        <div class="row">


                            <x-form-input name="country_id" label="الدولة" class="col-md-2 d-none" type="select" :options="$country_options" :value="$invoice->country_id" />
                            <x-form-input name="province_id" label="المحافظة" class="col-md-2" type="select" :options="$province_options" :value="$invoice->province_id" />
                            <x-form-input name="area_id" label="المنطقة" class="col-md-2" type="select" :options="$area_options" :value="$invoice->area_id" />
                            <x-form-input name="sub_area_id" label="المنطقة الفرعية" class="col-md-2" type="select" :options="$sub_area_options" :value="$invoice->sub_area_id" />
                    
                            <x-form-input name="address_title" label="العنوان" class="col-md-2" type="text" value="{{ $invoice->address_title }}" />
                            <x-form-input name="address_phone" label="رقم الهاتف" class="col-md-2" type="text" value="{{ $invoice->address_phone }}" />
                            <x-form-input name="address_notes" label="ملاحظات العنوان" class="col-md-2" type="text" value="{{ $invoice->address_notes }}" />
                        </div>
                    </div>


                    <div class="col-12 p-2 border rounded mb-2">
                        <div class="row">

                            <x-form-input name="total_amount" label="الاجمالي" class="col-md-2" type="text" value="{{ $invoice->total_amount }}" readonly />
                            <x-form-input name="discount_percentage" label="نسبة الخصم" class="col-md-2" type="text" value="{{ $invoice->discount_percentage }}" />
                            <x-form-input name="discount_value" label="قيمة الخصم" class="col-md-2" type="text" value="{{ $invoice->discount_value }}" readonly />
                            <x-form-input name="total_amount_after_discount" label="الاجمالي بعد الخصم" class="col-md-2" type="text" value="{{ $invoice->total_amount_after_discount }}" readonly />
                            <x-form-input name="delivery_fees" label="كلفة التوصيل" class="col-md-2" type="text" value="{{ $invoice->delivery_fees }}" readonly />
                            <x-form-input name="grand_total" label="الصافي" class="col-md-2 text-danger font-weight-bold" type="text" value="{{ $invoice->grand_total }}" readonly />




                        </div>
                    </div>


                    <div class="col-12 p-2 border rounded mb-2">
                        <div class="row">
                            <x-form-input name="price_group_id" label="فئة السعر" class="col-md-2 d-none" type="hidden" value="{{ $invoice->price_group_id }}" />
                                
                            <x-form-input name="payment_method" label="طريقة الدفع" class="col-md-2" type="select" :options="$payment_methods" value="{{ $invoice->payment_method }}" />
                            <x-form-input name="status" label="الحالة" class="col-md-2" type="select" :options="$status" value="{{ $invoice->status }}" />
                            <x-form-input name="notes" label="ملاحظات" class="col-md-2" type="text" value="{{ $invoice->notes }}" />

                            <x-form-input name="effection_type" label="التاثير" class="col-md-2 d-none" type="text" value="{{ $invoice->effection_type }}" readonly />
                            <x-form-input name="stock_effection" label="التاثير" class="col-md-2 d-none" type="hidden" value="{{ $invoice->stock_effection }}" readonly />

                            <x-form-input name="paid_amount" label="المدفوع" class="col-md-2" type="text" value="{{ $invoice->paid_amount }}" />
                            <x-form-input name="remaining_amount" label="المتبقي" class="col-md-2" type="text" value="{{ $invoice->remaining_amount }}" readonly />
                            <x-form-input name="payment_status" label="حالة الدفع" class="col-md-2" type="select" :options="$payment_status" value="{{ $invoice->payment_status }}" />
                        </div>
                    </div>

                

                    <div class="col-12">
                        <button type="button" class="btn btn-primary mb-2" id="add_row"><i class="bi bi-plus"></i> اضافة مادة</button>

                        <a href="{{ route('admin.sales.print', $invoice->id) }}" class="btn btn-primary mb-2" target="_blank"><i class="bi bi-printer"></i> طباعة</a>



                        <div class="table-responsive overflow-auto border" style="height: 55vh">
                            <table class="table table-sm text-center table-bordered table-hover table-striped table-sm">
                                <thead class="table-primary">
                                    <tr>
                                        <th style="width: 10%" scope="col">اسم المادة</th>
                                        <th style="width: 10%" scope="col">السعر</th>
                                        <th style="width: 10%" scope="col">الكمية</th>
                                        <th style="width: 10%" scope="col">الاجمالي</th>
                                        <th style="width: 10%" scope="col">نسبة الخصم</th>
                                        <th style="width: 10%" scope="col">قيمة الخصم</th>
                                        <th style="width: 10%" scope="col">الصافي</th>
                                        <th style="width: 10%" scope="col">ملاحظات</th>
                                        <th style="width: 10%" scope="col">المستودع</th>
                                        <th style="width: 10%" scope="col">حذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invoice_items as $item)

                                        <tr>
                                            <td>
                                                <select class="form-select select2 item-select" name="item_id[]">
                                                    <option value="{{ $item->item_id }}">{{ $item->item->name }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-price" name="item_price[]" value="{{ $item->item_price }}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-quantity" name="item_quantity[]" value="{{ $item->item_quantity }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-total" name="item_total_before_discount[]" readonly value="{{ $item->total_before_discount }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-discount-percentage" name="item_discount_percentage[]" value="{{ $item->discount_percentage }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-discount-value" name="item_discount_value[]" readonly value="{{ $item->discount_value }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control item-grand-total" name="item_grand_total[]" readonly value="{{ $item->grand_total }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="item_notes[]" value="{{ $item->item_notes }}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="warehouse_id[]" value="{{ $item->warehouse_id }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete-row"><i class="bi bi-trash3"></i></button>
                                            </td>
                                        </tr>
                                        
                                    @empty

                                        <tr>
                                            <td colspan="10">لا يوجد مواد</td>
                                        </tr>
                                        
                                    @endforelse
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            

            // Function to update item prices based on selected customer price group
            function updatePrices() {
                var priceGroupId = $('#price_group_id').val();
                console.log("Updating prices for price group ID:", priceGroupId);

                $('tbody tr').each(function() {
                    var $row = $(this);
                    var $selectedOption = $row.find('.item-select option:selected');
                    var priceData = $selectedOption.data('prices');

                    console.log("Price data for current item:", priceData);

                    if (priceData && priceGroupId) {
                        var basePrice = priceData[priceGroupId] || 0;
                        var exchangeRate = $('#exchange_rate').val();
                        var isForeign = $('#currency_id option:selected').data('is_forign');
                        var price = isForeign ? basePrice * exchangeRate : basePrice;

                        console.log("New price set to:", price);
                        $row.find('.item-price').val(price);

                        // Update the total based on new price
                        var quantity = $row.find('.item-quantity').val();
                        var total = price * quantity;
                        $row.find('.item-total').val(total);

                        updateInvoiceTotals(); // Update the invoice totals after setting new prices
                    }
                });
            }

            // Function to update invoice totals
            function updateInvoiceTotals() {
                var totalAmount = 0;
                var discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
                var discountValue = 0;
                var deliveryFees = parseFloat($('#delivery_fees').val()) || 0;

                $('tbody tr').each(function() {
                    var $row = $(this);
                    var itemTotal = parseFloat($row.find('.item-total').val()) || 0;
                    totalAmount += itemTotal;
                });

                discountValue = (totalAmount * discountPercentage) / 100;
                var totalAmountAfterDiscount = totalAmount - discountValue;
                var grandTotal = totalAmountAfterDiscount + deliveryFees;

                $('#total_amount').val(totalAmount.toFixed(2));
                $('#discount_value').val(discountValue.toFixed(2));
                $('#total_amount_after_discount').val(totalAmountAfterDiscount.toFixed(2));
                $('#grand_total').val(grandTotal.toFixed(2));
                $('#remaining_amount').val((grandTotal - parseFloat($('#paid_amount').val() || 0)).toFixed(2));
            }

            // Function to update exchange rate and recalculate prices
            function updateExchangeRate() {
                var exchangeRate = $('#currency_id option:selected').data('exchange_rate');
                var isForeign = $('#currency_id option:selected').data('is_forign');

                console.log("Selected currency exchange rate:", exchangeRate, "Is foreign:", isForeign);

                $('#exchange_rate').val(exchangeRate);

                // Update item prices based on the new exchange rate
                updatePrices();
            }

            // Initialize Select2 for the customer select box
            $('#profile_id').select2({
                placeholder: 'اختر الزبون',
                minimumInputLength: 3,
                allowClear: true,
                ajax: {
                    type: 'POST',
                    url: '{{ route('admin.sales.SearchCustomer') }}',
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
                        return {
                            results: $.map(data, function(profile) {
                                return {
                                    text: profile.name,
                                    id: profile.id,
                                    price_group_id: profile.price_group_id,
                                    country_id: profile.country_id,
                                    province_id: profile.province_id,
                                    area_id: profile.area_id,
                                    sub_area_id: profile.sub_area_id,
                                    address_title: profile.address_title,
                                    address_phone: profile.phone,
                                    delivery_fees: profile.delivery_fees,
                                    country_name: profile.country ? profile.country.name : '',
                                    province_name: profile.province ? profile.province.name : '',
                                    area_name: profile.area ? profile.area.name : '',
                                    sub_area_name: profile.subArea ? profile.subArea.name : ''
                                }
                            })
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;

                console.log("Selected customer:", data);

                $('#price_group_id').val(data.price_group_id);
                console.log("Selected customer with price group ID:", data.price_group_id);

                // Set region details
                $('#country_id').html(`<option value="${data.country_id}">${data.country_name}</option>`);
                $('#province_id').html(`<option value="${data.province_id}">${data.province_name}</option>`);


                
                $('#area_id').html(`<option value="${data.area_id}">${data.area_name}</option>`);
                $('#sub_area_id').html(`<option value="${data.sub_area_id}">${data.sub_area_name}</option>`);

                // Set address and contact details
                $('#address_title').val(data.address_title);
                $('#address_phone').val(data.address_phone);

                if(data.delivery_fees != null){
                    $('#delivery_fees').val(data.delivery_fees);
                }else{
                    $('#delivery_fees').val(0);
                }


                // Enable add row and save button
                $('#add_row').prop('disabled', false);
                $('form').find(':submit').prop('disabled', false);
                updatePrices(); // Update prices when customer changes
            }).on('select2:unselect', function(e) {
                // Disable add row and save button if no customer is selected
                $('#add_row').prop('disabled', true);
                $('form').find(':submit').prop('disabled', true);
                $('#price_group_id').val('');
            });

            // Add Row event
            $('#add_row').on('click', function() {
                var row = `
                        <tr>
                            <td>
                                <select class="form-select select2 item-select" name="item_id[]">
                                    <option value="">--</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control item-price" name="item_price[]" value="0" readonly>
                            </td>
                            <td>
                                <input type="number" class="form-control item-quantity" name="item_quantity[]" value="1">
                            </td>
                            <td>
                                <input type="number" class="form-control item-total" name="item_total_before_discount[]" readonly value="0">
                            </td>
                            <td>
                                <input type="number" class="form-control item-discount-percentage" name="item_discount_percentage[]" value="0">
                            </td>
                            <td>
                                <input type="number" class="form-control item-discount-value" name="item_discount_value[]" readonly value="0">
                            </td>
                            <td>
                                <input type="number" class="form-control item-grand-total" name="item_grand_total[]" readonly value="0">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="item_notes[]">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="warehouse_id[]">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger delete-row"><i class="bi bi-trash3"></i></button>
                            </td>
                        </tr>

                `;

                $('tbody').append(row);

                // Initialize select2 for the new item select box
                $('.item-select').last().select2({
                    placeholder: 'اختر المادة',
                    minimumInputLength: 3,
                    allowClear: true,
                    ajax: {
                        type: 'POST',
                        url: '{{ route('admin.sales.SearchItems') }}',
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
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id,
                                        prices: item.prices // Assuming all price groups are returned in the response
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    var data = e.params.data;
                    var $row = $(this).closest('tr');
                    var priceData = data.prices;

                    console.log("Item selected with price data:", priceData);

                    if (priceData) {
                        var priceGroupId = $('#price_group_id').val();
                        var basePrice = priceData[priceGroupId] || 0;
                        var exchangeRate = $('#exchange_rate').val();
                        var isForeign = $('#currency_id option:selected').data('is_forign');
                        var price = isForeign ? basePrice * exchangeRate : basePrice;

                        console.log("Setting price to:", price);
                        $row.find('.item-price').val(price);

                        var quantity = $row.find('.item-quantity').val();
                        var total = price * quantity;
                        $row.find('.item-total').val(total);

                        var discountPercentage = parseFloat($row.find('.item-discount-percentage').val()) || 0;
                        var discountValue = (total * discountPercentage) / 100;
                        var grandTotal = total - discountValue;

                        $row.find('.item-discount-value').val(discountValue.toFixed(2));
                        $row.find('.item-grand-total').val(grandTotal.toFixed(2));

                        // Store the price data in the option's data attribute for later use
                        $row.find('.item-select option:selected').data('prices', priceData);

                        updateInvoiceTotals(); // Update the invoice totals after adding a new item
                    }
                });

                // Event listener for quantity and discount change
                $('tbody').on('input', '.item-quantity, .item-discount-percentage', function() {
                    var $row = $(this).closest('tr');
                    var quantity = parseFloat($row.find('.item-quantity').val()) || 0;
                    var price = parseFloat($row.find('.item-price').val()) || 0;
                    var total = price * quantity;
                    $row.find('.item-total').val(total);

                    var discountPercentage = parseFloat($row.find('.item-discount-percentage').val()) || 0;
                    var discountValue = (total * discountPercentage) / 100;
                    var grandTotal = total - discountValue;

                    $row.find('.item-discount-value').val(discountValue.toFixed(2));
                    $row.find('.item-grand-total').val(grandTotal.toFixed(2));

                    updateInvoiceTotals(); // Update the invoice totals after changing quantity or discount
                });
            });

            // Delete row event
            $(document).on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
                updateInvoiceTotals(); // Update totals after removing an item
            });

            // Event listener for currency change
            $('#currency_id').on('change', function() {
                updateExchangeRate(); // Update exchange rate and recalculate prices
            });

            $('#type').on('change', function() {
                var effection_type = $(this).find(':selected').attr('effection_type');
                $('#effection_type').val(effection_type);
            });

            // Event listener for paid amount change
            $('#paid_amount').on('input', function() {
                var grandTotal = parseFloat($('#grand_total').val()) || 0;
                var paidAmount = parseFloat($(this).val()) || 0;
                var remainingAmount = grandTotal - paidAmount;

                $('#remaining_amount').val(remainingAmount.toFixed(2));
            });
        });
    </script>
@endsection
