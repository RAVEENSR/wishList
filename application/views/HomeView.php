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
    <!-- style css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css">

    <!-- all-js-start -->
    <!-- latest-jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- bootstrap 4.2.1 compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    <!-- underscore js -->
    <script src="<?php echo base_url(); ?>js/underscore-min.js"></script>
    <!-- backbone js -->
    <script src="<?php echo base_url(); ?>js/backbone-min.js"></script>
    <!-- all-js-end -->
</head>
<body>
<div id="body-div"></div>
<footer class="page-footer font-small special-color-dark pt-4">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2019 Copyright:
        <a href="https://www.raveen.me"> Raveen S Rathnayake</a>. All Right Reserved.
    </div>
    <!-- Copyright -->
</footer>

<script type="text/template" id="loginTemplate">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="#">Wish List Creator</a>
        <form class="form-inline">
            <input class="form-control mr-sm-2" type="text" id="username" name="username" placeholder="username"
                   required>
            <input class="form-control mr-sm-2" type="password" id="password" name="password" placeholder="password"
                   required>
            <button type="button" class="btn btn-primary" id="login-btn">Login</button>
            <button type="button" class="btn btn-primary" id="register-btn">Register</button>
        </form>
    </nav>
    <!-- user-login-area-start -->
    <div class="container">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2>User Login Required</h2>
                    <p>Please Login to the system or register</p>
                </div>
            </div>
        </div>
    </div>
    <!-- user-login-area-end -->
</script>
<script type="text/template" id="loggedTemplate">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="#">Wish List Creator</a>
        <form class="form-inline">
            <label style="margin-right: 24px;margin-top: 4px;"><span>Hi &nbsp</span><span id="loginName"></span></label>
            <button type="button" class="btn btn-primary" id="logout-btn">Logout</button>
        </form>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2 id="listName">User Wish List</h2>
                    <p id="listDescription">Details</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                    <div  id="wishList"></div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
        </div>
    </div>
    <div class="container pt-40">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2>Create Wish List Item</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" class="form-control" id="add-title" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="url">URL*</label>
                        <input type="text" class="form-control" id="add-url" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <label for="price">Price (LKR)*</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="add-price" name="price"
                               placeholder="Ex: 10.00" required>
                    </div>
                    <div class="form-group">
                        <label for="priority">Priority<span>*</span></label>
                        <select class="form-control" id="add-priority">
                            <option value=1>Must Have(1)</option>
                            <option value=2>Would be nice to have(2)</option>
                            <option value=3>If you can(3)</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-primary" id="add-item-btn">Add Item</button>
                </form>
            </div>
        </div>
    </div>
    <div class="container pt-40">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2>Request a wish list share link</h2>
                    <button type="button" class="btn btn-primary" id="get-share-link">Generate</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                <div class="text-center">
                    <span id="shareLink"></span>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12"></div>
        </div>
    </div>
</script>
<script id="itemTemplate" type="text/html">
    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h5 class="mb-0 text-center">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<%= cardId %>"
                            aria-expanded="true" aria-controls="collapseOne">
                        <%= title %>
                    </button>
                    <button type="button" class="btn btn-danger remove-item float-right">Delete</button>
                </h5>
            </div>
            <div id="collapse<%= cardId %>" class="collapse" aria-labelledby="headingOne"
                 data-parent="#accordionExample">
                <div class="card-body">
                    <div class="form-group form-inline">
                        <label>Title:&emsp;</label>
                        <div class="view">
                            <label><%- title %></label>
                        </div>
                    </div>
                    <input class="edit name" value="<%- title %>" type="text">
                    <div class="form-group form-inline">
                        <label>URL:&emsp;</label>
                        <div class="view">
                            <label><%- url %></label>
                        </div>
                    </div>
                    <input class="edit url" value="<%- url %>" type="text">
                    <div class="form-group form-inline">
                        <label>Price(LKR):&emsp;</label>
                        <div class="view">
                            <label><%- price %></label>
                        </div>
                    </div>
                    <input type="number" step="0.01" min="0" class="edit price" name="price" value="<%- price %>"
                           placeholder="Ex: 10.00" required>
                    <div class="form-group form-inline">
                        <label>Priority:&emsp;</label>
                        <div class="view">
                            <label><%- priority %></label>
                        </div>
                    </div>
                    <select class="edit priority" value="<%- priority %>">
                        <option value=1>Must Have(1)</option>
                        <option value=2>Would be nice to have(2)</option>
                        <option value=3>If you can(3)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</script>
<script type="text/template" id="registerTemplate">
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="navbar-brand" href="<?php echo site_url(); ?>">Home</a>
        <form class="form-inline">
            <a class="btn btn-primary" href="<?php echo site_url(); ?>" role="button">Login</a>
        </form>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2>User Registration</h2>
                    <p>Please enter user details to register the new user</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Username*</label>
                            <input class="form-control" type="text" id="username" name="username" placeholder="Username"
                                   required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password*</label>
                            <input class="form-control" type="password" id="password" name="password"
                                   placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name*</label>
                        <input type="text" class="form-control" id="name" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <label for="listName">List Name*</label>
                        <input type="text" class="form-control" id="listName" placeholder="List Name">
                    </div>
                    <div class="form-group">
                        <label for="listDescription">List Description*</label>
                        <textarea class="form-control" id="listDescription" placeholder="List Description"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" id="register-btn1">Register</button>
                </form>
            </div>
        </div>
    </div>
</script>
<!-- user.js -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/modelsAndUsers.js"></script>

</body>
</html>