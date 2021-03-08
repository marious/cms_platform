<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pearl Website</title>
    {!! Theme::header() !!}
</head>
<body>
<div class="page-wrapper rtl">
    <!-- main-header -->
    <header class="main-header">
        <!-- header-top -->
        <div class="header-top">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="top-left">
                        <ul class="contact-list clearfix">
                            <li>
                                <i class="flaticon-hospital-1"></i> القاهرة زهراء المعادى
                            </li>
                        </ul>
                    </div>
                    <div class="top-right">
                        <ul class="social-icon-one light">
                            <li>
                                <a href="#"><span class="fab fa-facebook-f"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="fab fa-twitter"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="fab fa-youtube"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Top -->

        <!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container">
                <!-- Main box -->
                <div class="main-box">
                    <!-- Logo Box -->
                    <div class="logo-box">
                        <div class="logo">
                            <a href=""><img src="storage/images/logo.png" alt=""/></a>
                        </div>
                    </div>
                    <!-- End Logo Box -->
                    <!-- Nav box -->
                    <div class="nav-outer">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current"><a href="index.html">الرئيسية</a></li>
                                <li><a href="">خدماتنا</a></li>
                                <li><a href="">من نحن</a></li>
                                <li><a href="">إتصل بنا</a></li>
                            </ul>
                        </nav>
                        <!-- Main Menu End -->
                        <div class="outer-box">
                            <!-- Appointment btn -->
                            <a
                                href="appointment.html"
                                id="appointment-btn"
                                class="btn theme-btn btn-style"
                            ><span class="btn-title">إحجز الأن</span></a
                            >
                        </div>
                    </div>
                    <!-- End Nav box -->
                </div>
                <!-- End Main box -->
            </div>
        </div>
        <!-- End Header Lower -->

        <!-- Sticky header -->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="main-box">
                    <div class="logo-box">
                        <div class="logo">
                            <a href="index.html"><img src="storage/images/logo.jpg" alt=""/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End sticky header -->
        <!-- Mobile Header -->
        <div class="mobile-header">
            <div class="logo">
                <a href="index.html"
                ><img src="storage/images/logo.jpg" alt="" title=""
                    /></a>
            </div>

            <!--Nav Box-->
            <div class="nav-outer clearfix">
                <div class="outer-box">
                    <!-- Search Btn -->
                    <!-- <div class="search-box">
                      <button class="search-btn mobile-search-btn">
                        <i class="flaticon-magnifying-glass"></i>
                      </button>
                    </div> -->

                    <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger"
                    ><span class="fa fa-bars"></span
                        ></a>
                </div>
            </div>
        </div>
        <!-- End Mobile-header -->

        <!-- Mobile Nav -->
        <div id="nav-mobile"></div>
    </header>
    <!-- End Main Header -->

    <section class="banner-section-three">
        <div class="banner-carousel owl-carousel owl-theme default-arrows dark">
            <!-- Slide Item -->
            <div class="slide-item" style="background-image: url(storage/images/slider/1.jpg);">
                <div class="auto-container">
                    <div class="content-outer">
                        <div class="content-box">
                            <span class="title">مستشفيات اللؤلؤة</span>
                            <h4>أكبر مستشفى متكامل فى قلب المعادى</h4>
                            <!-- <h2>Could Help <span>Your Life</span></h2> -->
                            <div class="text">
                                أفضل خدمة وأفضل فريق طبى متكامل على اعلى مستوى
                            </div>
                            <div class="btn-box"><a href="#" class="theme-btn btn-style-one bg-kellygreen"><span class="btn-title">إكتشف المزيد</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Slide Item -->

            <!-- Slide Item -->
            <div class="slide-item" style="background-image: url(storage/images/slider/2.jpg);">
                <div class="auto-container">
                    <div class="content-outer">
                        <div class="content-box">
                            <span class="title">مستشفيات اللؤلؤة</span>
                            <h4>أكبر مستشفى متكامل فى قلب المعادى</h4>
                            <!-- <h2>Could Help <span>Your Life</span></h2> -->
                            <div class="text">
                                أفضل خدمة وأفضل فريق طبى متكامل على اعلى مستوى
                            </div>
                            <div class="btn-box"><a href="#" class="theme-btn btn-style-one bg-kellygreen"><span class="btn-title">إكتشف المزيد</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Slide Item -->

            <!-- Slide Item -->
            <div class="slide-item" style="background-image: url(storage/images/slider/3.jpg);">
                <div class="auto-container">
                    <div class="content-outer">
                        <div class="content-box">
                            <span class="title">مستشفيات اللؤلؤة</span>
                            <h4>أكبر مستشفى متكامل فى قلب المعادى</h4>
                            <!-- <h2>Could Help <span>Your Life</span></h2> -->
                            <div class="text">
                                أفضل خدمة وأفضل فريق طبى متكامل على اعلى مستوى
                            </div>
                            <div class="btn-box"><a href="#" class="theme-btn btn-style-one bg-kellygreen"><span class="btn-title">إكتشف المزيد</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Slide Item -->

            <!-- Slide Item -->
            <div class="slide-item" style="background-image: url(storage/images/slider/4.jpg);">
                <div class="auto-container">
                    <div class="content-outer">
                        <div class="content-box">
                            <span class="title">مستشفيات اللؤلؤة</span>
                            <h4>أكبر مستشفى متكامل فى قلب المعادى</h4>
                            <!-- <h2>Could Help <span>Your Life</span></h2> -->
                            <div class="text">
                                أفضل خدمة وأفضل فريق طبى متكامل على اعلى مستوى
                            </div>
                            <div class="btn-box"><a href="#" class="theme-btn btn-style-one bg-kellygreen"><span class="btn-title">إكتشف المزيد</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Slide Item -->


        </div>
</div>
</section>








