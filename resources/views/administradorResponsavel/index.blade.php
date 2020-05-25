@extends('layouts.app')

@section('content')

<div class="container">

  	<h2 style="margin-top: 100px; ">{{ Auth()->user()->name }}</h2>

</div>

@endsection
