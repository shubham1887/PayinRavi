<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  d-flex  align-items-center">
                <a class="navbar-brand" href="dashboard.html">
                    <img src="<?php echo base_url(); ?>assets2/img/dashboard/logo.png" class="navbar-brand-img" alt="...">
                </a>
                <div class=" ml-auto ">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."SuperDealer_new/Dashboard"; ?>">
                                <i class="mdi mdi-monitor-multiple"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                       
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>SuperDealer_new/Razorpay" target="_blank">
                                <i class="mdi mdi-account-card-details-outline text-primary"></i>
                                <span class="nav-link-text">Payment Gateway</span>
                            </a>
                        </li>
                       
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Reports" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-finance text-info"></i>
                                <span class="nav-link-text">Reports Wallet1</span>
                            </a>
                            <div class="collapse" id="navbar-Reports">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Downline_recharge_report"; ?>" class="nav-link">Recharge Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Statement"; ?>" class="nav-link">Statement Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/LoadReport"; ?>" class="nav-link">Payment Load Report</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Payment Debit Report</a></li>
                                   
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Reports2" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-finance text-info"></i>
                                <span class="nav-link-text">Reports Wallet2</span>
                            </a>
                            <div class="collapse" id="navbar-Reports2">
                                <ul class="nav nav-sm flex-column">
                                   
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Downline_dmt_report"; ?>" class="nav-link">DMT Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/LoadReport2"; ?>" class="nav-link">Payment Load Report</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Payment Debit Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/dmr_report"; ?>" class="nav-link">Money Transfer Report</a></li>

                                    <li class="nav-item">
                                        <a href="<?php echo base_url(); ?>SuperDealer_new/bill_report" class="nav-link" >BBPS Report</a>
                                    </li>

                                    
                                   
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Account" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-account-multiple-outline  text-pink"></i>
                                <span class="nav-link-text">Account</span>
                            </a>
                            <div class="collapse" id="navbar-Account">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/UserProfile"; ?>" class="nav-link">Profile</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Change_password"; ?>" class="nav-link">Change Password</a></li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url()."SuperDealer_new/Change_txnpassword";?>" class="nav-link">Change TPIN</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Loginhistory";?>" class="nav-link">Login Detail</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Certificate";?>" class="nav-link">Certificate</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Mycommission"; ?>" class="nav-link">Commision</a></li>
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Support" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-help-circle-outline text-green"></i>
                                <span class="nav-link-text">Manage Users</span>
                            </a>
                            <div class="collapse" id="navbar-Support">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/AddUser"; ?>" class="nav-link">AddUser</a></li>
                                    
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/UserList"; ?>" class="nav-link">ViewUser</a></li>

                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/AddBalance"; ?>" class="nav-link">Add Balance</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/RevertBalance"; ?>" class="nav-link">Revert Balance</a></li>
                                    <li class="nav-item"  id="MasterDealer_CREATE_GROUP" style="display: none;"><a href="<?php echo base_url()."SuperDealer_new/CreateScheme"; ?>" class="nav-link">Create Scheme</a></li>

                                    <li class="nav-item" id="MasterDealer_SETTING_DOWNLINE_COMMISSION" style="display: none;"><a href="<?php echo base_url()."SuperDealer_new/CommissionUserWise"; ?>" class="nav-link">Commission Settings</a></li>
                                    
                                    
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Support" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-help-circle-outline text-green"></i>
                                <span class="nav-link-text">Support</span>
                            </a>
                            <div class="collapse" id="navbar-Support">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Services"; ?>" class="nav-link">Purchase Services</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/TopUpRequest"; ?>" class="nav-link">TopUp Request</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/PaymentRequestReport"; ?>" class="nav-link">Topup History</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/ComplainHistory"; ?>" class="nav-link">View All Tickets</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."SuperDealer_new/Raisecomplain"; ?>" class="nav-link">Raise Complain</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">AEPS Settlement</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!-- Divider -->
                    <hr class="my-3">
                    <!-- Heading -->
                    <h6 class="navbar-heading p-0 text-muted">Documentation
                    </h6>
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="mdi mdi-account-question-outline"></i>
                                <span class="nav-link-text">FAQ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>PrivacyPolicy" target="_blank">
                                <i class="mdi mdi-alert-outline"></i>
                                <span class="nav-link-text">Privacy Policy</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>SuperDealer_new/TermsAndConditions" target="_blank">
                                <i class="mdi mdi-clipboard-alert-outline"></i>
                                <span class="nav-link-text">Terms &amp; Conditions</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>