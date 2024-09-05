<?php include('header.php') ?>
<?php $pageName = "product"; ?>
<?php $subPageName = "add_product"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $company_name ?> | Add Product
    </title>
    <?php include('php-assets/head-section.php') ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/summernote-bs4.min.css">
    <style>
        .preview-img {
            width: 200px;
            height: 200px;
            margin-right: 10px;
        }

        .product-overlay {
            position: absolute;
            top: 10px;
            left: 20px;
            width: 85%;
            height: 95%;
            background: rgba(0, 0, 0, 0);
            transition: background 0.5s ease;
        }

        .img-container:hover .product-overlay {
            display: block;
            background: rgba(0, 0, 0, .3);
        }

        .product-button {
            position: absolute;
            width: 265px;
            left: 0;
            top: 90px;
            text-align: center;
            opacity: 0;
            transition: opacity .35s ease;
        }

        .product-button a {
            width: 120px;
            padding: 12px 10px;
            text-align: center;
            color: white;
            border: solid 2px white;
            z-index: 1;
        }

        .product-button1 {
            position: absolute;
            width: 265px;
            left: 0;
            top: 130px;
            text-align: center;
            opacity: 0;
            transition: opacity .35s ease;
        }

        .product-button1 a {
            width: 120px;
            padding: 12px 10px;
            text-align: center;
            color: white;
            border: solid 2px white;
            z-index: 1;
        }

        .img-container:hover .product-button {
            opacity: 1;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include("php-assets/loader.php") ?>
        <?php include("php-assets/nav-bar.php") ?>
        <?php include("php-assets/side-bar.php") ?>
        <input type="hidden" name="shop_type" id="shop_type_id">
        <input type="hidden" name="category_id" id="category_id">
        <input type="hidden" name="sub_category_id" id="sub_category_id">
        <input type="hidden" name="brand_id" id="brand_id">

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Product Details Add & Update</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Product Details Add & Update</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-edit"></i>
                                        Create Product
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if($product_id != "")
                                        $product_name = getDataByVal('product_name', 'product', array('id' => $product_id));
                                    else
                                        $product_name = "";
                                    ?>
                                    <div class="row mb-2">
                                        <div class="col-md-3">
                                            <h4>Add Product Details</h4>
                                        </div>
                                        <?php
                                        if($product_id != "") {
                                            ?>
                                                                <div class="col-md-9 text-right">
                                                                    <span class="">Product Name: </span>
                                                                    <span class="text-danger font-weight-bold">
                                                                        <?php echo $product_name ?>
                                                                    </span>
                                                                    <br>
                                                                    <span class="">Super Category: </span>
                                                                    <span class="text-danger font-weight-bold">
                                                                        <?php echo $shop_type_name ?>
                                                                    </span>
                                                                    <br>
                                                                    <span class="">Category: </span>
                                                                    <span class="text-danger font-weight-bold">
                                                                        <?php echo getDataByVal('name', 'category', array('id' => $category_id)) ?>
                                                                    </span>
                                                                    <br>
                                                                    <span class="">SubCategory: </span>
                                                                    <span class="text-danger font-weight-bold">
                                                                        <?php echo getDataByVal('name', 'sub_category', array('id' => $sub_category_id)) ?>
                                                                    </span>
                                                                </div>
                                                                <?php
                                        }
                                        ?>
                                    </div>
                                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist"
                                        style="background: #0a8693;">
                                        <li class="nav-item">
                                            <a class="nav-link text-white active" id="basicDetailsTab"
                                                data-toggle="pill" href="#basicDetails" role="tab"
                                                aria-controls="basicDetails" aria-selected="true">Basic
                                                Details</a>
                                        </li>
                                        <?php
                                        $shop_type_name_lower = strtolower($shop_type_name);
                                        $shopTypeNameArr = explode(' ', $shop_type_name_lower);
                                        if($product_id != "") {
                                            if(in_array('mobile', $shopTypeNameArr) != false || in_array('electronics', $shopTypeNameArr) != false) {
                                                ?>
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link text-white" id="mobileUnitTab" data-toggle="pill"
                                                                                                href="#mobileUnit" role="tab" aria-controls="mobileUnit"
                                                                                                aria-selected="false">Add RAM, ROM & Price</a>
                                                                                        </li>
                                                                                        <?php
                                            } else {
                                                ?>
                                                                                        <li class="nav-item">
                                                                                            <a class="nav-link text-white" id="unitAndPricesTab" data-toggle="pill"
                                                                                                href="#unitAndPrices" role="tab" aria-controls="unitAndPrices"
                                                                                                aria-selected="false" onclick="listUnitData();">Unit & Prices</a>
                                                                                        </li>
                                                                                        <?php
                                            }
                                            ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link text-white" id="productSizeTab" data-toggle="pill"
                                                                        href="#productSize" role="tab" aria-controls="productSize"
                                                                        aria-selected="false">Add Size & Prices</a>
                                                                </li>

                                                                <li class="nav-item">
                                                                    <a class="nav-link text-white" id="productColorTab" data-toggle="pill"
                                                                        href="#productColor" role="tab" aria-controls="productColor"
                                                                        aria-selected="false">Add Colors & Prices</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link text-white" id="otherDetailsTab" data-toggle="pill"
                                                                        href="#otherDetails" role="tab" aria-controls="otherDetails"
                                                                        aria-selected="false">Specifications</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link text-white" id="uploadImagesTab" data-toggle="pill"
                                                                        href="#uploadImages" role="tab" aria-controls="uploadImages"
                                                                        aria-selected="false">Upload Images</a>
                                                                </li>
                                                                <?php
                                        }
                                        ?>
                                    </ul>
                                    <div class="tab-content" id="custom-content-below-tabContent">

                                        <div class="tab-pane fade show active" id="basicDetails" role="tabpanel"
                                            aria-labelledby="basicDetailsTab">
                                            <div class="col-12 mt-3">
                                                <form method="POST" id="createProductForm">
                                                    <?php
                                                    if($product_id != "") {
                                                        $productDataObj = getAllDataByVal('product', array('id' => $product_id))->row();
                                                        $product_name = $productDataObj->product_name;
                                                        $title = $productDataObj->title;
                                                        $brand_id = $productDataObj->brand;
                                                        $origin = $productDataObj->origin;
                                                        $gst_percent = $productDataObj->gst_percent;
                                                        $hsn = $productDataObj->hsn;
                                                        $description = $productDataObj->description;
                                                        $disclaimer = $productDataObj->disclaimer;
                                                        $additional_detaiils = $productDataObj->additional_detaiils;
                                                        ?>
                                                                            <input type="hidden" name="product_id" id="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <?php
                                                    } else {
                                                        $product_name = "";
                                                        $title = "";
                                                        $brand_id = "";
                                                        $origin = "India";
                                                        $gst_percent = 0;
                                                        $hsn = 0;
                                                        $description = "";
                                                        $disclaimer = "";
                                                        $additional_detaiils = "";
                                                    }
                                                    ?>
                                                    <input type="hidden" name="shop_type" id="shop_type"
                                                        value="<?php echo $shop_type ?>">
                                                    <input type="hidden" name="category_id" id="category_id"
                                                        value="<?php echo $category_id ?>">
                                                    <input type="hidden" name="sub_category_id" id="sub_category_id"
                                                        value="<?php echo $sub_category_id ?>">
                                                    <input type="hidden" name="status" value="1">
                                                    <input type="hidden" name="date" value="<?php echo sys_date() ?>">
                                                    <input type="hidden" name="time" value="<?php echo sys_time() ?>">
                                                    <input type="hidden" name="ip"
                                                        value="<?php echo getRealIpAddr() ?>">
                                                    <input type="hidden" name="byid" value="<?php echo $byId ?>">
                                                    <div class="row">
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Product Name <span
                                                                    id="productNameMessage"></span></label>
                                                            <input type="text" class="form-control" name="product_name"
                                                                id="productname"
                                                                onblur="checkDetails('productname','productNameMessage');"
                                                                placeholder="Product Name"
                                                                value="<?php echo $product_name ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Title <span id="titleMessage"></span></label>
                                                            <input type="text" class="form-control" name="title"
                                                                id="title"
                                                                onblur="checkDetails('title','titleMessage');"
                                                                placeholder="Title" value="<?php echo $title ?>"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Brand <span id="brandMessage"></span></label>
                                                            <select class="form-control" name="brand" id="brand"
                                                                onblur="checkDetails('brand','brandMessage');">
                                                                <option value="">-- Select Brand --</option>
                                                                <?php
                                                                if($brandData->num_rows() > 0) {
                                                                    foreach($brandData->result() as $brandObj) {
                                                                        ($brandObj->id == $brand_id) ? $select_status_brand = 'selected' : $select_status_brand = '';
                                                                        ?>
                                                                                                                <option <?php echo $select_status_brand ?>
                                                                                                                    value="<?php echo $brandObj->id ?>">
                                                                                                                    <?php echo $brandObj->name ?>
                                                                                                                </option>
                                                                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Country Of
                                                                Origin <span id="originMessage"></span></label>
                                                            <input type="text" class="form-control" name="origin"
                                                                id="origin"
                                                                onblur="checkDetails('origin','originMessage');"
                                                                placeholder="Country Of Origin"
                                                                value="<?php echo $origin ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                GST Percent
                                                                <span id="gstPercentMessage"></span></label>
                                                            <input type="number" class="form-control" name="gst_percent"
                                                                id="gst_percent"
                                                                onblur="checkDetails('gst_percent','gstPercentMessage');"
                                                                placeholder="GST Percent"
                                                                value="<?php echo $gst_percent ?>" required>
                                                        </div>
                                                        <input type="hidden" name="gst_type" value="included">
                                                        <div class="form-group col-md-4">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                HSN
                                                                <span id="hsnMessage"></span></label>
                                                            <input type="text" class="form-control" name="hsn" id="hsn"
                                                                onblur="checkDetails('hsn','hsnMessage');"
                                                                placeholder="HSN" value="<?php echo $hsn ?>" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Description
                                                                <span id="descriptionMessage"></span></label>
                                                            <textarea class="form-control" name="description"
                                                                id="description"
                                                                onblur="checkDetails('description','descriptionMessage');"
                                                                placeholder="Complete Description" required
                                                                rows="14"><?php echo $description ?></textarea>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label class="form-label"><span class="text-danger">*</span>
                                                                Disclaimer
                                                                <span id="disclaimerMessage"></span></label>
                                                            <textarea class="form-control" name="disclaimer"
                                                                id="disclaimer"
                                                                onblur="checkDetails('disclaimer','disclaimerMessage');"
                                                                placeholder="Disclaimer" required
                                                                rows="14"><?php echo $disclaimer ?></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="form-label"> Additional Details</label>
                                                            <textarea class="form-control" name="additional_detaiils"
                                                                id="additional_detaiils" placeholder="Addtional Details"
                                                                rows="14"><?php echo $additional_detaiils ?></textarea>
                                                        </div>
                                                        <div class="col-md-12" style="text-align: center;">
                                                            <hr>
                                                            <button type="submit" class="btn btn-sm btn-info"><i
                                                                    class="fa fa-plus"></i> Create Product And
                                                                Continue</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <?php
                                        if($product_id != "") {
                                            ?>
                                                                <div class="tab-pane fade" id="unitAndPrices" role="tabpanel"
                                                                    aria-labelledby="unitAndPricesTab">
                                                                    <div class="col-12 mt-3">
                                                                        <form method="POST" id="addUitForm">
                                                                            <input type="hidden" name="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger"> *</span>
                                                                                        Unit Value
                                                                                        <span id="unitValueMessage"></span>
                                                                                    </label>
                                                                                    <input type="number" class="form-control" name="unit_value"
                                                                                        id="unit_value"
                                                                                        onblur="checkDetails('unit_value','unitValueMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger">*</span>
                                                                                        Unit
                                                                                        <span id="unitMessage"></span>
                                                                                    </label>
                                                                                    <select class="form-control" name="unit_id" id="unit"
                                                                                        onblur="checkDetails('unit','unitMessage');" required>
                                                                                        <option value="">-- Select Unit --</option>
                                                                                        <?php
                                                                                        foreach($unitData->result() as $unitObj) {
                                                                                            ?>
                                                                                                                <option value="<?php echo $unitObj->id ?>">
                                                                                                                    <?php echo $unitObj->name ?>
                                                                                                                </option>
                                                                                                                <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger">*</span>
                                                                                        Unit Sales Price<span id="unitSalesPriceMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="selling_price"
                                                                                        id="unit_sales_price"
                                                                                        onblur="checkDetails('unit_sales_price','unitSalesPriceMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label"><span class="text-danger">*</span>
                                                                                        Unit MRP
                                                                                        <span id="unitMrpMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="mrp"
                                                                                        id="unit_mrp"
                                                                                        onblur="checkDetails('unit_mrp','unitMrpMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label"><span
                                                                                            class="text-danger">*</span>Stock Status<span
                                                                                            id="currentStockMessage"></span></label>
                                                                                    <select class="form-control" name="stock_status"
                                                                                        id="stock_status"
                                                                                        onblur="checkDetails('stock_status','currentStockMessage');"
                                                                                        required>
                                                                                        <option value="1">Available</option>
                                                                                        <option value="0">Not Available</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-12" style="text-align: center;">
                                                                                    <hr>
                                                                                    <button type="submit" class="btn btn-sm btn-info"><i
                                                                                            class="fa fa-plus"></i> Add Details</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                        <table id="unitDataListing"
                                                                            class="table table-bordered table-striped table-sm">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Unit Value</th>
                                                                                    <th>Unit</th>
                                                                                    <th>Selling Price</th>
                                                                                    <th>MRP</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Unit Value</th>
                                                                                    <th>Unit</th>
                                                                                    <th>Selling Price</th>
                                                                                    <th>MRP</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="mobileUnit" role="tabpanel"
                                                                    aria-labelledby="mobileUnitTab">
                                                                    <div class="col-12 mt-3">
                                                                        <form method="POST" id="addMobileUnitForm">
                                                                            <input type="hidden" name="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger"> *</span>
                                                                                        RAM Size Value
                                                                                        <span id="ramSizeMessage"></span>
                                                                                    </label>
                                                                                    <input type="number" class="form-control" name="ram_size"
                                                                                        id="ram_size"
                                                                                        onblur="checkDetails('ram_size','ramSizeMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-1">
                                                                                    <label class="form-label">
                                                                                        Type
                                                                                    </label>
                                                                                    <select class="form-control" name="ram_size_type"
                                                                                        id="ram_size_type" required>
                                                                                        <option value="GB">GB</option>
                                                                                        <option value="MB">MB</option>
                                                                                        <option value="TB">TB</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger"> *</span>
                                                                                        ROM Size Value
                                                                                        <span id="romSizeMessage"></span>
                                                                                    </label>
                                                                                    <input type="number" class="form-control" name="rom_size"
                                                                                        id="rom_size"
                                                                                        onblur="checkDetails('rom_size','romSizeMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-1">
                                                                                    <label class="form-label">
                                                                                        Type
                                                                                    </label>
                                                                                    <select class="form-control" name="rom_size_type"
                                                                                        id="rom_size_type" required>
                                                                                        <option value="GB">GB</option>
                                                                                        <option value="MB">MB</option>
                                                                                        <option value="TB">TB</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger">*</span>
                                                                                        Unit Sales Price<span id="unitSalesPriceMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="selling_price"
                                                                                        id="unit_sales_price"
                                                                                        onblur="checkDetails('unit_sales_price','unitSalesPriceMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label"><span class="text-danger">*</span>
                                                                                        Unit MRP
                                                                                        <span id="unitMrpMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="mrp"
                                                                                        id="unit_mrp"
                                                                                        onblur="checkDetails('unit_mrp','unitMrpMessage');"
                                                                                        required>
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label"><span
                                                                                            class="text-danger">*</span>Stock Status<span
                                                                                            id="currentStockMessage"></span></label>
                                                                                    <select class="form-control" name="stock_status"
                                                                                        id="stock_status"
                                                                                        onblur="checkDetails('stock_status','currentStockMessage');"
                                                                                        required>
                                                                                        <option value="1">Available</option>
                                                                                        <option value="0">Not Available</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-12" style="text-align: center;">
                                                                                    <hr>
                                                                                    <button type="submit" class="btn btn-sm btn-info"><i
                                                                                            class="fa fa-plus"></i> Add Details</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                        <table id="mobileUnitListing"
                                                                            class="table table-bordered table-striped table-sm mt-3">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>RAM</th>
                                                                                    <th>ROM</th>
                                                                                    <th>Selling Price</th>
                                                                                    <th>MRP</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>RAM</th>
                                                                                    <th>ROM</th>
                                                                                    <th>Selling Price</th>
                                                                                    <th>MRP</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="productSize" role="tabpanel"
                                                                    aria-labelledby="productSizeTab">
                                                                    <div>
                                                                        <h6 class="text-danger text-right mt-2 mb-2">Note: Price Fluctuation
                                                                            will be
                                                                            added
                                                                            on the selling price</h6>
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <form method="POST" id="productSizeForm">
                                                                            <input type="hidden" name="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger"> *</span>
                                                                                        Size
                                                                                        <span id="sizeMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="size"
                                                                                        id="size" onblur="checkDetails('size','sizeMessage');"
                                                                                        required placeholder="XL/L OR 42 38 etc">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        Size Type
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="size_type"
                                                                                        placeholder="UK Convention, USA Convention etc">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        Price Fluctuation
                                                                                    </label>
                                                                                    <input type="number" class="form-control"
                                                                                        name="price_fluctuation" value="0">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label"><span
                                                                                            class="text-danger">*</span>Stock Status<span
                                                                                            id="currentStockMessage"></span></label>
                                                                                    <select class="form-control" name="stock_status"
                                                                                        id="stock_status"
                                                                                        onblur="checkDetails('stock_status','currentStockMessage');"
                                                                                        required>
                                                                                        <option value="1">Available</option>
                                                                                        <option value="0">Not Available</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-12" style="text-align: center;">
                                                                                    <hr>
                                                                                    <button type="submit" class="btn btn-sm btn-info"><i
                                                                                            class="fa fa-plus"></i> Add Details</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                        <table id="sizeListing"
                                                                            class="table table-bordered table-striped table-sm mt-3">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Size</th>
                                                                                    <th>Size Type</th>
                                                                                    <th>Price Fluctuation</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Size</th>
                                                                                    <th>Size Type</th>
                                                                                    <th>Price Fluctuation</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="productColor" role="tabpanel"
                                                                    aria-labelledby="productColorTab">
                                                                    <div>
                                                                        <h6 class="text-danger text-right mt-2 mb-2">Note: Price Fluctuation
                                                                            will be added on the selling price</h6>
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <form method="POST" id="productColorForm">
                                                                            <input type="hidden" name="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        <span class="text-danger"> *</span>
                                                                                        Color
                                                                                        <span id="colorMessage"></span>
                                                                                    </label>
                                                                                    <input type="text" class="form-control" name="color"
                                                                                        id="color"
                                                                                        onblur="checkDetails('color','colorMessage');" required
                                                                                        placeholder="Pink, Peach etc">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        Choose Color Image
                                                                                    </label>
                                                                                    <input type="file" class="form-control" name="color_image"
                                                                                        accept="image/*">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label">
                                                                                        Price Fluctuation
                                                                                    </label>
                                                                                    <input type="number" class="form-control"
                                                                                        name="price_fluctuation" value="0">
                                                                                </div>
                                                                                <div class="form-group col-md-3">
                                                                                    <label class="form-label"><span
                                                                                            class="text-danger">*</span>Stock Status<span
                                                                                            id="currentStockMessage"></span></label>
                                                                                    <select class="form-control" name="stock_status"
                                                                                        id="stock_status"
                                                                                        onblur="checkDetails('stock_status','currentStockMessage');"
                                                                                        required>
                                                                                        <option value="1">Available</option>
                                                                                        <option value="0">Not Available</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-12" style="text-align: center;">
                                                                                    <hr>
                                                                                    <button type="submit" class="btn btn-sm btn-info"><i
                                                                                            class="fa fa-plus"></i> Add Details</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                        <table id="colorListing"
                                                                            class="table table-bordered table-striped table-sm mt-3">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Image</th>
                                                                                    <th>Color</th>
                                                                                    <th>Price Fluctuation</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>SNo</th>
                                                                                    <th>Status</th>
                                                                                    <th>Actions</th>
                                                                                    <th>Image</th>
                                                                                    <th>Color</th>
                                                                                    <th>Price Fluctuation</th>
                                                                                    <th>Stock Status</th>
                                                                                </tr>
                                                                            </tfoot>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="otherDetails" role="tabpanel"
                                                                    aria-labelledby="otherDetailsTab">
                                                                    <div class="col-12 mt-3">
                                                                        <?php
                                                                        if($specificationData->num_rows() > 0) {
                                                                            foreach($specificationData->result() as $specificationObj) {
                                                                                $form_field_id = $specificationObj->id;

                                                                                $field_type = $specificationObj->field_type;
                                                                                $field_value = getDataByVal('specification_value', 'product_specification', array('product_id' => $product_id, 'specification_key' => $form_field_id));
                                                                                if($field_type == "input" || $field_type == "date" || $field_type == "time") {
                                                                                    ?>
                                                                                                                                                <div class="row mt-2">
                                                                                                                                                    <div class="col-4">
                                                                                                                                                        <label class="form-label">
                                                                                                                                                            <?php echo $specificationObj->field_name ?>
                                                                                                                                                        </label>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-8">
                                                                                                                                                        <input type="<?php echo $field_type ?>" class="form-control"
                                                                                                                                                            onchange="setSpecification('<?php echo $form_field_id ?>', this.value);"
                                                                                                                                                            value="<?php echo $field_value ?>">
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                } elseif($field_type == "textarea") {
                                                                                    ?>
                                                                                                                                                <div class="row mt-2">
                                                                                                                                                    <div class="col-4">
                                                                                                                                                        <label class="form-label">
                                                                                                                                                            <?php echo $specificationObj->field_name ?>
                                                                                                                                                        </label>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-8">
                                                                                                                                                        <textarea type="<?php echo $field_type ?>" class="form-control"
                                                                                                                                                            onchange="setSpecification('<?php echo $form_field_id ?>', this.value);"><?php echo $field_value ?></textarea>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                } elseif($field_type == "select") {
                                                                                    $fieldValuesData = getAllDataByVal('form_field_values', array('form_field_id' => $form_field_id));
                                                                                    ?>
                                                                                                                                                <div class="row mt-2">
                                                                                                                                                    <div class="col-4">
                                                                                                                                                        <label class="form-label">
                                                                                                                                                            <?php echo $specificationObj->field_name ?>
                                                                                                                                                        </label>
                                                                                                                                                    </div>
                                                                                                                                                    <div class="col-8">
                                                                                                                                                        <select class="form-control"
                                                                                                                                                            onchange="setSpecification('<?php echo $form_field_id ?>', this.value);">
                                                                                                                                                            <option value="">-- Select
                                                                                                                                                                <?php echo $specificationObj->field_name ?> --
                                                                                                                                                            </option>
                                                                                                                                                            <?php
                                                                                                                                                            if($fieldValuesData->num_rows() > 0) {
                                                                                                                                                                foreach($fieldValuesData->result() as $specificationValueObj) {
                                                                                                                                                                    ($field_value == $specificationValueObj->id) ? $select_status = 'selected' : $select_status = '';
                                                                                                                                                                    ?>
                                                                                                                                                                                                            <option <?php echo $select_status ?>
                                                                                                                                                                                                                value="<?php echo $specificationValueObj->id ?>">
                                                                                                                                                                                                                <?php echo $specificationValueObj->form_field_value ?>
                                                                                                                                                                                                            </option>
                                                                                                                                                                                                            <?php
                                                                                                                                                                }
                                                                                                                                                            }
                                                                                                                                                            ?>
                                                                                                                                                        </select>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                                                                                                                                <?php
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                                <div class="tab-pane fade" id="uploadImages" role="tabpanel"
                                                                    aria-labelledby="uploadImagesTab">
                                                                    <div id="image-loader" class="image-loader" style="display: none;">
                                                                        <img src="<?php echo base_url() ?>image/uploading.gif"
                                                                            class="loader-img">
                                                                    </div>
                                                                    <div class="col-12 mt-3">
                                                                        <form id="uploadImageForm" method="POST">
                                                                            <input type="hidden" name="product_id"
                                                                                value="<?php echo $product_id ?>">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-10">
                                                                                    <label class="form-label"><span class="text-danger">*</span>
                                                                                        Select
                                                                                        Multiple Images <span
                                                                                            id="productImageMessage"></span></label>
                                                                                    <input class="form-control" type='file' id="product_images"
                                                                                        name="product_images[]"
                                                                                        onblur="checkDetails('product_images','productImageMessage');"
                                                                                        multiple accept="image/*" required />
                                                                                </div>
                                                                                <div class="form-group col-md-2">
                                                                                    <label class="form-label">.</label>
                                                                                    <input type="submit" class="btn btn-sm btn-info"
                                                                                        value="Upload Images">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 img-preview p-2">
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                    <div id="productImagesView">

                                                                    </div>
                                                                </div>
                                                                <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include("php-assets/foot-section.php") ?>

    <script src="<?php echo base_url() ?>assets/admin/js/summernote-bs4.min.js"></script>

    <div class="modal fade" id="editUnitModel" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white">Update Unit & Price</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateUnitForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="unit_and_price_id" id="edit_unit_id">
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger"> *</span>
                                    Unit Value
                                    <span id="unitValueMessage"></span>
                                </label>
                                <input type="number" class="form-control" name="unit_value" id="edit_unit_unit_value"
                                    onblur="checkDetails('edit_unit_unit_value','unitValueMessage');" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger">*</span>
                                    Unit
                                    <span id="eunitMessage"></span>
                                </label>
                                <select class="form-control" name="unit_id" id="edit_unit_unit_id"
                                    onblur="checkDetails('edit_unit_unit_id','eunitMessage');" required>
                                    <option value="">-- Select Unit --</option>
                                    <?php
                                    foreach($unitData->result() as $unitObj) {
                                        ?>
                                                            <option value="<?php echo $unitObj->id ?>">
                                                                <?php echo $unitObj->name ?>
                                                            </option>
                                                            <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger">*</span>
                                    Unit Sales Price<span id="eunitSalesPriceMessage"></span>
                                </label>
                                <input type="text" class="form-control" name="selling_price"
                                    id="edit_unit_unit_sales_price"
                                    onblur="checkDetails('edit_unit_unit_sales_price','unitSalesPriceMessage');"
                                    required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label"><span class="text-danger">*</span>
                                    Unit MRP
                                    <span id="eunitMrpMessage"></span>
                                </label>
                                <input type="text" class="form-control" name="mrp" id="edit_unit_unit_mrp"
                                    onblur="checkDetails('edit_unit_unit_mrp','eunitMrpMessage');" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label"><span class="text-danger">*</span>Stock Status<span
                                        id="ecurrentStockMessage"></span></label>
                                <select class="form-control" name="stock_status" id="edit_unit_stock_status"
                                    onblur="checkDetails('edit_unit_stock_status','ecurrentStockMessage');" required>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm waves-effect "
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Update
                                details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editMobileUnitModel" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-white">Update Unit & Price</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateMobileUnitForm" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="unit_and_price_id" id="edit_mobile_unit_id">
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger"> *</span>
                                    RAM Size Value
                                    <span id="ramSizeMessage"></span>
                                </label>
                                <input type="number" class="form-control" name="ram_size" id="edit_mobile_unit_ram_size"
                                    onblur="checkDetails('ram_size','ramSizeMessage');" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">
                                    Type
                                </label>
                                <select class="form-control" name="ram_size_type" id="edit_mobile_unit_ram_size_type" required>
                                    <option value="GB">GB</option>
                                    <option value="MB">MB</option>
                                    <option value="TB">TB</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger"> *</span>
                                    ROM Size Value
                                    <span id="romSizeMessage"></span>
                                </label>
                                <input type="number" class="form-control" name="rom_size" id="edit_mobile_unit_rom_size"
                                    onblur="checkDetails('rom_size','romSizeMessage');" required>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">
                                    Type
                                </label>
                                <select class="form-control" name="rom_size_type" id="edit_mobile_unit_rom_size_type" required>
                                    <option value="GB">GB</option>
                                    <option value="MB">MB</option>
                                    <option value="TB">TB</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger">*</span>
                                    Unit Sales Price<span id="emunitSalesPriceMessage"></span>
                                </label>
                                <input type="text" class="form-control" name="selling_price" id="edit_mobile_unit_unit_sales_price"
                                    onblur="checkDetails('edit_mobile_unit_unit_sales_price','unitSalesPriceMessage');" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label"><span class="text-danger">*</span>
                                    Unit MRP
                                    <span id="emunitMrpMessage"></span>
                                </label>
                                <input type="text" class="form-control" name="mrp" id="edit_mobile_unit_unit_mrp"
                                    onblur="checkDetails('edit_mobile_unit_unit_mrp','unitMrpMessage');" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">
                                    <span class="text-danger">*</span>
                                    Unit MRP
                                    <span id="emStockStatusMessage"></span>
                                </label>
                                <select class="form-control" name="stock_status" id="edit_mobile_unit_stock_status"
                                    onblur="checkDetails('edit_mobile_unit_stock_status','currentStockMessage');" required>
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm waves-effect"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Update
                                details</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#description').summernote({
                height: 200,
                placeholder: "Description (Update Details Using Above Tools)"
            });
        })

        $(document).ready(function () {
            $('#disclaimer').summernote({
                height: 200,
                placeholder: "Disclaimer (Update Details Using Above Tools)"
            });
        })

        $(document).ready(function () {
            $('#additional_detaiils').summernote({
                height: 200,
                placeholder: "Additional Details (Update Details Using Above Tools)"
            });
        })

        $(document).on("submit", "#createProductForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addProductFunction/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Product Successfully Added!!!!', 'success');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url() ?>admin-create-product-details?product_id=" + data['product_id'];
                        }, 2000);
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#addUitForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addUnitAndPrice/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#addUitForm")[0].reset();
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Unit Successfully Added!!!!', 'success');
                        listUnitData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#updateUnitForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addUnitAndPrice/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Unit Successfully Updated!!!!', 'success');
                        listUnitData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                    $("#updateUitForm")[0].reset();
                    $('#editUnitModel').toggle('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#addMobileUnitForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addMobileUnitAndPrice/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#addMobileUnitForm")[0].reset();
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Unit Successfully Added!!!!', 'success');
                        listMobileUnitData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#updateMobileUnitForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addMobileUnitAndPrice/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Unit Successfully Added!!!!', 'success');
                        listMobileUnitData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                    $("#updateMobileUnitForm")[0].reset();
                    $('#editMobileUnitModel').toggle('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#productSizeForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addSize/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#productSizeForm")[0].reset();
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Size Successfully Added!!!!', 'success');
                        listSizeData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).on("submit", "#productColorForm", function (e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addColor/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#productColorForm")[0].reset();
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Color Successfully Added!!!!', 'success');
                        listColorData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        function setSpecification(key, value) {
            var product_id = $("#product_id").val();
            $.ajax({
                url: "<?php echo base_url() ?>main/setSpecification",
                data: {
                    product_id: product_id,
                    key: key,
                    value: value
                },
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    if (data['status'] == true) {
                    }
                }
            })
        }

        $(document).on('submit', '#uploadImageForm', function (e) {
            $("#image-loader").css('display', 'grid');
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/uploadProductImages/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                success: function (data) {
                    $("#image-loader").css('display', 'none');
                    $("#uploadImageForm")[0].reset();
                    if (data == true) {
                        showMessage('Good Job !!', 'Images Successfully Added!!!!', 'success');
                        listImagesData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })
        })

        $(document).ready(function () {
            listUnitData();
            listMobileUnitData();
            listSizeData();
            listColorData();
            listImagesData();
        })

        function listUnitData() {
            var product_id = $("#product_id").val();
            var table = $("#unitDataListing").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "ajax": {
                    url: "<?php echo base_url() ?>ajax/productUnitListing/getProductUnit",
                    method: 'POST',
                    data: {
                        'product_id': product_id,
                    },
                },
                "bDestroy": true,
                "columnDefs": [{
                    "target": [0, 3, 4],
                    "orderable": false
                }],
                dom: 'Bfrtip',
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#dataListing_wrapper .col-md-6:eq(0)');
        }

        function listMobileUnitData() {
            var product_id = $("#product_id").val();
            var table = $("#mobileUnitListing").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "ajax": {
                    url: "<?php echo base_url() ?>ajax/productUnitListing/getMobileProductUnit",
                    method: 'POST',
                    data: {
                        'product_id': product_id,
                    },
                },
                "bDestroy": true,
                "columnDefs": [{
                    "target": [0, 3, 4],
                    "orderable": false
                }],
                dom: 'Bfrtip',
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#dataListing_wrapper .col-md-6:eq(0)');
        }

        function listSizeData() {
            var product_id = $("#product_id").val();
            var table = $("#sizeListing").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "ajax": {
                    url: "<?php echo base_url() ?>ajax/productUnitListing/getSize",
                    method: 'POST',
                    data: {
                        'product_id': product_id,
                    },
                },
                "bDestroy": true,
                "columnDefs": [{
                    "target": [0, 3, 4],
                    "orderable": false
                }],
                dom: 'Bfrtip',
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#dataListing_wrapper .col-md-6:eq(0)');
        }

        function listColorData() {
            var product_id = $("#product_id").val();
            var table = $("#colorListing").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "ajax": {
                    url: "<?php echo base_url() ?>ajax/productUnitListing/getColor",
                    method: 'POST',
                    data: {
                        'product_id': product_id,
                    },
                },
                "bDestroy": true,
                "columnDefs": [{
                    "target": [0, 3, 4],
                    "orderable": false
                }],
                dom: 'Bfrtip',
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#dataListing_wrapper .col-md-6:eq(0)');
        }

        function listImagesData() {
            var product_id = $("#product_id").val();
            $.ajax({
                url: "<?php echo base_url() ?>main/listProductImages",
                data: {
                    'product_id': product_id
                },
                type: 'POST',
                success: function (data) {
                    $("#productImagesView").html(data);
                }
            })
        }

        $(function () {
            var imagesPreview = function (input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $($.parseHTML('<img>')).addClass('preview-img').attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#product_images').on('change', function () {
                imagesPreview(this, 'div.img-preview');
            });
        });

        function deleteImage(id) {
            $.ajax({
                url: "<?php echo base_url() ?>main/deleteProductImage",
                type: "POST",
                data: {
                    id: id
                },
                success: function () {
                    listImagesData();
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }

        function imageSetAsDefault(image, product_id) {
            $.ajax({
                url: "<?php echo base_url() ?>main/imageSetAsDefault",
                type: "POST",
                data: {
                    image: image,
                    'product_id': product_id
                },
                success: function () {
                    listImagesData();
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }


        $(document).on('click', '#getEditDataUnit', function (event) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url(); ?>main/getEditData",
                data: {
                    'table_name': 'product_unit_stock_price',
                    'id': id,
                },
                dataType: 'json',
                type: 'POST',
                success: function (data) {
                    $(data).each(function (i, val) {
                        $.each(val, function (k, v) {
                            $("#edit_unit_" + k).val(v);
                            if (k == "image") {
                                $("#edit_blah").attr("src", "<?php echo base_url() ?>image/" + table_name + "/" + v);
                            }
                        });
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $(document).on('click', '#getEditDataMobileUnit', function (event) {
            var id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url(); ?>main/getEditData",
                data: {
                    'table_name': 'product_ram_rom_price',
                    'id': id,
                },
                dataType: 'json',
                type: 'POST',
                success: function (data) {
                    $(data).each(function (i, val) {
                        $.each(val, function (k, v) {
                            $("#edit_mobile_unit_" + k).val(v);
                            if (k == "image") {
                                $("#edit_blah").attr("src", "<?php echo base_url() ?>image/" + table_name + "/" + v);
                            }
                        });
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $(document).on("click", "#disableProductData", function(){
            var id = $(this).data("id");
            var column = $(this).data("column");
            var table = $(this).data("table");
            $.ajax({
                url:"<?php echo base_url() ?>main/disableProductData",
                data:{
                    id:id,
                    column:column,
                    table:table
                },
                type:"POST",
                success:function(data){
                    
                }
            })
        })
    </script>

</body>

</html>