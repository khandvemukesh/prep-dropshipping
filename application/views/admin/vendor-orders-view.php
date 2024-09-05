<?php include('header.php');
$pageName = "order";
$subPageName = "vendor_list";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $company_name ?> | Home</title>
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
                            <h1>Orders Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item active">Orders Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php
                            if ($permission['view'] == 'yes') {
                                $addressDetailsArr = $vendorOrderDetails['address_detail'];
                                $paymentDetailsArr = $vendorOrderDetails['payment_details'];
                                $productListData = $vendorOrderDetails['products'];

                                if ((int)$addressDetailsArr['delivery_type'] == 0) $delivery_type = '<span class="badge badge-primary">Delivery</span>';
                                else $delivery_type = '<span class="badge badge-warning">Pickup</span>';

                                $status = '<span class="badge" style="background:' . $paymentDetailsArr['status_color'] . '; color:#fff;">' . $paymentDetailsArr['status_text'] . '</span>';

                            ?>
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Vendors Orders Detail </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <?php
                                                if ((int)$addressDetailsArr['delivery_type'] == 0) {
                                                ?>
                                                    <div class="my-box">
                                                        <h6 style="color: #e12222;font-weight: 500;"><u>Address Details</u></h6>
                                                        <label>Customer Name:</label>
                                                        <span><?php echo $addressDetailsArr['name'] ?></span>
                                                        <br>
                                                        <label>Customer Email:</label>
                                                        <span><?php echo $addressDetailsArr['email'] ?></span>
                                                        <br>
                                                        <label>Customer Mobile:</label>
                                                        <span><?php echo $addressDetailsArr['mobile_no'] ?></span>
                                                        <br>
                                                        <label>Customer Address:</label>
                                                        <span><?php echo $addressDetailsArr['house_no'] . ' ' . $addressDetailsArr['street_address'] . ' ' . $addressDetailsArr['address'] . ' ' . $addressDetailsArr['city'] . ' ' . $addressDetailsArr['state'] . ' ' . $addressDetailsArr['pincode'] ?></span>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <div class="my-box">
                                                    <h6 style="color: #e12222;font-weight: 500;"><u>Delivery Details</u></h6>
                                                    <label>Delivery Date:</label>
                                                    <span><?php echo $paymentDetailsArr['slot_details'] ?></span>
                                                    <br>
                                                    <label>Delivery Type:</label>
                                                    <span><?php echo $delivery_type  ?></span>
                                                    <br>
                                                    <label>Delivery Status:</label>
                                                    <span><?php echo $status ?></span>
                                                </div>
                                                <div class="my-box">
                                                    <h6 style="color: #e12222;font-weight: 500;"><u>Payment Details</u></h6>
                                                    <label>Total MRP:</label>
                                                    <span><?php echo $paymentDetailsArr['total_mrp'] ?></span>
                                                    <br>
                                                    <label>Total Discount:</label>
                                                    <span><?php echo $paymentDetailsArr['total_discount'] ?></span>
                                                    <br>
                                                    <label>Sub Total:</label>
                                                    <span><?php echo $paymentDetailsArr['sub_total'] ?></span>
                                                    <br>
                                                    <label>Delivery Charge:</label>
                                                    <span><?php echo $paymentDetailsArr['delivery_charge'] ?></span>
                                                    <br>
                                                    <label>Total:</label>
                                                    <span><?php echo $paymentDetailsArr['total'] ?></span>
                                                    <br>
                                                    <label>Payment Status:</label>
                                                    <span class="badge" style="background:<?php echo $paymentDetailsArr['payment_color'] ?>;color:#fff;"><?php echo $paymentDetailsArr['payment_status'] ?></span>
                                                    <br>
                                                    <label>Payment Mode:</label>
                                                    <span class="badge" style="background:<?php echo $paymentDetailsArr['payment_color'] ?>;color:#fff;"><?php echo $paymentDetailsArr['payment_mode'] ?></span>
                                                    <br>
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <div class="my-box">
                                                    <h6 style="color: #e12222;font-weight: 500;"><u>Products Ordered</u></h6>
                                                    <div class="row">
                                                        <?php
                                                        foreach ($productListData as $productListArr) {
                                                            $per_unit_cost = $productListArr['total'] / $productListArr['qty'];
                                                        ?>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="my-box">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <?php
                                                                            if(array_key_exists('home_image',$productListArr)){
                                                                                ?>
                                                                                <img src="<?php echo $productListArr['home_image'] ?>" style="width: 80px;height:75px;">
                                                                                <?php 
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <div class="row">
                                                                                <?php 
                                                                                if(array_key_exists('name',$productListArr)){
                                                                                    ?>
                                                                                    <div class="col-12">
                                                                                        <label class="my-font-style"><?php echo $productListArr['name'] ?></label>
                                                                                    </div>
                                                                                    <?php 
                                                                                }
                                                                                ?>
                                                                                <div class="col-12">
                                                                                    <label class="my-font-style"><?php echo $productListArr['unit'] ?></label>
                                                                                </div>
                                                                                <div class="col-7">
                                                                                    <label class="my-font-style">Qty: </label>
                                                                                    <span><?php echo $productListArr['qty'] . ' * ' . $per_unit_cost ?></span>
                                                                                </div>
                                                                                <div class="col-5">
                                                                                    <label class="my-font-style">Total: </label>
                                                                                    <span><?php echo $productListArr['total'] ?></span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

        <?php include("php-assets/foot-section.php") ?>
    </div>
</body>

</html>