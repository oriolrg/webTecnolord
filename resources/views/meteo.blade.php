<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        <div id="app">
        @include('layouts.preloader');
        
        @include('layouts.headernavbar');

        <meteo-app></meteo-app>
    
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
        @include('layouts.llibreries');
    
    </body>
    
    </html>