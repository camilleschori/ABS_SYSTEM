@section('title', 'طباعة فاتورة')

@extends('admin.print-layout')


@section('content')


    <div id="app">


        <div id="main" class="p-3">




            <div class="row border mb-3 align-items-center justify-content-center" id="invoice-header">

                <div class="col-8 text-danger text-center">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-4">
                            <h2>كومبانياي</h2>
                        </div>
                        <div class="col-4">
                            <img src="{{ url('assets/images/logo.jpg') }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-4">
                            <h2>شركة</h2>
                        </div>
                        <div class="col-12">
                            <h5>للتجارة العامة والاستثمار المحدودة - ادوات احتياطية للسيارات - بولبرين</h5>
                            <h5>بالکۆمسیۆنی گشتی و بەدەستەوردەکان - بەرهەمی زاپاس بۆ ئۆتۆمبیل - بولبەرینگ</h5>
                        </div>
                    </div>
                </div>

                <div class="col-4 text-center">
                    <h3>قائمة مبيعات نقدية</h3>
                    <h5>توقيت الطباعة</h5>
                    <h6>{{ date('Y-m-d H:i') }}</h6>
                </div>

            </div>

            <div class="row border" id="customer-info">
                <div class="col-12 p-0">
                    <table class="table table-success table-bordered text-center table-sm">
                        <thead>
                            <tr>
                                <th>0750 7399 001 - 0750 4400 873</th>
                                <th>0770 2628 822 - 0770 3978 757</th>
                                <th>اربيل - الصناعة الشمالية - قرب الاطفاء - الفرع الثاني - موبايل</th>
                            </tr>
                        </thead>
                        <tbody class="text-end">
                            <tr>
                                <td><span>0.00 </span><span> $ خصم</span></td>
                                <td>تاريخ القائمة <span>{{ $invoice->date }}</span></td>
                                <td>رقم القائمة <span>{{ $invoice->number }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="3"><span>المورد</span> <span> {{ $invoice->profile->name }}</span></td>
                            </tr>
                            <tr>
                                <td colspan="3"><span>الملاحظات</span> <span> {{ $invoice->notes }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="row mt-3 border" id="invoice-body">
                <div class="col-12 p-0">
                    <table class="table table-bordered text-center table-sm">
                        <thead>
                            <tr>
                                <th>المبلغ</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>المادة</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->items as $item)
                                <tr>
                                    <td>{{ number_format($item->grand_total) }}</td>
                                    <td>{{ number_format($item->item_price) }}</td>
                                    <td>{{ $item->item_quantity }}</td>
                                    <td>{{ $item->item->name }}</td>
                                    <td>{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-3">

                <div class="col-4 text-center bg-info">
                    <h3>توقيع وختم البائع</h3>
                    <br>
                    <br>
                    <p>البيع بالجملة فقط</p>
                    <p>الخطأ والسهو مرجوع للطرفين</p>
                </div>

                <div class="col-2">

                </div>

                <div class="col-6">
                    <table class="table table-bordered text-end  table-sm">
                        <thead class="table-info">
                            <tr>
                                
                                <th>{{ number_format($invoice->total_amount_after_discount) }}</th>
                                <th>مجموع القائمة</th>
                            </tr>
                            <tr>
                                
                                <th>{{ number_format($invoice->paid_amount) }}</th>
                                <th>المبلغ المدفوع</th>
                            </tr>
                            <tr>
                                <th>{{ number_format($invoice->remaining_amount) }}</th>
                                <th>المبلغ المتبقي</th>
                            </tr>
                            <tr>
                                <th>0 $ </th>
                                <th>الحساب السابق</th>
                            </tr>
                            <tr>
                                <th>{{ number_format($invoice->grand_total) }}</th>
                                <th>مجموع الحساب النهائي</th>
                            </tr>
                            
                        </thead>
                        <tfoot class="table-warning">
                            <tr>
                                <th><span>{{ count($invoice->items) }}</span><span>حبة</span></th>
                                <th>عدد الحبات</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>







        </div>


    </div>


    <script>
        $(document).ready(function() {
           
            window.print();
            
        });
    </script>

@endsection
