<section class="header_area">
    <div class="header_navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="/">
                            <h2 class="hero_title wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">{{ config('app.name', 'Laravel') }}</h2>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a href="{{url('/administra/clients')}}" >Clients</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/administra/projectes')}}" >Projectes</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/administra/histories_usuari')}}" >Histories d'usuari</a>
                                </li>
                                <li class="nav-item">
                                    <!--<a href="{{url('/administra/sprints')}}" >Sprints</a>-->
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('/administra/bugs')}}" >Bugs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="page-scroll" href="{{url('/administra/projectes_publicats')}}" >Projectes Publicats</a>
                                </li>
                                <li class="nav-item">
                                    <a class="page-scroll" href="/">Inici</a>
                                </li>
                                @include('layouts.user')
                            </ul>
                        </div> <!-- navbar collapse -->
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- header navbar -->
