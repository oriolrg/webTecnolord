<!--====== SERVICES PART START ======-->
    
<section id="meteo" class="services_area pt-115 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h5 class="sub_title">@lang('meteo.Dades Meteo ')</h5>
                <h4 class="main_title">@lang('meteo.Sant Llorenç de Morunys ')</h4>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="pricing_menu mt-30 pb-30">
            <ul class="nav justify-content-center" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="active" id="yearly-tab" data-toggle="tab" href="#actual" role="tab" aria-controls="yearly" aria-selected="false">@lang('meteo.Actual')</a>
                </li>
                <li class="nav-item">
                    <a id="yearly-tab" data-toggle="tab" href="#diaria" role="tab" aria-controls="yearly" aria-selected="false">@lang('meteo.Diaria')</a>
                </li>
                <li class="nav-item">
                    <a id="yearly-tab" data-toggle="tab" href="#mensual" role="tab" aria-controls="yearly" aria-selected="false">@lang('meteo.Mensual')</a>
                </li>
                <li class="nav-item">
                    <a id="yearly-tab" data-toggle="tab" href="#anual" role="tab" aria-controls="yearly" aria-selected="false">@lang('meteo.Anual')</a>
                </li>
                <!--<li class="nav-item">
                    <a id="yearly-tab" data-toggle="tab" href="#anual" role="tab" aria-controls="yearly" aria-selected="false">@lang('meteo.Anual')</a>
                </li>-->
            </ul>
        </div>
        <div class="pricing_content_area">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="actual" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title">@lang('meteo.Dades Actuals ')</h5>
                                <h5 class="sub_title">{{$dataActual}}</h5>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                    @include('public.meteo.meteoactual');
                </div>
                <div class="tab-pane fade" id="diaria" role="tabpanel" aria-labelledby="yearly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title">@lang('meteo.Dades Diaries ')</h5>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                    @include('public.meteo.meteodiaria')

                    <meteo-diaria-component></meteo-diaria-component>
                </div>
                <div class="tab-pane fade" id="mensual" role="tabpanel" aria-labelledby="yearly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title">@lang('meteo.Dades Mensuals ')</h5>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                </div>
                <div class="tab-pane" id="anual" role="tabpanel" aria-labelledby="yearly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title">@lang('meteo.Dades Anuals ')</h5>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                    <meteo-anual-component></meteo-anual-component>
                </div>
            </div>
        </div>
        <div class="row">
            
        </div> <!-- row -->
    </div> <!-- container -->
    
    
</section>

<!--====== SERVICES PART ENDS ======-->