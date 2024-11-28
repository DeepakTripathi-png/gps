<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
<head>
    <!-- Site Title -->
    <title>About</title>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>

    <!-- Stylesheets -->
    <link rel="icon" type="image/x-icon" href="{{asset('front/images/fevicon.ico')}}">
    <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/client.css')}}">
    <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
    
      .widget1 h5{
      font-family: 'Raleway', sans-serif;
    }
          .aboutpageimage
      {
        text-align: center;
      }
      
        .aboutus h2{
        text-align: center;
      }
      
      /* Media Query for Mobile View */
      @media only screen and (max-width: 767px) {

        .container-fluid .col-sm-4 {
          display: none; 
        }

        .container-fluid .col-sm-6 {
          width: 100%;
        }

        .container-fluid .col-sm-1 {
          display: none; 
        }

        .container-fluid .col-sm-10 {
          width: 100%; 
        }

        /* Adjust font size or padding if needed */
        .container-fluid .aboutus h2 {
          font-size: 24px; 
        }

        .container-fluid p {
          font-size: 16px; 
          padding: 10px;
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
    <div class="old-ie" style='background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;'>
        <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
            <img src="{{asset('front/images/ie8-panel/warning_bar_0000_us.jpg')}}" height="42" width="820"
                 alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
        </a>
    </div>
    <!--END block for older internet explorer-->

    <!--========================================================
                              HEADER
    =========================================================-->
    <header class="page-header header-1">
        <!-- RD Navbar -->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar" data-rd-navbar-lg="rd-navbar-static">
            <div class="rd-navbar-inner">
              <!-- RD Navbar Panel -->
              <div class="rd-navbar-panel">
    
                <!-- RD Navbar Toggle -->
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar"><span></span></button>
                <!-- END RD Navbar Toggle -->
    
                <!-- RD Navbar Brand -->
                <a href="{{url('/')}}" class="rd-navbar-brand">
                  <span class="brand-logo">
                    <img src="{{asset('front/images/GPS Packseals Logo.png')}}" alt="Logo">
                  </span>
                </a>
                <!-- END RD Navbar Brand -->
              </div>
              <!-- END RD Navbar Panel -->
    
              <div class="rd-navbar-nav-wrap">
    
                  <!-- RD Navbar Nav -->
                  <ul class="rd-navbar-nav">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active">
                      <a href="{{url('about-us')}}">About Us</a>
                    </li>
                     <li>
                        <a href="{{url('solutions')}}">Solutions</a>
                          <!--<ul class="rd-navbar-dropdown">-->
                            <!--<li>-->
                            <!--  <a href="#">Conatiner Monitering Tracking</a>-->
                            <!--</li>-->
                            <!--<li>-->
                            <!--  <a href="#">Software Solutions</a>-->
                            <!--</li>-->
                           <!--</ul>-->
                        <!-- END RD Navbar Dropdown -->
                      </li>
                    
                    <li>
                      <a href="{{url('products')}}">Products</a>
                    </li>
                    <li>
                      <a href="{{url('our-client')}}">Our Client</a>
                    </li>
                    <li>
                        <a href="{{ url('plateform') }}">Platform</a>
                      </li>
                    <!-- <li>
                      <a href="index-3.html">Gallery</a>
                    </li> -->
                    <li>
                      <a href="{{ url('contact-us') }}">Contact Us</a>
                    </li>
                  </ul>
                </div>
                 <a href="{{url('admin')}}" class="log">login</a>
              </div>
            </nav>
          </div>
          <!-- END RD Navbar -->
        <!-- END RD Navbar -->
      </header>

    <!--========================================================
                              CONTENT
    =========================================================-->
    <div class="container-fluid">
      <div class="row aboutus">
        <!--<div class="col-sm-3">-->
        <!--</div>-->
        <div class="col-sm-12">
          <h2>About our Company</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <p style="font-family:'Raleway', sans-serif;">Welcome to GPS PackSeals Industries - <strong>Your Trusted Partner for Secure Transit Solutions!!</strong>
            Introducing our innovative GPS PackSeals, the ultimate solution for secure transit tracking. Say goodbye to
            worries about pilferage and tampering, as our GPS-enabled seals provide <strong>real-time monitoring and
              location tracking for your valuable cargo.</strong>
          </p>

          <p>
            With GPS PackSeals Industries, you can trust that <strong>your shipments are in safe hands.</strong> Our tracking
            devices are equipped with <strong>cutting-edge technology</strong>  and are <strong>designed to ensure the highest level of
              security</strong> and reliability.
          </p>

          <p>
            Backed by a dedicated team and a commitment to excellence, we guarantee timely delivery and unparalleled
            customer satisfaction. Join us in revolutionizing transit security with GPS PackSeals!
          </p><br>

        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="aboutpageimage">
            <img src="{{asset('front/images/aboutpageimage.png')}}" alt="">
          </div>
        </div>
      </div>
    </div><br>
    
  
    <!--========================================================
                              FOOTER
    =========================================================-->
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
            <a href="{{url('/')}}">
              <img src="{{asset('front/images/Logo-Footer.svg')}}" alt="BootstrapBrain Logo" width="175" height="57">
              <address class="mb-4"> B-201/B-202, 2nd fl., B wing, Veerdhaval CHS LTD, L.T.Road,Babhai Naka,Borivali(W),Mumbai - 400092</address>
            </a>
          </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4 col-xl-2">
          <div class="widget1">
            <h5 class="widget-title mb-4">Get in Touch</h5>
            <p class="mb-0">
              <a class="link-secondary text-decoration-none" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;" href="tel:+15057922430">7506364190/7208039377/8879440129</a>
            </p>
            <p class="mb-0">
              <a class="link-secondary text-decoration-none" href="mailto:sales1@packsealsind.com">sales1@packsealsind.com</a>
              <a class="link-secondary text-decoration-none" href="mailto:marketing1@packsealsind.com">marketing1@packsealsind.com</a>
            </p>
            <p class="mb-0">
              <a class="link-secondary text-decoration-none" href="{{url('/')}}">https://gpspackseal.in</a>
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
            <h5 class="widget-title mb-4">Campany</h5>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                </svg>
              </a>
            </li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
              <a class="nav-link link-dark" href="#!">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                  <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />
                </svg>
              </a>
            </li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
              <a class="nav-link link-dark" href="#!">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                </svg>
              </a>
            </li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
              <a class="nav-link link-dark" href="#!">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                </svg>
              </a>
            </li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item">
              <a class="nav-link link-dark" href="#!">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                  <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
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
    <a class="text-reset fw-bold" href="https:///gpspackseal.in/">gpspackseal.com</a>
  </div>
 </div>
 
<!-- Copyright -->

</footer>
</div>

<!-- Core Scripts -->
<script src="{{asset('front/js/core.min.js')}}"></script>
<!-- Additional Functionality Scripts -->
<script src="{{asset('front/js/script.js')}}"></script>
<!-- Coded by gel -->
</body>
</html>