
<div class="row justify-content-center">
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active" data-wow-duration="0.5s" data-wow-delay="0.5s">
            <h3 class="services_title">@lang('meteo.Temperatura mitjana')</h3>
            <div class="services_icon">
                <i class="">{{round($dadesDiaries['Tmitjana'],2)}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="100" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Temperatura Màxima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['TMax']}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="100" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Temperatura Mínima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['TMin']}}º</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="100" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>

    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Precipitacó Acumulada')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['PTotal']}}mm</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Humitat Màxima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['HMax']}}%</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Humitat Mínima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['HMin']}}%</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " data-wow-duration="0.5s" data-wow-delay="1.5s">
            <h3 class="services_title">@lang('meteo.Velocitat del Vent Mitjana')</h3>
            <div class="services_icon">
                <i class="">{{round($dadesDiaries['VVentMitjana'],2)}}m/s</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="100" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Ràfega màxima de vent:')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['RafegaMaxima']}}m/s</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="80" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="single_services text-center mt-30 active  " data-wow-duration="0.5s" data-wow-delay="1s">
            <h3 class="services_title">@lang('meteo.Pressió Màxima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['PMax']}}mb</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="140" ry="50" />
                </svg>
            </div>
            <h3 class="services_title">@lang('meteo.Pressió Mínima')</h3>
            <div class="services_icon">
                <i class="">{{$dadesDiaries['PMin']}}mb</i>
                <svg xmlns="http://www.w3.org/2000/svg" width="300" height="100">
                    <ellipse class="services_shape" id="Polygon_12" data-name="Polygon 12" cx="150" cy="50" rx="140" ry="50" />
                </svg>
            </div>
        </div> <!-- single services -->
    </div>
</div> <!-- row -->