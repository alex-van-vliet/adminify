@php
$default = old($accessor);
@endphp
<div class="form-group">
    <label for="{{ $accessor }}">{{ $name }}</label>
    <input type="text" name="{{ $accessor }}" class="form-control" id="{{ $accessor }}" value="{{ $default }}">
</div>
