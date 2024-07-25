@session('success')
    <div class="alert alert-success alert-dismissible fade show " role="alert">
        {{ session('success') }}
        <button type="button" class="close alert-close btn-close" data-bs-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endsession
<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    <div class="row">
        {{ $slot }}
    </div>


    @if (auth()->user()->type == 'drugstore' || auth()->user()->type == 'admin')
        <button type="submit" class="btn btn-primary mt-3">{{ $method == 'POST' ? 'حفظ' : 'تحديث' }}</button>
    @endif


    <a href="{{ $back }}" class="btn btn-primary mt-3">رجوع</a>

</form>
