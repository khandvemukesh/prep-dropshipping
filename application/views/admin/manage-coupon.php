<?php include('header.php') ?>
<?php $pageName = "coupon"; ?>
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
                                    <form method="POST" id="insertDataCoupon">
                                        <div class="p-20 z-depth-top-0 waves-effect mb-2">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h5 class="text-bold align-self-center">Create Coupon</h5>
                                                </div>
                                                <div class="col-md-9 text-right">
                                                    <small class="text-danger">Fields Marked With * Are
                                                        Mandatory</small>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Coupon
                                                        Title<span id="couponNameMessage"></span></label>
                                                    <input type="text" class="form-control" name="coupon_name"
                                                        id="coupon_name"
                                                        onblur="checkDetails('coupon_name','couponNameMessage');"
                                                        placeholder="eg. Flat 50% off" required>
                                                </div>
                                                <input type="hidden" name="coupon_type" id="coupon_type" value="3">
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Coupon
                                                        Code<span id="couponCodeMessage"></span></label>
                                                    <input type="text" class="form-control" name="coupon_code"
                                                        id="coupon_code"
                                                        onblur="checkDetails('coupon_code','couponCodeMessage');"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Coupon
                                                        In<span id="couponInMessage"></span></label>
                                                    <select class="form-control" name="coupon_in" id="coupon_in"
                                                        onblur="checkDetails('coupon_in','couponInMessage');" required>
                                                        <option value="Percent">Order Value Percent</option>
                                                        <option value="Amount">Fixed Amount</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Coupon
                                                        Value<span id="couponPercentMessage"></span></label>
                                                    <input type="number" class="form-control" name="coupon_percent"
                                                        id="coupon_percent"
                                                        onblur="checkDetails('coupon_percent','couponPercentMessage');"
                                                        placeholder="Percent Or Fixed Amount Selected Above" required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label"><span class="text-danger">*</span>Start
                                                        Date<span id="startDateMessage"></span></label>
                                                    <input type="date" class="form-control" name="coupon_start_date"
                                                        id="coupon_start_date"
                                                        onblur="checkDetails('coupon_start_date','startDateMessage');"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label"><span class="text-danger">*</span>Start
                                                        Time<span id="startTimeMessage"></span></label>
                                                    <input type="time" class="form-control" name="coupon_start_time"
                                                        id="coupon_start_time"
                                                        onblur="checkDetails('coupon_start_time','startTimeMessage');"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label"><span class="text-danger">*</span>End
                                                        Date<span id="endDateMessage"></span></label>
                                                    <input type="date" class="form-control" name="coupon_end_date"
                                                        id="coupon_end_date"
                                                        onblur="checkDetails('coupon_end_date','endDateMessage');"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="form-label"><span class="text-danger">*</span>End
                                                        Time<span id="endTimeMessage"></span></label>
                                                    <input type="time" class="form-control" name="coupon_end_time"
                                                        id="coupon_end_time"
                                                        onblur="checkDetails('coupon_end_time','endTimeMessage');"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Coupon
                                                        For<span id="couponForMessage"></span></label>
                                                    <select class="form-control" name="coupon_for" id="coupon_for"
                                                        onblur="checkDetails('coupon_for','couponForMessage');"
                                                        required>
                                                        <option value="1">All Users</option>
                                                        <option value="2">First Order</option>
                                                        <option value="3">First 3 Orders</option>
                                                        <option value="4">First 5 Orders</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span class="text-danger">*</span>Minimum
                                                        Order Value<span id="minimumOrderValueMessage"></span></label>
                                                    <input type="number" class="form-control" name="minimum_order_value"
                                                        id="minimum_order_value"
                                                        onblur="checkDetails('minimum_order_value','minimumOrderValueMessage');"
                                                        placeholder="Mininimum Value To Get This Coupon Benifit"
                                                        required>
                                                </div>
                                                <div class="form-group col-md-6" id="maximumAmountShowHide">
                                                    <label class="form-label"><span class="text-danger">*</span>Maximum
                                                        Coupon Value<span id="maximumValueMessage"></span></label>
                                                    <input type="number" class="form-control"
                                                        name="maximum_coupon_value" id="maximum_coupon_value"
                                                        onblur="checkDetails('maximum_coupon_value','maximumValueMessage');"
                                                        placeholder="Maximum Reward Provided On Any Order" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label"><span
                                                            class="text-danger">*</span>Desccription<span
                                                            id="descriptionMessage"></span></label>
                                                    <textarea class="form-control" name="description" id="description"
                                                        onblur="checkDetails('description','descriptionMessage');"
                                                        placeholder="Description" required></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="form-label"><span class="text-danger">*</span> Select
                                                        Banner Images <span id="imageMessage"></span></label>
                                                    <input class="form-control" type='file' id="image" name="image[]"
                                                        onblur="checkDetails('image','imageMessage');" multiple
                                                        accept="image/*" required />
                                                </div>

                                                <div class="col-md-12 img-preview">
                                                </div>

                                                <div class="">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-20  mb-2">
                                            <div style="text-align: center;">
                                                <button type="submit" class="btn btn-sm btn-info">Save Data
                                                    <i class="fa fa-file"></i></button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="p-20 mb-2">
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <h5 class="text-bold align-self-center">
                                                    Existing Coupons
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <span class="mr-2">Expired Coupons Are Denoted With: </span>
                                                <span style="padding:0px 10px;background:#ffbfbf;"></span>
                                            </div>
                                        </div>

                                        <div class="row table-responsive">
                                            <div class="col-12">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>SNo.</th>
                                                            <th>CouponTitle</th>
                                                            <th>CouponDetails</th>
                                                            <th>StartDate</th>
                                                            <th>EndDate</th>
                                                            <th>Images</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="coupon">
                                                    </tbody>
                                                </table>
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
            getDataCoupon();
        });


        $(document).on('submit', '#insertDataCoupon', function (event) {
            event.preventDefault();
            $("#image-loader").css('display', 'grid');
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/insertCoupon",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    $("#image-loader").css('display', 'none');
                    if (data == true) {
                        showMessage('Good Job !!', 'Images Successfully Added!!!!', 'success');
                        getDataCoupon();
                        $("#insertDataCoupon")[0].reset();
                    } else {
                        showMessage('Ooops !!', data, 'danger');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $(function () {
            var imagesPreview = function (input, placeToInsertImagePreview) {
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
            $('#image').on('change', function () {
                imagesPreview(this, 'div.img-preview');
            });
        });

        function getDataCoupon() {
            $.ajax({
                url: "<?php echo base_url(); ?>main/getCoupon",
                data: {
                    'get': 'coupon'
                },
                type: 'POST',
                success: function (data) {
                    $("#coupon").html(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }

        function deleteCoupon(coupon_id) {
            $.ajax({
                url: "<?php echo base_url(); ?>main/deleteCoupon",
                data: {
                    'id': coupon_id
                },
                type: 'POST',
                success: function (data) {
                    if (data == true) {
                        showMessage('Good Job !!', 'Offer Successfully Deleted!!!!', 'success');
                        getDataCoupon();
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