<!--====== CONTACT PART START ======-->
    
<section id="contact" class="contact_area pt-70 pb-120">
    <div class="contact_image d-flex align-items-center justify-content-end">
        <div class="image">
            <img class="wow fadeInLeftBig" data-wow-duration="2s" data-wow-delay="0.4s" src="assets/images/contact.svg" alt="Contacte">
        </div>
    </div> <!-- about image -->
    
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-6">
                <div class="contact_wrapper mt-45 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.9s">
                    <div class="section_title pb-15">
                        <h5 class="sub_title">@lang('contacte.Contacte')</h5>
                        <h4 class="main_title">@lang('contacte.Posar-se en contacte')</h4>
                        <p>@lang('contacte.Contacta amb TecnoLord amb el següent formulari i en breu ens posarem en contacte amb tu. Moltes gràcies.')</p>
                    </div> <!-- section title -->
                    
                    <div class="contact_form">
                        <form id="contact-form" action="assets/contact.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single_form">
                                        <input name="name" type="text" placeholder="@lang('contacte.Nom')" disabled>
                                    </div> <!-- single form -->
                                </div>
                                <div class="col-md-6">
                                    <div class="single_form">
                                        <input name="email" type="email" placeholder="@lang('contacte.Email')" disabled>
                                    </div> <!-- single form -->
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <textarea name="message" placeholder="@lang('contacte.Missatge')" disabled></textarea>
                                    </div> <!-- single form -->
                                </div>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <input name="telefon" placeholder="@lang('contacte.Telèfon')" disabled></textarea>
                                    </div> <!-- single form -->
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="option" required="" data-validation-required-message="Accepta la politica de privacitat." data-changeadded="required" aria-label=" Sí, accepto la politica de privacitat de TecnoLord" aria-labelledby="id-hatemile-association-7294589648893151-0" aria-required="true">
                                    <label for="option" id="id-hatemile-association-7294589648893151-0"><span></span> 
                                        <p class="section-subheading text-muted">@lang('contacte.Sí, accepto la') <a class="portfolio-link" data-toggle="modal" href="#politicaPrivacitat">@lang('contacte.politica de privacitat')</a> de TecnoLord</p>
                                        <span class="force-read-after" data-attributerequiredof="option"> @lang('contacte.(Campo obligatorio)')</span>
                                    </label>
                                    <p class="help-block text-danger"></p>
                                </div>
                                <p class="form-message"></p>
                                <div class="col-md-12">
                                    <div class="single_form">
                                        <button class="main-btn">@lang('contacte.Envia')</button>
                                    </div> <!-- single form -->
                                    <span>@lang('contacte.TecnoLord li informa que les dades de caracter personal que proporcionis omplint el formulari serán tractats per Oriol Riu Gispert (TecnoLord) com a responsable d\'aquesta web. La finalitat de la recollida i tractament de les dades personals que sol·licito són per gestionar la sol·licitut que realizes en aquest formulario de contacte. Legitimació: Consentimient de l\'interessat.') </span>
                                </div>
                            </div> <!-- row -->
                        </form>
                    </div> <!-- contact form -->
                </div> <!-- contact wrapper -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== CONTACT PART ENDS ======-->