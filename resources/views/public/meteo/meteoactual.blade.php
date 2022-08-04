<img src="assets/images/tecnolord.png" alt="Contacte" class="logo" style="width:100%">
<div>
<div class="row justify-content-center">
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.1s" data-wow-delay="0.1s">
            <div class="services_icon">
                <h3 class="services_title" style="color: white;">@lang('meteo.Temperatura.')</h3>
            
                <h2 class="dades" style="color: white;">{{$temperatura}}º</h2>
            </div>
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Temperatura de sensació')</h3>
                <h2 class="dades" style="color: white;">{{$temperaturaSensacio}}º</h2>
            </div>
        </div> <!-- single services -->
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.5s" data-wow-delay="1s">
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Precipitacó')</h3>
                <h2 class="dades" style="color: white;">{{$precipRate}}mm/hr</h2>
            </div>
            <div class="services_icon">

                <h3 class="services_title"  style="color: white;">@lang('meteo.Precipitacó total')</h3>
                <h2 class="dades" style="color: white;">{{$precipTotal}}mm</h2>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.5s" data-wow-delay="1s">
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Humitat')</h3>
                <h2 class="dades" style="color: white;">{{$humitat}}%</h2>
            </div>
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Punt de Rosada')</h3>
                <h2 class="dades" style="color: white;">{{$punt_rosada}}º</h2>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.5s" data-wow-delay="0.5s">
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Llum')</h3>
                <h2 class="dades" style="color: white;">{{$radSolar}}Kfc</h2>
            </div>
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Radiació solar')</h3>
                <h2 class="dades" style="color: white;">{{$uv}}</h2>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.5s" data-wow-delay="1.5s">
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Velocitat del Vent')</h3>
                <h2 class="dades" style="color: white;">{{$velVent}}m/s</h2>
            </div>
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Ràfega de vent:')</h3>
                <h2 class="dades" style="color: white;">{{$rafegaVent}}m/s</h2>
            </div>
            
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75);" data-wow-duration="0.5s" data-wow-delay="1s">
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Pressió')</h3>
                <h2 class="dades" style="color: white;">{{$pressio}}mb</h2>
            </div>
            
            <div class="services_icon">
                <h3 class="services_title"  style="color: white;">@lang('meteo.Direcció del Vent')</h3>
                <h2 class="dades" style="color: white;">{{$dirVent}}º
                    @if ($dirVent > 330 && $dirVent < 360 || $dirVent > 0 && $dirVent < 30)
                        N
                    @elseif ($dirVent > 60 && $dirVent <120)
                        E
                    @elseif ($dirVent > 150 && $dirVent <210)
                        S
                    @elseif ($dirVent > 240 && $dirVent <300)
                        O
                    @elseif ($dirVent >= 300 && $dirVent <= 330)
                        NO
                    @elseif ($dirVent >= 30 && $dirVent <= 60)
                        NE
                    @elseif ($dirVent >= 120 && $dirVent <= 150)
                        SE
                    @elseif ($dirVent >= 210 && $dirVent <= 240)
                        SO
                    @endif
                </h2>

                <br>
            </div>
        </div> <!-- single services -->
    </div>

    <div class="col-lg-12 col-sm-12">
        <div class="single_services text-center mt-30 active  " style="background-color:rgba(0, 0, 0, 0.75); padding:25px 0px !important" data-wow-duration="0.5s" data-wow-delay="1.5s">
            
            <div class="services_icon single_services active"  style="padding:25px 0px !important">
                <h3 class="services_title"  style="color: white;">Guixers (Aigua de Valls)</h3>
                <h2 class="dades" style="color: white;">{{$cabalValls}}m³/s</h2>
            </div>
            
            <div class="services_icon single_services active" style="padding:25px 0px !important">
                <h3 class="services_title"  style="color: white;">Cardener (Monegal)</h3>
                <h2 class="dades" style="color: white;">{{$cabalCardener}}m³/s</h2>
            </div>
            
            <div class="services_icon single_services active" style="padding:25px 0px !important">
                <h3 class="services_title"  style="color: white;">Sortida Llosa del cavall</h3>
                <h2 class="dades" style="color: white;">{{$cabalLlosa}}m³/s</h2>
            </div>
            
            <div class="services_icon single_services active" style="padding:25px 0px !important">
                <h3 class="services_title"  style="color: white;">Nivell Llosa del cavall</h3>
                <h2 class="dades" style="color: white;">{{$capacitatLlosa}}%</h2>
            </div>
            
        </div> <!-- single services -->
    </div>
</div> <!-- row -->