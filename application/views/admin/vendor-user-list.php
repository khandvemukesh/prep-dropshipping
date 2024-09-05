<?php include('header.php') ?>
<?php
$pageName = "user";
$subPageName = "vendor_list";
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
                            <h1>Users List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Users List</li>
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
                                            <h3 class="card-title">Vendors Users List </h3>
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
                                                <div class="form-group col-md-4">
                                                    <input type="text" name="name" id="search_name" class="form-control"
                                                        placeholder="User Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input type="number" name="mobile" id="search_mobile"
                                                        class="form-control" placeholder="User Mobile">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input type="email" name="email" id="search_email" class="form-control"
                                                        placeholder="User Email">
                                                </div>
                                                <div class="col-12">
                                                    <center><button type="submit" class="btn btn-info btn-sm">Search <i
                                                                class="fa fa-search"></i></button></center>
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
                                        <h3 class="card-title">Vendors User List</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th>Total Orders</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th>Total Orders</th>
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
    $(document).ready(function () {
        listData();
    })

    function listData() {
        var table = $("#dataListing").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ajax": {
                url: "<?php echo base_url() ?>ajax/userListing/getVendorUsers",
                type: 'POST',
                data: {
                    'vendor_id': $("#search_vendor_id").val(),
                    'full_name': $("#search_name").val(),
                    'mobile_no': $("#search_mobile").val(),
                    'email': $("#search_email").val(),
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

    $("#searchForm").submit(function (event) {
        event.preventDefault();
        listData();
    })
</script>

</html>