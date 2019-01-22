<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Book Shop</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>img/favicon.png">

    <!-- all css start -->
    <!-- latest-bootstrap-version-3 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- animate css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/meanmenu.min.css">
    <!-- owl.carousel css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.carousel.css">
    <!-- font-awesome css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/font-awesome.min.css">
    <!-- flexslider.css-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/flexslider.css">
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/responsive.css">
    <!-- select2 library css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <!-- modernizr css -->
    <script src="<?php echo base_url(); ?>js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- all-css-end-->

    <!-- all-js-start -->
    <!-- latest-jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- bootstrap 3.3.7 compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <!-- owl.carousel js -->
    <script src="<?php echo base_url(); ?>js/owl.carousel.min.js"></script>
    <!-- meanmenu js -->
    <script src="<?php echo base_url(); ?>js/jquery.meanmenu.js"></script>
    <!-- wow js -->
    <script src="<?php echo base_url(); ?>js/wow.min.js"></script>
    <!-- jquery.parallax-1.1.3.js -->
    <script src="<?php echo base_url(); ?>js/jquery.parallax-1.1.3.js"></script>
    <!-- jquery.flexslider.js -->
    <script src="<?php echo base_url(); ?>js/jquery.flexslider.js"></script>
    <!-- plugins js -->
    <script src="<?php echo base_url(); ?>js/plugins.js"></script>
    <!-- select2 library script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <!-- underscore js -->
    <script src="<?php echo base_url(); ?>js/underscore-min.js"></script>
    <!-- backbone js -->
    <script src="<?php echo base_url(); ?>js/backbone-min.js"></script>
    <!-- all-js-end -->
</head>
<body class="home-2">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please upgrade your browser to improve
    your experience.</p>
<![endif]-->
<div id="body-div"></div>

<!-- footer-area-start -->
<footer>
    <!-- footer-bottom-start -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row bt-2">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="copy-right-area">
                        <p>Copyright ©<a href="https://www.raveen.me">Raveen S Rathnayake</a>. All Right Reserved.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                </div>
            </div>
        </div>
    </div>
    <!-- footer-bottom-end -->
</footer>
<!-- footer-area-end -->

<script type="text/template" id="loginTemplate">
<header>
    <!-- main-menu-area-start -->
    <div class="main-menu-area hidden-sm hidden-xs" id="header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-area">
                        <nav>
                            <ul>
                                <li class="active">
                                <li><a href="<?php echo site_url(); ?>">Home</a></li>
                                <li><a id ="sign-in-btn1" href="#">Sign In</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-menu-area-end -->
    <!-- mobile-menu-area-start -->
    <div class="mobile-menu-area hidden-md hidden-lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul id="nav">
                                <li><a href="<?php echo site_url(); ?>">Home</a></li>
                                <li><a id ="sign-in-btn2" href="#">Sign In</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile-menu-area-end -->
</header>
<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li><a href="#" class="active">User Login</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbs-area-end -->
<!-- user-login-area-start -->
<div class="user-login-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login-title text-center mb-30">
                    <h2>User Login</h2>
                    <p>Enter Your Login Credentials</p>
                </div>
            </div>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                <div class="login-form">
                    <form id="userLoginForm">
                        <div class="form-group">
                            <label for="username">Username<span>*</span></label>
                            <input type="text" class="form-control" id= "username" name="username"
                                   placeholder="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password<span>*</span></label>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="password"
                                   required>
                        </div>
                        <div class="single-login single-login-2">
                            <button type="submit" id="userLoginBtn" class="btn btn-default">Login</button>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo site_url(); ?>/userController/loadRegister">Not a member? Register Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- user-login-area-end -->
</script>

<script type="text/template" id="loggedTemplate">
    <header>
        <!-- main-menu-area-start -->
        <div class="main-menu-area hidden-sm hidden-xs" id="header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="menu-area">
                            <nav>
                                <ul>
                                    <li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
                                    <li><a id ="logout-btn1" href="#">LogOut</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main-menu-area-end -->
        <!-- mobile-menu-area-start -->
        <div class="mobile-menu-area hidden-md hidden-lg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul id="nav">
                                    <li><a href="<?php echo site_url(); ?>">Home</a></li>
                                    <li><a id ="logout-btn2" href="#">LogOut</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>
    <!-- breadcrumbs-area-start -->
    <div class="breadcrumbs-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumbs-menu">
                        <ul>
                            <li><a href="<?php echo site_url(); ?>">Home</a></li>
                            <li>Current User: <span id="loginName"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner-area-start -->
    <div class="banner-area banner-res-large pb-50 pt-100 pb-145">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
    <!-- banner-area-end -->
</script>
<!-- user.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/user.js"></script>
<!-- main js -->
<script src="<?php echo base_url(); ?>js/main.js"></script>

</body>
</html>