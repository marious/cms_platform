<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>Leaders Group</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Niramit:wght@200;300;400;500;600;700&family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    {!! Theme::header() !!}
</head>

<body class="" @if (class_exists('Language', false) && Language::getCurrentLocaleRTL()) dir="rtl" @endif>

<div class="page-wrapper">
    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header / Header Style Two -->
    <header class="main-header header-style-two">

        <!-- Header Upper -->
        <div class="header-upper">
            <div class="auto-container">
                <div class="inner-container clearfix">

                    <!-- Logo Box -->
                    <div class="pull-left logo-box">
                        <div class="logo"><a href="index.html"><img src="images/logo-3.png" alt="" title=""></a></div>
                    </div>

                    <!-- Nav Outer -->
                    <div class="nav-outer clearfix">

                        <!-- Mobile Navigation Toggler For Mobile -->
                        <div class="mobile-nav-toggler"><span class="icon flaticon-menu"></span></div>
                        <!-- End Mobile Navigation Toggler For Mobile -->

                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md">
                            <div class="navbar-header">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li class="current dropdown"><a href="#"><span data-hover="Home">Home</span></a>
                                        <ul>
                                            <li><a href="index.html">Home page 01</a></li>
                                            <li><a href="index-2.html">Home page 02</a></li>
                                            <li><a href="index-3.html">Home page 03</a></li>
                                            <li><a href="index-4.html">Home page 04</a></li>
                                            <li><a href="index-5.html">Home page 05</a></li>
                                            <li><a href="index-6.html">Home page 06</a></li>
                                            <li class="dropdown"><a href="#">Header styles</a>
                                                <ul>
                                                    <li><a href="index.html">Header Style 01</a></li>
                                                    <li><a href="index-2.html">Header Style 02</a></li>
                                                    <li><a href="index-3.html">Header Style 03</a></li>
                                                    <li><a href="index-4.html">Header Style 04</a></li>
                                                    <li><a href="index-5.html">Header Style 05</a></li>
                                                    <li><a href="index-6.html">Header Style 06</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#"><span data-hover="About">About</span></a>
                                        <ul>
                                            <li><a href="about.html">About us</a></li>
                                            <li><a href="price.html">Price</a></li>
                                            <li><a href="faq.html">Faq's</a></li>
                                            <li><a href="team.html">Team</a></li>
                                            <li><a href="testimonial.html">Testimonial</a></li>
                                            <li><a href="comming-soon.html">Comming Soon</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#"><span data-hover="Services">Services</span></a>
                                        <ul>
                                            <li><a href="services.html">Services</a></li>
                                            <li><a href="investment-trading.html">Investment Trading</a></li>
                                            <li><a href="taxation-planning.html">Taxation Planning</a></li>
                                            <li><a href="analysis.html">Financial Analysis</a></li>
                                            <li><a href="wealth-marketing.html">Wealth Marketing</a></li>
                                            <li><a href="strategies.html">Planning Strategies</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#"><span data-hover="Projects">Projects</span></a>
                                        <ul>
                                            <li><a href="projects.html">Projects</a></li>
                                            <li><a href="portfolio-single.html">Projects Single</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown has-mega-menu"><a href="#"><span data-hover="Pages">Pages</span></a>
                                        <div class="mega-menu">
                                            <div class="mega-menu-bar row clearfix">
                                                <div class="column col-lg-3 col-md-6 col-sm-12">
                                                    <h3>About Us</h3>
                                                    <ul>
                                                        <li><a href="about.html">About us</a></li>
                                                        <li><a href="price.html">Price</a></li>
                                                        <li><a href="faq.html">Faq's</a></li>
                                                        <li><a href="team.html">Team</a></li>
                                                        <li><a href="testimonial.html">Testimonial</a></li>
                                                        <li><a href="comming-soon.html">Comming Soon</a></li>
                                                    </ul>
                                                </div>
                                                <div class="column col-lg-3 col-md-6 col-sm-12">
                                                    <h3>Services</h3>
                                                    <ul>
                                                        <li><a href="services.html">Services</a></li>
                                                        <li><a href="investment-trading.html">Investment Trading</a></li>
                                                        <li><a href="taxation-planning.html">Taxation Planning</a></li>
                                                        <li><a href="analysis.html">Financial Analysis</a></li>
                                                        <li><a href="wealth-marketing.html">Wealth Marketing</a></li>
                                                        <li><a href="strategies.html">Planning Strategies</a></li>
                                                    </ul>
                                                </div>
                                                <div class="column col-lg-3 col-md-6 col-sm-12">
                                                    <h3>Shops</h3>
                                                    <ul>
                                                        <li><a href="shop.html">Shop</a></li>
                                                        <li><a href="shop-single.html">Shop Details</a></li>
                                                        <li><a href="shoping-cart.html">Cart Page</a></li>
                                                        <li><a href="checkout.html">Checkout Page</a></li>
                                                        <li><a href="login.html">Login</a></li>
                                                    </ul>
                                                </div>
                                                <div class="column col-lg-3 col-md-6 col-sm-12">
                                                    <h3>Blog</h3>
                                                    <ul>
                                                        <li><a href="blog.html">Our Blog</a></li>
                                                        <li><a href="blog-sidebar.html">Blog Sidebar</a></li>
                                                        <li><a href="news-detail.html">Blog Details</a></li>
                                                        <li><a href="error-page.html">Error Page</a></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown"><a href="#"><span data-hover="Blog">Blog</span></a>
                                        <ul>
                                            <li><a href="blog.html">Our Blog</a></li>
                                            <li><a href="blog-sidebar.html">Blog Sidebar</a></li>
                                            <li><a href="news-detail.html">Blog Details</a></li>
                                            <li><a href="error-page.html">Error Page</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#"><span data-hover="Shop">Shop</span></a>
                                        <ul>
                                            <li><a href="shop.html">Shop</a></li>
                                            <li><a href="shop-single.html">Shop Details</a></li>
                                            <li><a href="shoping-cart.html">Cart Page</a></li>
                                            <li><a href="checkout.html">Checkout Page</a></li>
                                            <li><a href="login.html">Login</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="contact.html"><span data-hover="Contact">Contact</span></a></li>
                                </ul>
                            </div>

                        </nav>

                        <!-- Main Menu End-->
                        <div class="outer-box clearfix">

                            <!-- Cart Box -->
                            <div class="cart-box">
                                <div class="dropdown">
                                    <button class="cart-box-btn dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="flaticon-shopping-bag-1"></span><span class="total-cart">2</span></button>
                                    <div class="dropdown-menu pull-right cart-panel" aria-labelledby="dropdownMenu3">

                                        <div class="cart-product">
                                            <div class="inner">
                                                <div class="cross-icon"><span class="icon fas fa-times"></span></div>
                                                <div class="image"><img src="images/resource/post-thumb-1.jpg" alt="" /></div>
                                                <h3><a href="shop-single.html">Product 01</a></h3>
                                                <div class="quantity-text">Quantity 1</div>
                                                <div class="price">$49.00</div>
                                            </div>
                                        </div>
                                        <div class="cart-product">
                                            <div class="inner">
                                                <div class="cross-icon"><span class="icon fas fa-times"></span></div>
                                                <div class="image"><img src="images/resource/post-thumb-2.jpg" alt="" /></div>
                                                <h3><a href="shop-single.html">Product 02</a></h3>
                                                <div class="quantity-text">Quantity 1</div>
                                                <div class="price">$99.00</div>
                                            </div>
                                        </div>
                                        <div class="cart-total">Sub Total: <span>$148</span></div>
                                        <ul class="btns-boxed">
                                            <li><a href="shoping-cart.html">View Cart</a></li>
                                            <li><a href="checkout.html">CheckOut</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <!-- Search Btn -->
                            <div class="search-box-btn search-box-outer"><span class="icon flaticon-search"></span></div>

                            <!-- Nav Btn -->
                            <div class="nav-btn navSidebar-button"><span class="icon flaticon-menu-4"></span></div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!--End Header Upper-->

        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><span class="icon flaticon-cancel"></span></div>

            <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            <nav class="menu-box">
                <div class="nav-logo"><a href="index.html"><img src="images/logo.png" alt="" title=""></a></div>

                <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>
            </nav>
        </div><!-- End Mobile Menu -->

    </header>
    <!--End Main Header -->

