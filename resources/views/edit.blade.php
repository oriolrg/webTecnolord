@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pregunta @isset($data->id){{$data->id}}@endisset
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="guardar">
                        {{ csrf_field() }}
                            <div id="@isset($data->id){{$data->id}}@endisset"><input type="hidden" name="id" value="@isset($data->id){{$data->id}}@endisset">
                                <h4><input type="text" name="textPregunta" value="{{$data->questiontext}}" size="50%"></h4><br>
                                @foreach($data->respostes as $key => $resposta)
                                <select name="puntuacio[{{$resposta->id}}]" id="">
                                    <option value="0.0000000" @if($resposta->fraction == 0.0000000) selected @endif>0.0000000</option>
                                    <option value="1.0000000" @if($resposta->fraction == 1.0000000) selected @endif>1.0000000</option>
                                </select>
                                    <input name="resposta[{{$resposta->id}}]" value="{{$resposta->answer}}" size="50%"><br>
                                @endforeach
                                <br>
                            </div>
                                <button type="submit">Guardar</button>
                        </form>
                    <form method="POST" action="eliminar/@isset($data->id){{$data->id}}@endisset">
                        <input type="hidden" name="_method" value="DELETE">
                        {{ csrf_field() }}
                        <button type="submit"class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
