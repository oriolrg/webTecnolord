@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Examen</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="app">
                        <examen-component></examen-component>
                    </div>
                    <div class="col-md-7">
                        <posts></posts>
    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
