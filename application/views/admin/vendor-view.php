<?php include('header.php');
$pageName = "approval_module";
$subPageName = "vendor_approval";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $company_name ?> | Home
    </title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <input type="hidden" id="tablename" value="product">
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
                            <h1>Vendor Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Vendor Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if ($permission['view'] == 'yes') {
                            ?>
                            <div class="col-md-4">
                                <div class="card card-widget widget-user-2 shadow-sm">
                                    <h5 class="font-weight-bold p-2"
                                        style="border-bottom:1px solid #ececec;margin-bottom:0px;">Basic
                                        Details</h5>
                                    <div class="widget-user-header text-left">
                                        <div class="widget-user-image text-left">
                                            <?php
                                            $firm_logo = $vendorDetailsArr['firm_logo'];
                                            if ($firm_logo != '' && file_exists('./image/vendor/profile/' . $firm_logo) == true) {
                                                ?>
                                                <img class="img-circle elevation-2"
                                                    src="<?php echo base_url() ?>image/vendor/profile/<?php echo $firm_logo ?>"
                                                    alt="User Avatar">
                                                <?php
                                            } else {
                                                ?>
                                                <img class="img-circle elevation-2" src="<?php echo base_url() ?>image/user.png"
                                                    alt="User Avatar">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Firm Name: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['firm_name'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Concern Person: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['concern_person'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Mobile Number: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['mobile_no'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Email: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['email'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">GST Number: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['gst_no'] ?>
                                            </span>
                                        </div>
                                        <?php
                                        if ($type == "approval") {
                                            if ($vendorDetailsArr['basic_details_verification'] == 0) {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-warning">Pending</span>
                                                </div>

                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-success"
                                                        onclick="approveVendor('basic_details_verification');">Approve</button>
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                        data-target="#rejectionModal"
                                                        onclick="setColumn('basic_details_verification');">Reject</button>
                                                </div>
                                                <?php
                                            } elseif ($vendorDetailsArr['basic_details_verification'] == 2) {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-danger">Rejected</span>
                                                </div>
                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-success"
                                                        onclick="approveVendor('basic_details_verification');">Approve</button>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-success">Approved</span>
                                                </div>
                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                        data-target="#rejectionModal"
                                                        onclick="setColumn('basic_details_verification');">Reject</button>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="card card-widget widget-user-2 shadow-sm">
                                    <h5 class="font-weight-bold p-2"
                                        style="border-bottom:1px solid #ececec;margin-bottom:0px;">Address
                                        Details</h5>
                                    <div class="widget-user-header text-left">
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Address Line1: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['address_line1'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Address Line2: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['address_line2'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Landmark: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['landmark'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">Pincode: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['pincode'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">State: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['state'] ?>
                                            </span>
                                        </div>
                                        <div class="vendor-details-box">
                                            <span class="vendor-details-title">City: </span>
                                            <span class="vendor-details-desc">
                                                <?php echo $vendorDetailsArr['city'] ?>
                                            </span>
                                        </div>
                                        <?php
                                        if ($type == "approval") {
                                            if ($vendorDetailsArr['address_details_verification'] == 0) {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-warning">Pending</span>
                                                </div>

                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-success"
                                                        onclick="approveVendor('address_details_verification');">Approve</button>
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                        data-target="#rejectionModal"
                                                        onclick="setColumn('address_details_verification');">Reject</button>
                                                </div>
                                                <?php
                                            } elseif ($vendorDetailsArr['address_details_verification'] == 2) {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-danger">Rejected</span>
                                                </div>
                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-success"
                                                        onclick="approveVendor('address_details_verification');">Approve</button>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="vendor-details-box">
                                                    <span class="vendor-details-title">Status: </span>
                                                    <span class="badge badge-success">Approved</span>
                                                </div>
                                                <div class="vendor-details-box">
                                                    <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                        data-target="#rejectionModal"
                                                        onclick="setColumn('address_details_verification');">Reject</button>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="card card-widget widget-user-2 shadow-sm">
                                    <h5 class="font-weight-bold p-2"
                                        style="border-bottom:1px solid #ececec;margin-bottom:0px;">Documents</h5>
                                    <div class="widget-user-header text-left">
                                        <span class="font-weight-bold text-danger">* Click on image to open</span>
                                        <table class="table table-striped mt-2">
                                            <tr>
                                                <th>S.no.</th>
                                                <th>Document</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <?php
                                                if ($type == "approval") {
                                                    ?>
                                                    <th>Action</th>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Aadhaar Card Front</td>
                                                <td>
                                                    <?php
                                                    $aadhaar_img = $vendorDetailsArr['aadhaar_img'];
                                                    if ($aadhaar_img != '' && file_exists('./image/vendor/document/' . $aadhaar_img) == true) {
                                                        ?>
                                                        <img class="elevation-2 img-open"
                                                            src="<?php echo base_url() ?>image/vendor/document/<?php echo $aadhaar_img ?>"
                                                            alt="User Avatar" style="width:150px;">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-circle elevation-2"
                                                            src="<?php echo base_url() ?>image/no-image.png" alt="User Avatar">
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                if ($type == "approval") {
                                                    if ($vendorDetailsArr['aadhaar_front_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('aadhaar_front_verification');">Approve</button>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('aadhaar_front_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    } elseif ($vendorDetailsArr['aadhaar_front_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-danger">Rejected</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('aadhaar_front_verification');">Approve</button>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-success">Approved</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('aadhaar_front_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Aadhaar Card Back</td>
                                                <td>
                                                    <?php
                                                    $aadhaar_img_back = $vendorDetailsArr['aadhaar_img_back'];
                                                    if ($aadhaar_img_back != '' && file_exists('./image/vendor/document/' . $aadhaar_img_back) == true) {
                                                        ?>
                                                        <img class="elevation-2 img-open"
                                                            src="<?php echo base_url() ?>image/vendor/document/<?php echo $aadhaar_img_back ?>"
                                                            alt="User Avatar" style="width:150px;">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-circle elevation-2"
                                                            src="<?php echo base_url() ?>image/no-image.png" alt="User Avatar">
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                if ($type == "approval") {
                                                    if ($vendorDetailsArr['aadhaar_back_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('aadhaar_back_verification');">Approve</button>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('aadhaar_back_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    } elseif ($vendorDetailsArr['aadhaar_back_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-danger">Rejected</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('aadhaar_back_verification');">Approve</button>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-success">Approved</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('aadhaar_back_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>PAN Card</td>
                                                <td>
                                                    <?php
                                                    $pan_img = $vendorDetailsArr['pan_img'];
                                                    if ($pan_img != '' && file_exists('./image/vendor/document/' . $pan_img) == true) {
                                                        ?>
                                                        <img class="elevation-2 img-open"
                                                            src="<?php echo base_url() ?>image/vendor/document/<?php echo $pan_img ?>"
                                                            alt="User Avatar" style="width:150px;">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-circle elevation-2"
                                                            src="<?php echo base_url() ?>image/no-image.png" alt="User Avatar">
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php
                                                if ($type == "approval") {
                                                    if ($vendorDetailsArr['pan_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-warning">Pending</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('pan_verification');">Approve</button>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('pan_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    } elseif ($vendorDetailsArr['pan_verification'] == 0) {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-danger">Rejected</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-success"
                                                                onclick="approveVendor('pan_verification');">Approve</button>
                                                        </td>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td>
                                                            <span class="badge badge-success">Approved</span>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-xs btn-danger" data-toggle="modal"
                                                                data-target="#rejectionModal"
                                                                onclick="setColumn('pan_verification');">Reject</button>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" id="rejectionModal" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-white">Enter Reason To Reject</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12 pr-1">
                                <input type="hidden" id="column" name="column">
                                <textarea class="form-control" name="verification_message" id="verification_message"
                                    placeholder="Enter Reason For Rejection" rows="10" required>
                                    <?php echo $vendorDetailsArr['verification_message'] ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm waves-effect "
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger btn-sm waves-effect waves-light"
                                onclick="rejectVendor();">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("php-assets/foot-section.php") ?>
        <script>
            function approveVendor(column) {
                let vendor_id = '<?php echo $vendor_id_encoded ?>';
                $.ajax({
                    url: "<?php echo base_url() ?>main/approveVendor",
                    type: "POST",
                    data: {
                        column: column,
                        vendor_id: vendor_id
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data['status'] == true) {
                            showMessage('Good Job !!', data['message'], 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        } else {
                            showMessage('Ooopsssss !!!', data['message'], 'error');
                        }
                    }
                })
            }

            function setColumn(column) {
                $("#column").val(column);
            }

            function rejectVendor() {
                let vendor_id = '<?php echo $vendor_id_encoded ?>';
                let verification_message = $("#verification_message").val();
                let column = $("#column").val();
                $.ajax({
                    url: "<?php echo base_url() ?>main/rejectVendor",
                    type: "POST",
                    data: {
                        column: column,
                        vendor_id: vendor_id,
                        verification_message: verification_message
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data['status'] == true) {
                            showMessage('Good Job !!', data['message'], 'success');
                            setTimeout(() => {
                                location.reload();
                            }, 2000)
                        } else {
                            showMessage('Ooopsssss !!!', data['message'], 'error');
                        }
                    }
                })
            }


        </script>
    </div>
</body>

</html>