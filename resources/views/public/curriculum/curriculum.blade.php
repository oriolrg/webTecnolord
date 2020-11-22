
<!--====== especialitats PLAN PART START ======-->

<section id="curriculum" class="pricing_area pt-115 pb-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h5 class="sub_title">Oriol Riu Gispert</h5>
                    <h4 class="main_title">@lang('curriculum.Enginyer Informatic')</h4>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="pricing_menu mt-30 pb-30">
                    <ul class="nav justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="active" id="monthly-tab" data-toggle="tab" href="#informatica" role="tab" aria-controls="monthly" aria-selected="true">@lang('curriculum.Informàtica')</a>
                        </li>
                        <li class="nav-item">
                            <a id="yearly-tab" data-toggle="tab" href="#habilitats" role="tab" aria-controls="yearly" aria-selected="false">@lang('curriculum.Habilitats')</a>
                        </li>
                        <li class="nav-item">
                            <a id="yearly-tab" data-toggle="tab" href="#coneixements" role="tab" aria-controls="yearly" aria-selected="false">@lang('curriculum.Formacions')</a>
                        </li>
                    </ul>
                </div> <!-- pricing menu -->
                <!---->
                <div class="pricing_content_area">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="informatica" role="tabpanel" aria-labelledby="monthly-tab">
                            <div class="row justify-content-center">
                                @include('public.curriculum.currInformatica')
                            </div> <!-- row -->
                        </div>
                        <div class="tab-pane fade" id="coneixements" role="tabpanel" aria-labelledby="yearly-tab">
                            <div class="row justify-content-center">
                                @include('public.curriculum.currFormacioVaria')
                            </div> <!-- row -->
                        </div>
                        <div class="tab-pane fade" id="habilitats" role="tabpanel" aria-labelledby="yearly-tab">
                            <div class="row justify-content-center">
                                @include('public.curriculum.currConeixements')
                            </div> <!-- row -->
                        </div>
                    </div>
                </div> <!-- pricing menu -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== PRICING PLAN PART ENDS ======-->
