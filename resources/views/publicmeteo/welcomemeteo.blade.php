<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        <!--[if IE]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->
      <!-- API https://api.weather.com/v2/pws/history/all?stationId=ISANTL9&format=json&units=h&date=20201110&apiKey=979bf738d55144929bf738d551f49248 -->
       
       
      <div id="app">
        @include('layouts.preloader');
        
        @include('publicmeteo.layouts.headernavbar');
    
        @include('public.meteo.meteo')

        @include('public.webcams')
    
        @include('public.contacte')
    
        @include('layouts.footer');
    
        <!--====== FOOTER PART ENDS ======-->
        
        <!--====== BACK TOP TOP PART START ======-->
    
        <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>
    
        <!--====== BACK TOP TOP PART ENDS ======-->    
    
        <!--====== PART START ======-->
    
    <!--
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-">
                        
                    </div>
                </div>
            </div>
        </section>
    -->
    
        <!--====== PART ENDS ======-->
      </div>
        @include('layouts.llibreries')
    </body>
    
    </html>