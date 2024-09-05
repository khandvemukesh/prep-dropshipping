<?php
if ($categoryData['status'] == true) {
    foreach ($categoryData['data'] as $categoryObj) {
?>
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="">
                <div class="cat-item d-flex shadow-sm align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 70px; height: 70px;">
                        <img class="img-fluid" src="<?php echo $categoryObj['image'] ?>" alt="">
                    </div>
                    <div class="flex-fill pl-3">
                        <h6><?php echo $categoryObj['name'] ?></h6>
                        <small class="text-body"><?php echo $categoryObj['no_of_product'] ?> Products</small>
                    </div>
                </div>
            </a>
        </div>
<?php
    }
}
?>