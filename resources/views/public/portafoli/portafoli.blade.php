<!--====== BLOG PART START ======-->
<section id="portafoli" class="blog_area pt-115">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-25">
                    <h5 class="sub_title">@lang('serveis.Portafoli')</h5>
                    <h4 class="main_title">@lang('serveis.Projectes TecnoLord')</h4>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row justify-content-center">
            @include('public.portafoli.autocaravanes')
            @include('public.portafoli.controlAcces')
            @include('public.portafoli.restauracioVall')
            @include('public.portafoli.gerardriugd')
            @include('public.portafoli.mercalord')
            @include('public.portafoli.porterautomatic')
            @include('public.portafoli.estacioMeteo')
            @include('public.portafoli.tecnolord')
            @include('public.portafoli.zoopirineu')
            @include('public.portafoli.portdelcomte')
            @include('public.portafoli.inhospit')
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== BLOG PART ENDS ======-->