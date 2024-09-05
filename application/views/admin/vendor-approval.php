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
                            <h1>Approve Vendors</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Approval Module</li>
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
                                                    <input type="text" name="firm_name" id="search_firm_name"
                                                        class="form-control" placeholder="Firm Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" name="start_date" id="start_date"
                                                        type="date">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input class="form-control" name="end_date" id="end_date" type="date">
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
                                        <h3 class="card-title">Pending Vendors List</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Actions</th>
                                                    <th>Firm Name</th>
                                                    <th>Concern Person</th>
                                                    <th>Mobile No.</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Actions</th>
                                                    <th>Firm Name</th>
                                                    <th>Concern Person</th>
                                                    <th>Mobile No.</th>
                                                    <th>Email</th>
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
                url: "<?php echo base_url() ?>ajax/pendingApproval/getVendorApproval",
                type: 'POST',
                data: {
                    'firm_name': $("#search_firm_name").val(),
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

    $("#searchForm").submit(function (event) {
        event.preventDefault();
        listData();
    })
</script>

</html>