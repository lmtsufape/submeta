@php
  $class = $class ?? " ";
  $obrigatorio = $obrigatorio ?? " ";
@endphp
<div class="form-group">
  <label class=" control-label {{ $class }}" for="firstname">{{ $label }} @if($obrigatorio)  <span style="color: red; font-weight:bold">*</span> @endif</label>
  <div class="">
    {{ $slot }}
  </div>
</div>
