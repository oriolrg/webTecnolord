@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Definició
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="guardar">
                        {{ csrf_field() }}
                            <div id=""><input type="hidden" name="id" value="@isset($editdefinicio->id){{$editdefinicio->id}}@endisset">
                            <h4>Paraula<input type="text" name="textParaula" value="@isset($editdefinicio->paraula){{$editdefinicio->paraula}}@endisset" size="50%"></h4><br>
                                <h4>Definició<textarea type="textbox" cols="40" rows="5" name="textDefinicio" size="50%">@isset($editdefinicio->definicio){{$editdefinicio->definicio}}@endisset</textarea></h4><br>
                                <h4>Categoria
                                    <select name="textCategoria" id="">
                                        @foreach ($categories as $categoria)
                                            <option value="{{$categoria->id}}" @isset($editdefinicio->categoria)@if($editdefinicio->categoria == $categoria->id) selected @endif @endisset>{{$categoria->name}}</option>
                                        @endforeach
                                    </select>
                                </h4><br>
                            </div>
                                <button type="submit">Guardar</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
