<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>

        @if(isset($sub1))
            <li class="breadcrumb-item"><a href="{{ isset($sub1url) && $sub1url ? $sub1url : '' }}">{{ $sub1 }}</a></li>
        @endif

        @if(isset($sub2))
            <li class="breadcrumb-item active" aria-current="page">{{ $sub2 }}</li>
        @endif
    </ol>
</nav>
