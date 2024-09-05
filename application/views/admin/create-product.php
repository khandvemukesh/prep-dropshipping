<?php include('header.php');
$pageName = "product";
$subPageName = "add_product";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $company_name ?> | Home
    </title>
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
                            <h1>Select Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Select Details</li>
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
                                    <h3 class="card-title"></h3>
                                </div>
                                <div class="card-body">
                                    <div class="col-12">

                                        <div class="card card-primary card-tabs">
                                            <div class="card-header">
                                                <?php include('php-assets/card-tools.php') ?>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h3 class="card-title">Select Category</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div id="loader" class="loader" style="display: none;">
                                                    <img src="<?php echo base_url() ?>image/loader.gif"
                                                        class="loader-img">
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-4">
                                                        <input type="text" id="search_text" class="form-control"
                                                            placeholder="Search..." onkeyup="getCategories();">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" id="categoriesData">

                                                </div>
                                            </div>
                                        </div>
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
    <script>
        $(document).ready(function () {
            getCategories();
        })

        function getCategories() {
            $("#loader").css('display', 'grid');
            var search_text = $("#search_text").val();
            $.ajax({
                url: "<?php echo base_url() ?>ajax/categoryListing/getCategories",
                data: {
                    'search_text': search_text,
                },
                type: "POST",
                success: function (data) {
                    $("#loader").css('display', 'none');
                    $("#categoriesData").html(data);
                }
            })
        }

        function getLowerCategories(shop_type_id) {
            $("#loader").css('display', 'grid');
            $("#shop_type_id").val(shop_type_id);
            var search_text = $("#search_text").val();
            $.ajax({
                url: "<?php echo base_url() ?>ajax/categoryListing/getLowerCategories",
                data: {
                    'shop_type': shop_type_id,
                    'search_text': search_text,
                },
                type: "POST",
                success: function (data) {
                    $("#loader").css('display', 'none');
                    $("#categoriesData").html("");
                    $("#categoriesData").html(data);
                }
            })
        }

        function getSubCategories(category_id) {
            $("#loader").css('display', 'grid');
            $("#category_id").val(category_id);
            var search_text = $("#search_text").val();
            $.ajax({
                url: "<?php echo base_url() ?>ajax/categoryListing/getSubCategories",
                data: {
                    'category_id': category_id,
                    'search_text': search_text,
                },
                type: "POST",
                success: function (data) {
                    $("#loader").css('display', 'none');
                    $("#categoriesData").html("");
                    $("#categoriesData").html(data);
                }
            })
        }

        function createProduct(sub_category_id) {
            var shop_type_id = $("#shop_type_id").val();
            var category_id = $("#category_id").val();
            if (shop_type_id != "" && category_id != "" && sub_category_id != "") {
                window.location.href = "<?php echo base_url() ?>admin-create-product-details?shop_type_id=" + shop_type_id + "&category_id=" + category_id + "&sub_category_id=" + sub_category_id;
            }
        }

    </script>
</body>

</html>