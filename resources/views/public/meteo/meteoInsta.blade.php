<!--====== SERVICES PART START ======-->
@if($value != null)
<section id="meteo" class="services_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h5 class="sub_title">@lang('meteo.Dades Meteo ')</h5>
                <h4 class="main_title">@lang('meteo.Sant Llorenç de Morunys ')</h4>
                </div> <!-- section title -->
            </div>
        </div> 
        <div class="pricing_content_area">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="actual" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title">{{$dataActual}}</h5>
                            </div> <!-- section title -->
                        </div>
                    </div> <!-- row -->
                    @include('public.meteo.meteoactual')
                </div>
            </div>
        </div>
        <div class="row">
            
        </div> <!-- row -->
    </div> <!-- container -->
    
    
</section>
@endif
<!--====== SERVICES PART ENDS ======-->