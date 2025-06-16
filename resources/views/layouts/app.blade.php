<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app2.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('testsOpos/preguntes') }}">
                        Questionaris
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <ul class="nav navbar-nav navbar-center">
                        <li><a href="{{url('testsOpos/errors')}}">Consulta Errors</a></li>
                        <li><a href="{{url('testsOpos/definicio')}}">Consulta Definicions</a></li>
                        <li>
                            <a href="{{url('testsOpos/preguntes/crearpregunta/')}}">Crear Pregunta </a>
                        </li>
                        <li>
                            <a href="{{url('testsOpos/definicio/creardefinicio/')}}">Crear Definició </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                Escull Tema <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @isset($categories)
                                    @foreach($categories as $key => $categoria)
                                        <li>
                                            <a href="{{ url('testsOpos/preguntes/'.$categoria->id.'/'.$categoria->name) }}">Tema {{$categoria->name}}</a>
                                        </li>
                                    @endforeach
                                    <li>
                                        <a href="{{ url('testsOpos/preguntes/preguntesfallades/') }}">Tema Preguntes fallades</a>
                                    </li>
                                @endisset
                            </ul>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        	
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}"></script>
</body>
</html>
