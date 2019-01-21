<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include 'Header.php' ?>
<!-- js file for Add to Cart -->
<script src="<?php echo base_url(); ?>js/manageCart.js"></script>
<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="<?php echo site_url(); ?>">Home</a></li>
                        <li><a href="#" class="active">Book Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbs-area-end -->
<?php if (isset($errorMessage)) {
    echo "<h3>" . $errorMessage . "</h3>";
} else { ?>
    <!-- product-main-area-start -->
    <div class="product-main-area mb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- product-main-area-start -->
                    <div class="product-main-area">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"></div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <div class="flexslider">
                                    <ul class="slides">
                                        <li data-thumb="<?php echo base_url() . $book->imageURL; ?>">
                                            <img src="<?php echo base_url() . $book->imageURL; ?>" alt="bookImage"/>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                                <div class="product-info-main">
                                    <div class="page-title">
                                        <h1><?php echo $book->title; ?></h1>
                                    </div>
                                    <div class="product-attribute">
                                        <span class="value"><?php echo $book->categoryTitle; ?></span>
                                        <span class="value"><i class="fa fa-angle-right"></i></span>
                                        <span class="value"><?php echo $book->subCategoryTitle; ?></span>
                                    </div>
                                    <div class="product-info-price">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td align="right" class=""><strong>Author:</strong></td>
                                                <td><?php echo $book->authorName; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class=""><strong>ISBN:</strong></td>
                                                <td><?php echo $book->isbnNo; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class=""><strong>Edition:</strong></td>
                                                <td><?php echo $book->edition; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class=""><strong>Publisher:</strong></td>
                                                <td><?php echo $book->publisherName; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class=""><strong>Available Qty:</strong></td>
                                                <td><?php echo $book->availableCopies; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right" class=""><strong>Price:</strong></td>
                                                <td>$<?php echo $book->price; ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="product-add-form">
                                        <form>
                                            <div class="quality-button">
                                                <input class="qty" type="number" value="1" min="1" id="quantity"
                                                       name="quantity">
                                            </div>
                                            <!-- store the base url to access in the js file -->
                                            <input type="text" class="hide" id="siteURL"
                                                   value="<?php echo site_url(); ?>"/>
                                            <button type="button" id="<?php echo $book->isbnNo; ?>"
                                                    class="btn btn-default"
                                                    onclick="addToCart(this.id)">Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product-main-area-end -->
                    <!-- product-info-area-start -->
                    <div class="product-info-area ">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-4 col-xs-12"></div>
                            <div class="col-lg-10 col-md-10 col-sm-4 col-xs-12">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="" data-toggle="tab" aria-expanded="true">Description</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="Description">
                                        <div class="valu">
                                            <p><?php echo $book->description; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-4 col-xs-12"></div>
                        </div>
                    </div>
                    <!-- product-info-area-end -->
                    <!-- new-book-area-start -->
                    <div class="new-book-area mt-60">
                        <div class="section-title text-center mb-30">
                            <h3>You May Also Like</h3>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"></div>
                            <div class="col-lg-8 col-md-8 col-sm-4 col-xs-12">
                                <div class="tab-active-2 owl-carousel">
                                    <?php foreach ($similarBooks as $book) { ?>
                                        <!-- single-product-start -->
                                        <div class="product-wrapper">
                                            <div class="product-img">
                                                <a href="<?php echo site_url() . '/visitor/viewBookDetails/?isbn='
                                                    . $book->isbnNo; ?>">
                                                    <img src="<?php echo base_url() . $book->imageURL; ?>" alt="book"
                                                         class="primary"/>
                                                </a>
                                            </div>
                                            <div class="product-details text-center">
                                                <h4><a href="<?php echo site_url() . '/visitor/viewBookDetails/?isbn='
                                                        . $book->isbnNo; ?>"><?php echo $book->title; ?></a></h4>
                                                <div class="product-price">
                                                    <ul>
                                                        <li>$<?php echo $book->price; ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-link">
                                                <div class="product-button">
                                                    <button type="button" id="<?php echo $book->isbnNo; ?>"
                                                            class="btn btn-default"
                                                            onclick="addToCart(this.id)">Add to Cart
                                                    </button>
                                                </div>
                                                <div class="add-to-link">
                                                    <ul>
                                                        <li>
                                                            <a href="<?php echo site_url() . '/visitor/viewBookDetails/?isbn='
                                                                . $book->isbnNo; ?>" title="Details"><i
                                                                        class="fa fa-external-link"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- single-product-end -->
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12"></div>
                        </div>
                    </div>
                    <!-- new-book-area-end -->
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- product-main-area-end -->
<?php include 'Footer.php' ?>
