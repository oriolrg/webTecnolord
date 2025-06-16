@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Pregunta 
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="guardar">
                        {{ csrf_field() }}
                            <div id=""><input type="hidden" name="id" value="">
                                <h4>Pregunta<input type="text" name="textPregunta" value="" size="50%"></h4><br>
                                <h4>Categoria
                                    <select name="textCategoria" id="">
                                        @foreach ($categories as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                                        @endforeach
                                    </select>
                                </h4><br>
                                <select name="puntuacio[]" id="">
                                    <option value="0.0000000">0.0000000</option>
                                    <option value="1.0000000">1.0000000</option>
                                </select>
                                <input name="resposta[]" value="" size="50%"><br>
                                <select name="puntuacio[]" id="">
                                    <option value="0.0000000">0.0000000</option>
                                    <option value="1.0000000">1.0000000</option>
                                </select>
                                <input name="resposta[]" value="" size="50%"><br>
                                <select name="puntuacio[]" id="">
                                    <option value="0.0000000">0.0000000</option>
                                    <option value="1.0000000">1.0000000</option>
                                </select>
                                <input name="resposta[]" value="" size="50%"><br>
                                <select name="puntuacio[]" id="">
                                    <option value="0.0000000">0.0000000</option>
                                    <option value="1.0000000">1.0000000</option>    
                                </select>
                                <input name="resposta[]" value="" size="50%"><br>    
                                <br>
                            </div>
                                <button type="submit">Guardar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
