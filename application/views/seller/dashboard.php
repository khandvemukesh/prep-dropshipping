<?php include('php-assets/seller-header.php'); ?>
<!-- Sidebar Start -->
<?php include('php-assets/seller-sidenavbar.php'); ?>
<!-- Sidebar End -->

<!-- Topbar Start -->
<section class="home-section">
      <div class="home-content">
            <i class="bx bx-menu text-white"></i>
      </div>
      <!-- Categories Start -->
      <?php include('php-assets/seller-product-categories.php'); ?>
      <!-- Categories End -->

      <?php
      include('php-assets/seller-offer.php');
      ?>

      <!-- Products Start -->
      <?php include('php-assets/seller-feature-products.php'); ?>
      <!-- Products End -->

      <!-- Offer Start -->

      <!-- Offer End -->

      <!-- Products Start -->
      <?php //include('php-assets/seller-recent-products.php'); 
      ?>
      <!-- Products End -->

      <!-- Shipping Start -->

      <!-- Footer Start -->
      <?php include('php-assets/seller-footer-product.php'); ?>
      <!-- Footer End -->

      <script>
            $(document).ready(function() {
                  getCategoryData();
                  getProductData();
            })
      </script>