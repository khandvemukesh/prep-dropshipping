<?php include('header.php');
$pageName = "basics";
$subPageName = "sub_category";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <input type="hidden" id="tablename" value="sub_category">
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
                            <h1>Sub Category</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Category</li>
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
                                                    <select name="category" id="search_category" class="form-control">
                                                        <option value="">-- Select Category --</option>
                                                        <?php
                                                        foreach ($categoryData->result() as $categoryObj) {
                                                        ?>
                                                            <option value="<?php echo $categoryObj->id ?>"><?php echo $categoryObj->name ?></option>
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
                                        <h3 class="card-title">Sub Category List</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Ststus</th>
                                                    <th>Actions</th>
                                                    <th>Category</th>
                                                    <th>SubCategory</th>
                                                    <th>Image</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Select</th>
                                                    <th>Ststus</th>
                                                    <th>Actions</th>
                                                    <th>Category</th>
                                                    <th>SubCategory</th>
                                                    <th>Image</th>
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
                        <h4 class="modal-title text-white">Add Sub Category</h4>
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
                                <div class="form-group col-md-12">
                                    <label class="form-label">Category<span id="categoryMessage"></span></label>
                                    <select name="category" id="category" class="form-control" onblur="checkDetails('category','categoryMessage');">
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        foreach ($categoryData->result() as $categoryObj) {
                                        ?>
                                            <option value="<?php echo $categoryObj->id ?>"><?php echo $categoryObj->name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Name Of Sub Category<span id="nameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="name" onblur="checkUniqueDetails('name','nameMessage','name');" placeholder="eg. Grocery, Medical etc">
                                </div>
                                <div class="form-group col-md-12">
                                    <center><img id="blah" src="<?php echo base_url() ?>image/default-image.png" alt="City Image" class="img img-circle img-thumbnail img-responsive" width="150" height="150"></center>
                                    <input class="form-control" type='file' onchange="readURL(this);" id="image" name="image" accept="image/*" required />
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

        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Sub Category</h4>
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
                                <div class="form-group col-md-12">
                                    <label class="form-label">Category<span id="ecategoryMessage"></span></label>
                                    <select name="category" id="edit_category" class="form-control" onblur="checkDetails('edit_category','ecategoryMessage');">
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        foreach ($categoryData->result() as $categoryObj) {
                                        ?>
                                            <option value="<?php echo $categoryObj->id ?>"><?php echo $categoryObj->name ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Name Of Sub Category <span id="enameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="edit_name" onblur="checkUniqueDetails('edit_name','enameMessage','name');" placeholder="eg.  etc">
                                </div>
                                <div class="form-group col-md-12">
                                    <center><img id="edit_blah" src="<?php echo base_url() ?>image/default-image.png" alt="Sub Category Image" class="img img-circle img-thumbnail img-responsive" width="150" height="150"></center>
                                    <input class="form-control" type='file' onchange="readURLEdit(this);" id="eimage" name="image" accept="image/*" />
                                    <input type="hidden" name="oldImage" id="edit_image">
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
                url: "<?php echo base_url() ?>ajax/subCategoryListing/getSubCategory",
                type: 'POST',
                data: {
                    'category': $("#search_category").val(),
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