<?php include('header.php');
$pageName = "subscription";
$subPageName = "subscription";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <input type="hidden" id="tablename" value="subscription">
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
                            <h1>Subscription</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Subscription</li>
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
                                                    <input type="text" name="name" id="search_name" class="form-control" placeholder="Category Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <select class="form-control" name="status" id="search_status">
                                                        <option value="1">Enable</option>
                                                        <option value="0">Disable</option>
                                                    </select>
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
                                        <h3 class="card-title">Subscription List</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Shop Type</th>
                                                    <th>For</th>
                                                    <th>Name</th>
                                                    <th>Original Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Validity</th>
                                                    <th>Description</th>
                                                    <th>Profit</th>
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
                                                    <th>Shop Type</th>
                                                    <th>For</th>
                                                    <th>Name</th>
                                                    <th>Original Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Validity</th>
                                                    <th>Description</th>
                                                    <th>Profit</th>
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
        <div class="modal fade" id="insertModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-white">Add Subscription</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="insertForm" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="status" id="status" value="1">
                                <input type="hidden" name="ip" id="ip" value="<?php echo getRealIpAddr(); ?>">
                                <input type="hidden" name="date" id="date" value="<?php echo sys_date() ?>">
                                <input type="hidden" name="time" id="time" value="<?php echo sys_time() ?>">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Shop Type<span id="shopTypeMessage"></span></label>
                                    <select name="shop_type" id="shop_type" class="form-control" onblur="checkDetails('shop_type','shopTypeMessage');" required>
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
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Name Of Subscription<span id="nameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="name" onblur="checkDetails('name','nameMessage');" placeholder="eg. Premium, Silver etc" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Original Price<span id="originalPriceMessage"></span></label>
                                    <input type="number" class="form-control" name="original_price" id="original_price" onblur="checkDetails('original_price','originalPriceMessage');" placeholder="Original Price" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Selling Price<span id="sellingPriceMessage"></span></label>
                                    <input type="number" class="form-control" name="selling_price" id="selling_price" onblur="checkDetails('selling_price','sellingPriceMessage');" placeholder="eg. Premium, Silver etc" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Validity<span id="validityNumberMessage"></span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="validity_number" id="validity_number" onblur="checkDetails('validity_number','validityNumberMessage');" placeholder="10 days, 2 months etc" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="validity_type">
                                                <option value="days">days</option>
                                                <option value="month">month</option>
                                                <option value="year">year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Subscription For<span id="typeMessage"></span></label>
                                    <select name="type" id="type" class="form-control" onblur="checkDetails('type','typeMessage');" required>
                                        <option value="">-- Select Subscription For --</option>
                                        <option value="both">Both</option>
                                        <option value="new">New User</option>
                                        <option value="old">Old User(Renewal)</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Description<span id="descriptionMessage"></span></label>
                                    <textarea class="form-control" name="description" id="description" onblur="checkDetails('description','descriptionMessage');" placeholder="About Subscription" required></textarea>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Profit<span id="profitMessage"></span></label>
                                    <textarea class="form-control" name="profit" id="profit" onblur="checkDetails('profit','profitMessage');" placeholder="Profits of subscription" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light ">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Unit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="status" id="edit_status" value="1">
                                <input type="hidden" name="ip" id="edit_ip" value="<?php echo getRealIpAddr(); ?>">
                                <input type="hidden" name="date" id="edit_date" value="<?php echo sys_date() ?>">
                                <input type="hidden" name="time" id="edit_time" value="<?php echo sys_time() ?>">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Shop Type<span id="eshopTypeMessage"></span></label>
                                    <select name="shop_type" id="edit_shop_type" class="form-control" onblur="checkDetails('edit_shop_type','eshopTypeMessage');" required>
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
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Name Of Subscription<span id="enameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="edit_name" onblur="checkUniqueDetails('edit_name','enameMessage','name');" placeholder="eg. Premium, Silver etc" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Original Price<span id="eoriginalPriceMessage"></span></label>
                                    <input type="number" class="form-control" name="original_price" id="edit_original_price" onblur="checkDetails('edit_original_price','eoriginalPriceMessage');" placeholder="Original Price" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Selling Price<span id="esellingPriceMessage"></span></label>
                                    <input type="number" class="form-control" name="selling_price" id="edit_selling_price" onblur="checkDetails('edit_selling_price','esellingPriceMessage');" placeholder="eg. Premium, Silver etc" required>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Validity<span id="evalidityNumberMessage"></span></label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="number" class="form-control" name="validity_number" id="edit_validity_number" onblur="checkDetails('edit_validity_number','evalidityNumberMessage');" placeholder="10 days, 2 months etc" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="validity_type">
                                                <option value="days">days</option>
                                                <option value="month">month</option>
                                                <option value="year">year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Subscription For<span id="etypeMessage"></span></label>
                                    <select name="type" id="edit_type" class="form-control" onblur="checkDetails('edit_type','etypeMessage');" required>
                                        <option value="">-- Select Subscription For --</option>
                                        <option value="both">Both</option>
                                        <option value="new">New User</option>
                                        <option value="old">Old User(Renewal)</option>
                                    </select>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Description<span id="edescriptionMessage"></span></label>
                                    <textarea class="form-control" name="description" id="edit_description" onblur="checkDetails('edit_description','edescriptionMessage');" placeholder="About Subscription" required></textarea>
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Profit<span id="eprofitMessage"></span></label>
                                    <textarea class="form-control" name="profit" id="edit_profit" onblur="checkDetails('edit_profit','eprofitMessage');" placeholder="Profits of subscription" required></textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light ">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                url: "<?php echo base_url() ?>ajax/subscriptionListing/getSubscription",
                type: 'POST',
                data: {
                    'shop_type': $("#search_shop_type").val(),
                    'name': $("#search_name").val(),
                    'status': $("#search_status").val(),
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
</script>

</html>