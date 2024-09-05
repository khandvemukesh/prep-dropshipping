<?php include('header.php') ?>
<?php $pageName = "offer"; ?>
<?php $subPageName = "add_offer"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php echo $company_name ?> | Add Offers
    </title>
    <?php include('php-assets/head-section.php') ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/admin/css/icheck-bootstrap.min.css">
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
                            <h1>Manage Offers</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Manage Offers</li>
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
                                        Manage Offer
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist"
                                        style="background: #0a8693;">
                                        <li class="nav-item">
                                            <a class="nav-link text-white active" id="pageTabLink1" data-toggle="pill"
                                                href="#pageTab1" role="tab" aria-controls="basicDetails"
                                                aria-selected="true">Create Offers</a>
                                        </li>
                                        <?php
                                        $offer_title = $start_date = $start_time = $end_date = $end_time = $offer_position = "";
                                        $top1_selection = $top2_selection = $middle1_selection = $middle2_selection = $bottom1_selection = $bottom2_selection = "";
                                        if ($offer_id != "") {
                                            $offerObj = getAllDataByVal('offers', array('id' => $offer_id))->row();
                                            $offer_title = $offerObj->offer_title;
                                            $start_date = $offerObj->start_date;
                                            $start_time = $offerObj->start_time;
                                            $end_date = $offerObj->end_date;
                                            $end_time = $offerObj->end_time;
                                            $offer_position = $offerObj->offer_position;
                                            if ($offer_position == "Top-1")
                                                $top1_selection = "selected";
                                            if ($offer_position == "Top-2")
                                                $top2_selection = "selected";
                                            if ($offer_position == "Middle-1")
                                                $middle1_selection = "selected";
                                            if ($offer_position == "Middle-2")
                                                $middle2_selection = "selected";
                                            if ($offer_position == "Bottom-1")
                                                $bottom1_selection = "selected";
                                            if ($offer_position == "Bottom-2")
                                                $bottom2_selection = "selected";
                                            ?>
                                            <li class="nav-item">
                                                <a class="nav-link text-white" id="pageTabLink2" data-toggle="pill"
                                                    href="#pageTab2" role="tab" aria-controls="basicDetails"
                                                    aria-selected="true">Add Offer Details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-white" id="pageTabLink3" data-toggle="pill"
                                                    href="#pageTab3" role="tab" aria-controls="basicDetails"
                                                    aria-selected="true">Add Images</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                    <div class="tab-content" id="custom-content-below-tabContent">
                                        <div class="tab-pane fade show active" id="pageTab1" role="tabpanel"
                                            aria-labelledby="pageTabLink1">
                                            <form method="POST" id="insertOffer">
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <h5 class="text-bold align-self-center">Add Offers</h5>
                                                    </div>
                                                    <div class="col-md-9 text-right">
                                                        <small class="text-danger">Fields Marked With * Are
                                                            Mandatory</small>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" name="type" value="category">
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Offer Title<span
                                                                id="offerTitleCategoryMessage"></span></label>
                                                        <input type="text" class="form-control" name="offer_title"
                                                            id="offer_title_category"
                                                            onblur="checkDetails('offer_title_category','offerTitleCategoryMessage');"
                                                            placeholder="Title" value="<?php echo $offer_title ?>"
                                                            required>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Banner Position<span
                                                                id="offerPositionCategoryMessage"></span></label>
                                                        <select class="form-control" name="offer_position"
                                                            id="offer_position_category"
                                                            onblur="checkDetails('offer_position_category','offerPositionCategoryMessage');"
                                                            required>
                                                            <option <?php echo $top1_selection ?> value="Top-1">
                                                                Top-1</option>
                                                            <option <?php echo $top2_selection ?> value="Top-2">
                                                                Top-2</option>
                                                            <option <?php echo $middle1_selection ?> value="Middle-1">
                                                                Middle-1</option>
                                                            <option <?php echo $middle2_selection ?> value="Middle-2">
                                                                Middle-2</option>
                                                            <option <?php echo $bottom1_selection ?> value="Bottom-1">
                                                                Bottom-1</option>
                                                            <option <?php echo $bottom2_selection ?> value="Bottom-2">
                                                                Bottom-2</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Start Date<span
                                                                id="startDateCategoryMessage"></span></label>
                                                        <input type="date" class="form-control" name="start_date"
                                                            id="start_date_category"
                                                            onblur="checkDetails('start_date_category','startDateCategoryMessage');"
                                                            value="<?php echo $start_date ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="form-label"><span
                                                                class="text-danger">*</span>Start Time<span
                                                                id="startTimeCategoryMessage"></span></label>
                                                        <input type="time" class="form-control" name="start_time"
                                                            id="start_time_category"
                                                            onblur="checkDetails('start_time_category','startTimeCategoryMessage');"
                                                            value="<?php echo $start_time ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="form-label"><span class="text-danger">*</span>End
                                                            Date<span id="endDateCategoryMessage"></span></label>
                                                        <input type="date" class="form-control" name="end_date"
                                                            id="end_date_category"
                                                            onblur="checkDetails('end_date_category','endDateCategoryMessage');"
                                                            value="<?php echo $end_date ?>" required>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label class="form-label"><span class="text-danger">*</span>End
                                                            Time<span id="endTimeCategoryMessage"></span></label>
                                                        <input type="time" class="form-control" name="end_time"
                                                            id="end_time_category"
                                                            onblur="checkDetails('end_time_category','endTimeCategoryMessage');"
                                                            value="<?php echo $end_time ?>" required>
                                                    </div>
                                                </div>
                                                <div style="text-align: center;">
                                                    <button type="submit" class="btn btn-info ">Save Data
                                                        <i class="fa fa-file"></i></button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="pageTab2" role="tabpanel"
                                            aria-labelledby="pageTabLink2">
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <h5 class="text-bold align-self-center">Add Category/Brand/Product
                                                        To Offer Offers</h5>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <small class="text-danger">Fields Marked With * Are
                                                        Mandatory</small>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <span class="font-weight-bold">Note : </span>
                                                    <br>
                                                    <span>1. You Can Select Multiple Categories/Product//Brand For
                                                        Single Offer as Well </span><br>
                                                    <span>2. Offer % will be applied on the selling price of the
                                                        repected product </span><br>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">Search Product/Category/Brand
                                                        Here ....</label>
                                                    <input type="text"
                                                        class="my-search desktopbutton searchInput form-control"
                                                        placeholder="Search Product/Category/Brand Here .....">
                                                    <div class="menu dropdown_account desktopbutton finalResult"
                                                        style="padding: 0px 0px;width:100%;z-index:999;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="control-label">Offer %</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="% applicable on selling price">
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
        function changeTab(cur, tab, table, column, functionName) {
            $("#pageTab" + cur).removeClass('active');
            $("#pageTabLink" + cur).removeClass('active');

            $("#pageTab" + tab).addClass('active');
            $("#pageTabLink" + tab).addClass('active');
            if (table != "" && column != "") {
                getEditDataHotel(table, column);
            } else { }
        }

        $(document).ready(function () {
            getDataOffers('category');
            getDataOffers('brand');
            getDataOffers('subcategory');
        });


        $(document).on('submit', '#insertOffer', function (event) {
            event.preventDefault();
            $("#image-loader").css('display', 'grid');
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/insertOffers",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    $("#image-loader").css('display', 'none');
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Offer Successfully Added!!!!', 'success');
                        $("#insertOffer")[0].reset();
                        window.location.href = "<?php echo base_url() ?>admin-manage-offers?offer_id=" + data['offer_id'];
                    } else {
                        showMessage('Ooops !!', data, 'danger');
                    }
                }
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
            $('#image_category').on('change', function () {
                imagesPreviewCategory(this, 'div.img-preview-category');
            });
        });


        function changeValue(type, i) {
            if ($("#" + type + "_offer_on" + i).is(':checked')) {
                $("#" + type + "_offer_value" + i).prop('readonly', false);
                $("#" + type + "_offer_value" + i).prop('required', true);
            } else {
                $("#" + type + "_offer_value" + i).prop('readonly', true);
                $("#" + type + "_offer_value" + i).prop('required', false);
            }
        }

        function deleteOffer(offer_id, type) {
            $.ajax({
                url: "<?php echo base_url(); ?>main/deleteOffer",
                data: {
                    'id': offer_id
                },
                type: 'POST',
                success: function (data) {
                    if (data == true) {
                        showMessage('Good Job !!', 'Offer Successfully Deleted!!!!', 'success');
                        getDataOffers(type);
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong', 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
</body>

</html>