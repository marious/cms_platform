</div>
<!--body content wrap end-->

<!--footer section start-->
<footer class="footer-section">
    <!--footer top start-->
    <div class="footer-top gradient-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row footer-top-wrap">
                        {!! dynamic_sidebar('footer_sidebar') !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row footer-top-wrap">
                        <div class="col-12">
                            <div class="footer-nav-wrap text-white">
                                <h4 class="text-white">GET IN TOUCH</h4>
                                <ul class="get-in-touch-list">
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-map-marker-alt mr-2"></span> {{ theme_option('address') }}</li>
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-envelope mr-2"></span> {{ theme_option('contact_email') }}</li>
                                    <li class="d-flex align-items-center py-2"><span class="fas fa-phone-alt mr-2"></span> {{ theme_option('phone_number') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer top end-->

    <!--footer copyright start-->
    <div class="footer-bottom gray-light-bg py-2">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-md-5 col-lg-5">
                    <p class="copyright-text pb-0 mb-0">{{ theme_option('copyright') }}</p>
                </div>
                <div class="col-md-7 col-lg-6 d-none d-md-block d-lg-block">
                    <div class="social-nav text-right">
                        <ul class="list-unstyled social-list mb-0">
                            <li class="list-inline-item tooltip-hover">
                                <a href="#" class="rounded"><span class="ti-facebook"></span></a>
                                <div class="tooltip-item">Facebook</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="#" class="rounded"><span class="ti-twitter"></span></a>
                                <div class="tooltip-item">Twitter</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="#" class="rounded"><span class="ti-linkedin"></span></a>
                                <div class="tooltip-item">Linkedin</div>
                            </li>
                            <li class="list-inline-item tooltip-hover"><a href="#" class="rounded"><span class="ti-dribbble"></span></a>
                                <div class="tooltip-item">Dribbble</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--footer copyright end-->
</footer>
<!--footer section end-->

<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>
<!--bottom to top button end-->


{!! Theme::footer() !!}
</body>
</html>
