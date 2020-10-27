<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        @include('layouts.preloader');
        
        @include('administra.layouts.headernavbar');
        <div class="d-flex" id="wrapper">

            @include('administra.layouts.leftMenu')
        
            <!-- Page Content -->
            <div id="page-content-wrapper">
        
              <div class="container-fluid">
                <h1 class="mt-4">Area administra</h1>
                <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
              </div>
            </div>
            <!-- /#page-content-wrapper -->
        
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