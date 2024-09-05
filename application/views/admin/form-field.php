<?php include('header.php');
$pageName = "basics";
$subPageName = "form_field";
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
    <input type="hidden" id="tablename" value="form_fields">
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
                            <h1>Form Fields</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Form Fields</li>
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
                                                    <select name="super_category_id" id="search_super_category_id"
                                                        class="form-control">
                                                        <option value="">-- Select Super Category --</option>
                                                        <?php
                                                        foreach ($shopTypeData->result() as $shopTypeObj) {
                                                            ?>
                                                            <option value="<?php echo $shopTypeObj->id ?>">
                                                                <?php echo $shopTypeObj->name ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <input type="text" name="field_name" id="search_field_name"
                                                        class="form-control" placeholder="Field Name">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <select class="form-control" name="status" id="search_status">
                                                        <option value="1">Enable</option>
                                                        <option value="0">Disable</option>
                                                    </select>
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
                                        <h3 class="card-title">Form Fields List</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Super Category</th>
                                                    <th>Field Name</th>
                                                    <th>Field Type</th>
                                                    <th>Field Validation</th>
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
                                                    <th>Super Category</th>
                                                    <th>Field Name</th>
                                                    <th>Field Type</th>
                                                    <th>Field Validation</th>
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
        <div class="modal fade" id="insertModal" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-white">Add Form Fields</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="insertFormFields" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="status" id="status" value="1">
                                <input type="hidden" name="ip" id="ip" value="<?php echo getRealIpAddr(); ?>">
                                <input type="hidden" name="date" id="date" value="<?php echo sys_date() ?>">
                                <input type="hidden" name="time" id="time" value="<?php echo sys_time() ?>">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Super Category<span id="shopTypeMessage"></span></label>
                                    <select name="shop_type" id="shop_type" class="form-control"
                                        onblur="checkDetails('shop_type','shopTypeMessage');">
                                        <option value="">-- Select Super Category --</option>
                                        <?php
                                        foreach ($shopTypeData->result() as $shopTypeObj) {
                                            ?>
                                            <option value="<?php echo $shopTypeObj->id ?>">
                                                <?php echo $shopTypeObj->name ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Field Name <span id="fieldNameMessage"></span></label>
                                    <input type="text" class="form-control" name="field_name" id="field_name"
                                        onblur="checkUniqueDetails('field_name','fieldNameMessage','field_name');"
                                        placeholder="eg. fabric, processor">
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Select Type<span id="typeMessage"></span></label>
                                    <select class="form-control" name="field_type" id="field_type"
                                        onchange="checkFieldType('field_type','typeMessage');">
                                        <option value="">-- Select Type --</option>
                                        <option value="input">Input Field</option>
                                        <option value="select">Select Field</option>
                                        <option value="textarea">Description Field</option>
                                        <option value="date">Date Field</option>
                                        <option value="time">Time Field</option>
                                    </select>
                                </div>
                                <div id="fieldValues" class="col-md-12">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm waves-effect "
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light ">Save
                                    changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Category</h4>
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
                                    <label class="form-label">Super Category<span id="eshopTypeMessage"></span></label>
                                    <select name="super_category_id" id="edit_super_category_id" class="form-control"
                                        onblur="checkDetails('edit_super_category_id','eshopTypeMessage');">
                                        <option value="">-- Select Super Category --</option>
                                        <?php
                                        foreach ($shopTypeData->result() as $shopTypeObj) {
                                            ?>
                                            <option value="<?php echo $shopTypeObj->id ?>">
                                                <?php echo $shopTypeObj->name ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Name Of Category <span id="enameMessage"></span></label>
                                    <input type="text" class="form-control" name="field_name" id="edit_field_name"
                                        onblur="checkUniqueDetails('edit_field_name','enameMessage','name');"
                                        placeholder="eg. Fruites, Vegitables etc">
                                </div>
                                <div class="form-group col-12 pr-1">
                                    <label class="form-label">Select Type<span id="etypeMessage"></span></label>
                                    <select class="form-control" name="field_type" id="edit_field_type"
                                        onchange="checkFieldType('edit_field_type','etypeMessage');">
                                        <option value="">-- Select Type --</option>
                                        <option value="input">Input Field</option>
                                        <option value="select">Select Field</option>
                                        <option value="textarea">Description Field</option>
                                        <option value="date">Date Field</option>
                                        <option value="time">Time Field</option>
                                    </select>
                                </div>

                            </div>
                            <hr>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm waves-effect "
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light ">Save
                                    changes</button>
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
    $(document).ready(function () {
        listData();
    })

    function listData() {
        var table = $("#dataListing").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ajax": {
                url: "<?php echo base_url() ?>ajax/formFieldListing/getFormField",
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

    $("#searchForm").submit(function (event) {
        event.preventDefault();
        listData();
    })

    function checkFieldType(inputId, showId) {
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = "Req.";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            var message = "Good";
            $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-success").removeClass("text-danger");
            if (inputVal == "select") {
                var html = '<div class="col-md-12"><button type="button" onclick="addMoreValue()" class="btn btn-xs btn-info mb-2">Add More</button></div>';
                html += '<div class="form-group col-md-12">';
                html += '<label class="form-label">Select Value</label>';
                html += '<input type="text" class="form-control" name="form_field_value[]" placeholder="Values">';
                html += '</div>';
                $("#fieldValues").html(html);
            }
        }
    }

    function addMoreValue() {
        var html = '<div class="form-group col-md-12">';
        html += '<label class="form-label">Select Value</label>';
        html += '<input type="text" class="form-control" name="form_field_value[]" placeholder="Values">';
        html += '</div>';
        $("#fieldValues").append(html);
    }

    $(document).on('submit', '#insertFormFields', function (event) {
        event.preventDefault();
        if ($("#insertFormFields").find('input.is-invalid').length == 0) {
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/insertFormFields/",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType: 'json',
                success: function (data) {
                    var table = $('#dataListing').DataTable();
                    table.ajax.reload();
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Data Successfully Added!!!!', 'success');
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                    $('#insertFormFields')[0].reset();
                    $('#insertModal').toggle('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            });
        } else {
            showMessage('Ooops !!', 'Wrong Data', 'danger');
        }
    });
</script>

</html>