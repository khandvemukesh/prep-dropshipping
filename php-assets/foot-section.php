<?php include('./php-assets/modal.php'); ?>

<script src="<?php echo base_url() ?>assets/admin/js/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/adminlte.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/jquery-3.3.1.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/constants.js"></script>

<script src="<?php echo base_url() ?>assets/admin/js/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/datatables/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script>
    function checkDetailsLogin(inputField, messageField) {
        var inputVal = $("#" + inputField).val();
        if (inputVal == "") {
            $("#" + inputField).addClass("is-invalid").removeClass("is-valid");
            $("#" + messageField).addClass("bg-danger").removeClass("bg-success");
            toastFire('info', inputField + ' Field Is Required !!!', 'top-end', '#dc3545d9', '#fff');
        } else {
            $("#" + inputField).addClass("is-valid").removeClass("is-invalid");
            $("#" + messageField).addClass("bg-success").removeClass("bg-danger");
            toastFire('success', 'Looks Good !!!', 'top-end', '#28a745d9', '#fff');
        }
    }

    function checkDetails(inputId, showId) {
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
        }
    }

    function checkUniqueDetails(inputId, showId, column) {
        var inputVal = $("#" + inputId).val();
        var table_name = $("#tablename").val();
        if (inputVal == "" || inputVal == null) {
            var message = "Req.";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>main/checkData",
                type: "POST",
                data: {
                    'table': table_name,
                    'column': column,
                    'value': inputVal,
                },
                success: function (data) {
                    if (data == false) {
                        var column_name = column.substr(0, 1).toUpperCase() + column.substr(1);
                        var message = column_name + " Already Registered";
                        $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-danger").removeClass("text-success");
                    } else {
                        var message = "Good";
                        $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-success").removeClass("text-danger");
                    }
                }
            });
        }
    }

    function checkMobile(inputId, showId) {
        var table_name = $("#tablename").val();
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = " Req. ";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            if (inputVal.length < 10) {
                var message = "Mobile Number To Small";
                $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                $("#" + showId).html(message);
                $("#" + showId).addClass("text-danger").removeClass("text-success");
            } else if (inputVal.length > 10) {
                var message = "Mobile Number To large";
                $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                $("#" + showId).html(message);
                $("#" + showId).addClass("text-danger").removeClass("text-success");
            } else {
                $.ajax({
                    url: "<?php echo base_url() ?>main/checkData",
                    type: "POST",
                    data: {
                        'table': table_name,
                        'column': 'mobile_no',
                        'value': inputVal,
                    },
                    success: function (data) {
                        if (data == false) {
                            var message = "Mobile No Already Registered";
                            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                            $("#" + showId).html(message);
                            $("#" + showId).addClass("text-danger").removeClass("text-success");
                        } else {
                            var message = "Looks Good !!!";
                            $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                            $("#" + showId).html(message);
                            $("#" + showId).addClass("text-success").removeClass("text-danger");
                        }
                    }
                });
            }
        }
    }

    function checkUserName(inputId, showId) {
        var table_name = $("#tablename").val();
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = " Req.";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>main/checkData",
                type: "POST",
                data: {
                    'table': table_name,
                    'column': 'username',
                    'value': inputVal,
                },
                success: function (data) {
                    if (data == false) {
                        var message = "Username Already Registered";
                        $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-danger").removeClass("text-success");
                    } else {
                        var message = "Looks Good !!!";
                        $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-success").removeClass("text-danger");
                    }
                }
            });
        }
    }

    function checkPinCode(inputId, showId) {
        var table_name = $("#tablename").val();
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = " This Field Is Required ";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            if (inputVal.length < 6) {
                var message = "Pin Code To Small";
                $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                $("#" + showId).html(message);
                $("#" + showId).addClass("text-danger").removeClass("text-success");
            } else if (inputVal.length > 6) {
                var message = "Pin Code To large";
                $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                $("#" + showId).html(message);
                $("#" + showId).addClass("text-danger").removeClass("text-success");
            } else {
                var message = "Looks Good !!!";
                $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                $("#" + showId).html(message);
                $("#" + showId).addClass("text-success").removeClass("text-danger");
            }
        }
    }

    function checkDetailsDataList(inputId, showId, table_name, column) {
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = "Req.";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>main/checkData",
                type: "POST",
                data: {
                    'table': table_name,
                    'column': column,
                    'value': inputVal,
                },
                success: function (data) {
                    if (data == false) {
                        var message = "Looks Good..";
                        $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-success").removeClass("text-danger");
                    } else {
                        var message = "Invalid Value !!!";
                        $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
                        $("#" + showId).html(message);
                        $("#" + showId).addClass("text-danger").removeClass("text-success");
                    }
                }
            });
        }
    }

    function getOptions(inputId, showId, table_name, coloum, value, showDataId, coulum_to_show) {
        var inputVal = $("#" + inputId).val();
        if (inputVal == "" || inputVal == null) {
            var message = "Req.";
            $("#" + inputId).addClass("is-invalid").removeClass("is-valid");
            $("#" + showId).html(message);
            $("#" + showId).addClass("text-danger").removeClass("text-success");
        } else {
            $.ajax({
                url: "<?php echo base_url() ?>main/getOptions",
                type: "POST",
                data: {
                    'table': table_name,
                    'column': coloum,
                    'value': value,
                    'coulum_to_show': coulum_to_show,
                },
                success: function (data) {
                    var message = "Looks Good..";
                    $("#" + inputId).addClass("is-valid").removeClass("is-invalid");
                    $("#" + showId).html(message);
                    $("#" + showId).addClass("text-success").removeClass("text-danger");

                    $("#" + showDataId).html(data);
                }
            });
        }
    }

    function showMessage(title, message, type) {
        if (type == "success") {
            background = "#48b461";
        } else if (type == "danger" || type == "error") {
            background = "#e15361";
        } else {
            background = "#fff";
        }
        const Toast = Swal.mixin({
            toast: true,
            timer: 2000,
            position: 'top-right',
            showConfirmButton: false,
            timerProgressBar: true,
            color: "white",
            background: background
        })

        Toast.fire({
            icon: type,
            title: message
        })
    }

    function toastFire(type, message, position, background = "#fff") {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timerProgressBar: false,
            background: background
        })

        Toast.fire({
            icon: type,
            title: message
        })
    }

    function toastFireWithoutTime(type, message, position) {
        const Toast = Swal.mixin({
            toast: true,
            position: position,
            showConfirmButton: false,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: type,
            title: message
        })
    }

    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);

        if ($(".checkbox_delete").is(":checked")) {
            $(".checkbox_delete").closest('tr').addClass('bg-gradient-orange');
        } else {
            $(".checkbox_delete").closest('tr').removeClass('bg-gradient-orange');
        }

        if ($(".checkbox_active").is(":checked")) {
            $(".checkbox_active").closest('tr').addClass('bg-success').removeClass('bg-gradient-orange');
        } else {
            $(".checkbox_active").closest('tr').removeClass('bg-success').addClass('bg-gradient-orange');
        }
    });

    $(document).on("click", ".checkbox_delete", function (event) {
        if ($(this).is(':checked')) {
            $(this).closest('tr').addClass('bg-gradient-orange');
            var checkbox = $(".checkbox_delete:checked");
            var msg = "Selected Records - " + checkbox.length;
            toastFireWithoutTime('info', msg, "bottom-end");
        } else {
            $(this).closest('tr').removeClass('bg-gradient-orange');
            var checkbox = $(".checkbox_delete:checked");
            var msg = "Selected Records - " + checkbox.length;
            toastFireWithoutTime('info', msg, "bottom-end");
        }
    });
    $("#disableData").click(function () {
        var table_name = $("#tablename").val();
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
                text: "You Want To Trash This File To RecycleBin",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Disable It!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var checkbox_value = [];
                    $(checkbox).each(function () {
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        url: "<?php echo base_url() ?>main/disableData",
                        type: "POST",
                        data: {
                            "checkbox_value": checkbox_value,
                            "table_name": table_name
                        },
                        success: function (data) {
                            $(".bg-gradient-orange").fadeOut(1500);
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
    $("#deleteDataEnable").click(function () {
        var table_name = $("#tablename").val();
        var checkbox1 = $(".checkbox_delete:checked");
        if (checkbox1.length > 0) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You Want To Completelly Delete This File",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var checkbox_value = [];
                    $(checkbox1).each(function () {
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        url: "<?php echo base_url() ?>main/deleteData",
                        type: "POST",
                        data: {
                            "checkbox_value": checkbox_value,
                            "table_name": table_name
                        },
                        success: function (data) {
                            $(".bg-gradient-orange").fadeOut(1500);
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

    $(document).on("click", ".checkbox_active ", function () {
        if ($(this).is(':checked')) {
            $(this).closest('tr').addClass('bg-success').removeClass('bg-gradient-orange');
            var checkbox = $(".checkbox_active:checked");
            var msg = "Selected Records - " + checkbox.length;
            toastFireWithoutTime('info', msg, "bottom-end");
        } else {
            $(this).closest('tr').removeClass('bg-success').addClass('bg-gradient-orange');
            var checkbox = $(".checkbox_active:checked");
            var msg = "Selected Records - " + checkbox.length;
            toastFireWithoutTime('info', msg, "bottom-end");
        }
    });
    $("#enableData").click(function () {
        var table_name = $("#tablename").val();
        var checkbox = $(".checkbox_active:checked");
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
                text: "You Want To Enable This Record",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Enable it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var checkbox_value = [];
                    $(checkbox).each(function () {
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        url: "<?php echo base_url() ?>main/enableData",
                        type: "POST",
                        data: {
                            "checkbox_value": checkbox_value,
                            "table_name": table_name
                        },
                        success: function (data) {
                            $(".bg-success").fadeOut(1500);
                            listData();
                        }
                    })
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your Data is Still In RecycleBin :)',
                        'error'
                    )
                }
            })
        } else {
            showMessage("Oops !!!!", "Please Select At Least One Record", "error");
        }
    });
    $("#deleteDataDisable").click(function () {
        var table_name = $("#tablename").val();
        var checkbox = $(".checkbox_active:checked");
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
                text: "You Want To Completely Delete This File",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    var checkbox_value = [];
                    $(checkbox).each(function () {
                        checkbox_value.push($(this).val());
                    });
                    $.ajax({
                        url: "<?php echo base_url() ?>main/deleteData",
                        type: "POST",
                        data: {
                            "checkbox_value": checkbox_value,
                            "table_name": table_name
                        },
                        success: function (data) {
                            $(".bg-success").fadeOut(1500);
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

    $(document).on('submit', '#insertForm', function (event) {
        event.preventDefault();
        if ($("#insertForm").find('input.is-invalid').length == 0) {
            var table_name = $("#tablename").val();
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/addData/" + table_name,
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    var table = $('#dataListing').DataTable();
                    table.ajax.reload();
                    if (data == true) {
                        showMessage('Good Job !!', 'Data Successfully Added!!!!', 'success');
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                    $('#insertForm')[0].reset();
                    $('#insertModal').toggle('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                }
            });
        } else {
            showMessage('Ooops !!', 'Wrong Data', 'danger');
        }
    });

    $(document).on('click', '#getEditData', function (event) {
        var table_name = $("#tablename").val();
        var id = $(this).data('id');
        $.ajax({
            url: "<?php echo base_url(); ?>main/getEditData",
            data: {
                'table_name': table_name,
                'id': id,
            },
            dataType: 'json',
            type: 'POST',
            success: function (data) {
                $(data).each(function (i, val) {
                    $.each(val, function (k, v) {
                        $("#edit_" + k).val(v);
                        if (k == "image") {
                            $("#edit_blah").attr("src", "<?php echo base_url() ?>image/" + table_name + "/" + v);
                        }
                    });
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    });


    $(document).on('submit', '#editForm', function (event) {
        event.preventDefault();
        if ($("#editForm").find('input.is-invalid').length == 0) {
            var table_name = $("#tablename").val();
            var id = $("#edit_id").val();
            var formData = new FormData(this);
            $.ajax({
                url: "<?php echo base_url(); ?>main/updateData/" + table_name + "/" + id + "/id",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    var table = $('#dataListing').DataTable();
                    table.ajax.reload();
                    if (data == true) {
                        showMessage('Good Job !!', 'Data Successfully Updated!!!!', 'success');
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                    $('#editForm')[0].reset();
                    $('#editModal').toggle('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                },
                error: function (data) {
                    console.log(data);
                }
            });
        } else {
            showMessage('Ooops !!', 'Wrong Data', 'danger');
        }
    });


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function readURLEdit(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#edit_blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on("click", ".img-open", function () {
        var src = $(this).attr('src');
        $("#fullScreenImage").attr('src', src);
        $("#image-modal").modal('show');
    })

</script>