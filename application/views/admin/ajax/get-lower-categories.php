<?php
if ($categoryData->num_rows() > 0) {
    foreach ($categoryData->result() as $categoryObj) {
        ?>
        <div class="col-sm-2 text-center p-2">
            <div class="p-3" style="box-shadow: 0px 0px 3px 2px #cfccc3;border-radius: 5px;"
                onclick="getSubCategories('<?php echo id_encode($categoryObj->id) ?>');">
                <img src="<?php echo base_url() . 'image/category/' . $categoryObj->image ?>"
                    alt="<?php echo $categoryObj->name ?>" class="img img-circle img-thumbnail"
                    style="width:100px;height:100px;">
                <p>
                    <?php echo $categoryObj->name ?>
                </p>
                <button type="button" class="btn btn-info btn-xs"
                    onclick="getSubCategories('<?php echo id_encode($categoryObj->id) ?>');">Select</button>
            </div>
        </div>
        <?php
    }
}
?>