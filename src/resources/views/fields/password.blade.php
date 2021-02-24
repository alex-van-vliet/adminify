@php
$error = $errors->first($accessor) ?: null;
@endphp
<div class="form-group">
    <label for="{{ $accessor }}">{{ $name }}</label>
    <input type="password"
           name="{{ $accessor }}"
           class="form-control {{ $error ? 'is-invalid' : '' }}"
           id="{{ $accessor }}"
           {{ $error ? "aria-describedby=\"{$accessor}-error\"" : '' }}/>
    @if($error)
        <span id="{{ $accessor }}-error" class="error invalid-feedback">{{ $error }}</span>
    @endif
</div>
<div class="form-group">
    <label for="{{ $accessor }}_confirmation">{{ $name }} Confirmation</label>
    <input type="password"
           name="{{ $accessor }}_confirmation"
           class="form-control"
           id="{{ $accessor }}_confirmation"/>
</div>
