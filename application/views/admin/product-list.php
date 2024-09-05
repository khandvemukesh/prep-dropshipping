<?php include('header.php') ?>
<?php
$pageName = "product";
$subPageName = "list_product";
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
                            <h1>Product List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Product List</li>
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
                                            <button class="btn bg-gradient-info btn-xs ml-2" data-toggle="modal" data-target="#categoryModal">
                                                <i class="fa fa-list" data-toggle="tooltip" title="Add Category To Product"></i>
                                                Add Category
                                            </button>
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
                                                <div class="form-group col-md-2">
                                                    <input type="text" name="name" id="search_name" class="form-control" placeholder="Product Name">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="category" id="search_category">
                                                        <option value="">-- Select Category --</option>
                                                        <?php
                                                        foreach ($categoryData->result() as $categoryRow) {
                                                        ?>
                                                            <option value="<?php echo $categoryRow->id ?>">
                                                                <?php echo $categoryRow->name ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="sub_category" id="search_sub_category">
                                                        <option value="">-- Select Sub Category --</option>
                                                        <?php
                                                        foreach ($subCategoryData->result() as $subCategoryRow) {
                                                        ?>
                                                            <option value="<?php echo $subCategoryRow->id ?>">
                                                                <?php echo $subCategoryRow->name ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="shop_type" id="shop_type_category">
                                                        <option value="">-- Select Shop Type --</option>
                                                        <?php
                                                        foreach ($shopTypeData->result() as $shopTypeRow) {
                                                        ?>
                                                            <option value="<?php echo $shopTypeRow->id ?>">
                                                                <?php echo $shopTypeRow->name ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <select class="form-control" name="status" id="search_status">
                                                        <option value="1">Enable</option>
                                                        <option value="0">Disable</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input class="form-control" name="start_date" id="start_date" type="date">
                                                </div>
                                                <div class="form-group col-md-2">
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
                                        <h3 class="card-title">Product List</h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Featured</th>
                                                    <th>Sponsored</th>
                                                    <th>Image</th>
                                                    <th>Shop Type</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                    <th>Brand</th>
                                                    <th>GST</th>
                                                    <th>Description</th>
                                                    <th>Country Of Origin</th>
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
                                                    <th>Featured</th>
                                                    <th>Sponsored</th>
                                                    <th>Image</th>
                                                    <th>Shop Type</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                    <th>Brand</th>
                                                    <th>GST</th>
                                                    <th>Description</th>
                                                    <th>Country Of Origin</th>
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

        <div class="modal fade" id="categoryModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-white">Add Categories</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label">Category<span id="categoryMessage"></span></label>
                                <select name="category_id" id="category_id" class="form-control" onblur="getOptions('category_id','categoryMessage','sub_category','category',this.value,'sub_category_id','name');">
                                    <option value="">-- Select Category --</option>
                                    <?php
                                    foreach ($categoryData->result() as $categoryObj) {
                                    ?>
                                        <option value="<?php echo $categoryObj->id ?>">
                                            <?php echo $categoryObj->name ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">Sub Category<span id="subCategoryMessage"></span></label>
                                <select name="sub_category_id" id="sub_category_id" class="form-control" onblur="checkDetails('sub_category_id','subCategoryMessage');">
                                    <option value="">-- Select Sub Category --</option>
                                    <?php
                                    foreach ($subCategoryData->result() as $subCategoryObj) {
                                    ?>
                                        <option value="<?php echo $subCategoryObj->id ?>">
                                            <?php echo $subCategoryObj->name ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm waves-effect " data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" id="addCategoryToProduct">Save changes</button>
                        </div>
                    </div>
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
                url: "<?php echo base_url() ?>ajax/productListing/getProduct",
                type: 'POST',
                data: {
                    'product_name': $("#search_name").val(),
                    'category': $("#search_category").val(),
                    'sub_category': $("#search_sub_category").val(),
                    'shop_type': $("#search_shop_type").val(),
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

    function getProductImages(product_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>main/getProductImage",
            data: {
                product_id: product_id
            },
            type: 'POST',
            success: function(data) {

            }
        });
    }

    $("#addCategoryToProduct").click(function() {
        var category_id = $("#category_id").val();
        var sub_category_id = $("#sub_category_id").val();
        var checkbox = $(".checkbox_delete:checked");
        if (checkbox.length > 0) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You Want To Add Selected Products To Category",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Change Category!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var checkbox_value = [];
                    $(checkbox).each(function() {
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        url: "<?php echo base_url() ?>main/addProductToCategory",
                        type: "POST",
                        data: {
                            "checkbox_value": checkbox_value,
                            "sub_category_id": sub_category_id,
                            "category_id": category_id
                        },
                        success: function(data) {
                            listData();
                        }
                    })
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Data is safe :)',
                        'error'
                    )
                }
            })
        } else {
            showMessage("Oops !!!!", "Please Select At Least One Record", "error");
        }
    });

    $(document).on('click', '.change-status', function(e) {
        var id = $(this).data('id');
        var column = $(this).data('column');
        var status = $(this).data('status');
        $.ajax({
            url: "<?php echo base_url() ?>main/changeProductStatus",
            data: {
                id: id,
                column: column,
                status: status,
            },
            type: "POST",
            success: function(data) {
                listData();
            }
        })
    })
</script>

</html>