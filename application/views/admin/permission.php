<?php include('header.php') ?>
<?php $pageName = "staff"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
    <?php include('php-assets/head-section.php') ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <input type="hidden" id="tablename" value="permission">
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
                            <h1>Staff Permissions</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url() . 'staff/1'; ?>">Staff</a></li>
                                <li class="breadcrumb-item active">Staff Permission</li>
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
                                    <h3 class="card-title">Staff Permission</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered nowrap table-condensed">
                                        <thead>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Type</th>
                                                <th>All</th>
                                                <th>Add</th>
                                                <th>View</th>
                                                <th>Search</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                <th>Notification</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>SNo</th>
                                                <th>Type</th>
                                                <th>All</th>
                                                <th>Add</th>
                                                <th>View</th>
                                                <th>Search</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                                <th>Notification</th>
                                                <th>Message</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            if ($pagedata->num_rows() > 0) {
                                                $i = 1;
                                                foreach ($pagedata->result() as $data) {
                                                    if (($data->add_data == "yes" || $data->add_data == "") && ($data->view_data == "yes" || $data->view_data == "") && ($data->search_data == "yes" || $data->search_data == "") && ($data->update_data == "yes" || $data->update_data == "") && ($data->delete_data == "yes" || $data->delete_data == "") && ($data->notification_data == "yes" || $data->notification_data == "") && ($data->message_data == "yes" || $data->message_data == "")) {
                                                        $all = "yes";
                                                    } else {
                                                        $all = "no";
                                                    }
                                                    if ($all == "yes") {
                                                        $all_button = "btn-success";
                                                        $change_status_to = "no";
                                                    } else {
                                                        $all_button = "btn-danger";
                                                        $change_status_to = "yes";
                                                    }

                                                    if ($data->add_data == "yes") {
                                                        $add_button = "btn-success";
                                                        $change_add_status_to = "no";
                                                    } else {
                                                        $add_button = "btn-danger";
                                                        $change_add_status_to = "yes";
                                                    }

                                                    if ($data->view_data == "yes") {
                                                        $view_button = "btn-success";
                                                        $change_view_status_to = "no";
                                                    } else {
                                                        $view_button = "btn-danger";
                                                        $change_view_status_to = "yes";
                                                    }

                                                    if ($data->search_data == "yes") {
                                                        $search_button = "btn-success";
                                                        $change_search_status_to = "no";
                                                    } else {
                                                        $search_button = "btn-danger";
                                                        $change_search_status_to = "yes";
                                                    }

                                                    if ($data->update_data == "yes") {
                                                        $update_button = "btn-success";
                                                        $change_update_status_to = "no";
                                                    } else {
                                                        $update_button = "btn-danger";
                                                        $change_update_status_to = "yes";
                                                    }

                                                    if ($data->delete_data == "yes") {
                                                        $delete_button = "btn-success";
                                                        $change_delete_status_to = "no";
                                                    } else {
                                                        $delete_button = "btn-danger";
                                                        $change_delete_status_to = "yes";
                                                    }

                                                    if ($data->notification_data == "yes") {
                                                        $notification_button = "btn-success";
                                                        $change_notification_status_to = "no";
                                                    } else {
                                                        $notification_button = "btn-danger";
                                                        $change_notification_status_to = "yes";
                                                    }

                                                    if ($data->message_data == "yes") {
                                                        $message_button = "btn-success";
                                                        $change_message_status_to = "no";
                                                    } else {
                                                        $message_button = "btn-danger";
                                                        $change_message_status_to = "yes";
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><?php echo $i;
                                                            $i++; ?></td>
                                                        <td>
                                                            <?php
                                                            echo strtoupper(strtolower($data->type));
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-xs <?php echo $all_button ?> all-permission" data-status="<?php echo $change_status_to ?>" data-id="<?php echo $data->id ?>" id="allPermission<?php echo $data->id ?>"><?php echo $all; ?></button>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->add_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $add_button ?> change-permission" data-status="<?php echo $change_add_status_to ?>" data-id="<?php echo $data->id ?>" data-column="add_data" id="addPermission<?php echo $data->id ?>">
                                                                    <?php echo $data->add_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->view_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $view_button ?> change-permission" data-status="<?php echo $change_view_status_to ?>" data-id="<?php echo $data->id ?>" data-column="view_data" id="viewPermission<?php echo $data->id ?>">
                                                                    <?php echo $data->view_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->search_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $search_button ?> change-permission" data-status="<?php echo $change_search_status_to ?>" data-id="<?php echo $data->id ?>" data-column="search_data" id="searchPermission<?php echo $data->id ?>">
                                                                    <?php echo $data->search_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->update_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $update_button ?> change-permission" data-status="<?php echo $change_update_status_to ?>" data-id="<?php echo $data->id ?>" data-column="update_data" id="updatePermission<?php echo $data->id ?>">
                                                                    <?php echo $data->update_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->delete_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $delete_button ?> change-permission" data-status="<?php echo $change_delete_status_to ?>" data-id="<?php echo $data->id ?>" data-column="delete_data" id="deletePermission<?php echo $data->id ?>">
                                                                    <?php echo $data->delete_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->notification_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $notification_button ?> change-permission" data-status="<?php echo $change_notification_status_to ?>" data-id="<?php echo $data->id ?>" data-column="notification_data" id="notificationPermission<?php echo $data->id ?>">
                                                                    <?php echo $data->notification_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($data->message_data != "") {
                                                            ?>
                                                                <button type="button" class="btn btn-xs <?php echo $message_button ?> change-permission" data-status="<?php echo $change_message_status_to ?>" data-id="<?php echo $data->id ?>" data-column="message_data" id="messagePermission<?php echo $data->id ?>">
                                                                    <?php echo $data->message_data; ?>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("php-assets/foot-section.php") ?>
    </div>
</body>


<script>
    $(".change-permission").click(function() {
        var id = $(this).data('id');
        var column = $(this).data('column');
        if (column == "add_data") {
            var tagId = "addPermission" + id;
        } else if (column == "view_data")
            var tagId = "viewPermission" + id;
        else if (column == "search_data")
            var tagId = "searchPermission" + id;
        else if (column == "update_data")
            var tagId = "updatePermission" + id;
        else if (column == "delete_data")
            var tagId = "deletePermission" + id;
        else if (column == "notification_data")
            var tagId = "notificationPermission" + id;
        else if (column == "message_data")
            var tagId = "messagePermission" + id;
        var status = $("#" + tagId).data('status');

        var change_type = "single";
        $.ajax({
            url: "<?php echo base_url() ?>main/updatePermission",
            data: {
                'status': status,
                'column': column,
                'id': id,
                'change_type': change_type,
            },
            type: 'POST',
            success: function(data) {
                if (data == "all") {
                    if (status == "no") {
                        $("#allPermission" + id).addClass('btn-danger').removeClass('btn-success');
                        $("#allPermission" + id).text('no');
                    } else {
                        $("#allPermission" + id).addClass('btn-success').removeClass('btn-danger');
                        $("#allPermission" + id).text('yes');
                    }
                } else {
                    $("#allPermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#allPermission" + id).text('no');
                }
                if (status == "no") {
                    $("#" + tagId).attr('data-status', 'yes');
                    $("#" + tagId).addClass('btn-danger').removeClass('btn-success');
                    $("#" + tagId).text('no');
                } else {
                    $("#" + tagId).attr('data-status', 'no');
                    $("#" + tagId).addClass('btn-success').removeClass('btn-danger');
                    $("#" + tagId).text('yes');
                }
            }
        })
    })

    $(".all-permission").click(function() {
        var status = $(this).data('status');
        var column = $(this).data('column');
        var id = $(this).data('id');
        var change_type = "all";
        $.ajax({
            url: "<?php echo base_url() ?>main/updatePermission",
            data: {
                'status': status,
                'column': column,
                'id': id,
                'change_type': change_type,
            },
            type: 'POST',
            success: function(data) {
                if (status == "no") {
                    $("#allPermission" + id).data('status', 'yes');
                    $("#allPermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#allPermission" + id).text('no');

                    $("#addPermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#viewPermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#searchPermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#updatePermission" + id).addClass('btn-danger').removeClass('btn-success');
                    $("#deletePermission" + id).addClass('btn-danger').removeClass('btn-success');

                    $("#addPermission" + id).text('no');
                    $("#viewPermission" + id).text('no');
                    $("#searchPermission" + id).text('no');
                    $("#updatePermission" + id).text('no');
                    $("#deletePermission" + id).text('no');
                } else {
                    $("#allPermission" + id).data('status', 'no');
                    $("#allPermission" + id).addClass('btn-success').removeClass('btn-danger');
                    $("#allPermission" + id).text('yes');

                    $("#addPermission" + id).addClass('btn-success').removeClass('btn-danger');
                    $("#viewPermission" + id).addClass('btn-success').removeClass('btn-danger');
                    $("#searchPermission" + id).addClass('btn-success').removeClass('btn-danger');
                    $("#updatePermission" + id).addClass('btn-success').removeClass('btn-danger');
                    $("#deletePermission" + id).addClass('btn-success').removeClass('btn-danger');

                    $("#addPermission" + id).text('yes');
                    $("#viewPermission" + id).text('yes');
                    $("#searchPermission" + id).text('yes');
                    $("#updatePermission" + id).text('yes');
                    $("#deletePermission" + id).text('yes');
                }
            }
        })
    })
</script>


</html>