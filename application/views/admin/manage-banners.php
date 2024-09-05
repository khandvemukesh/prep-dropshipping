<?php include('header.php') ?>
<?php $pageName = "banners"; ?>
<?php $subPageName = "add_offer"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $company_name ?> | Add Banners
    </title>
    <?php include('php-assets/head-section.php') ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/admin/css/icheck-bootstrap.min.css">
    <style>
        .img-preview-home-banner img {
            width: 200px;
        }

        .img-preview-home-banner {
            padding: 10px;
        }

        .img-preview-category-banner img {
            width: 200px;
        }

        .img-preview-category-banner {
            padding: 10px;
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
                            <h1>Manage Banners</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Manage Banners</li>
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
                                        Manage Banners
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div id="image-loader" class="image-loader" style="display: none;">
                                        <img src="<?php echo base_url() ?>image/uploading.gif" class="loader-img">
                                    </div>
                                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist"
                                        style="background: #0a8693;">
                                        <li class="nav-item">
                                            <a class="nav-link text-white active" id="pageTabLink1" data-toggle="pill"
                                                href="#pageTab1" role="tab" aria-controls="basicDetails"
                                                aria-selected="true">Home Page Banners</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" id="pageTabLink2" data-toggle="pill"
                                                href="#pageTab2" role="tab" aria-controls="basicDetails"
                                                aria-selected="true">Category Page Banners</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" id="pageTabLink3" data-toggle="pill"
                                                href="#pageTab3" role="tab" aria-controls="basicDetails"
                                                aria-selected="true">Brand Page Banners</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="custom-content-below-tabContent">
                                        <div class="tab-pane fade show active" id="pageTab1" role="tabpanel"
                                            aria-labelledby="pageTabLink1">
                                            <form method="POST" id="insertHomeBanner">
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <h5 class="text-bold align-self-center">Add Home Page Banners
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-9 text-right">
                                                        <small class="text-danger">Fields Marked With * Are
                                                            Mandatory</small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" name="banner_type" value="1">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Banner For<span
                                                                id="bannerForMessage"></span></label>
                                                        <select class="form-control" name="banner_for" id="banner_for"
                                                            onblur="checkDetails('banner_for','bannerForMessage');"
                                                            required>
                                                            <option value="1">Ecommerce</option>
                                                            <option value="2">Grocery</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Banner Position<span
                                                                id="positionMessage"></span></label>
                                                        <select class="form-control" name="position" id="position"
                                                            onblur="checkDetails('position','positionMessage');"
                                                            required>
                                                            <option value="1">On Top</option>
                                                            <option value="2">After Category</option>
                                                            <option value="3">After Brands</option>
                                                            <option value="4">After Products</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-label"><span class="text-danger">*</span>
                                                            Select Banner Images <span
                                                                id="imageHomeBannerMessage"></span></label>
                                                        <input class="form-control" type='file' id="image_home_banner"
                                                            name="image[]"
                                                            onblur="checkDetails('image_home_banner','imageHomeBannerMessage');"
                                                            multiple accept="image/*" required />
                                                    </div>
                                                    <div class="col-md-12 img-preview-home-banner">
                                                    </div>
                                                </div>
                                                <div style="text-align: center;">
                                                    <button type="submit" class="btn btn-info ">Save Data
                                                        <i class="fa fa-file"></i></button>
                                                </div>
                                            </form>
                                            <div class="row table-responsive mt-2">
                                                <div class="col-12">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>SNo.</th>
                                                                <th>For</th>
                                                                <th>Type</th>
                                                                <th>Position</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bannersList1">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="pageTab2" role="tabpanel"
                                            aria-labelledby="pageTabLink2">
                                            <form method="POST" id="insertCategoryBanner">
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <h5 class="text-bold align-self-center">Add Category Page
                                                            Banners
                                                        </h5>
                                                    </div>
                                                    <div class="col-md-9 text-right">
                                                        <small class="text-danger">Fields Marked With * Are
                                                            Mandatory</small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" name="banner_type" value="2">
                                                    <div class="form-group col-md-4">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Banner For<span
                                                                id="bannerForMessage"></span></label>
                                                        <select class="form-control" name="banner_for" id="banner_for"
                                                            onblur="getCategoryByType(this.value);" required>
                                                            <option value="1">Ecommerce</option>
                                                            <option value="2">Grocery</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Select Category<span
                                                                id="categoryMessage"></span></label>
                                                        <select class="form-control" name="category_id" id="category_id"
                                                            onblur="checkDetails('category_id','categoryMessage');"
                                                            required>
                                                            <option value="">-- Select Category --</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Banner Position<span
                                                                id="frequencyMessage"></span></label>
                                                        <select class="form-control" name="frequency" id="frequency"
                                                            onblur="checkDetails('frequency','frequencyMessage');"
                                                            required>
                                                            <option value="0">On Top</option>
                                                            <option value="10">After 10 Products</option>
                                                            <option value="30">After 30 Products</option>
                                                            <option value="60">After 60 Products</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="form-label"><span class="text-danger">*</span>
                                                            Select Banner Images <span
                                                                id="imageCategoryBannerMessage"></span></label>
                                                        <input class="form-control" type='file'
                                                            id="image_category_banner" name="image[]"
                                                            onblur="checkDetails('image_category_banner','imageCategoryBannerMessage');"
                                                            multiple accept="image/*" required />
                                                    </div>
                                                    <div class="col-md-12 img-preview-category-banner">
                                                    </div>
                                                </div>
                                                <div style="text-align: center;">
                                                    <button type="submit" class="btn btn-info ">Save Data
                                                        <i class="fa fa-file"></i></button>
                                                </div>
                                            </form>
                                            <div class="row table-responsive mt-2">
                                                <div class="col-12">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>SNo.</th>
                                                                <th>For</th>
                                                                <th>Type</th>
                                                                <th>Category</th>
                                                                <th>Position</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="bannersList2">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="pageTab3" role="tabpanel"
                                            aria-labelledby="pageTabLink3">
                                            <div id="image-loader" class="image-loader" style="display: none;">
                                                <img src="<?php echo base_url() ?>image/uploading.gif"
                                                    class="loader-img">
                                            </div>
                                            <div class="row mt-3">
                                                <div class="form-group col-md-12">
                                                    <label class="form-label"><span class="text-danger">*</span>
                                                        Select Main Image </label>
                                                    <center>
                                                        <img id="blah_category"
                                                            src="<?php echo base_url() ?>image/default-image.png"
                                                            alt="Main Image"
                                                            class="img img-circle img-thumbnail img-responsive"
                                                            width="150" height="150">
                                                    </center>
                                                    <input class="form-control" type='file'
                                                        onchange="readURLCategory(this);" id="category_image"
                                                        name="main_image" accept="image/*" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="form-label"><span class="text-danger">*</span>
                                                        Select Banner Images <span
                                                            id="imageCategoryMessage"></span></label>
                                                    <input class="form-control" type='file' id="image_category"
                                                        name="image[]"
                                                        onblur="checkDetails('image_category','imageCategoryMessage');"
                                                        multiple accept="image/*" required />
                                                </div>
                                                <div class="col-md-12 img-preview-category">
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

    <?php echo include("php-assets/foot-section.php") ?>

    <script>
        $(document).ready(function () {
            getBanners(1);
            getBanners(2);
            getBanners(3);
            getCategoryByType(1);
        });

        function getCategoryByType(type) {
            $.ajax({
                url: "<?php echo base_url() ?>main/getCategoryByType",
                data: {
                    type: type
                },
                type: 'POST',
                success: function (data) {
                    $("#category_id").html(data);
                }
            })
        }


        function getBanners(type) {
            $.ajax({
                url: "<?php echo base_url() ?>main/getBanners",
                data: {
                    banner_type: type,
                },
                type: 'POST',
                success: function (data) {
                    $("#bannersList" + type).html(data);
                }
            })
        }

        function deleteBanner(banner_id, type) {
            $.ajax({
                url: "<?php echo base_url(); ?>main/deleteBanner",
                data: {
                    'id': banner_id
                },
                type: 'POST',
                success: function (data) {
                    console.log(data);
                    if (data == true) {
                        showMessage('Good Job !!', 'Banner Successfully Deleted!!!!', 'success');
                        getBanners(type);
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        $(document).on('submit', '#insertHomeBanner', function (event) {
            event.preventDefault();
            $("#image-loader").css('display', 'grid');
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/insertBanner",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#image-loader").css('display', 'none');
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Banner Successfully Added!!!!', 'success');
                        $("#insertHomeBanner")[0].reset();
                    } else {
                        showMessage('Ooops !!', data['message'], 'danger');
                    }
                }, error: function (data) {
                    $("#image-loader").css('display', 'none');
                }
            });
        });

        $(document).on('submit', '#insertCategoryBanner', function (event) {
            event.preventDefault();
            $("#image-loader").css('display', 'grid');
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/insertBanner",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#image-loader").css('display', 'none');
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Banner Successfully Added!!!!', 'success');
                        $("#insertCategoryBanner")[0].reset();
                    } else {
                        showMessage('Ooops !!', data['message'], 'danger');
                    }
                }, error: function (data) {
                    $("#image-loader").css('display', 'none');
                }
            });
        });

        $(function () {
            var imagesPreviewHome = function (input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#image_home_banner').on('change', function () {
                imagesPreviewHome(this, 'div.img-preview-home-banner');
            });
        });



        $(function () {
            var imagesPreviewCategory = function (input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#image_category_banner').on('change', function () {
                imagesPreviewCategory(this, 'div.img-preview-category-banner');
            });
        });
    </script>
</body>

</html>