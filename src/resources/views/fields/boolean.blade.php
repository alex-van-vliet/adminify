@php
$default = old($accessor, ($object ?? null)?->{$accessor});
$error =  $errors->first($accessor) ?: null;
@endphp
<div class="form-check">
    <input type="checkbox"
           name="{{ $accessor }}"
           class="form-check-input {{ $error ? 'is-invalid' : '' }}"
           id="{{ $accessor }}"
           value="1"
           {{ $default ? 'checked' : '' }}/>
    <label class="form-check-label" for="{{ $accessor }}">{{ $name }}</label>
    @if($error)
        <span id="{{ $accessor }}-error" class="error invalid-feedback">{{ $error }}</span>
    @endif
</div>
