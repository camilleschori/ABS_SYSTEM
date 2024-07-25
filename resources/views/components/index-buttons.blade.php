@session('success')
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="close alert-close btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endsession
<div class="card-header d-flex align-items-baseline p-4">

    @if (isset($buttons['add']) && $buttons['add'])
        <a href="{{ $buttons['add'] }}" class="btn btn-primary me-2">أضافة</a>
    @endif
    @if (isset($buttons['add_permission']) && $buttons['add_permission'])
        <a href="{{ $buttons['add_permission'] }}" class="btn btn-primary me-2"> أضافة صلاحية</a>
    @endif
    @if (isset($buttons['assign_role']) && $buttons['assign_role'])
        <a href="{{ $buttons['assign_role'] }}" class="btn btn-primary me-2"> تعيين صلاحية للمستخدمين</a>
    @endif

    @if (isset($buttons['filter']) && $buttons['filter'])
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
            data-bs-target="#filterModal">فلترة</button>
    @endif

    @if (isset($buttons['import']) && $buttons['import'])
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
            data-bs-target="#importModal">استيراد</button>
    @endif
    @if (isset($buttons['import_prices']) && $buttons['import_prices'])
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#importPricesModal">
            استيراد الأسعار</button>
    @endif

    @if (isset($buttons['export']) && $buttons['export'])
        <form action="{{ $buttons['export'] }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary me-2">تصدير</button>
        </form>
    @endif

    @if (isset($buttons['back']) && $buttons['back'])
        <a href="{{ $buttons['back'] }}" class="btn btn-primary me-2">رجوع</a>
    @endif



    @if (isset($buttons['multiple_print']) && $buttons['multiple_print'])
        <button type="button" class="btn btn-primary me-2" id="multiple_print">تاكيد & طباعة متعددة</button>
    @endif


    @if (isset($buttons['form']) && $buttons['form'])
        <form action="{{ $buttons['form'] }}" method="GET" class="me-2">
            <input type="text" class="form-control" name="keyword" value="{{ request()->keyword ?? '' }}"
                placeholder="بحث">
        </form>
    @endif


</div>
