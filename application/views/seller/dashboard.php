<?php include('php-assets/seller-header.php'); ?>
<!-- Sidebar Start -->
<?php include('php-assets/seller-sidenavbar.php'); ?>
<!-- Sidebar End -->

<!-- Topbar Start -->
<section class="home">
    <div class="textContent">
        <div class="container-fluid pb-3 pt-3">
            <div class="row align-items-center  py-3 px-xl-5 d-none d-lg-flex">

                <div class="col-lg-12  col-6 text-left">
                    <form action="">
                        <div class="input-group rounded">
                            <input type="text" class="form-control" placeholder="Search for products">
                            <div class="input-group-append">
                                <span class="input-group-text bg-transparent text-primary">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="container pb-5 mb-4 pt-3 border-1">
                <div class="row align-items-center  py-3  d-none d-lg-flex">
                    <div class="col-lg-12 row col-6 ">
                        <div class="col-lg-1 col-md-4 col-sm-6 pb-1">
                            <a class="text-decoration-none" href="">
                                <div class="cat-item p-3 d-flex shadow-sm align-items-center border-1 rounded ">

                                    <div class="flex-fill text-center">
                                        <i class='bx bx-plus icon'></i>

                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-1 col-md-4 col-sm-6 pb-1">
                            <a class="text-decoration-none" href="">
                                <div class="cat-item p-3 d-flex shadow-sm align-items-center border-1 rounded ">

                                    <div class="flex-fill text-center">
                                        <i class='bx bx-plus icon'></i>

                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>




                <!-- Categories Start -->
                <?php include('php-assets/seller-product-categories.php'); ?>
                <!-- Categories End -->

                <!-- Offer Start -->
                <?php include('php-assets/seller-offer.php'); ?>
                <!-- Offer End -->

                <!-- Products Start -->
                <?php include('php-assets/seller-feature-products.php'); ?>
                <!-- Products End -->

                <!-- Products Start -->
                <?php //include('php-assets/seller-recent-products.php'); 
                ?>
                <!-- Products End -->

                <!-- Shipping Start -->
                <?php //include('php-assets/seller-term-shipping.php'); 
                ?>
                <!-- Shipping End -->

                <!-- Vendor Start -->
                <?php //include('php-assets/seller-client.php'); 
                ?>
                <!-- Vendor End -->
            </div>
            <?php include('php-assets/seller-footer-product.php'); ?>
            <!-- Footer End -->

            <script>
                $(document).ready(function() {
                    getCategoryData();
                    getProductData();

                    $(window).scroll(function() {
                        if ($(window).scrollTop() == $(document).height() - $(window).height()) {
                            getProductData();
                        }
                    })
                })
            </script>