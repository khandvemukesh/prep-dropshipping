<?php include('header.php') ?>
<?php $pageName = "staff"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <input type="hidden" id="tablename" value="staff">
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
                            <h1>Staff</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Staff</li>
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
                                                <div class="form-group col-md-2">
                                                    <input type="text" name="name" id="search_name" class="form-control" placeholder="Staff Name">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" name="email" id="search_email" class="form-control" placeholder="Staff Email">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <input type="text" name="mobile" id="search_mobile" class="form-control" placeholder="Staff Mobile">
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
                                        <h3 class="card-title">Staff List</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataListing" class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th><input type="checkbox" id="checkAll"></th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Image</th>
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
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
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
                        <h4 class="modal-title text-white">Add Staff</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="insertStaffForm" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="status" value="1">
                                <input type="hidden" name="login_date" value="<?php echo sys_date() ?>">
                                <input type="hidden" name="login_time" value="<?php echo sys_time() ?>">
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Name <span id="nameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="name" onblur="checkDetails('name','nameMessage');" placeholder="Name">
                                </div>
                                <div class="form-group col-6 pl-1">
                                    <label class="form-label">Mobile No <span id="mobileMessage"></span></label>
                                    <input type="number" class="form-control" name="mobile" id="mobile" onblur="checkDetails('mobile','mobileMessage');" placeholder="Mobile">
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Email <span id="emailMessage"></span></label>
                                    <input type="email" class="form-control" name="email" id="email" onblur="checkDetails('email','emailMessage');" placeholder="Email">
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Password <span id="passwordMessage"></span></label>
                                    <input type="text" class="form-control" name="password" id="password" onblur="checkDetails('password','passwordMessage');" placeholder="Password">
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
                        <h4 class="modal-title">Edit Staff</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editForm" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" name="id" id="edit_id">
                                <input type="hidden" name="status" id="edit_status" value="1">
                                <input type="hidden" name="password" id="edit_password">
                                <input type="hidden" name="company" id="edit_company">
                                <input type="hidden" name="image" id="edit_image">
                                <input type="hidden" name="ip" id="edit_ip">
                                <input type="hidden" name="login_date" id="edit_login_date" value="<?php echo sys_date() ?>">
                                <input type="hidden" name="login_time" id="edit_login_time" value="<?php echo sys_time() ?>">
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Name <span id="enameMessage"></span></label>
                                    <input type="text" class="form-control" name="name" id="edit_name" onblur="checkDetails('edit_name','enameMessage');" placeholder="Name">
                                </div>
                                <div class="form-group col-6 pl-1">
                                    <label class="form-label">Mobile No <span id="emobileMessage"></span></label>
                                    <input type="number" class="form-control" name="mobile" id="edit_mobile" onblur="checkDetails('edit_mobile','emobileMessage');" placeholder="Mobile">
                                </div>
                                <div class="form-group col-6 pr-1">
                                    <label class="form-label">Email <span id="eemailMessage"></span></label>
                                    <input type="email" class="form-control" name="email" id="edit_email" onblur="checkDetails('edit_email','eemailMessage');" placeholder="Email">
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
    $(document).on('submit', '#insertStaffForm', function(event) {
        event.preventDefault();
        $("#cover").fadeIn();
        var table_name = $("#tablename").val();
        var formData = new FormData(this);
        $.ajax({
            url: "<?php echo base_url(); ?>main/addStaff/" + table_name,
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                $("#cover").fadeOut();
                if (data != false) {
                    showMessage('Good Job !!', 'Data Successfully Added!!!!', 'success');
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>main/staffPermission/" + data;
                    }, 1000)
                } else {
                    showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                }
                $('#insertStaffForm')[0].reset();
                $('#insertModal').toggle('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }
        });
    });

    $(document).ready(function() {
        listData();
    })

    function listData() {
        var table = $("#dataListing").DataTable({
            "responsive": false,
            "lengthChange": false,
            "autoWidth": false,
            "ajax": {
                url: "<?php echo base_url() ?>ajax/staffListing/getStaff",
                type: 'POST',
                data: {
                    'name': $("#search_name").val(),
                    'email': $("#search_email").val(),
                    'mobile': $("#search_mobile").val(),
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