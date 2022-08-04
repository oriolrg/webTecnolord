<!--====== SERVICES PART START ======-->
@if($value != null)
<section id="meteo" class="services_area">
    <div class="container">
        <div class="pricing_content_area">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="actual" role="tabpanel" aria-labelledby="monthly-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="section_title text-center pb-25">
                                <h5 class="sub_title" style="font-size: 6rem;">{{$dataActual}}</h5>
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