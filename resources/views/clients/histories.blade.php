<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <body>
        @include('layouts.preloader');
        
        @include('clients.layouts.headernavbar');
        <div class="about_area pt-70 ">
            <div id="app">
              <client-histories-component></administra-histories-component>
            </div>
        
          </div>
          <!-- /#wrapper -->
          <!-- Menu Toggle Script -->
          <script>
            $("#menu-toggle").click(function(e) {
              e.preventDefault();
              $("#wrapper").toggleClass("toggled");
            });
          </script>
        
        <!--====== BACK TOP TOP PART START ======-->
    
        <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

        @include('layouts.llibreries');
    
    </body>
    
    </html>