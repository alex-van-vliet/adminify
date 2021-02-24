@php
$default = old($accessor);
$error = $errors->first($accessor) ?: null;
$referenced = $field->getReferenced();
@endphp
<div class="form-group">
    <label for="{{ $accessor }}">{{ $name }}</label>
    <select
            class="form-control select2bs4  {{ $error ? 'is-invalid' : '' }}"
            style="width: 100%;"
            name="{{ $accessor }}"
            id="{{ $accessor }}"
            {{ $error ? "aria-describedby=\"{$accessor}-error\"" : '' }}>
        @foreach($referenced as $value)
            <option value="{{ $value->getKey() }}" {{ $value->getKey() == $default ? 'selected' : '' }}>
                {{ $value }} ({{ $value->getKey() }})
            </option>
        @endforeach
    </select>
    @if($error)
        <span id="{{ $accessor }}-error" class="error invalid-feedback">{{ $error }}</span>
    @endif
</div>
