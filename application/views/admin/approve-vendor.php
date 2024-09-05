<?php include('header.php');
$pageName = "vendor";
$subPageName = "pending_vendor";
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
    <input type="hidden" id="tablename" value="user">
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
                            <h1>Approve Vendor </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Pending Vendor</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if ($permission['view'] == 'yes') {
                                ?>
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-4">
                                                <h3 class="card-title text-bold">
                                                    You Are About To Approve
                                                    <span class="text-danger">
                                                        <?php echo $vendorObj->shop_name ?>
                                                    </span>
                                                </h3>
                                            </div>
                                            <div class="col-8">
                                                <p class="float-right">
                                                    1. Please Follow All The Checksum As Mentioned Below
                                                    <br>
                                                    2. To Approve Vendor You Need To Complete All The Checksum
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Create Database</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="databaseStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="databasePendingGif">
                                                <p class="text-bold">Create database and db user using following credentials
                                                </p>
                                                <p>DB Name: <span class="text-warning text-bold">
                                                        <?php echo id_decode($vendorObj->cred_bd_name) ?>
                                                    </span></p>

                                                <p>DB User: <span class="text-warning text-bold">
                                                        <?php echo id_decode($vendorObj->cred_bd_user) ?>
                                                    </span></p>

                                                <p>DB Pass: <span class="text-warning text-bold">
                                                        <?php echo id_decode($vendorObj->cred_bd_pass) ?>
                                                    </span></p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Dump Tables To Database</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="tableStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="tablePendingGif">
                                                <p class="text-bold">Tables Will Be Dumped Automatically</p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Copy Folders To Vendor</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="foldersStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="foldersPendingGif">
                                                <p class="text-bold">All Folders Will Be Copied Automatically</p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Create Database Conncetion</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="connectionStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="connectionPendingGif">
                                                <p class="text-bold">Database Conncetion For New Vendor Will Be Created
                                                    Automatically</p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Add Default Products To Database</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="productStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="productPendingGif">
                                                <p class="text-bold">All Products Will Be Dumped Automatically For Vendor
                                                </p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Add Default Slots To Database</h5>
                                                <p class="text-bold">Status: <span class="text-bold" id="slotStatus"></span>
                                                </p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="slotPendingGif">
                                                <p class="text-bold">All Slots Will Be Dumped Automatically For Vendor</p>
                                            </div>

                                            <div class="col-md-3 text-center">
                                                <h5 class="text-bold">Final Approval</h5>
                                                <p class="text-bold">Status: <span class="text-bold"
                                                        id="approvalStatus"></span></p>
                                                <img src="<?php echo base_url() ?>image/exclamation.gif"
                                                    style="width: 100px;height:100px;" id="approvalPendingGif">
                                                <p class="text-bold">Vendor Will be Approved After All Checksum Passed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("php-assets/foot-section.php") ?>
    </div>
</body>

<script>
    $(document).ready(function () {
        checkDatabaseAndUser();
    })

    setInterval(function () {
        checkDatabaseAndUser();
    }, 12000);


    function checkDatabaseAndUser() {
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/checkDataBaseStatus',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#databaseStatus').text('Connected');
                    $('#databaseStatus').addClass('text-success').removeClass('text-warning');
                    $('#databasePendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    createDatabaseTable();
                } else {
                    $('#databaseStatus').text('Pending');
                    $('#databaseStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                $('#databaseStatus').text('Pending');
                $('#databaseStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function createDatabaseTable() {
        $('#tableStatus').text('Dumping Data');
        $('#tableStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/createDatabaseTable',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#tableStatus').text('Table Dumped');
                    $('#tableStatus').addClass('text-success').removeClass('text-warning');
                    $('#tablePendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    copyFolders();
                } else {
                    $('#tableStatus').text('Pending');
                    $('#tableStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                $('#tableStatus').text('Pending');
                $('#tableStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function copyFolders() {
        $('#foldersStatus').text('Copying Folders');
        $('#foldersStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/copyFolders',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#foldersStatus').text('Folders Copied Successfully');
                    $('#foldersStatus').addClass('text-success').removeClass('text-warning');
                    $('#foldersPendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    establishConncetion();
                } else {
                    $('#foldersStatus').text('Pending');
                    $('#foldersStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                console.log(data);
                $('#foldersStatus').text('Pending');
                $('#foldersStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function establishConncetion() {
        $('#connectionStatus').text('Establishing Conncetion');
        $('#connectionStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/establishConncetion',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#connectionStatus').text('Conncetion Successfully Established');
                    $('#connectionStatus').addClass('text-success').removeClass('text-warning');
                    $('#connectionPendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    addProductsForVendor();
                } else {
                    $('#connectionStatus').text('Pending');
                    $('#connectionStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                console.log(data);
                $('#connectionStatus').text('Pending');
                $('#connectionStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function addProductsForVendor() {
        $('#productStatus').text('Adding Products');
        $('#productStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/addProductsForVendor',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#productStatus').text('All Products Successfully Dumped');
                    $('#productStatus').addClass('text-success').removeClass('text-warning');
                    $('#productPendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    addSlotForVendor();
                } else {
                    $('#productStatus').text('Pending');
                    $('#productStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                console.log(data);
                $('#productStatus').text('Pending');
                $('#productStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function addSlotForVendor() {
        $('#slotStatus').text('Adding Slots');
        $('#slotStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/addSlotForVendor',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#slotStatus').text('All Slots Successfully Dumped');
                    $('#slotStatus').addClass('text-success').removeClass('text-warning');
                    $('#slotPendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                    approveVendor();
                } else {
                    $('#slotStatus').text('Pending');
                    $('#slotStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                console.log(data);
                $('#slotStatus').text('Pending');
                $('#slotStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }

    function approveVendor() {
        $('#approvalStatus').text('Checking All Checksum');
        $('#approvalStatus').addClass('text-warning').removeClass('text-success');
        var vendor_id = '<?php echo $vendor_id ?>';
        $.ajax({
            url: '<?php echo base_url() ?>main/approveVendor',
            data: {
                vendor_id: vendor_id
            },
            type: 'POST',
            success: function (data) {
                if (data == true) {
                    $('#approvalStatus').text('Successfully Approved');
                    $('#approvalStatus').addClass('text-success').removeClass('text-warning');
                    $('#approvalPendingGif').attr('src', '<?php echo base_url() ?>image/check.gif');
                } else {
                    $('#approvalStatus').text('Pending');
                    $('#approvalStatus').addClass('text-warning').removeClass('text-success');
                }
            },
            error: function (data) {
                console.log(data);
                $('#approvalStatus').text('Pending');
                $('#approvalStatus').addClass('text-warning').removeClass('text-success');
            }
        })
    }
</script>

</html>