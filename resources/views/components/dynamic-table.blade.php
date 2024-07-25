<div class="card-body">
    <div class="table-responsive overflow-auto" style="height: 65vh">

        <table class="table table-hover text-center table-bordered">
            <thead class="table-primary">
                <tr>
                    <th scope="col">ت</th>
                    @foreach ($headers as $key => $value)
                        <th scope="col">{{ $value }}</th>
                    @endforeach
                    @if (!$excludeBtns)
                        <th scope="col">-</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $index => $row)
                    <tr>
                        <th scope="row" class="align-middle">{{ $index + 1 }}</th>
                        @foreach ($headers as $key => $value)
                            <td>{!! $row[$key] !!}</td>
                        @endforeach
                        @if (!$excludeBtns)
                            <td>

                                <div class="d-flex justify-content-center">

                                    <div>
                                        <a href="{{ route($route . '.edit', $row['id']) }}"
                                            class="btn btn-primary me-2"><i class="bi bi-pencil-square"></i></a>
                                    </div>




                                    @if (auth()->user()->type == 'drugstore' || auth()->user()->type == 'admin')
                                        <form action="{{ route($route . '.destroy', $row['id']) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    @endif


                                </div>

                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) + 2 }}">لايوجد بيانات</td>
                    </tr>
                @endforelse



            </tbody>
        </table>


    </div>


</div>

@if (!$excludePagination)
    {{ $rows->appends(request()->query())->links('pagination::bootstrap-5') }}
@endif
