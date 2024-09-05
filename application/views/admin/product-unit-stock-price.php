<?php include('header.php');
$pageName = "product";
$subPageName = "add_product";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
    <style>
        .preview-img {
            width: 200px;
            height: 200px;
            margin-right: 10px;
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
                            <h1>Create Product</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Create Product</li>
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
                                    <h3 class="card-title">Create Product</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="addUitForm">
                                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id ?>">
                                        <div class="row">
                                            <div class="form-group col-md-2">
                                                <label class="form-label"><span class="text-danger">*</span>Unit Value<span id="unitValueMessage"></span></label>
                                                <input type="number" class="form-control" name="unit_value" id="unit_value" onblur="checkDetails('unit_value','unitValueMessage');" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="form-label"><span class="text-danger">*</span>Unit<span id="unitMessage"></span></label>
                                                <select class="form-control" name="unit_id" id="unit" onblur="checkDetails('unit','unitMessage');" required>
                                                    <option value="">-- Select Unit --</option>
                                                    <?php
                                                    foreach ($unitData->result() as $unitObj) {
                                                    ?>
                                                        <option value="<?php echo $unitObj->id ?>"><?php echo $unitObj->name ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="form-label"><span class="text-danger">*</span>Unit Sales Price<span id="unitSalesPriceMessage"></span></label>
                                                <input type="text" class="form-control" name="selling_price" id="unit_sales_price" onblur="checkDetails('unit_sales_price','unitSalesPriceMessage');" required>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="form-label"><span class="text-danger">*</span>Unit MRP<span id="unitMrpMessage"></span></label>
                                                <input type="text" class="form-control" name="mrp" id="unit_mrp" onblur="checkDetails('unit_mrp','unitMrpMessage');" required>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label class="form-label"><span class="text-danger">*</span>Stock Status<span id="currentStockMessage"></span></label>
                                                <select class="form-control" name="stock_status" id="stock_status" onblur="checkDetails('stock_status','currentStockMessage');" required>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12" style="text-align: center;">
                                                <hr>
                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add Product</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-body">
                                    <table id="dataListing" class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                <th>Unit Value</th>
                                                <th>Unit</th>
                                                <th>Selling Price</th>
                                                <th>MRP</th>
                                                <th>Stock Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                                <th>Unit Value</th>
                                                <th>Unit</th>
                                                <th>Selling Price</th>
                                                <th>MRP</th>
                                                <th>Stock Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include("php-assets/foot-section.php") ?>

    <script>
        $(document).on("submit", "#addUitForm", function(e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addUnitAndPrice/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Unit Successfully Added!!!!', 'success');
                        listData();
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        $(document).ready(function() {
            listData();
        })

        function listData() {
            var product_id = $("#product_id").val();
            var table = $("#dataListing").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "ajax": {
                    url: "<?php echo base_url() ?>ajax/productUnitListing/getProductUnit",
                    method: 'POST',
                    data: {
                        'product_id': product_id,
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
    </script>
</body>

</html>