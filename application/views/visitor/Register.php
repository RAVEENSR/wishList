<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- js file for Admin Login -->
<script src="<?php echo base_url(); ?>js/userRegister.js"></script>
<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li><a href="#" class="active">Register User</a></li>
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
                    <h2>User Registration</h2>
                    <p>Enter User Details</p>
                </div>
            </div>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
                <div class="login-form">
                    <form id="userRegistrationForm" action="<?php echo site_url(); ?>/userController/registerUser"
                          method="POST">
                        <div class="form-group">
                            <label for="name">Name<span>*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="name" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username<span>*</span></label>
                            <input type="text" class="form-control" name="username" placeholder="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password<span>*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="password"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="listName">List Name<span>*</span></label>
                            <input type="text" class="form-control" name="listName" placeholder="list name" required>
                        </div>
                        <div class="form-group">
                            <label for="listDescription">List Description<span>*</span></label>
                            <input type="text" class="form-control" name="listDescription"
                                   placeholder="list description" required>
                        </div>
                        <div class="single-login single-login-2">
                            <button type="submit" id="userRegisterBtn" class="btn btn-default">Register</button>
                        </div>
                        <!-- store the base url to access in the js file -->
                        <input type="text" class="hide" id="siteURL" value="<?php echo site_url(); ?>"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- user-login-area-end -->
