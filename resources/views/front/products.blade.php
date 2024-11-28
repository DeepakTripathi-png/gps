<!DOCTYPE html>
<html lang="en" class="wide smoothscroll wow-animation desktop landscape rd-navbar-static-linked">
<head>
  <!-- Site Title -->
  <title>Products</title>
  <meta name="format-detection" content="telephone=no" />
  <meta name="viewport"
    content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

  <!-- Stylesheets -->
  <link rel="icon" type="image/x-icon" href="{{asset('front/images/fevicon.ico')}}">
  <!-- <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> -->
  <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Bitter" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
  <!-- //added slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css">
  <link rel="stylesheet" href="{{asset('front/css/productpage.css')}}">
   
  <style>
   .single-line {
      white-space: nowrap;
      text-overflow: ellipsis;
    }
  
    .heading-4{
       /*margin-top: 225px; */
       text-align: center; 
    }
    .slick-list p{
      font-size: 16px;
    }
    /* .container.text-center { */
    /* margin-top: 225px; */
   /* } */
   
   .Electronic.container.text-center {
    margin-top: 300px;
    margin-left: 270px;
    }
    
    .widget1 h5{
      font-family: 'Raleway', sans-serif;
    }
    /*.heading-4{*/
    /*  margin-top: 225px;*/
    /*  text-align:center;*/
    /*}*/
  
    @media (max-width: 768px) {
    .Electronic.container.text-center {
      margin-top: 94px;
      margin-left: -10px;
    }
  }
   @media (max-width: 768px) {
    .container.text-center {
      margin-top: -79px;
    }
  }
    @media (max-width: 768px) {
      .slick-list p {
    font-size: 11px;
    line-height: 21px;
    text-align: center;
    text-align: initial;
    }
  }
    @media (max-width: 768px) {
    .container h5 {
  font-size: 14px;
  font-family: sans-serif;
}

  }
  
    @media only screen and (max-width: 768px) {
    .hide-on-mobile {
        display: none; 
    }
  }
    /* Media queries for smaller screens */
  @media (max-width: 768px) {
    h5 {
      font-size: 16px;
    }
    p {
      font-size: 14px;
    }
  }
    @media (max-width: 768px) {
    .heading-4 {
      margin-top: 50px; /* Adjust as needed */
      text-align: center;
    }
}
    @media (max-width: 768px) {
    .image-wrap {
      justify-content: center;
      text-align: center;
      margin-top: 79px;
    }
    }
    @media (max-width: 768px) {
        .Electronic.container.text-center
        {
          margin-top: 94px;
        }
     }
  }

  }
@media (min-width: 992px){
.image-wrap-left-md img {
    max-width: none;
    margin-right: -182px;
}

.image-wrap-3 {
    margin-right: 115px!important;
}
}
/*footer side by side */
@media (max-width: 767px) {
  .container.overflow-hidden .row.justify-content-xl-between {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
  }
  .container.overflow-hidden .row.justify-content-xl-between > div {
    flex: 0 0 calc(50% - 10px); 
    margin-bottom: 10px; 
  }
}


  </style>
</head>

