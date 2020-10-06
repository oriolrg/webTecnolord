<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        <!--[if IE]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->
       
       
        @include('layouts.preloader');
        
        @include('layouts.headernavbar');
    
        <section class="">
            <div class="container">
                <div class="row">
                    <div class="col-lg-">
                        
                    </div>
                </div>
            </div>
        </section>
        
        @include('layouts.footer');
        
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

        @include('layouts.llibreries');
    
    </body>
    
    </html>