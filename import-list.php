<?php include('php-assets/seller-header.php'); ?>
<!-- Sidebar Start -->
<?php include('php-assets/seller-sidenavbar.php'); ?>
<!-- Sidebar End -->

<!-- Topbar Start -->
<section class="home">
    <div class="textContent">
    <section class="py-5">
        <div class="container border-1 bg-white p-4">
          <h5 class="mt-4">Import Product</h5><br/>
          <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="icon-tab-0" data-bs-toggle="tab" href="#icon-tabpanel-0" role="tab" aria-controls="icon-tabpanel-0" aria-selected="true"><i class='bx bxs-shopping-bags'></i> Product</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="icon-tab-1" data-bs-toggle="tab" href="#icon-tabpanel-1" role="tab" aria-controls="icon-tabpanel-1" aria-selected="false"><i class='bx bxs-book-content'></i> Description</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="icon-tab-2" data-bs-toggle="tab" href="#icon-tabpanel-2" role="tab" aria-controls="icon-tabpanel-2" aria-selected="false"><i class='bx bxs-category-alt'></i> Variants</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="icon-tab-3" data-bs-toggle="tab" href="#icon-tabpanel-3" role="tab" aria-controls="icon-tabpanel-3" aria-selected="false"><i class="bx bx-image-alt"></i> Images</a>
              </li>
          </ul>
          <div class="tab-content pt-5" id="tab-content">
              <div class="tab-pane active" id="icon-tabpanel-0" role="tabpanel" aria-labelledby="icon-tab-0"> <div class="row gx-5">
              <div class="col-lg-1"></div>
              <aside class="col-lg-5 ">
                  <div class="border rounded-4 mb-3 d-flex justify-content-center">
                      <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp">
                          <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big.webp" />
                      </a>
                  </div>
              </aside>
              <main class="col-lg-5">
                <div class="ps-lg-3">
                  <h5><span class="title text-dark">Quality Men's Hoodie for Winter, Men's Fashion  Casual Hoodie</span></h5>
                  <form method="#">
                    <div class="form-group">
                    <label >Product Name:</label>
                    <input type= "text" placeholder="Product Name" class="form-control"><h5 class="title text-dark"></h5>
                    <div>
                    <div class="form-group">
                    <label >Product Tags:</label>
                    <input type= "text" placeholder="Prduct Tags" class="form-control"><h5 class="title text-dark"></h5>
                    <div>
                    <div class="form-group">
                    <label >Product Category:</label>
                    <input type= "text" placeholder="Product Category" class="form-control"><h5 class="title text-dark"></h5>
                    <div>
                    <div class="form-group">
                    <label >Collections(s):</label>
                    <input type= "text" placeholder="Collections" class="form-control" disabled><h5 class="title text-dark"></h5>
                    <div>
                  </form>
          </div>
            
          
        </div>
      </main>
      <div class="col-lg-1"></div>
    </div>
  </div>

  <!-- End product display -->
   
  <!-- product description -->
  <div class="tab-pane" id="icon-tabpanel-1" role="tabpanel" aria-labelledby="icon-tab-1">
    <div data-mdb-input-init class="form-outline mb-4">
    <textarea class="form-control" name="editor" id="editor"></textarea>
    
  </div>
  </div>
  <!-- End product description -->
  
  <!-- Variants -->
  <div class="tab-pane" id="icon-tabpanel-2" role="tabpanel" aria-labelledby="icon-tab-2">
    <table class="table table-striped">
    <thead>
      <tr>
        <th><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"></th>
        <th>Image</th>
        <th>Sku</th>
        <th>Farbe</th>
        <th>Size</th>
        <th>Inventory</th>
        <th>Cost</th>
        <th>Shipping</th>
        <th>Sales Price</th>
        <th>Profit</th>
        <th>Compare At Price</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="checkbox" id="variants" name="variants" ></td>
        <td><img src="<?php echo base_url() ?>assets/seller/img/cat-1.jpg" alt="product-image" width="40" height="40"></td>
        <td>91403122</td>
        <td>coffee</td>
        <td>M</td>
        <td>3
Low Stock</td>
        <td>$22.42 USD</td>
        <td>$4.00 USD</td>
        <td><input class="form-control" type="text" name="price-compare" value="$29.00"></td>
        <td>+2.64</td>
        <td><input class="form-control" type="text" name="price-compare"></td>
      

      </tr>
    </tbody>
  </table>
</div>
<!--End  Variants -->
  
  
  <!-- images -->
    <div class="tab-pane" id="icon-tabpanel-3" role="tabpanel" aria-labelledby="icon-tab-3">

      <div class="d-flex  mb-3">
          <!-- <a data-fslightbox="mygalley" class="mx-1 rounded-2" target="_blank" data-type="image" href="#" class="item-thumb"> -->
             
              <img class="lazy" width="150" height="150" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp">
              <img class="lazy" width="150" height="150" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp">
              <img class="lazy" width="150" height="150" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp">
              <img class="lazy" width="150" height="150" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp">
              <img class="lazy" width="150" height="150" src="https://mdbcdn.b-cdn.net/img/bootstrap-ecommerce/items/detail1/big1.webp">
          <!-- </a> -->
      </div>
     </div>
  <br/><br/>
  <div class="text-center">
            <a href="#" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i> Remove Product </a>
            <a href="#" class="btn btn-warning shadow-0"> Save</a>
            <a href="#" class="btn btn-warning shadow-0"> Push To Store </a>
</div>
</div>

<!-- images -->

</div> 
</section>

  <!-- Footer Start -->
  <?php include('php-assets/seller-footer.php'); ?>
  <!-- Footer End -->
   
