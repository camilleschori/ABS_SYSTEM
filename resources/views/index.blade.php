<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

    <!--- basic page needs
    ================================================== -->
    <meta charset="utf-8">
    <title>A.B.S Soon</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- mobile specific metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ url('website/css/base.css') }}">
    <link rel="stylesheet" href="{{ url('website/css/vendor.css') }}">
    <link rel="stylesheet" href="{{ url('website/css/main.css') }}">

    <!-- script
    ================================================== -->
    <script src="{{ url('website/js/modernizr.js') }}"></script>
    <script src="{{ url('website/js/pace.min.js') }}"></script>
    
    <!-- favicons
    ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>

<body>

    <!-- home
    ================================================== -->
    <main class="s-home s-home--slides">

        <div class="home-slider">
            <div class="home-slider-img" style="background-image: url(images/slides/slide-01.jpg);"></div>
            <div class="home-slider-img" style="background-image: url(images/slides/slide-02.jpg);"></div>
            <div class="home-slider-img" style="background-image: url(images/slides/slide-03.jpg);"></div>
        </div>

        <div class="overlay"></div>

        <div class="home-content">

            <div class="home-logo">
                <a href="index-slides.html">
                    <img src="{{ url('website/images/logo.jpg') }}" alt="Homepage">
                   
                </a>
            </div>

            <div class="row home-content__main">

                <div class="col-eight home-content__text pull-right">
                    <h1>Welcome to A.B.S Company</h1>

                    <h3>
                    We are currently working <br>
                    on a new super awesome <br> website.
                    </h3>

                    {{-- <p>
                    Nulla porttitor accumsan tincidunt. Nulla quis lorem ut libero malesuada feugiat. 
                    Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. 
                    Pellentesque in ipsum id orci porta dapibus. Nulla quis lorem ut libero malesuada feugiat.
                    </p> --}}

                    {{-- <div class="home-content__subscribe">
                        <form id="mc-form" class="group" novalidate="true">
                            <input type="email" value="" name="EMAIL" class="email" id="mc-email" placeholder="Email Address" required="">
                            <input type="submit" name="subscribe" value="Notify Me">
                            <label for="mc-email" class="subscribe-message"></label>
                        </form>
                    </div> --}}
                </div>  <!-- end home-content__text -->

                <div class="col-four home-content__counter">
                    <h3>Launching In</h3>

                    <div class="home-content__clock">
                        <div class="top">
                            <div class="time days">
                                325
                                <span>Days</span>
                            </div>
                        </div>    
                        <div class="time hours">
                            09
                            <span>H</span>
                        </div>
                        <div class="time minutes">
                            54
                            <span>M</span>
                        </div>
                        <div class="time seconds">
                            30
                            <span>S</span>
                        </div>
                    </div>  <!-- end home-content__clock -->
                </div>  <!-- end home-content__counter -->

            </div>  <!-- end home-content__main -->

            <ul class="home-social">
                <li>
                <a href="#0"><i class="fab fa-facebook-f" aria-hidden="true"></i><span>Facebook</span></a>
                </li>
                <li>
                <a href="#0"><i class="fab fa-twitter" aria-hidden="true"></i><span>Twiiter</span></a>
                </li>
                <li>
                <a href="#0"><i class="fab fa-instagram" aria-hidden="true"></i><span>Instagram</span></a>
                </li>
                <li>
                <a href="#0"><i class="fab fa-behance" aria-hidden="true"></i><span>Behance</span></a>
                </li>
                <li>
                <a href="#0"><i class="fab fa-dribbble" aria-hidden="true"></i><span>Dribbble</span></a>
                </li>
            </ul> <!-- end home-social -->

            <div class="row home-copyright">
                <span>Copyright A.B.S 2024</span> 
                <span>Design by <a href="https://www.sky-control.net/">SKY-CONTROL</a></span>
            </div> <!-- end home-copyright -->


            <div class="home-content__line"></div>

        </div> <!-- end home-content -->

    </main> <!-- end s-home -->


    <!-- info
    ================================================== -->


    <!-- preloader
    ================================================== -->
    <div id="preloader">
        <div id="loader">
            <div class="line-scale-pulse-out">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <!-- Java Script
    ================================================== -->
    <script src="{{ url('website/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ url('website/js/plugins.js') }}"></script>
    <script src="{{ url('website/js/main.js') }}"></script>

</body>

</html>