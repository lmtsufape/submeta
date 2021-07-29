@if($errors->any())
  <div class="alert alert-warning">
      @foreach ($errors->all() as $error)
        <p>{{$error}}</p>
      @endforeach
    </div>
@endif

@if(session('success'))
  <div class="alert alert-success" role="alert" align="center" style="position:absolute width:100%">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    {{session('success')}}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger"  role="alert" align="center" style="position:absolute width:100%">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    {{session('error')}}
  </div>
@endif
