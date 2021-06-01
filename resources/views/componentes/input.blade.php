@php
  $class = $class ?? " ";
@endphp
<div class="form-group">
  <label class=" control-label {{ $class }}" for="firstname">{{ $label }}<span style="color: red; font-weight:bold">*</span></label>
  <div class="col-sm-5">
    {{ $slot }}
  </div>
</div>