<body>

  <div class="page">
    <!--For older internet explorer-->
    <!-- <div class="old-ie"
       style='background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;'>
    <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
      <img src="images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820"
           alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
    </a>
  </div> -->
    <!--END block for older internet explorer-->

    <!--===============HEADER===================-->
    <header class="page-header header-1">
      <!-- RD Navbar -->
      <div class="rd-navbar-wrap">
        <nav class="rd-navbar" data-rd-navbar-lg="rd-navbar-static">
          <div class="rd-navbar-inner">
            <div class="rd-navbar-panel">
              <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar"><span></span></button>
              <a href="{{url('/')}}" class="rd-navbar-brand">
                <span class="brand-logo">
                  <img src="{{asset('front/images/GPS Packseals Logo.png')}}" alt="Logo">
                </span>
              </a>
            </div>
            <div class="rd-navbar-nav-wrap">
              <ul class="rd-navbar-nav">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('about-us')}}">About Us</a></li>
                <li><a href="{{url('solutions')}}">Solutions</a></li>
                          <!--<ul class="rd-navbar-dropdown">-->
                            <!--<li>-->
                            <!--  <a href="#">Conatiner Monitering Tracking</a>-->
                            <!--</li>-->
                            <!--<li>-->
                            <!--  <a href="#">Software Solutions</a>-->
                            <!--</li>-->
                           <!--</ul>-->
                           <!-- END RD Navbar Dropdown -->
                      
                <li class="active">
                  <a href="{{url('products')}}">Products</a>
                </li>
                <li>
                  <a href="{{url('our-client')}}">Our Client</a>
                </li>
                <li>
                  <a href="{{url('plateform')}}">Platform</a>
                </li>
                <li>
                  <a href="{{url('contact-us')}}">Contact Us</a>
                </li>
              </ul>
            </div>
            <a href="{{url('admin')}}" class="log">login</a>
          </div>
        </nav>
      </div>
    </header>
 <!-- END RD Navbar -->
  <!--======================CONTENT===================-->
    <main class="page-content">
      <section class="well well-7 bg-alabster"
        style="background-image: url(/images/Vector.svg);background-repeat: no-repeat;">
        <div class="container-fluid">
          <div class="row text-center text-md-left">
            <div class="col-md-6 order-md-2">
              <div class="image-wrap image-wrap-left image-wrap-left-md image-wrap-3">
                <img src="{{asset('front/images/product_page_svg.svg')}}" width="600" height="700" alt="">
              </div>
            </div>
            <div class="col-md-6 order-md-1">
              <div class="Electronic container text-center">
                <div class="row">
                  <!--<div class="col-sm-3"> </div>-->
                  <div class="col-sm-12 col-lg-12 col-md-12">
                    <span class="heading-4">Intelligent Electronic Lock </span>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="row">
                  <div class="col-sm-12 text-center">
                    <p style="text-align: center;color: #2c2c2c;">With our Intelligent Tracking Lock Devices,
                      such as PS701, PS709 and SolargurdPS700 we
                      cordially encourage you to enter the future of
                      asset management.
                    </p>
                  </div>
                </div>
      </section>
    <!-- END We provide top-notch  -->

    <!-- Start Customization Service -->
      <section class="well well-3">
        <div class="container text-center">
          <div class="row">
            <!--<div class="col-sm-5"> </div>-->
            <div class="col-md-12">
                <span class="heading-4">Customization Service </span>
            </div>
            <div class="col-sm-2"></div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <p style="text-align: center;color: #2c2c2c;">Our mission has always been to comprehend client project
                details and difficulties, and to provide them with distinctive
                personalized services.
              </p>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #ffd4d454;">
                <div>
                  <img src="{{asset('front/images/tabler_settings-check.svg')}}" alt="" width="50" height="50" ;>
                </div>
                <!--<p>Easy installation.</p>-->
            <p style="text-align: center;color: #2c2c2c;">Easy installation.</p>
              
              </div>
            </div>

            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #ffd4d454;">
                <div class="dualsim">
                  <img src="{{asset('front/images/solar_sim-cards-linear.svg')}}" alt="" width="50" height="50" ;>
                </div>
                <p style="text-align: center;">Dual SIM card slot designed to address
                  signal issues during cross-border
                  transportation.
                </p>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #ffd4d454;">
                <div class="">
                  <img src="{{asset('front/images/mingcute_unlock-line.svg')}}" alt="">
                </div>
                <p>Remote control to lock/unlock via web,<br> app, or SMS</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #e9e9ffa1;">
                <div class="">
                  <img src="{{asset('front/images/bx_rfid.svg')}}" alt="">
                </div>
                <p>Lock/unlock using an RFID card or<br>
                  Bluetooth on-site.
                </p>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #e9e9ffa1;">
                <div class="">
                  <img src="{{asset('front/images/icon-park-outline_alarm.svg')}}" alt="">
                </div>
                <p class="inset-6">Unauthorized lock opening/<br>
                  tamper alarm</p>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="card customize" style="height: 161px;background-color: #e9e9ffa1;">
                <div class="">
                  <img src="{{asset('front/images/circum_temp-high.svg')}}" alt="">
                </div>
                <p>Temperature monitoring at many<br>
                  points in the container
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- END Customization Service -->
      <!-- Start Device Feature -->
        <section class="well well-3">
            <div class="container text-center">
              <div class="row">
                <!-- <div class="col-sm-3"> </div> -->
                <div class="col-sm-12">
                 <span class="heading-4">Device Feature </span>
                </div>
                <!-- <div class="col-sm-2"></div> -->
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <p style="text-align:center; color:#2c2c2c;">Dual SIM card slot for enhanced signal reliability during
                    cross border transportation, ensuring consistent connectivity..
                  </p>
                </div>
              </div>
            <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="slick-list">
                      <div>
                        <h5 class="single-line" style="color: #212121;"><strong>Advanced Security</strong></h5>
                        <p style="margin-bottom: 28px;">Emphasize the importance of RFID/remote password unlocking and the
                          illegal unlocking alarm for robust security.</p>
                      </div>
                      <div>
                        <h5 class="single-line" style="color: #212121;"><strong>Enhanced Efficiency</strong></h5>
                        <p style="margin-bottom: 50px;">Highlight the device's long working hours due to the large-capacity
                          battery, ensuring continuous asset monitoring..</p>
                      </div>
                      <div>
                        <h5 class="single-line" style="color: #212121;"><strong>Global Connectivity</strong></h5>
                        <p style="margin-bottom: 49px;">Discuss the global positioning feature provided by the built-in GPS
                          module for accurate tracking .</p>
                      </div>
                      <div>
                        <h5 class="single-line" style="color: #212121;"><strong>Real-time Monitoring</strong></h5>
                        <p style="margin-bottom: 48px;">Stress the real-time online monitoring facilitated by the integrated
                          wireless module, ensuring timely updates.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              </div>
        </section>
      <!-- END Device Feature  -->
    </main>
    <!--========================================================
                            FOOTER
  ==========================================================-->
    <!-- Footer Start -->
    <footer class="footer">
      <!-- Widgets - Bootstrap Brain Component -->
      <section class="bg-light py-4 py-md-5 py-xl-8 border-top border-light">
        <div class="container overflow-hidden">
          <div class="row gy-4 gy-lg-0 justify-content-xl-between">
            <div class="">

            </div>
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              <div class="widget1">
                <a href="#!">
                  <img src="{{asset('front/images/Logo-Footer.svg')}}" alt=" Logo" width="175" height="57">
                  <address class="mb-4"> B-201/B-202, 2nd fl., B wing, Veerdhaval CHS LTD, L.T.Road,Babhai
                    Naka,Borivali(W),Mumbai - 400092</address>
                </a>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4 col-xl-2">
              <div class="widget1">
                <h5 class="widget-title mb-4">Get in Touch</h5>
                <p class="mb-0">
                  <a class="link-secondary text-decoration-none"
                    style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"
                    href="tel:+15057922430">7506364190/7208039377/8879440129</a>
                </p>
                <p class="mb-0">
                  <a class="link-secondary text-decoration-none"
                    href="mailto:sales1@packsealsind.com">sales1@packsealsind.com</a>
                  <a class="link-secondary text-decoration-none"
                    href="mailto:marketing1@packsealsind.com">marketing1@packsealsind.com</a>
                </p>
                <p class="mb-0">
                  <a class="link-secondary text-decoration-none"
                    href="{{url('/')}}">https://gpspackseal.in</a>
                </p>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
              <div class="widget1">
                <h5 class="widget-title mb-4">Service</h5>
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <a href="{{url('/')}}" class="link-secondary text-decoration-none">Home</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('about-us')}}" class="link-secondary text-decoration-none">About Us</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('solutions')}}" class="link-secondary text-decoration-none">Solutions</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('products')}}" class="link-secondary text-decoration-none">Product</a>
                  </li><br>

                </ul>
              </div>
            </div>
            <div class="col-12 col-md-4 col-lg-2 col-xl-2">
              <div class="widget1">
                <h5 class="widget-title mb-4">Company</h5>
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <a href="{{url('/')}}" class="link-secondary text-decoration-none">Pricing</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('about-us')}}" class="link-secondary text-decoration-none">Settings</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('solutions')}}" class="link-secondary text-decoration-none">Orders</a>
                  </li><br>
                  <li class="mb-2">
                    <a href="{{url('products')}}" class="link-secondary text-decoration-none">Help</a>
                  </li><br>

                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Copyright - Bootstrap Brain Component -->
      <div class="bg-light py-4 py-md-5 py-xl-8 border-top border-light-subtle">
        <div class="container overflow-hidden">
          <div class="row gy-4 gy-md-0">
            <!-- <div class="col-xs-12 col-md-7 order-1 order-md-0">
          <div class="copyright text-center text-md-start">
            &copy; 2024. All Rights Reserved.
          </div>
          <div class="credits text-secondary text-center text-md-start mt-2 fs-7">
            Built by <a href="https://bootstrapbrain.com/" class="link-secondary text-decoration-none">BootstrapBrain</a> with <span class="text-primary">&#9829;</span>
          </div>
        </div> -->

            <div class="col-xs-12 col-md-5 order-0 order-md-1">
              <ul class="nav justify-content-center justify-content-md-end">
                <li class="nav-item">
                  <a class="nav-link link-dark" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                      class="bi bi-facebook" viewBox="0 0 16 16">
                      <path
                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg>
                  </a>
                </li>&nbsp;&nbsp;&nbsp;
                <li class="nav-item">
                  <a class="nav-link link-dark" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                      class="bi bi-youtube" viewBox="0 0 16 16">
                      <path
                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                    </svg>
                  </a>
                </li>&nbsp;&nbsp;&nbsp;
                <li class="nav-item">
                  <a class="nav-link link-dark" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                      class="bi bi-twitter" viewBox="0 0 16 16">
                      <path
                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                    </svg>
                  </a>
                </li>&nbsp;&nbsp;&nbsp;
                <li class="nav-item">
                  <a class="nav-link link-dark" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                      class="bi bi-instagram" viewBox="0 0 16 16">
                      <path
                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                  </a>
                </li>&nbsp;&nbsp;&nbsp;
                <li class="nav-item">
                  <a class="nav-link link-dark" href="#!">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                      class="bi bi-twitter" viewBox="0 0 16 16">
                      <path
                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </footer>
  </div>
  <!-- Copyright -->
  <div class="copyright">
    <div class="text-center p-4" style="color:rgb(255, 252, 252);text-align: center; background-color:#2e3192">
       &copy; 2024 Copyright:
      <a class="text-reset fw-bold" href="{{url('/')}}">gpspackseal.com</a>
    </div>
  </div>

  <!-- Copyright -->

  </footer>
  </div>

  <!-- Core Scripts -->
  <script src="{{asset('front/js/core.min.js')}}"></script>
  <script src="{{asset('front/js/script.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

</body>
<script>
  $(document).ready(function () {
    $(".slick-list").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      arrows: true,
      infinite: false,
      autoplay: false
    });
    $(".prev-btn").click(function () {
      $(".slick-list").slick("slickPrev");
    });

    $(".next-btn").click(function () {
      $(".slick-list").slick("slickNext");
    });
    $(".prev-btn").addClass("slick-disabled");
    $(".slick-list").on("afterChange", function () {
      if ($(".slick-prev").hasClass("slick-disabled")) {
        $(".prev-btn").addClass("slick-disabled");
      } else {
        $(".prev-btn").removeClass("slick-disabled");
      }
      if ($(".slick-next").hasClass("slick-disabled")) {
        $(".next-btn").addClass("slick-disabled");
      } else {
        $(".next-btn").removeClass("slick-disabled");
      }
    });
  });
</script>

</html>