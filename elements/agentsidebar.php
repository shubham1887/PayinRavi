<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">

        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header  d-flex  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="<?php echo base_url(); ?>assets2/img/dashboard/logo.png" class="navbar-brand-img" alt="...">
                </a>
                
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/Dashboard"; ?>">
                                <i class="mdi mdi-monitor-multiple"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/Recharge_home"; ?>">
                                <i class="mdi mdi-cellphone-android text-orange"></i>
                                <span class="nav-link-text">Recharge</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/dmrmm_home"; ?>">
                                <i class="mdi mdi-bank-outline text-info"></i>
                                <span class="nav-link-text">Money Transfer</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/dmr3_home"; ?>">
                                <i class="mdi mdi-check-box-multiple-outline text-green"></i>
                                <span class="nav-link-text">Money Transfer 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/IndoNepal"; ?>">
                                <i class="mdi mdi-message-text-outline text-info"></i>
                                <span class="nav-link-text">Nepal Money Transfer</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url()."Retailer/Bbps";?>" >
                                <i class="mdi mdi-gas-station-outline text-pink"></i>
                                <span class="nav-link-text">BBPS</span>
                            </a>   
                        </li>
                        
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>Retailer/Razorpay_home" target="_blank">
                                <i class="mdi mdi-account-card-details-outline text-primary"></i>
                                <span class="nav-link-text">Payment Gateway</span>
                            </a>
                        </li>

                       <!--<li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="mdi mdi-account-card-details-outline text-primary"></i>
                                <span class="nav-link-text"> Pan Card </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="mdi mdi-content-duplicate text-green"></i>
                                <span class="nav-link-text"> AEPS </span>
                            </a>
                        </li>-->
                       <!-- <li class="nav-item">
                            <a class="nav-link" href="#navbar-AEPS" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-content-duplicate text-green"></i>
                                <span class="nav-link-text">AEPS</span>
                            </a>
                            <div class="collapse" id="navbar-AEPS">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <span class="menu-title">AEPS</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" target="_blank">
                                            <span class="menu-title">AEPS New</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Reports" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-finance text-info"></i>
                                <span class="nav-link-text">Reports </span>
                            </a>
                            <div class="collapse" id="navbar-Reports">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Recharges_Report"; ?>" class="nav-link">Recharge Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/dmr_report"; ?>" class="nav-link">Money Transfer Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/IndoNepal_report"; ?>" class="nav-link">IndoNepal Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url(); ?>Retailer/bill_report" class="nav-link" >BBPS Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url(); ?>Retailer/AEPS_Report" class="nav-link" >AEPS Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url(); ?>Retailer/Pg_Report" class="nav-link" >PG Report</a></li>
                                     <li class="nav-item"><a href="<?php echo base_url()."Retailer/Statement"; ?>" class="nav-link">Wallet1 Summary Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Statement2"; ?>" class="nav-link">Wallet2 Summary Report</a></li>
                                    

                                    
                                   
                                </ul>
                            </div>
                        </li>
                       <!-- <li class="nav-item">
                            <a class="nav-link" href="#navbar-ReportsWT1" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-finance text-info"></i>
                                <span class="nav-link-text">Reports Wallet1</span>
                            </a>
                            <div class="collapse" id="navbar-ReportsWT1">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Statement"; ?>" class="nav-link">Statement Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/LoadReport"; ?>" class="nav-link">Payment Load Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/DebitLoadReport"; ?>" class="nav-link">Payment Debit Report</a></li>
                                   
                                </ul>
                            </div>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-Reports2" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi mdi-finance text-info"></i>
                                <span class="nav-link-text">Payment Reports</span>
                            </a>
                            <div class="collapse" id="navbar-Reports2">
                                <ul class="nav nav-sm flex-column">
                                   
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/LoadReport"; ?>" class="nav-link">Wallet1 Credit Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/DebitLoadReport"; ?>" class="nav-link">Wallet1 Debit Report</a></li>
                                    
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/LoadReport2"; ?>" class="nav-link">Wallet2 Credit Report</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/DebitLoadReport2"; ?>" class="nav-link">Wallet2 Debit Report</a></li>
                                   
                                   
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#navbar-balance" data-toggle="collapse" role="button"
                                aria-controls="navbar-dashboards">
                                <i class="mdi  text-success">₹</i>
                                <span class="nav-link-text">Balance</span>
                            </a>
                            <div class="collapse" id="navbar-balance">
                                <ul class="nav nav-sm flex-column">
                                   
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/TopUpRequest"; ?>" class="nav-link">TopUp Request</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/PaymentRequestReport"; ?>" class="nav-link">Topup History</a></li>
                                    
                                   
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
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/UserProfile"; ?>" class="nav-link">Profile</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Change_password"; ?>" class="nav-link">Change Password</a></li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url()."Retailer/Change_txnpassword";?>" class="nav-link">Change TPIN</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Loginhistory";?>" class="nav-link">Login Detail</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Certificate";?>" class="nav-link">Certificate</a></li>
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
                                   
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/ComplainHistory"; ?>" class="nav-link">View All Tickets</a></li>
                                    <li class="nav-item"><a href="<?php echo base_url()."Retailer/Raisecomplain"; ?>" class="nav-link">Raise Complain</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url(); ?>Agentlogout"  ?>
                                <i class="mdi mdi-power text-danger"></i>
                                <span class="nav-link-text">LogOut</span>
                            </a>
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
                            <a class="nav-link" href="<?php echo base_url(); ?>Retailer/TermsAndConditions" target="_blank">
                                <i class="mdi mdi-clipboard-alert-outline"></i>
                                <span class="nav-link-text">Terms &amp; Conditions</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>