@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Definicions:                    
                </div>
                <div class="panel-body">
                    <a href="{{ url('/errors/imprimir') }}">
                        <span class="glyphicon glyphicon-name"></span>
                        Imprimir Definicions
                    </a> 
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <ul>
                @foreach ($definicions as $definicio)
                        <li id="{{$definicio->paraula}}"><strong>{{$definicio->paraula}}:</strong></li>
                        <li style="list-style-type:none;">{{$definicio->definicio}}.</li>
                        <br><li style="list-style-type:none;">@foreach($categories as $categoria) @if($definicio->categoria == $categoria->id){{$categoria->name}} @endif @endforeach.</li>
                        <form method="get" action="{{url('definicio/edit')}}/{{$definicio->id}}">
                            <button type="submit">Editar</button>
                        </form>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
