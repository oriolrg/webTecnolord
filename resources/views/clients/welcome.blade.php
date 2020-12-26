<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        @include('layouts.preloader');
        
        @include('clients.layouts.headernavbar');
        <div class="about_area pt-70 ">
            <!-- Page Content -->
            <div id="page-content-wrapper">
        
              <div class="container-fluid">
                <h1 class="mt-4">Area Client</h1>
                <p>Des d'aquí podràs consultar l'estat dels teu productes/projectes, com el desglossat del mateix en diferents històries d'Usuari.</p>
                <ul>
                  <li class="list-group-item"><p>Des de la pestanya <code>Projectes</code> pots consultar l'estat dels que hem realitzat per tu.</p></li>
                  <li class="list-group-item"><p>Des de la pestanya <code>Histories d'Usuari</code> registraràs el format del teu projecte, desglossat en petits problemes, per tal que així el desenvolupament sigui mes clar i àgil. Al mateix temps podràs consultar l'estat de desenvolupament, veient la quantitat d'Histries ja desenvolupades</p></li>
                  <li class="list-group-item"><p>Des de la pestanya <code>Incidències</code> pots Crear incidències que vagis detectant, pels diferents projectes i veure'n l'estat de les mateixes.</p></li>
                </ul>
                <ul>
                  <li class="list-group-item">
                    <h3 class="mt-4">Histories d'Usuari</h3>
                    <p>Des d'aquí podràs consultar l'estat dels teu productes/projectes, com el desglossat del mateix en diferents històries d'Usuari.</p>
                    <p>Des de la pestanya <code>Projectes</code> pots consultar l'estat dels que hem realitzat per tu.</p>
                  </li>
                  <li class="list-group-item">
                    <h3 class="mt-4">Incidències</h3>
                    <p>Des d'aquí podràs consultar l'estat dels teu productes/projectes, com el desglossat del mateix en diferents històries d'Usuari.</p>
                    <p>Des de la pestanya <code>Projectes</code> pots consultar l'estat dels que hem realitzat per tu.</p>
                  </li>
                </ul>
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