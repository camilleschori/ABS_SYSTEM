@section('title', 'اضافة مادة')ذ;

@extends('admin.layout')


@section('content')


    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المواد" sub1url="{{ route('admin.items.index') }}" sub2="اضافة مادة" />
            <div class="card p-5">

                <x-form action="{{ route('admin.items.store') }}" :back="$back" method="POST">
                    <div class="d-flex justify-content-between align-items-center">
                        <ul class="nav nav-tabs pb-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                    type="button" role="tab" aria-controls="home" aria-selected="true">معلومات</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">الصور</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                    type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">التسعير</button>
                            </li>

                        </ul>

                        <button type="button" class="btn btn-primary add_attachment">إضافة صورة</button>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">



                                @foreach (\App\Models\Item::Form() as $field)
                                    <x-form-input :type="$field['type']" :name="$field['name']" :label="$field['label']" :class="$field['class']"
                                        :value="$field['value'] ?? ''" :options="$field['options'] ?? []" :multiple="$field['multiple'] ?? false" :readonly="$field['readonly'] ?? false"
                                        :required="$field['required'] ?? false" :modal="$field['modal'] ?? false" :disabled="$field['disabled'] ?? false" />
                                @endforeach



                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="table-responsive overflow-auto">

                                <table class="table table-hover text-center table-bordered attachment_table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">ت</th>
                                            <th scope="col">الملف</th>
                                            <th scope="col">-</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="3">لايوجد بيانات</td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="table-responsive overflow-auto">

                                <table class="table table-hover text-center table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">الفئة</th>
                                            <th scope="col">السعر</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($price_groups as $price_group)
                                            <tr>
                                                <td>{{ $price_group->name }}</td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="price_groups[{{ $price_group->id }}]" value="0">
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2">لايوجد بيانات</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                </x-form>

            </div>

        </div>



    </div>
    <script>
        $(document).ready(function() {

            var codeInput = $('input[name="code"]');
            $(document).on('change', 'select[name="brand_id"]', function() {
                value = $(this).val();

                fetchLastChildCode();



            });

            function fetchLastChildCode() {
                let value;

                let brandSelect = $(document).find('select[name="brand_id"]');
                $.ajax({
                    url: '{{ route('admin.items.getLastChildCode') }}',
                    type: 'POST',
                    data: {
                        brand_id: brandSelect.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        value = data.new_code;
                        $(document).find('input[name="code"]').val(value);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching last child code:', error);
                    }
                });

            }




            $(document).on('click', '.add_attachment', function() {

                var table = $('.attachment_table tbody');

                var row = $('.attachment_table tbody tr:first-child td');

                if (row.length === 1) {
                    row.parent().remove();
                }


                var newRow = `<tr>

                    <td>${table.find('tr').length +1}</td>
                    <td><input type="file" name="attachment[]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove_attachment"><i class="bi bi-trash"></i></button></td>
                    </tr>`;

                table.append(newRow);

            })
            $(document).on('click', '.remove_attachment', function() {
                var row = $(this).closest('tr');
                row.remove();

                var table = $('.attachment_table tbody');
                if (table.find('tr').length === 0) {
                    var noDataRow = `<tr><td colspan="3">لايوجد بيانات</td></tr>`;
                    table.append(noDataRow);
                } else {
                    table.find('tr').each(function(index) {
                        $(this).find('td:first-child').text(index + 1);
                    });
                }
            });
        });
    </script>
@endsection
