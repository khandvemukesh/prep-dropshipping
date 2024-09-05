<div class="row">
    <?php
    if ($imageData->num_rows() > 0) {
        foreach ($imageData->result() as $imageObj) {
            ($imageObj->image == $home_image) ? $default_status = true : $default_status = false;
            ?>
            <div class="col-md-3">
                <div style="padding:10px;border:1px solid #ececec;text-align:center;" class="img-container">
                    <?php
                    if ($default_status == true) {
                        ?>
                        <span style="padding: 5px;background: #17a2b8;float: right;color: #f5f5f5;position:absolute;right:22px;">
                            Default
                        </span>
                        <?php
                    }
                    ?>
                    <img src="<?php echo base_url() ?>image/product/<?php echo $imageObj->image ?>"
                        style="width:220px;height:300px;" class="product-img">
                    <div class="product-overlay"></div>
                    <span></span>
                    <div class="product-button">
                        <?php
                        if ($default_status == false) {
                            ?>
                            <a href="#"
                                onclick="imageSetAsDefault('<?php echo $imageObj->image ?>', '<?php echo $imageObj->product_id ?>')">
                                Set As Default
                            </a>
                            <?php
                        }
                        ?>
                        <a href="#" style="margin-top: 68px;position: absolute;right: 72px;"
                            onclick="deleteImage('<?php echo $imageObj->id ?>')"> Delete </a>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>