@php
$default = old($accessor, ($object ?? null)?->{$accessor});
$error = $errors->first($accessor) ?: null;
@endphp
<div class="form-group">
    <label for="{{ $accessor }}">{{ $name }}</label>
    <input type="text"
           name="{{ $accessor }}"
           class="form-control {{ $error ? 'is-invalid' : '' }}"
           id="{{ $accessor }}"
           value="{{ $default }}"
           {{ $error ? "aria-describedby=\"{$accessor}-error\"" : '' }}/>
    @if($error)
        <span id="{{ $accessor }}-error" class="error invalid-feedback">{{ $error }}</span>
    @endif
</div>
