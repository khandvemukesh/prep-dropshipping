<?php
if ($pageName == "dashboard")
    $dahboardClass = "active pcoded-trigger";
else
    $dahboardClass = "";

if ($pageName == "order")
    $orderClass = "active pcoded-trigger";
else
    $orderClass = "";


if ($pageName == "user")
    $userClass = "active pcoded-trigger";
else
    $userClass = "";

if ($pageName == "staff")
    $staffClass = "active pcoded-trigger";
else
    $staffClass = "";

if ($pageName == "offer")
    $offerClass = "active pcoded-trigger";
else
    $offerClass = "";

if ($pageName == "coupon")
    $couponClass = "active pcoded-trigger";
else
    $couponClass = "";

if ($pageName == "banners")
    $bannersClass = "active pcoded-trigger";
else
    $bannersClass = "";

if ($pageName == "subscription")
    $subscriptionClass = "active pcoded-trigger";
else
    $subscriptionClass = "";

if ($pageName == "agent_package")
    $agentPackageClass = "active pcoded-trigger";
else
    $agentPackageClass = "";

if ($pageName == "basics") {
    $basicsClass = "active";
    $basicsMenuClass = "menu-open";
    $subPageName == "shop_type" ? $shopTypeClass = "active pcoded-trigger" : $shopTypeClass = "";
    $subPageName == "category" ? $categoryClass = "active pcoded-trigger" : $categoryClass = "";
    $subPageName == "sub_category" ? $subCategoryClass = "active pcoded-trigger" : $subCategoryClass = "";
    $subPageName == "brands" ? $brandsClass = "active pcoded-trigger" : $brandsClass = "";
    $subPageName == "unit" ? $unitClass = "active pcoded-trigger" : $unitClass = "";
    $subPageName == "form_field" ? $formFieldClass = "active pcoded-trigger" : $formFieldClass = "";
} else {
    $basicsClass = "";
    $basicsMenuClass = "";
    $shopTypeClass = "";
    $categoryClass = "";
    $subCategoryClass = "";
    $brandsClass = "";
    $unitClass = "";
    $formFieldClass = "";
}

if ($pageName == "approval_module") {
    $approvalClass = "active";
    $approvalMenuClass = "menu-open";
    $subPageName == "vendor_approval" ? $vendorApprovalClass = "active pcoded-trigger" : $vendorApprovalClass = "";
    $subPageName == "category_approval" ? $categoryApprovalClass = "active pcoded-trigger" : $categoryApprovalClass = "";
    $subPageName == "sub_category_approval" ? $subCategoryApprovalClass = "active pcoded-trigger" : $subCategoryApprovalClass = "";
    $subPageName == "brand_approval" ? $brandApprovalClass = "active pcoded-trigger" : $brandApprovalClass = "";
    $subPageName == "unit_approval" ? $unitApprovalClass = "active pcoded-trigger" : $unitApprovalClass = "";
    $subPageName == "form_field_approval" ? $formFieldApprovalClass = "active pcoded-trigger" : $formFieldApprovalClass = "";
    $subPageName == "pincode_approval" ? $pincodeApprovalClass = "active pcoded-trigger" : $pincodeApprovalClass = "";
} else {
    $approvalClass = "";
    $approvalMenuClass = "";
    $vendorApprovalClass = "";
    $categoryApprovalClass = "";
    $subCategoryApprovalClass = "";
    $brandApprovalClass = "";
    $unitApprovalClass = "";
    $formFieldApprovalClass = "";
    $pincodeApprovalClass = "";
}

if ($pageName == "vendor") {
    $vendorClass = "active";
    $vendorMenuClass = "menu-open";
    $subPageName == "add_vendor" ? $vendorAddClass = "active pcoded-trigger" : $vendorAddClass = "";
    $subPageName == "vendor_list" ? $vendorListClass = "active pcoded-trigger" : $vendorListClass = "";
    $subPageName == "vendor_product_list" ? $vendorProductListClass = "active pcoded-trigger" : $vendorProductListClass = "";
    $subPageName == "vendor_order_list" ? $vendorOrderListClass = "active pcoded-trigger" : $vendorOrderListClass = "";
} else {
    $vendorClass = "";
    $vendorMenuClass = "";
    $vendorAddClass = "";
    $vendorListClass = "";
    $vendorProductListClass = "";
    $vendorOrderListClass = "";
}

