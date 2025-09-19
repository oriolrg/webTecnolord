<head>
    <meta charset="utf-8">

    <!--====== Title ======-->
    <title>MeteoLord</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="TecnoLord, empresa de la Vall de Lord de serveis informàtics: servei tècnic, xarxes, programació i disseny web. Solucions Informàtiques i noves Tecnologies per a empreses, entitats i particulars.">
    <meta name="author" content="TecnoLord: Oriol Riu Gispert">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?" defer></script>

    <!--grafigs-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>
    
    <link rel="manifest" href="/assets/meteo/manifest.webmanifest">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/meteo/icons/icon-192.png">
    <link rel="icon" href="/assets/meteo/icons/icon-192.png" type="image/png" />
    <link rel="apple-touch-icon" href="/assets/meteo/icons/icon-512.png" />


    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png">

    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">


    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{ asset('assets/fonts/lineicons/font-css/LineIcons.css') }}">

    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

   <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

</head>
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/assets/meteo/sw.js', { scope: '/meteo/' })
    .catch(console.error);
}
</script>
