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
            @foreach ($projectes as $projecte)
                <div class="col-lg-4 col-md-7">
                    <div class="single_blog mt-30 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.3s">
                        <div class="blog_image">
                            <img src="assets/images/blog-1.jpg" alt="{{$projecte->name}}">
                        </div>
                        <div class="blog_content">
                            <ul class="blog_meta d-flex justify-content-between">
                                <li>{{$projecte->tipologia}}</li>
                                <li>{{$projecte->data_finalitzacio}}</li>
                            </ul>
                            <h3 class="blog_title"><a href="#">{{$projecte->name}}</a></h3>
                            <a href="#" class="more">Read More</a>
                        </div>
                    </div> <!-- row -->
                </div>
            @endforeach

            <div class="col-lg-4 col-md-7">
                <div class="single_blog mt-30 wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.6s">
                    <div class="blog_image">
                        <img src="assets/images/blog-2.jpg" alt="blog">
                    </div>
                    <div class="blog_content">
                        <ul class="blog_meta d-flex justify-content-between">
                            <li>By: <a href="#">Musharof Chowdury</a></li>
                            <li>15 June 2024</li>
                        </ul>
                        <h3 class="blog_title"><a href="#">Improving products depending on feedback</a></h3>
                        <a href="#" class="more">Read More</a>
                    </div>
                </div> <!-- row -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== BLOG PART ENDS ======-->