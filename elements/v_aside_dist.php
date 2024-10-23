<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<aside id="leftsidebar" class="sidebar fullbodydycolorbg retailer-header-left header-left-newresponshive" style="box-shadow:none;">
            <div class="navbar-header asd-asd" style="padding:0px 0px;">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars" style="display: none;"></a>
                <a href="<?php echo base_url();?>Distributor/Home/Dashboard">
                    <center>
                            <img src="<?php echo base_url();?>vfiles/79444dab-571e-4737-99c1-99ffa47ea94d_M.png" class="img-responsive" style="width:148px;background-color:transparent;padding:2px;">
                    </center>
                </a>
            </div>
            <div class="op-user-trypo">
                <div class="user-info navbar fullbodydycolorbg">
                    <center>
                        <div class="user-op">
                            <p>Distributor</p>
                        </div>
                        <div class="image">
                                <img src="<?php echo base_url();?>vfiles/saved_resource" width="51" height="51" alt="User">
                        </div>
                    </center>
                    <center>
                        <div class="legal legal-profilepassword legal-responsiveclass" style="background:none; position:relative; padding:0px;">
                            <div class="name john john-changeclass" style="color:white;"><span style="font-weight:700"><?php echo $this->session->userdata("DistBusinessName"); ?></span></div>
                            <div class="email" style="color:white;"></div>
                            <div style="margin-top:2px;margin-right:0px;">
                                <div class="profile-es profile-es-newadd">
                                    <a href="<?php echo base_url(); ?>Distributor/Profile" class="btn btn-info">Profile</a>
                                </div>
                                <div class="manage-mantp" style="float:right;margin-top:4px;">

<form action="" method="post"><input name="__RequestVerificationToken" type="hidden" value="">                                        
    <a href="<?php echo base_url()."Distributor/change_password"; ?>" style="padding:5px 1px;background:#fff;padding: 8px 6px;
background:#fff;color:#000;font-size: 12px;text-decoration: none;">Manage Password</a>
</form>                                </div><br>
                                
                            </div>

                        </div>

                    </center>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu" style="border-right:2px solid #9e8e8e33;">

                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 609px;"><ul class="list report-list-change" style="overflow: hidden; width: auto; height: 609px;">
                    <h2 class="reportadminclass" style="font-size: 20px;margin: 10px 10px 0px 15px;border-bottom: 2px solid #fff;color: #fff;padding-bottom: 5px;margin-top: 13px !important;">

                        <img src="<?php echo base_url();?>vfiles/bars.svg" style="float:left;width:24px;"><span style="padding-left:10px;">Reports</span>


                    </h2>
                    <li class="active">
                        <a href="<?php echo base_url(); ?>Distributor/recharge_history" class="toggled waves-effect waves-block">
                            
                            
                            <span>Prepaid &amp; Utility</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo base_url(); ?>Distributor/dmr_report" class="toggled waves-effect waves-block">
                            
                            
                            <span>DMT Report</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo base_url(); ?>Distributor/operatorwisereport" class="toggled waves-effect waves-block">
                            
                            
                            <span>Income Report</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="<?php echo base_url(); ?>Distributor/search_number" class="toggled waves-effect waves-block">
                            
                            
                            <span>Number Search</span>
                        </a>
                    </li>

                    <li class="active">
                        <a href="<?php echo base_url(); ?>Distributor/complain" class="toggled waves-effect waves-block">
                            
                            
                            <span>Complain History</span>
                        </a>
                    </li>
                
                    
                    <li>
                        <a href="<?php echo base_url();?>Distributor/Home/Ecommerce_Report" class=" waves-effect waves-block">
                            
                            
                            <span>E-commerce  </span>
                        </a>

                    </li>
                  

                    
                    
                    <h2 class="reportadminclass" style="font-size: 20px;margin: 15px 10px 0px 15px;border-bottom: 2px solid #fff;color: #fff;padding-bottom: 5px;">
                        <img src="<?php echo base_url();?>vfiles/commerce.svg" style="float:left;width: 31px !important;height:31px;padding-left: 0;margin-left: 3px;"><span style="padding-left:10px;padding-left: 10px !important;">wallet<sup class="addmargin">+</sup></span>
                    </h2>

                    

                    

                    

                    

                    

                    <li>
                        <a href="<?php echo base_url();?>Distributor/payment_request" class=" waves-effect waves-block">
                            
                            
                            <span>Request Manualy </span>
                        </a>

                    </li>
                            <li>
                                <a href="<?php echo base_url();?>Distributor/Home/UPITRANSFER" class=" waves-effect waves-block">

                                    <span>Add By<div class="for-blink1"> UPI</div></span>
                                </a>

                            </li>
                                                <li>

                                <a href="<?php echo base_url();?>Distributor/Home/GatewayTRANSFER" class=" waves-effect waves-block">

                                    <span>Add By Gateway</span>
                                </a>

                            </li>
                    <li>
                        <a href="<?php echo base_url()."Distributor/topuphistory"; ?>" class=" waves-effect waves-block">

                            <span>Wallet History</span>
                        </a>

                    </li>
                    <li>
                        <a href="<?php echo base_url();?>Distributor/Home/Fund_Transfer_Retailer_To_Retailer" class=" waves-effect waves-block">
                            
                            
                            <span>Transfer R<sup style="top: -5px;left: 2px;">2</sup> R </span>
                        </a>

                    </li>





                    <h2 class="reportadminclass reportadminclass-lastclass" style="font-size: 20px;margin: 15px 10px 0px 15px;border-bottom: 2px solid #fff;color: #fff;padding-bottom: 5px;">
                        <img src="<?php echo base_url();?>vfiles/customer.svg" style="float:left;width:24px;padding-left: 0;"><span style="padding-left:10px;">
                            <a href="<?php echo base_url();?>Distributor/Home/Help" style="margin:0px;padding:0px;width:auto;font-size: 18px;
text-transform: uppercase;font-weight:700;" class=" waves-effect waves-block">Support</a>
                        </span>
                    </h2>
                    

                </ul><div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.5); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 0px; z-index: 99; right: 1px; height: 432.399px;"></div><div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 0px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
            </div>
            <button id="notiff" style="display:block;"></button>
            <div class="legal legal-new">
                <div class="copyright tmw-total-color-one" style="margin-top:-4px;">
                    Copyright&nbsp;&nbsp;2019 - <span>2020</span>
                </div>
                <div class="copyright copyright-new">
                    <a href="javascript:void(0);" class="tmw-total-color-one" style="">MAHARSHI ENTERPRISE</a>
                </div>

            </div>
            <!-- #Footer -->
        </aside>