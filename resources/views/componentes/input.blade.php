@php
  $class = $class ?? " ";
  // $obrigatorio = $obrigatorio ?? " ";
@endphp
<div class="form-group">
  <label class=" control-label {{ $class }}" for="firstname">{{  $label  }} <span style="color: red; font-weight:bold">*</span></label>
  {{ $slot }}
  <div class="">
    
  </div>
</div>
