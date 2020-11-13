
<div class="row justify-content-center">
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow" data-wow-duration="0.5s" data-wow-delay="0.5s">
            
            <h3 class="services_title">@lang('meteo.Temperatura.')</h3>
            <div class="services_icon">
                <i class="">{{$temperatura}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Temperatura de sensació')</h3>
            <div class="services_icon">
                <i class="">{{$temperaturaSensacio}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Precipitacó')</h3>
            <div class="services_icon">
                <i class="">{{$precipRate}}mm/hr</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Precipitacó total')</h3>
            <div class="services_icon">
                <i class="">{{$precipTotal}}mm</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Humitat')</h3>
            <div class="services_icon">
                <i class="">{{$humitat}}%</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Punt de Rosada')</h3>
            <div class="services_icon">
                <i class="">{{$punt_rosada}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow " data-wow-duration="0.5s" data-wow-delay="0.5s">
            <h3 class="services_title">@lang('meteo.Llum')</h3>
            <div class="services_icon">
                <i class="">{{$radSolar}}Kfc</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="120" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Radiació solar')</h3>
            <div class="services_icon">
                <i class="">{{$uv}}</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow " data-wow-duration="0.5s" data-wow-delay="1.5s">
            <h3 class="services_title">@lang('meteo.Velocitat del Vent')</h3>
            <div class="services_icon">
                <i class="">{{$velVent}}m/s</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Ràfega de vent:')</h3>
            <div class="services_icon">
                <i class="">{{$rafegaVent}}m/s</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Direcció del Vent')</h3>

            <h4>{{$dirVent}}º</h4>
            <div class="services_icon">
                <i class="">
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
                </i>

                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="50" cy="50" rx="50" ry="50" />
                </svg>
                <br>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active wow " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Pressió')</h3>
            <div class="services_icon">
                <i class="">{{$pressio}}mb</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="140" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
</div> <!-- row -->