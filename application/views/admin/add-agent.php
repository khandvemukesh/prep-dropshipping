<?php include('header.php');
$pageName = "agent";
$subPageName = "add_agent";
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
                            <h1>Add Agent/Franchise/Employee For Sales </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Add Agent/Franchise/Employee For Sales</li>
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
                                    <h3 class="card-title">Add Agent/Franchise/Employee For Sales</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="createProductForm">
                                        <input type="hidden" name="status" value="1">
                                        <input type="hidden" name="date" value="<?php echo sys_date() ?>">
                                        <input type="hidden" name="time" value="<?php echo sys_time() ?>">
                                        <input type="hidden" name="ip" value="<?php echo getRealIpAddr() ?>">
                                        <input type="hidden" name="byid" value="<?php echo $byId ?>">
                                        <div class="row">


                                            <div class="col-md-12" style="text-align: center;">
                                                <hr>
                                                <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Add Details</button>
                                            </div>
                                        </div>
                                    </form>
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
        $(document).on("submit", "#createProductForm", function(e) {
            e.preventDefault();
            var formdata = new FormData(this);
            $.ajax({
                url: "<?php echo base_url() ?>main/addProductFunction/",
                data: formdata,
                processData: false,
                contentType: false,
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    if (data['status'] == true) {
                        showMessage('Good Job !!', 'Product Successfully Added!!!!', 'success');
                        setTimeout(function() {
                            window.location.href = "<?php echo base_url() ?>admin-product-unit-stock/" + data['product_id'];
                        }, 2000);
                    } else {
                        showMessage('Ooops !!', 'Something Went Wrong!!!!', 'danger');
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })
    </script>
</body>

</html>