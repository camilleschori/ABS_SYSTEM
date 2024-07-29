<div class="{{ $class }} mb-4">

    @if ($type != 'hidden')
        <label class="mb-2" for="{{ $name }}">{{ $label }}</label>
    @endif

    @if ($type == 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror"
            {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }}>{{ old($name, $value) }}</textarea>
    @elseif($type == 'select')
        <select id="{{ $name }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            {{ $required ? 'required' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $multiple ? 'multiple' : '' }}
            class="form-select  @error($name) is-invalid @enderror">
            <option value="">--</option>
            @foreach ($options as $key => $option)
                @if ($multiple)
                    <option value="{{ $key }}"
                        {{ in_array($key, old($name, $value) ?? []) ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @else
                    <option value="{{ $key }}" {{ old($name, $value) == $key ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endif
            @endforeach
        </select>
    @elseif($type == 'hidden')
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            value="{{ old($name, $value) }}">
    @elseif ($type == 'number')
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" step="any"
            {{ $required ? 'required' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}
            value="{{ old($name, $value) }}" class="form-control @error($name) is-invalid @enderror">
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
            {{ $required ? 'required' : '' }} {{ $readonly ? 'readonly' : '' }} {{ $disabled ? 'disabled' : '' }}
            value="{{ old($name, $value) }}" class="form-control @error($name) is-invalid @enderror">
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

@if ($type == 'select')
    @push('scripts')
        <script>
            $(document).ready(function() {
                var $select = $(document).find('#{{ $name }}');
                var currentRoute = '{{ Route::currentRouteName() }}';
                // List of select elements to exclude
                // var excludeSelects = ['final_account_id', 'account_id', 'fund_acc_id',
                //     'settle_disc_acc_id', 'sell_disc_acc_id', 'comm_acc_id', 'broker_acc_id', 'ex_rate_diff_acc_id',
                //     'gift_acc_id', 'inc_acc_id', 'bank_acc_id',
                //     'settle_disc_acc_id'
                // ];

                // Check if the current select is not in the exclude list
                // List of select elements to exclude
                // var excludeSelects = ['final_account_id', 'account_id', 'fund_acc_id',
                //     'settle_disc_acc_id', 'sell_disc_acc_id', 'comm_acc_id', 'broker_acc_id', 'ex_rate_diff_acc_id',
                //     'gift_acc_id', 'inc_acc_id', 'bank_acc_id', 'settle_disc_acc_id'
                // ];

                // Include 'parent_id' if the route is 'durgstore.items.create' or 'durgstore.items.edit'
                // if (currentRoute === 'durgstore.items.create' || currentRoute === 'durgstore.items.edit') {
                //     excludeSelects.push('parent_id');
                // }

                var options = {
                    placeholder: "{{ $label }}",
                    allowClear: true
                };

                if ($select.closest('#printInvoiceModal').length) {
                    options.dropdownParent = $('#printInvoiceModal');
                    $('#invoice_columns').parent().css('display', 'grid');
                    $('#invoice_items_columns').parent().css('display', 'grid');
                }
                if ($select.closest('#filterModal').length) {
                    options.dropdownParent = $('#filterModal');
                }

                $select.select2(options);

            });
        </script>
    @endpush
@endif
