<?php include('header.php');
$pageName = "vendor";
$subPageName = "pending_vendor";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
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
                            <h1>Pending Vendor's List</h1>
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
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <?php include('php-assets/card-tools.php') ?>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h3 class="card-title">Apply Filter</h3>
                                        </div>
                                        <?php include('php-assets/actions.php') ?>
                                    </div>
                                </div>
                                <?php
                                if ($permission['searchButton'] == "yes") {
                                ?>
                                    <div class="card-body collapse" id="searchData">
                                        <form method="POST" id="searchForm">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <select name="shop_type" id="search_shop_type" class="form-control">
                                                        <option value="">-- Select Shop Type --</option>
                                                        <?php
                                                        foreach ($shopTypeData->result() as $shopTypeObj) {
                                                        ?>
                                                            <option value="<?php echo $shopTypeObj->id ?>"><?php echo $shopTypeObj->name ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" name="shop_name" id="search_shop_name" class="form-control" placeholder="Shop Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" name="name" id="search_name" class="form-control" placeholder="User Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" name="email" id="search_email" class="form-control" placeholder="Email">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="number" name="mobile" id="search_mobile" class="form-control" placeholder="Mobile">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" name="pincode" id="search_pincode" class="form-control" placeholder="Pincode">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" name="start_date" id="start_date" type="date">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" name="end_date" id="end_date" type="date">
                                                </div>
                                                <div class="col-12">
                                                    <center><button type="submit" class="btn btn-info btn-sm">Search <i class="fa fa-search"></i></button></center>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                            <?php
                            if ($permission['view'] == 'yes') {
                            ?>
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Pending Vendor's List</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm nowrap">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Image</th>
                                                    <th>Android Code</th>
                                                    <th>Unique Code</th>
                                                    <th>Shop Name</th>
                                                    <th>Shop Type</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Shop Address1</th>
                                                    <th>Shop Address2</th>
                                                    <th>Pincode</th>
                                                    <th>Area</th>
                                                    <th>District</th>
                                                    <th>State</th>
                                                    <th>ShopImages</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Select</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Image</th>
                                                    <th>Android Code</th>
                                                    <th>Unique Code</th>
                                                    <th>Shop Name</th>
                                                    <th>Shop Type</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Shop Address1</th>
                                                    <th>Shop Address2</th>
                                                    <th>Pincode</th>
                                                    <th>Area</th>
                                                    <th>District</th>
                                                    <th>State</th>
                                                    <th>ShopImages</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    $(document).ready(function() {
        listData();
    })

    function listData() {
        var table = $("#dataListing").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ajax": {
                url: "<?php echo base_url() ?>ajax/vendorListing/getPendingVendor",
                type: 'POST',
                data: {
                    'shop_type': $("#search_shop_type").val(),
                    'full_name': $("#search_name").val(),
                    'shop_name': $("#search_shop_name").val(),
                    'email': $("#search_email").val(),
                    'mobile': $("#search_mobile").val(),
                    'shop_pincode': $("#search_pincode").val(),
                    'status': '0',
                    'start_date': $("#start_date").val(),
                    'end_date': $("#end_date").val(),
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

    $("#searchForm").submit(function(event) {
        event.preventDefault();
        listData();
    })

    $(document).on('submit', '#credentialsForm', function(e) {
        e.preventDefault();
        var id = $("#vendor_id").val();
        var cred_sub_main = $("#cred_sub_main").val();
        var cred_bd_host = $("#cred_bd_host").val();
        var cred_bd_user = $("#cred_bd_user").val();
        var cred_bd_pass = $("#cred_bd_pass").val();
        var cred_bd_name = $("#cred_bd_name").val();
        if (id != "" && cred_sub_main != "" && cred_bd_host != "" && cred_bd_user != "" && cred_bd_pass != "" && cred_bd_name != "") {
            $.ajax({
                url: "<?php echo base_url() ?>main/approveVendor",
                data: {
                    id: id,
                    cred_sub_main: cred_sub_main,
                    cred_bd_host: cred_bd_host,
                    cred_bd_user: cred_bd_user,
                    cred_bd_pass: cred_bd_pass,
                    cred_bd_name: cred_bd_name
                },
                type: 'POST',
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        $('#credentialsForm')[0].reset();
                        $('#approveModal').toggle('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        listData();
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        } else {
            showMessage("Oops !!!!", "Required fields cannot be empty", "error");
        }
    })
</script>

</html>