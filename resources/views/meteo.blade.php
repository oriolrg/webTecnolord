<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
        <div id="app">
        @include('layouts.preloader');
        
        @include('layouts.headernavbar');

        <meteo-app></meteo-app>
    
        @include('layouts.footer');
        <h2>Predicció de Pluja</h2>
<button onclick="ferPrediccio()">Fer Predicció</button>
<p id="prediccio">Esperant predicció...</p>
<script>
    async function ferPrediccio() {
        // Dades d'exemple (en un futur es poden agafar en temps real)
        const dades = {
            temperatura: 8.2,   // Graus Celsius
            humitat: 3,       // Percentatge
            pressio: 1004,     // hPa
            vent: 0            // km/h
        };

        // Fem una petició a Laravel perquè obtingui la predicció
        const resposta = await fetch('/api/predir-pluja', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dades)
        });

        // Convertim la resposta a JSON
        const resultat = await resposta.json();

        // Actualitzem la interfície amb la probabilitat de pluja
        document.getElementById('prediccio').innerText =
            `Probabilitat de pluja: ${resultat.probabilitat_pluja}%`;
    }
</script>
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