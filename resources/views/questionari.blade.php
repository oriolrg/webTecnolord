@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Questionari {{$tema}}
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($preguntes as $key => $pregunta)
                        <div id="{{$pregunta->id}}">
                            <h4>{{$pregunta->questiontext}}</h4><br>
                            @foreach($pregunta->respostes as $key => $resposta)
                                <input type="radio" name="{{$resposta->question}}" value="{{$resposta->fraction}}"> <span>{{$resposta->answer}}</span><br>
                            @endforeach
                            <br>
                        </div>
                        <form method="get" action="{{url('edit')}}/{{$pregunta->id}}">
                            <button type="submit">Editar</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
