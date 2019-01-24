<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
    <title>Wish List</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>img/favicon.png">

    <!-- all css start -->
    <!-- latest-bootstrap-version-4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <!-- all-js-start -->
    <!-- latest-jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- bootstrap 4.2.1 compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    <!-- all-js-end -->
</head>
<body>
<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand" href="#">Wish List Creator</a>
    <form class="form-inline">
        <a href="<?php echo site_url(); ?>" class="btn btn-primary" role="button">Login Or Register</a>
    </form>
</nav>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center">
                <h2><?php echo $name; ?>'s <?php echo $listName; ?> Wish List</h2>
                <p><?php echo $listDescription; ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
        <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
            <?php if(isset($items)) {
            foreach ($items as $item) { ?>
            <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0 text-center">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $item->itemId; ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $item->title; ?>
                        </button>
                    </h5>
                </div>
                <div id="collapse<?php echo $item->itemId; ?>" class="collapse" aria-labelledby="headingOne"
                     data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="form-group form-inline">
                            <label>Title:&emsp;</label>
                            <label><?php echo $item->title; ?></label>
                        </div>
                        <div class="form-group form-inline">
                            <label>URL:&emsp;</label>
                            <label><?php echo $item->url; ?></label>
                        </div>
                        <div class="form-group form-inline">
                            <label>Price(LKR):&emsp;</label>
                            <label><?php echo $item->price; ?></label>
                        </div>
                        <div class="form-group form-inline">
                            <label>Priority:&emsp;</label>
                            <label><?php echo $item->priority; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php } } ?>
        </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
    </div>
</div>
<footer class="page-footer font-small special-color-dark pt-4">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="https://www.raveen.me"> Raveen S Rathnayake</a>. All Right Reserved.
    </div>
    <!-- Copyright -->
</footer>

</body>
</html>