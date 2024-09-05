<?php include('header.php');
$pageName = "order";
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
                            <h1>Orders List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Orders List</li>
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
                                            <h3 class="card-title">Vendors Orders List</h3>
                                        </div>
                                        <?php include('php-assets/actions.php') ?>
                                    </div>
                                </div>
                                <?php
                                if ($permission['searchButton'] == "yes") {
                                    ?>
                                    <div class="card-body collapse" id="searchData">
                                        <form method="POST" id="searchForm">
                                            <input type="hidden" id="search_vendor_id" value="<?php echo $vendor_id ?>">
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="user_id" id="search_user_id">
                                                        <option value="">-- Select User --</option>
                                                        <?php
                                                        foreach ($vendorUserList->result() as $vendorUserListRow) {
                                                            ?>
                                                            <option value="<?php echo $vendorUserListRow->id ?>"><?php echo $vendorUserListRow->full_name . '-' . $vendorUserListRow->mobile_no ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" name="order_no" id="search_order_no"
                                                        class="form-control" placeholder="Order Number">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="order_status"
                                                        id="search_order_status">
                                                        <option value="">-- Order Status --</option>
                                                        <option value="0">Pending</option>
                                                        <option value="1">Accepted</option>
                                                        <option value="2">Packed</option>
                                                        <option value="3">Out For Delivery</option>
                                                        <option value="4">Delivered</option>
                                                        <option value="5">Cancelled</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="delivery_type"
                                                        id="search_delivery_type">
                                                        <option value="">-- Delivery Type --</option>
                                                        <option value="0">Delivery</option>
                                                        <option value="1">Pickup</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="payment_mode"
                                                        id="search_payment_mode">
                                                        <option value="">-- Payment Mode --</option>
                                                        <option value="online">Online</option>
                                                        <option value="cod">Cash On Delivery</option>
                                                        <option value="upi">UPI</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" name="order_start_date"
                                                        id="order_start_date" type="date">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" name="order_end_date" id="order_end_date"
                                                        type="date">
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
                                        <h3 class="card-title">Vendors Orders List <span class="text-danger">
                                            </span></h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>User</th>
                                                    <th>OrderNo</th>
                                                    <th>Total Amount</th>
                                                    <th>Delivery Type</th>
                                                    <th>Payment Mode</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>User</th>
                                                    <th>OrderNo</th>
                                                    <th>Total Amount</th>
                                                    <th>Delivery Type</th>
                                                    <th>Payment Mode</th>
                                                    <th>Order Date</th>
                                                    <th>Delivery Date</th>
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
                url: "<?php echo base_url() ?>ajax/orderListing/getVendorOrdersList",
                type: 'POST',
                data: {
                    'vendor_id': $("#search_vendor_id").val(),
                    'user_id': $("#search_user_id").val(),
                    'order_no': $("#search_order_no").val(),
                    'order_status': $("#search_order_status").val(),
                    'delivery_type': $("#search_delivery_type").val(),
                    'payment_mode': $("#search_payment_mode").val(),
                    'start_date_order': $("#order_start_date").val(),
                    'end_date_order': $("#order_end_date").val(),
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

    $(document).on('click', '.update-order-status', function () {
        var status = $(this).data('status');
        var order_id = $(this).data('id');
        var user_id = '<?php echo id_encode($vendor_id) ?>';
        $.ajax({
            url: '<?php echo base_url() ?>vendorApi/updateOrderStatus',
            type: 'POST',
            data: {
                status: status,
                order_id: order_id,
                user_id: user_id
            },
            dataType: 'json',
            headers: {
                'Auth': '59574a6b4e6d466b5a4455335a6a566d4d5463344f54466a5a47497a4e32497859546c6a5a44566b596d553d'
            },
            success: function (data) {
                listData();
            }
        })
    })
</script>

</html>