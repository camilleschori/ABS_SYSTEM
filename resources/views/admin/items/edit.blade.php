@section('title', 'تعديل مادة')

@extends('admin.layout')

@section('content')

    <div id="app">
        <x-sidebar />

        <div id="main" class="vh-100 overflow-auto">
            <x-breadcrumb sub1="المواد" sub1url="{{ route('admin.items.index') }}" sub2="تعديل مادة" />
            <div class="card p-5">


                <x-form action="{{ route('admin.items.update', $item->id) }}" :back="$back" method="PUT">

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
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="views-tab" data-bs-toggle="tab" data-bs-target="#views"
                                    type="button" role="tab" aria-controls="views"
                                    aria-selected="false">المشاهدات</button>
                            </li>
                        </ul>

                        <button type="button" class="btn btn-primary add_attachment">إضافة صورة</button>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                @php
                                    $values = $item->toArray();
                                    $values['item_categories'] = $item->categories->pluck('id')->toArray();
                                    $formFields = \App\Models\Item::Form($values);
                                @endphp

                                @foreach ($formFields as $field)
                                    <x-form-input :type="$field['type']" :name="$field['name']" :label="$field['label']" :class="$field['class']"
                                        :value="$field['value']" :options="$field['options'] ?? []" :multiple="$field['multiple'] ?? false" :readonly="$field['readonly'] ?? false"
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
                                        @forelse($item->attachments as $attachment)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    <a class="btn btn-primary"
                                                        href="{{ url('my_files/public/uploads/items/' . $attachment->type . '/' . $attachment->name) }}"
                                                        target="_blank">عرض</a>
                                                    <input type="hidden" name="existing_attachments[]"
                                                        value="{{ $attachment->id }}">
                                                </td>
                                                <td><button type="button" class="btn btn-danger remove_attachment"><i
                                                            class="bi bi-trash"></i></button></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">لايوجد بيانات</td>
                                            </tr>
                                        @endforelse
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
                                                        name="price_groups[{{ $price_group->id }}]"
                                                        value="{{ $item->prices->firstWhere('price_group_id', $price_group->id)->price ?? 0 }}">
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
                        <div class="tab-pane fade" id="views" role="tabpanel" aria-labelledby="views-tab">
                            <div class="table-responsive overflow-auto">
                                <table class="table table-hover text-center table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th scope="col">اسم المستخدم</th>
                                            <th scope="col">عدد المشاهدات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($item->views as $view)
                                            <tr>
                                                <td>{{ $view->user->name }}</td>
                                                <td>
                                                    {{ $view->view_count }}
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
            $(document).on('change', 'select[name="brand_id"]', function() {
                value = $(this).val();

                LastChildCode = fetchLastChildCode();


                $(document).find('input[name="code"]').val(LastChildCode);
            });

            function fetchLastChildCode() {
                let value;
                $.ajax({
                    url: '{{ route('admin.items.getLastChildCode') }}',
                    type: 'POST',
                    data: {
                        brand_id: brandSelect.val(),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        value = data.new_code;
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching last child code:', error);
                    }
                });
                return value;
            }

            $(document).on('click', '.add_attachment', function() {
                var table = $('.attachment_table tbody');
                var row = $('.attachment_table tbody tr:first-child td');

                if (row.length === 1 && row.attr('colspan') === '4') {
                    row.parent().remove();
                }

                var newRow = `<tr>
                <td>${table.find('tr').length + 1}</td>

                <td><input type="file" name="attachment[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger remove_attachment"><i class="bi bi-trash"></i></button></td>
                </tr>`;

                table.append(newRow);
            });

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
