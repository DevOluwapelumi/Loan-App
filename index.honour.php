<?php
session_start();
include 'config.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="<?php echo $sitename ?>">
    <meta name="description" content="<?php echo $sitename ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        <?php echo $sitename ?>
    </title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="images/favicon.svg">

    <!-- All Device Favicon -->
    <link rel="icon" href="images/icon.svg">

    <!-- Icon -->
    <link rel="stylesheet" href="css/myicon.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Animate Css -->
    <link rel="stylesheet" href="css/animate.min.css">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="css/swiper-bundle.min.css">

    <!-- Venobox Css -->
    <link rel="stylesheet" href="css/venobox.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Responsive -->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body>

    <div id="main-wrapper">
        <header>
            <!-- Manu Bar Start -->
            <div class="menu-bar v2">
                <div class="container">
                    <div class="menu-content">
                        <div class="menu-logo">
                            <img src="logo.png" style="width: 15rem;" alt="">
                        </div>
                        <nav class="main-menu">
                            <ul>
                                <li class="active ">
                                    <a href="?p=index">Home</a>

                                </li>
                                <li><a href="#about">About</a></li>

                                <li><a href="?p=login">Login</a></li>
                                <li><a href="?p=signup">Get Started</a></li>
                            </ul>
                        </nav>
                        <div class="menu-right">
                            <ul class="right-menur-btns">
                                <li>
                                    <a href="?p=signup" class="link-anime v5 round-border-sm icon-1">Get started</a>
                                </li>
                                <li class="d-lg-none">
                                    <button class="mobile-btns"><i class="my-icon icon-category"></i></button>
                                </li>
                            </ul>
                            <div class="mobile-menu-bar">
                                <div class="mobile-content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Manu Bar End -->
        </header>
        <main class="bg-color-1">
            <section class="body-bg-1" id="banner" data-background="assets/img/bg-shap/v1/01.png">
                <!-- Banner Start -->
                <div class="banner v2">
                    <div class="container">
                        <div class="banner-content">
                            <div class="section-title v1">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <h2 class="big-title font-v4">FLEXIBLE <span>LOAN SOLUTIONS</span> FOR YOUR
                                            FINANCIAL NEEDS</h2>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="content-text">
                                            <p class="title-para font-v3">Access quick loans, manage repayments, and
                                                take control of your finances with ease.</p>
                                            <ul class="all-btns">
                                                <li>
                                                    <a href="?p=signup" class="link-anime v6 round-border-sm icon-1">Apply
                                                        Now</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Banner End -->
                <!-- Pament Get Card Start -->
                <div class="pamentget-card v1 pt-sm-50 pb-md-50 pt-lg-85 pb-lg-85 pb-130">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="pament-card-img">
                                    <img src="images/visa_card.png" alt="visa_card">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Pament Get Card End -->
            </section>
            <!-- Invoices Card Start-->

            <section class="invoices v1 mt-shap-over">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.1s"
                            data-wow-duration="0.8s">
                            <div class="invoices-card invoices-card-small">
                                <div class="invoices-card-head">
                                    <a href="?p=apply" class="read-more v2"></a>
                                    <div class="numbber-stitle">
                                        <h6 class="count-num">01</h6>
                                        <h6 class="stitle">Loan Application</h6>
                                    </div>
                                </div>
                                <h2 class="card-title font-v4">
                                    Apply for a loan <br> effortlessly
                                </h2>
                                <p class="card-para">Streamline your loan application process with our user-friendly
                                    platform.</p>
                            </div>
                        </div>
                        <div class="col-lg-6 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.3s"
                            data-wow-duration="0.8s">
                            <div class="invoices-card invoices-card-small">
                                <div class="invoices-card-head">
                                    <a href="?p=signup" class="read-more v2"></a>
                                    <div class="numbber-stitle">
                                        <h6 class="count-num">02</h6>
                                        <h6 class="stitle">Loan Repayment</h6>
                                    </div>
                                </div>
                                <h2 class="card-title font-v4">
                                    Manage loan repayments <br> with ease
                                </h2>
                                <p class="card-para">Effortlessly manage your loan repayments and stay on top of your
                                    financial obligations.</p>
                            </div>
                        </div>
                        <div class="col-lg-12 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.5s"
                            data-wow-duration="0.8s">
                            <div class="invoices-card bg-img-cover invoices-card-big"
                                data-background="assets/img/invoices/v1/middle-img.png">
                                <div class="invoices-card-head">
                                    <a href="?p=signup" class="read-more v2"></a>
                                    <div class="numbber-stitle">
                                        <h6 class="count-num">03</h6>
                                        <h6 class="stitle">Financial Control</h6>
                                    </div>
                                </div>
                                <h2 class="card-title font-v4">
                                    Take control of your finances <br> effortlessly
                                </h2>
                                <p class="card-para font-v3">Empower yourself with tools to manage your finances
                                    effectively and achieve your financial goals.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Invoices Card End-->
            <!-- Financial Start -->
            <section class="financial v1 pt-sm-50 pb-sm-50 pt-md-70 pb-md-70 pt-xl-100 pb-xl-100 pt-130 pb-130">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="section-title v2">
                                <h2 class="big-title font-v4">NO MORE HOOPS TO JUMP THROUGH, JUST PURE JUMPING FOR JOY.
                                </h2>
                                <p class="title-para">Design a financial operating system that works for your business.
                                </p>
                            </div>
                            <ul class="all-btns">
                                <li><a href="?p=signup" class="link-anime v6 round-border-sm icon-1">Learn More</a></li>
                            </ul>

                            <div class="financial-contant pt-sm-50 pt-md-70 pt-100 pr-xl-0 pr-xxl-50 pr-92">
                                <div class="chart-img-content">
                                    <div class="chart-img">
                                        <img src="images/person-img.jpg" alt="chart-img">
                                    </div>
                                    <p class="contant-para font-v4">Secure your financial future with hassle-free
                                        lending solutions. Access quick loans, eliminate transaction fees, and simplify
                                        the borrowing process for your customers.</p>
                                    <div class="contant-btn-link">
                                        <a href="?p=apply" class="read-more v3">Apply Now</a>
                                    </div>
                                </div>
                                <div class="dollar-img wow animate__zoomIn" data-wow-offset="100" data-wow-delay="0.4s"
                                    data-wow-duration="0.4s">
                                    <img src="images/dollar-img.png" alt="dollar">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4">
                            <div class="financial-contant">
                                <div class="chart-img-content">
                                    <div class="chart-img">
                                        <img src="images/chart.svg" alt="chart-img">
                                    </div>
                                    <p class="contant-para font-v4">Streamline your loan management process and achieve
                                        better financial control. Utilize our comprehensive platform to handle loan
                                        applications, track repayments, and monitor your financial health, all in one
                                        place.</p>
                                    <div class="contant-btn-link">
                                        <a href="?p=apply" class="read-more v3">Apply Now</a>
                                    </div>
                                    <img class="shap-2" src="images/shap-2.png" alt="shap-2">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- Financial End -->
            <section class="body-bg-2" data-background="assets/img/bg-shap/v1/02.png">
                <!-- Why They Prefer Start -->
                <div class="why-they-prefer v1">
                    <div class="container">
                        <div class="section-title v2">
                            <h2 class="big-title font-v4">Why they prefer
                                <?php echo $sitename ?>
                            </h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.1s"
                                data-wow-duration="0.8s">
                                <div class="quick-support-img">
                                    <img src="images/quick-support.jpg" alt="quick-support-img">
                                    <a href="?p=signup" class="quick-para"><i class="my-icon icon-chatting"></i> Quick
                                        Support</a>
                                </div>
                            </div>
                            <div class="col-lg-3 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.3s"
                                data-wow-duration="0.8s">
                                <div class="the-world-box">
                                    <div class="text-content">
                                        <h2 class="text-numbber font-v4"><span class="counter" data-count-min="150"
                                                data-count-max="180" data-count-duration="1000"
                                                data-count-delay="200">180</span>+</h2>
                                        <h6 class="text-para">We are in the 180 + countries in the world</h6>
                                    </div>
                                    <img src="images/the-world.jpg" alt="the-world-img">
                                </div>
                            </div>
                            <div class="col-lg-4 wow animate__fadeInUp" data-wow-offset="100" data-wow-delay="0.5s"
                                data-wow-duration="0.8s">
                                <div class="digital-visa-card-img">
                                    <img src="images/digital-visa-card.jpg" alt="digital-visa-card-img">
                                    <a href="?p=signup" class="quick-para"><i class="my-icon icon-wallate"></i>Digital Visa
                                        card</a>
                                </div>
                            </div>
                        </div>
                        <div class="why-they-prefer-images">
                        </div>
                    </div>
                </div>
                <!-- Why They Prefer End -->
                <!-- Discover Start -->

            </section>

        </main>
        <footer>
            <div class="footer-section v2 pt-sm-50 pt-130 pt-md-70 pt-lg-100">
                <div class="container">

                    <div class="footer-main v2">
                        <div class="footer-main-content">
                            <h6 class="text">Copyright © 2024 all right reserved</h6>
                            <h6 class="text">&copy;
                                <?php echo $sitename ?>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="footer-bg-shap-1" data-background="assets/img/bg-shap/v1/bg-shap-1.png"></div>
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Anime JS -->
    <script src="js/anime.min.js"></script>

    <!-- Swiper JS -->
    <script src="js/swiper-bundle.min.js"></script>

    <!-- Venobox JS -->
    <script src="js/venobox.min.js"></script>

    <!-- WOW JS -->
    <script src="js/wow.min.js"></script>

    <!-- Index -->
    <script src="js/index.js"></script>


</body>

</html>