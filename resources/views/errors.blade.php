@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Errors comesos:                    
                </div>

                <div class="panel-body">
                    <a href="{{ url('/errors/imprimir') }}">
                        <span class="glyphicon glyphicon-name"></span>
                        Imprimir Errors
                    </a> 
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Categories</h3>
                    @foreach($categories as $key => $categoria)
                        <ul>
                            <li>
                                {{$categoria->name}}
                            </li>
                        </ul>
                    @endforeach
                    <h3>Preguntes</h3>
                    @php ($repeat = '')
                    @foreach($preguntes as $key => $pregunta)
                        
                        @if ($repeat != $pregunta[1])
                            @php ($repeat = $pregunta[1])
                            <h2>{{$pregunta[1]}}</h2>
                        @endif
                        
                        <dl>
                            <dt> {{$pregunta[0]}}
                                
                                    <dd><ul><li>{{$pregunta[2]->answer}}</li></ul></dd>
                                
                            </dt>
                        </dl>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