if ($pageName == "product") {
    $productClass = "active";
    $productMenuClass = "menu-open";
    $subPageName == "add_product" ? $productAddClass = "active pcoded-trigger" : $productAddClass = "";
    $subPageName == "list_product" ? $productListClass = "active pcoded-trigger" : $productListClass = "";
} else {
    $productClass = "";
    $productMenuClass = "";
    $productAddClass = "";
    $productListClass = "";
}

if ($pageName == "offer") {
    $offerClass = "active";
    $offerMenuClass = "menu-open";
    $subPageName == "add_offer" ? $ceateOfferClass = "active pcoded-trigger" : $ceateOfferClass = "";
    $subPageName == "list_offer" ? $listOfferClass = "active pcoded-trigger" : $listOfferClass = "";
} else {
    $offerClass = "";
    $offerMenuClass = "";
    $ceateOfferClass = "";
    $listOfferClass = "";
}

if ($pageName == "agent") {
    $agentClass = "active";
    $agentMenuClass = "menu-open";
    $subPageName == "agent_list" ? $agentListClass = "active pcoded-trigger" : $agentListClass = "";
    $subPageName == "add_agent" ? $addAgentClass = "active pcoded-trigger" : $addAgentClass = "";
} else {
    $agentClass = "";
    $agentMenuClass = "";
    $agentListClass = "";
    $addAgentClass = "";
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url(); ?>image/logo.png" alt="Foodovity Logo" class="brand-image" style="opacity: .8">
        <br>
        <span class="brand-text font-weight-light"></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url(); ?>image/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">LoginAs :
                    <?php echo $nameUser ?>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>admin-dashboard" class="nav-link <?php echo $dahboardClass ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>admin-vendor-orders-list?vendor_id=4d513d3d"
                        class="nav-link <?php echo $orderClass ?>">
                        <i class="nav-icon fas fa-caret-right"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item <?php echo $productMenuClass ?>">
                    <a href="#" class="nav-link <?php echo $productClass ?>">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Product Module
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-add-product"
                                class="nav-link <?php echo $productAddClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-view-product"
                                class="nav-link <?php echo $productListClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product List</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item <?php echo $offerMenuClass ?>">
                    <a href="#" class="nav-link <?php echo $offerClass ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users Module
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-vendor-user?vendor_id=4d513d3d"
                                class="nav-link <?php echo $ceateOfferClass ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Users List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Subscription</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Import List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users Live Products</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?php echo $offerMenuClass ?>">
                    <a href="#" class="nav-link <?php echo $offerClass ?>">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Influencers Module
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>"
                                class="nav-link <?php echo $ceateOfferClass ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Influencers List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Influencers Accounts</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item <?php echo $offerMenuClass ?>">
                    <a href="#" class="nav-link <?php echo $offerClass ?>">
                        <i class="nav-icon fas fa-dollar"></i>
                        <p>
                            Accounts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-create-offers"
                                class="nav-link <?php echo $ceateOfferClass ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Influencers Settlement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transactions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-list-offers"
                                class="nav-link <?php echo $listOfferClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>admin-manage-coupon" class="nav-link <?php echo $couponClass ?>">
                        <i class="nav-icon fas fa-euro"></i>
                        <p>Subscription Module</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>admin-banners" class="nav-link <?php echo $bannersClass ?>">
                        <i class="nav-icon fas fa-image"></i>
                        <p>Banners</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>staff" class="nav-link <?php echo $staffClass ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Staff & Permission</p>
                    </a>
                </li>
                <li class="nav-item <?php echo $basicsMenuClass ?>">
                    <a href="#" class="nav-link <?php echo $basicsClass ?>">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>
                            Masters
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-shop-type"
                                class="nav-link <?php echo $shopTypeClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Super Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-category"
                                class="nav-link <?php echo $categoryClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-sub-category"
                                class="nav-link <?php echo $subCategoryClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-brands" class="nav-link <?php echo $brandsClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-unit" class="nav-link <?php echo $unitClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Unit</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url(); ?>admin-form-fields"
                                class="nav-link <?php echo $formFieldClass ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Form Fields</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>