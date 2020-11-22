<section class="header_area">
    <div class="header_navbar">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">
                <img class="logo" data-wow-duration="2s" data-wow-delay="0.4s" src="assets/images/tecnolord.png" alt="Contacte">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
                <span class="toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                <ul id="nav" class="languages ml-auto  navbar-nav inline  my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="" href="#inici">@lang('headernavbar.Inici')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#estrategia">@lang('headernavbar.Estrategia')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#services">@lang('headernavbar.Serveis')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#portafoli">@lang('headernavbar.Portafoli')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#meteo">@lang('Meteo')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#curriculum">@lang('headernavbar.Curriculum')</a>
                    </li>
                    <li class="nav-item">
                        <a class="" href="#contact">@lang('headernavbar.Contacte')</a>
                    </li>
                    <li class="nav-item"><a class="" href="{{ asset('idioma/ca') }}">CA</a></li>
                    <li class="nav-item"><a class="" href="{{ asset('idioma/en') }}">EN</a></li>
                    <li class="nav-item"><a class="" href="{{ asset('idioma/es') }}">ES</a></li>
                </ul>
                <ul class="navbar-nav ml-auto inline my-2 my-lg-0">
                    @include('layouts.user')
                </ul>
            </div> <!-- navbar collapse -->
        </nav> <!-- navbar -->
    </div> <!-- container -->
</section> <!-- header navbar -->
