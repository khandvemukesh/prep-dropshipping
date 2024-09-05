<div class="col-sm-8" style="text-align: end;">
    <?php
    if ($permission['addButton'] == "yes") {
    ?>
        <button class="btn bg-gradient-info btn-xs" data-toggle="modal" data-target="#insertModal"><i class="fa fa-plus" data-toggle="tooltip" title="Add Data"></i> Add</button>
    <?php
    }
    if ($permission['disableButton'] == "yes") {
    ?>
        <button class="btn bg-gradient-warning btn-xs" id="disableData"><i class="fa fa-minus" data-toggle="tooltip" title="Disable Data"></i> Disable</button>
    <?php
    }
    if ($permission['enableButton'] == "yes") {
    ?>
        <button class="btn bg-gradient-success btn-xs" id="enableData"><i class="fa fa-redo" data-toggle="tooltip" title="Enable Data"></i> Enable</button>
    <?php
    }
    ?>
    <?php
    if ($permission['deletButton'] == "yes") {
        if ($this->uri->segment(2) == 1) {
    ?>
            <button class="btn bg-gradient-danger btn-xs" id="deleteDataEnable"><i class="fa fa-trash" data-toggle="tooltip" title="Delete Data"></i> Delete</button>
        <?php
        } else {
        ?>
            <button class="btn bg-gradient-danger btn-xs" id="deleteDataDisable"><i class="fa fa-trash" data-toggle="tooltip" title="Delete Data"></i> Delete</button>
        <?php
        }
    }
    if ($permission['reloadButton'] == "yes") {
        ?>
        <button class="btn btn-outline-secondary btn-xs" onclick="location.reload();"><i class="fa fa-sync" data-toggle="tooltip" title="Reload Page"></i> Reload</button>
    <?php
    }
    if ($permission['notificationButton'] == "yes") {
    ?>
        <button class="btn btn-outline-danger btn-xs" id="sendNotificationButton" data-toggle="modal" data-target="#notificationModal"><i class="fa fa-mail-bulk" data-toggle="tooltip" title="Send Mail"></i> Notification</button>
    <?php
    }
    if ($permission['messageButton'] == "yes") {
    ?>
        <button class="btn btn-outline-info btn-xs" onclick="location.reload();"><i class="fa fa-envelope-open-text" data-toggle="tooltip" title="Send Message"></i> Message</button>
    <?php
    }
    if ($permission['searchButton'] == "yes") {
    ?>
        <button class="btn btn-secondary btn-xs" data-toggle="collapse" data-target="#searchData"><i class="fa fa-search" data-toggle="tooltip" title="Reload Page"></i> Search</button>
    <?php
    }
    ?>
</div>