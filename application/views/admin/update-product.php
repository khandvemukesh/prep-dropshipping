<?php include('header.php');
$pageName = "product";
$subPageName = "add_product";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
    <style>
        .preview-img {
            width: 200px;
            height: 200px;
            margin-right: 10px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("php-assets/loader.php") ?>
        <?php include("php-assets/nav-bar.php") ?>
        <?php include("php-assets/side-bar.php") ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Update Product</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Update Product</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Create Product</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="updateProductForm">
                                        <input type="hidden" name="product_id" value="<?php echo $productObj->id ?>">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="date" value="<?php echo sys_date() ?>">
                                        <input type="hidden" name="time" value="<?php echo sys_time() ?>">
                                        <input type="hidden" name="ip" value="<?php echo getRealIpAddr() ?>">
                                        <input type="hidden" name="byid" value="<?php echo $byId ?>">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Shop Type <span id="shopTypeMessage"></span></label>
                                                <select class="form-control" name="shop_type" id="shop_type" onblur="checkDetails('shop_type','shopTypeMessage');" required>
                                                    <option value="">-- Select Shop Type --</option>
                                                    <?php
                                                    foreach ($shopTypeData->result() as $shopTypeObj) {
                                                        if ($shopTypeObj->id == $productObj->shop_type) $selection_status = 'selected';
                                                        else $selection_status = '';
                                                    ?>
                                                        <option value="<?php echo $shopTypeObj->id ?>" <?php echo $selection_status ?>><?php echo $shopTypeObj->name ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Product Name <span id="productNameMessage"></span></label>
                                                <input type="text" class="form-control" name="product_name" id="productname" onblur="checkDetails('productname','productNameMessage');" placeholder="Product Name" value="<?php echo $productObj->product_name ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Title <span id="titleMessage"></span></label>
                                                <input type="text" class="form-control" name="title" id="title" onblur="checkDetails('title','titleMessage');" value="<?php echo $productObj->title ?>" placeholder="Title" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Category <span id="categoryMessage"></span></label>
                                                <select class="form-control" name="category_id" id="category" required onchange="getOptions('category_id','categoryMessage','sub_category','category',this.value,'sub_category_id','name');">
                                                    <option value="">-- Select Category --</option>
                                                    <?php
                                                    foreach ($categoryData->result() as $categoryObj) {
                                                        if ($categoryObj->id == $productObj->category) $selection_status = 'selected';
                                                        else $selection_status = '';
                                                    ?>
                                                        <option value="<?php echo $categoryObj->id ?>" <?php echo $selection_status ?>><?php echo $categoryObj->name ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Sub Category <span id="subCategoryMessage"></span></label>
                                                <select class="form-control" name="sub_category_id" id="subCategory" onblur="checkDetails('subCategory','subCategoryMessage');" required>
                                                    <option value="">-- Select Category --</option>
                                                    <?php
                                                    foreach ($subCategoryData->result() as $subCategoryObj) {
                                                        if ($subCategoryObj->id == $productObj->sub_category) $selection_status = 'selected';
                                                        else $selection_status = '';
                                                    ?>
                                                        <option value="<?php echo $subCategoryObj->id ?>" <?php echo $selection_status ?>><?php echo $subCategoryObj->name ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Brand <span id="brandMessage"></span></label>
                                                <input type="text" class="form-control" name="brand" id="brand" onblur="checkDetails('brand','brandMessage');" placeholder="Brand Name" value="<?php echo $productObj->brand ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Country Of Origin <span id="originMessage"></span></label>
                                                <input type="text" class="form-control" name="origin" id="origin" onblur="checkDetails('origin','originMessage');" placeholder="Country Of Origin" value="<?php echo $productObj->origin ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> GST Percent <span id="gstPercentMessage"></span></label>
                                                <input type="number" class="form-control" name="gst_percent" id="gst_percent" onblur="checkDetails('gst_percent','gstPercentMessage');" placeholder="GST Percent" value="<?php echo $productObj->gst_percent ?>" required>
                                            </div>
                                            <input type="hidden" name="gst_type" value="included">
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> HSN <span id="hsnMessage"></span></label>
                                                <input type="text" class="form-control" name="hsn" id="hsn" onblur="checkDetails('hsn','hsnMessage');" placeholder="HSN" value="<?php echo $productObj->hsn ?>" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="form-label"><span class="text-danger">*</span> Description <span id="descriptionMessage"></span></label>
                                                <textarea class="form-control" name="description" id="description" onblur="checkDetails('description','descriptionMessage');" placeholder="Complete Description" required rows="16"><?php echo $productObj->description ?></textarea>
                                            </div>
                                            <div class="form-group col-md-4 text-center">
                                                <label>Home Image</label>
                                                <center>
                                                    <img id="blah" src="<?php echo base_url() ?>image/product/<?php echo $productObj->home_image ?>" alt="Product Image" class="img img-thumbnail img-responsive" width="150" height="150">
                                                </center>
                                                <input type="hidden" name="oldImage" value="<?php echo $productObj->home_image ?>">
                                                <input class="form-control" type='file' onchange="readURL(this);" id="image" name="home_image" accept="image/*" />
                                            </div>
                                            <div class="form-group col-md-4 text-center">
                                                
                                                <div class="col-md-12 img-preview p-2">
                                                <?php
                                                if ($productImagesData->num_rows() > 0) {
                                                    foreach ($productImagesData->result() as $productImagesObj) {
                                                ?>
                                                        <img src="<?php echo base_url() . 'image/product/' . $productImagesObj->image ?>" class="preview-img">
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                                
                                                <label class="form-label"><span class="text-danger">*</span> Select Multiple Images <span id="productImageMessage"></span></label>
                                                <input class="form-control" type='file' id="product_images" name="product_images[]" onblur="checkDetails('product_images','productImageMessage');" multiple accept="image/*" />
                                            </div>
                                            

                                            <div class="col-md-12" style="text-align: center;">
                                                <hr>
                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add Product</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include("php-assets/foot-section.php") ?>

    <script>
        $(document).on("submit", "#updateProductForm", function(e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addProductFunction/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Product Successfully Added!!!!', 'success');
                        setTimeout(function() {
                            window.location.href = "<?php echo base_url() ?>admin-view-product/";
                        }, 2000);
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).addClass('preview-img').attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#product_images').on('change', function() {
                imagesPreview(this, 'div.img-preview');
            });
        });
    </script>
</body>

</html>