<?php
if ($bannerData->num_rows() > 0) {
    $i = 1;
    foreach ($bannerData->result() as $bannerObj) {
        $category_td = "";
        $banner_type = $bannerObj->banner_type;
        $banner_for = $bannerObj->banner_for;
        $position = $bannerObj->position;
        $banner_type_name = $position_name = $banner_for_name = '';
        if ($banner_type == 1) {
            $banner_type_name = 'Home Page Banner';
        } elseif ($banner_type == 2) {
            $banner_type_name = 'Category Page Banner';
            $category_td = '<td>' . getDataByVal('name', 'category', array('id' => $bannerObj->category_id)) . '</td>';
        } elseif ($banner_type == 3)
            $banner_type_name = 'Brand Page Banner';

        if ($banner_for == 1) {
            $banner_for_name = 'Ecommerce';
        } else
            $banner_for_name = 'Grocery';

        if ($position == 1)
            $position_name = 'On Top';
        elseif ($position == 2)
            $position_name = 'After Category';
        elseif ($position == 3)
            $position_name = 'After Brands';
        elseif ($position == 4)
            $position_name = 'After Products';
        ?>
        <tr>
            <td>
                <?php echo $i ?>
            </td>
            <td>
                <?php echo $banner_for_name ?>
            </td>
            <td>
                <?php echo $banner_type_name ?>
            </td>
            <?php echo $category_td ?>
            <td>
                <?php echo $position_name ?>
            </td>
            <td>
                <img src="<?php echo base_url() ?>image/banner/<?php echo $bannerObj->image ?>" class="img-open"
                    style="height:60px;">
            </td>
            <td>
                <button type="button" class="btn btn-xs btn-danger"
                    onclick="deleteBanner('<?php echo $bannerObj->id ?>', '<?php echo $banner_type ?>');"><i
                        class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php
        $i++;
    }
}
?>