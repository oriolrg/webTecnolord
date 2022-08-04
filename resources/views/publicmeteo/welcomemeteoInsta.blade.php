<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        <!--[if IE]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->
      <!-- API https://api.weather.com/v2/pws/history/all?stationId=ISANTL9&format=json&units=h&date=20201110&apiKey=979bf738d55144929bf738d551f49248 -->
       
       
      <div id="app">
        
    
        @include('public.meteo.meteoInsta')
      </div>
        @include('layouts.llibreries')
        <style>
          .services_shape{
            fill: black !important;
          }
          .dades{
            font-size: 5rem;
            font-weight: bold;
          }
          .services_title{
            font-weight: bold;
            font-size: 2rem;
          }
          .sub_title{
            color: black !important;
            font-weight: bold !important;
          }
        </style>
    </body>
    
    </html>