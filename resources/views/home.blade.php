@extends('layouts.app')

@section('content')
<div class="container content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-primary" href="{{route('perfil')}}">Perfil</a>
                            <a class="btn btn-primary" href="{{route('coord.home')}}">Eventos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
