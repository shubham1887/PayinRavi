<!DOCTYPE html>
<html class="chrome">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $this->white->getName(); ?></title>
    <!-- Favicon-->

    <link rel="icon" href="<?php echo base_url() ?>Outside_favicon/63969ec4-c079-4d05-8558-b0f34337ac9b_MF.png" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="<?php echo base_url();?>vfiles/css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>vfiles/icon" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url();?>vfiles/font-awesome.min.css">
    <!-- Wait Me Css -->
    <link href="<?php echo base_url();?>vfiles/waitMe.css" rel="stylesheet">
    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url();?>vfiles/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/bootstrap-select.css" rel="stylesheet">
    <!-- Waves Effect Css -->
    <link href="<?php echo base_url();?>vfiles/waves.css" rel="stylesheet">
    <!-- Animation Css -->
    <link href="<?php echo base_url();?>vfiles/animate.css" rel="stylesheet">
    <!-- Morris Chart Css-->
    <link href="<?php echo base_url();?>vfiles/morris.css" rel="stylesheet">
    <!-- Custom Css -->
    <link href="<?php echo base_url();?>vfiles/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/icofont.css" rel="stylesheet">


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    

    <link href="<?php echo base_url();?>vfiles/globalallcss.css" rel="stylesheet">
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url();?>vfiles/all-themes.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/daterangepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vfiles/StyleSheet.css" rel="stylesheet">

    <script src="<?php echo base_url();?>vfiles/jquery-1.10.2.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/jquery.validate.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/jquery.validate.unobtrusive.min.js.download"></script>
    <style>
        .navbar .navbar-toggle:before {
            content: '\E8D5';
            font-family: 'Material Icons';
            font-size: 26px;
        }

        .navbar .navbar-toggle:before {
            content: '\E8D5';
            font-family: 'Material Icons';
            font-size: 26px;
        }
           .for-blink1{color:#fff;
        animation: blink 2s linear infinite;display: initial;
        }
        @keyframes blink{
        0%{color: #fff;}
        50%{color: Yellow;}
        100%{color: red;}
        }
    </style>
</head>

<body class="theme layoutt-retailer" style="overflow-x: hidden;">

    <section class="layoutt">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <center><img src="<?php echo base_url();?>vfiles/serachimg.gif" class="img-responsive" style="height:200px;width:200px;"></center>

            </div>
        </div>


        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Search Bar -->
        <div class="search-bar">
            <div class="search-icon">
                <i class="material-icons">search</i>
            </div>
            <input type="text" placeholder="START TYPING...">
            <div class="close-search">
                <i class="material-icons">close</i>
            </div>
        </div>
        <!-- #END# Search Bar -->
        <!-- Top Bar -->

        
   <!-- -->
        <?php include("elements/v_aside.php"); ?>
        <!-- -->


         <?php include("elements/v_header.php"); ?>



        <!-- Left Sidebar -->


        <button id="bb" style="display:none;"></button>
    </section>
    




<style>
    span {
        color: #fff !important;
    }

    section.content {
        margin: 87px 0px 0 164px;
    }

 

    .tab-menur li a::before {
        content: '';
        width: 12px;
        height: 12px;
        display: inline-block;
        border: 2px solid #bbb;
        border-radius: 50%;
        margin: 2px 6px 0px 0px;
    }

    .tab-menur li a.active-ar::before {
        border-color: var(--main-bg-lcolor);
        background: var(--main-bg-lcolor);
    }

    .tab-menur li a.active-ar {
        color: var(--main-bg-lcolor);
    }
    .fund-user-left.fund-trasfer-left .nav-tabs li {
    width: 50% !important;
}
    .fund-t-dalear input {
        border: 1px solid #bbb;
        height: 32px;
        padding: 0px 5px;
        padding-top: 0px !important;
        width: 100%;
        padding-left: 40px;
       
    }
    .fund-t-dalear button {
        height: 32px;
        border: 1px solid #c7c2c2;
        background: #fff;
    }
       .for-change-fund {
    margin: 0px;
    width: 100%;
}
          .fund-fistory {
    float: left;
    margin-top: 0px;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
}
    .fund-fistory sub {
    position: absolute;
    bottom: 4px !important;
    top: 24px;
    line-height: 8px;
    left: 11px;
    font-size: 9px;
}
    .nav-tabs li.active .for-change-fund .fa {
    float: left;
    font-size: 44px;
    transform: rotate(-90deg);
    margin-left: 5px;
    color: var(--main-bg-lcolor) !important;
    margin-top: -2px;
    line-height: 36px;
}
    .fund-trasfer-right .nav-tabs + .tab-content {
        padding: 5px !important;
    }
    .fund-trasfer-right .tab-content{height:74vh;}
</style>
<section class="content fundretailer-content-responshive">
    <div class="container-fluid">
        <div class="bread-same-all-page allpage-responshivenew">
            <div class="col-md-6">
                <ul>
                    <li class="smli">
                        <a href="<?php echo base_url(); ?>MasterDealer_new/Dashboard" class="fullbodydycolorbg tmw-total-color-one">
                            Dashboard&nbsp;<img src="<?php echo base_url();?>vfiles/rightaeps.svg" alt="right-arrow" style="width: 12px;margin-top: -2px;">
                        </a>
                    </li>

                    <li class="fullbodydycolorbg tmw-total-color-one">
                        Fund <sup style="top: -5px;left: 2px;">2</sup>&nbsp;&nbsp;Transfer
                    </li>
                </ul>
            </div>
            <div class="col-md-6">

                <div class="for-search">
                    <input id="myInput" name="myInput" type="text" placeholder="Search..." onkeyup="myFunction()">

                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <script>
            $(document).ready(function () {

                $('#firstontyimetabe').click();

            })
        </script>
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="fund-trasfer-left fund-user-left">
                    <ul class="nav nav-tabs tabtypeschages tabtypeschages-fullpage" id="tabs">
                        
                        <li id="firstontyimetabe" class="tab-link tabChangeType current active" data-tabname="Purchase_ORDER" data-href="/Retailer/payment_request/MDTODealer?tabtype=Purchase_ORDER" data-tab="tab-1" style="width:100% !important;"><a data-toggle="tab" href="<?php echo base_url(); ?>MasterDealer_new/payment_request#menu1" aria-expanded="false">Purchase Rerquest &nbsp;&nbsp; &nbsp;</a></li>
                        


                    </ul>

                    <div class="width100 float-left ">

                     
                        <div id="menu1" class="width100 float-left tab-pane fade active in">

                            <div class="fund-transfer-form textarea-classadd" id="frmdata1">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div>

                                        <div class="old-crd old-crd-showoption fullbodydycolorbg" style="border: 0px; position: absolute; top: 22px; color: rgb(255, 255, 255) !important; display: block;"><b>No Old Credit Balance</b></div>
                                    </div>
                                </div>

                                <div class="w-100 float-left tab-menur tab-menubaar-responsive">
                                    <ul class="w-100 float-left">
                                        <li><a href="<?php echo base_url(); ?>MasterDealer_new/payment_request#" data-oldcr="/Retailer/payment_request/R_Creditchk?MID=Distributor" data-usertype="Distributor" class="chkoldcredit tab-ar  active-ar" data-id="tab1">Request&nbsp;To&nbsp;Distributor</a></li>
                                        <li><a href="<?php echo base_url(); ?>MasterDealer_new/payment_request#" data-oldcr="/Retailer/payment_request/R_Creditchk?MID=Admin" class="chkoldcredit tab-ar" data-usertype="Admin" data-id="tab2">Request&nbsp;To&nbsp;Admin</a></li>

                                    </ul>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>
                                        Payment Mode
                                    </label>
                                    <div>

                                        <div class="custom-district custom-district-retailercss">
                                            <select id="ddldealerPaymentMode" name="ddldealerPaymentMode" onchange="changemoded(this)">
                                                <option value="Cash">Cash</option>
                                                <option value="Branch / CMS Deposite">Branch / CMS Deposite</option>
                                                <option value="Online Transfer">Online Transfer</option>
                                                <option value="Wellets Transfer">Wellets Transfer</option>
                                                <option value="Credit">Credit</option>

                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dcollection-by ">
                                    <label>Collection By </label>
                                    <div>
                                        <input type="text" id="txtdlmretcollection" name="txtdlmretcollection" placeholder="Enter Collection Person">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dtransfer-type" style="display:none;">
                                    <label>Transfer Type </label>
                                    <div>
                                        <div class="custom-district">
                                            <select id="ddlAdmintransfertype" name="ddlAdmintransfertype">
                                                <option>Neft</option>
                                                <option>RTGS</option>
                                                <option>IMPS</option>
                                                <option>Same Bank</option>
                                                <option>UPI</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dbank-select" style="display:none;">
                                    <label>Select Bank 1</label>
                                    <?php

                                                $rsltbank = $this->db->query("SELECT a.user_bank_id,a.account_name,a.ifsc_code,a.account_number,a.branch_name,b.bank_name FROM `tbluser_bank` a left join tblbank b on a.bank_id = b.bank_id");

                                     ?>
                                    <div>
                                        <div class="custom-district">
                                            <select id="dealerbank" name="dealerbank">
                                                <option value="">Select Bank q</option>
                                               <?php
                                                foreach($rsltbank->result() as $rwbank)
                                                {?>
                                                    <option value="<?php echo $rwbank->user_bank_id; ?>"><?php echo $rwbank->bank_name; ?></option>
                                                
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 daccount-no" style="display:none;">
                                    <label>Account No.</label>
                                    <div>
                                        <input type="text" id="txtdealeraccountno" readonly="" name="txtdealeraccountno" placeholder="Enter Account No.">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dutr-no" style="display:none;">
                                    <label>UTR No.</label>
                                    <div>
                                        <input type="text" id="txtdelmretutr" name="txtdelmretutr" placeholder="Enter UTR No.">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dwallet-select" style="display:none;">
                                    <label>Select Wallet</label>
                                    <div>
                                        <div class="custom-district">
                                            <select id="dealerwallets" name="dealerwallets"><option value="">Select Wallet</option></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dwallet-no" style="display:none;">
                                    <label>Wallet No.</label>
                                    <div>
                                        <input type="text" id="txtdealerwalletno" readonly="" name="txtdealerwalletno" placeholder="Enter Wallet No.">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dtranstion-no" style="display:none;">
                                    <label>Transtion No.</label>
                                    <div>
                                        <input type="text" id="txtdlmrettranctionno" name="txtdlmrettranctionno" placeholder="Enter Transtion No.">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 dsubject-reason" style="display:none;">
                                    <label>Subject (Reason)</label>
                                    <div>
                                        <input type="text" id="txtdlmretreason" name="txtdlmretreason" placeholder="Enter Credit Detail">
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 damount ">
                                    <label>Enter Amount </label>
                                    <div>
                                        <input type="text" id="txtdlmretamount" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,&#39;&#39;)" name="txtdlmretamount" placeholder="Enter Amount">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 ddeposite-slip-no" style="display:none;">
                                    <label>Deposite Slip No. </label>
                                    <div>
                                        <input type="text" id="txtdeposno" name="txtdeposno" placeholder="Enter Deposite No.">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 dfund-comment">
                                    <label>Comments</label>
                                    <div>
                                        <textarea id="dlmretcomment" name="dlmretcomment"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div>
                                        <label id="errorsssnd"></label>
                                        <button id="btndistributorInform" class="fullbodydycolorbg" style="color:#fff;float:right;padding: 6px 20px;border: 1px solid #bbb;margin-top: 10px;line-height: 22px;">
                                            Submit
                                        </button>
                                    </div>
                                </div>


                            </div>

                            <div id="DIstribotorshowinformation" style="display:none" class="fund-transfer-form show-after-submit">


<form action="<?php echo base_url(); ?>MasterDealer_new/payment_request" data-ajax="true" data-ajax-failure="OnFailure" data-ajax-mode="replace" data-ajax-success="OnSuccess11" data-ajax-update="#tblshowMasterD" id="form0" method="post">                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div>
                                            <input type="hidden" id="Payto" name="Payto" value="Distributor">

                                            <div id="hdddninputvalues">

                                            </div>
                                            <button id="btnsendpurorder" class="fullbodydycolorbg" type="submit" style="color:#fff;float:right;padding: 6px 20px;border: 1px solid #bbb;margin-top: 10px;line-height: 22px;margin-left:10px;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
</form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <div class="fund-trasfer-right fund-user-right">
                    <ul class="nav nav-tabs responsive-sateulce" id="tabs">
                        <li class="tab-link current active firstclassactive" data-tab="tab-1" style="width:22%;"><a data-toggle="tab" aria-expanded="true" style="padding: 0px 10px;float:left;">
                            <label class="for-change-fund">
                                <span class="fund-fistory">History<sub class="tmw-total-color-one fullbodydycolorbg">Fund Received</sub></span>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </label>
                        </a></li>
                        <li style="width: 47%;float: right;margin-top: 4px;margin-right: 20px;">
                            <div class="row fund-t-dalear fund-t-dalear-responshive">

                                <div class="col-md-5 date-sateclassee trypurchasecewq trypurchasecewq-fi" style="padding-left: 0px;">
                                    <div class="custom-date-icon" style="height: 32px;border-top:0px;border-bottom:0px;">
                                        <i class="fa fa-calendar tmw-total-color-one fullbodydycolorbg" aria-hidden="true"></i>
                                    </div>
                                    <input type="datetime" id="txt_frm_date" name="txt_frm_date">
                                </div>
                                <div class="col-md-5 date-sateclassee trypurchasecewq" style="padding-left: 0px;">
                                    <div class="custom-date-icon" style="height: 32px;border-top:0px;border-bottom:0px;">
                                        <i class="fa fa-calendar tmw-total-color-one fullbodydycolorbg" aria-hidden="true"></i>
                                    </div>
                                    <input type="datetime" id="txt_to_date" name="txt_to_date" style=" margin-top: 1px !important;">
                                </div>
                                <div class="col-md-2 apiclass-satenew" style="padding:0px;">
                                    <button type="button" id="btnchangetabbutton" name="btnDsearch" class="btnssl22" style="padding:0px 15px;float:left;height:30px;margin-top:2px;" data-loading-text="&lt;i class=&#39;fa fa-spinner fa-spin&#39;&gt;&lt;/i&gt;">
                                        <i class="fa fa-search" style="top:-1px;font-size:13px;color:black;"></i>Search
                                    </button>
                                </div>
                            </div>
                        </li>

                    </ul>
                    <div id="tab-1" class="width100 float-left tab-content current secondclassaddew" style="overflow:inherit;">
                        <div class="for-un">
                            
                          
                        </div>
                        <div id="tblshowMasterD" class="table-responsive tblshowMasterclassadd" style="width:100%;overflow:auto;">

    <table class="table table-bordered table-striped table-hover">
        <thead style="background-color:whitesmoke;">
            <tr>

                <th>Order&nbsp;No</th>

                <th>Request&nbsp;To</th>
                <th>Mode</th>
                <th>Description</th>
                <th>Order&nbsp;₹</th>
                <th>Charge</th>
                <th>Net&nbsp;Amount</th>

                
                
                <th>Request&nbsp;Date </th>
                <th>##</th>
                

            </tr>
        </thead>
        <tbody id="tblbody">
        </tbody>
    </table>

</div>
                        <div id="loadingdiv" style="text-align:center;display:none;margin-bottom:20px;">

                            <img src="<?php echo base_url();?>vfiles/ajax-loader.gif">
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!----------master distributor fund transfer----->

    <div class="modal fund-tr-history  in" id="m-d-fund-transfer" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document" style="margin:0px;float:right;margin-top: 77px;">

            <div class="modal-content width100 float-left">
                <div class="modal-header width100 float-left ecomm-pop-head">

                    <h5 id="mdhis">Retailer Fund Transfered History</h5>


                    <button type="button" class="btn waves-effect " data-dismiss="modal" style="float:right;border:0px;color:var(--main-bg-lcolor);padding:0px; height:auto;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>


                </div><!--.modal-header-->
                <div class="modal-body width100 float-left ecomm-pop-body">
                    <div class="float-left width100">
                        <form class="first-form">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="form-group">
                                        <label id="mdfrmname">Retailer Firm Name</label>

                                        <input class="form-control" readonly="readonly" required="required" id="txtmdfirmnameshow" type="text">

                                    </div>
                                </div>

                            </div><!--.row-->

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 col">
                                    <div class="form-group">
                                        <label>Total Amount</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txttotalamountshow">
                                    </div>
                                </div>

                            </div><!--.row-->


                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label id="mdPreremain">Reatiler Pre Remain</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtMDPREREMAINshow">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="mdPostremain">Reatiler Post Remain</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtMDPOSTREMAINshow">
                                    </div>
                                </div>
                            </div><!--.row-->



                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label id="mdPrecredit">Your Pre Balance</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtMDPRECREDITshow">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="mdPostcredit">Your Post Balance</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtMDPOSTCREDITshow">
                                    </div>
                                </div>
                            </div><!--.row-->
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 col">
                                    <div class="form-group">
                                        <label>Request Timing</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtREQUESTTIMINGshow">
                                    </div>
                                </div>
                                
                            </div><!--.row-->

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Comments</label>

                                        <input class="form-control" readonly="readonly" required="required" type="text" value="" id="txtCOMMNETSshow" style="height:50px;">

                                    </div>
                                </div>

                            </div><!--.row-->



                        </form>

                        <!--=============-->

                    </div><!--.modal-body-->


                </div>

            </div>
        </div>
    </div>


    <!---------Purchase request send-->
    <div class="modal fund-tr-history  in purchase-model purchase-model-newadd model-responshive-full" id="m-d-fund-transfer12" tabindex="-1" role="dialog" style="display: none; margin-top: 77px;">
        <div class="modal-dialog" role="document" style="margin:0px;float:right;height:auto;">

            <div class="modal-content width100 float-left">
                <div class="modal-header width100 float-left ecomm-pop-head">

                    <h5 id="mdhis">Purchase Order History</h5>


                    <button type="button" class="btn waves-effect " data-dismiss="modal" style="float:right;border:0px;color:var(--main-bg-lcolor);padding:0px; height:auto;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>


                </div><!--.modal-header-->
                <div class="modal-body width100 float-left ecomm-pop-body">
                    <div class="float-left width100">
                        <form class="first-form">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="form-group">
                                        <label id="mdfrmname">Request To</label>

                                        <input class="form-control" readonly="readonly" required="required" id="txtfromshow" type="text">

                                    </div>
                                </div>

                            </div><!--.row-->





                            <!--.row-->

                            <!--.row-->
                            <!--.row-->


                            <div class="row">
                                
                            <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label id="mdPrecredit">response date</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtresponsedateshow">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="mdPostremain">request date</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtreqdateshow">
                                    </div>
                                </div>
                            </div><!--.row-->



                            <div class="row">
                                
                                
                            </div><!--.row-->

                            
                                
                                <!--.row-->

                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase;border-color:var(--main-bg-lcolor);" type="text" id="txtdetailsshow">
                                    </div>
                                </div>
                            </div><!--.row-->



                        </form>

                        <!--=============-->

                    </div><!--.modal-body-->


                </div>

            </div>
        </div>
    </div>


 
    <!-------------ALLFUNDRECIVE-->
    <div class="modal fund-tr-history  in purchase-model" id="ALLm-d-fund-transfer12" tabindex="-1" role="dialog" style="display: none; margin-top: 77px;">
        <div class="modal-dialog" role="document" style="margin:0px;float:right;">

            <div class="modal-content width100 float-left">
                <div class="modal-header width100 float-left ecomm-pop-head">

                    <h5 id="mdhis">Fund Receive History</h5>


                    <button type="button" class="btn waves-effect " data-dismiss="modal" style="float:right;border:0px;color:var(--main-bg-lcolor);padding:0px; height:auto;">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>


                </div><!--.modal-header-->
                <div class="modal-body width100 float-left ecomm-pop-body">
                    <div class="float-left width100">
                        <form class="first-form">
                            <!--.row-->





                            <div class="row">
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" id="txtstsshowfundrecive" type="text">
                                    </div>
                                </div>
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label>paymode</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtpaymodeshowfundrecive">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="lblcollreasonfundrecive">utrno</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtcollreasonfundrecive">
                                    </div>
                                </div>
                            </div><!--.row-->
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label>PreBalance</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtPrebalanceshowrecive">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label>PostBalance</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase;border-color:var(--main-bg-lcolor);" type="text" id="txtPostbalanceshowrecive">
                                    </div>
                                </div>
                            </div>

                            <!--.row-->


                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label id="mdPreremain">amount</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtamountshowfundrecive">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="mdPostremain">reqdate</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtreqdateshowfundrecive">
                                    </div>
                                </div>
                            </div><!--.row-->



                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 col">
                                    <div class="form-group">
                                        <label id="mdPrecredit">M/D Pre Credit</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtPrecreditshowfundrecive">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label id="mdPostcredit">M/D Post Credit</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase" type="text" id="txtMDPOSTCREDITshowfundrecive">
                                    </div>
                                </div>
                            </div><!--.row-->

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>cashDepositCharge</label>

                                        <input class="form-control" readonly="readonly" required="required" type="text" id="txtcashDepositChargehowfundrecive">

                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>finalAmount</label>

                                        <input class="form-control" readonly="readonly" required="required" type="text" value="" id="txtfinalAmountshowfundrecive" style="height:50px;">

                                    </div>
                                </div>
                            </div><!--.row-->

                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-xs-12 col-2">
                                    <div class="form-group">
                                        <label>Comment</label>
                                        <input class="form-control" readonly="readonly" required="required" style="text-transform:uppercase;border-color:var(--main-bg-lcolor);" type="text" id="txtdetailsshowfundrecive">
                                    </div>
                                </div>
                            </div><!--.row-->



                        </form>

                        <!--=============-->

                    </div><!--.modal-body-->


                </div>

            </div>
        </div>
    </div>

</section>

<script src="<?php echo base_url();?>vfiles/jquery.min.js.download"></script>
<!-- Custom Js -->
<script src="<?php echo base_url();?>vfiles/basic-form-elements.js.download"></script>
<!-- Demo Js -->
<script src="<?php echo base_url();?>vfiles/bootstrap-select.js.download"></script>
<script src="<?php echo base_url();?>vfiles/demo.js.download"></script>
<script src="<?php echo base_url();?>vfiles/jquery.slimscroll.js.download"></script>
<!--Add State dropdown list-->
<script src="<?php echo base_url();?>vfiles/sweetalert-dev.js.download">
</script>
<link href="<?php echo base_url();?>vfiles/sweetalert(1).css" rel="stylesheet">
<link href="<?php echo base_url();?>vfiles/Dashcustom.css" rel="stylesheet">

<script src="<?php echo base_url();?>vfiles/jquery.validate.min.js.download"></script>
<script src="<?php echo base_url();?>vfiles/jquery.validate.unobtrusive.min.js.download"></script>
<script src="<?php echo base_url();?>vfiles/jquery.unobtrusive-ajax.min.js.download"></script>

<script>


    $('#btnchangetabbutton').click(function (e) {
        debugger
        var tabtype = $("ul.tabtypeschages li.tab-link.active").attr('data-tabname')
      
      $.ajax({
          url: "/Retailer/payment_request",
          data: { tabtype: tabtype, txt_frm_date: $('#txt_frm_date').val(),txt_to_date: $('#txt_to_date').val() },
            success: function (data) {
                $('#tblshowMasterD').html(data)

            }

        })


    });



</script>

<script>
    $(document).ready(function()
    {

        $('.input-daterange').datepicker({
            format: "yyyy-mm-dd",
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",

        });
        var val = '';
        if (val != "post") {
            $("#txt_frm_date").datepicker("setDate", new Date());
            $("#txt_to_date").datepicker("setDate", new Date());
        }

    })
</script>

<script>
    var fewSeconds = 10;
    $(document).ajaxStart(function () {

        $("#shownoneclass").prop('disabled', true);
        $("#btnsendpurorder").prop('disabled', true);
        setTimeout(function () {

            $("#btnsendpurorder").prop('disabled', false);

        }, fewSeconds * 1000);
    });


</script>

<script>
    function tablerowshowdetail22(frm, orderno, sts, paymode, utrno, details, amount, reqdate, responsedate, cashDepositCharge, finalAmount, headtype) {
alert("here");
        $('#txtfromshow').val(frm);
        $('#txtordernohow').val(orderno);
        $('#txtstsshow').val(sts);
        $('#txtpaymodeshow').val(paymode);
        // $('#txtutrnoshow').val(utrno);
        $('#txtdetailsshow').val(details);
        $('#txtamountshow').val(amount);
        $('#txtreqdateshow').val(reqdate);
        $('#txtresponsedateshow').val(responsedate);
        //$('#txtcrestsshow').val(crests);
        $('#txttypeshow').val(headtype);
        $('#txtcashDepositChargehow').val(cashDepositCharge)
        $('#txtfinalAmountshow').val(finalAmount)
        if (paymode == "Cash") {

            $('#lblcollreason').html('Collection By')
            $('#txtcollreason').val(utrno)
        }
        if (paymode == "Branch / CMS Deposite") {

            $('#lblcollreason').text('Deposite Slip No.')
            $('#txtcollreason').val(utrno)
        }
        if (paymode == "Online Transfer") {

            $('#lblcollreason').text('UTR No.')
            $('#txtcollreason').val(utrno)
        }
        if (paymode == "Wellets Transfer") {

            $('#lblcollreason').text('Transtion No')
            $('#txtcollreason').val(utrno)
        }


        //  $('#txtmdfirmnameshow').val(frmname);
        // / /$('#txtmdfirmnameshow').val(frmname);
        //   $('#txtmdfirmnameshow').val(frmname);
        //   $('#txtmdfirmnameshow').val(frmname);
    }



</script>

<script>
    function tablerowshowdetail(frmname, total, remainfromnew, remainfromold, remtoold, remotonew, comment, date) {



        $('#txtmdfirmnameshow').val(frmname);

        $('#txttotalamountshow').val(total);

        $('#txtMDPREREMAINshow').val(remtoold);
        $('#txtMDPOSTREMAINshow').val(remotonew);
        $('#txtMDPRECREDITshow').val(remainfromold);
        $('#txtMDPOSTCREDITshow').val(remainfromnew);
        $('#txtCOMMNETSshow').val(comment)
        $('#txtREQUESTTIMINGshow').val(date)
        //   $('#txtmdfirmnameshow').val(frmname);
        //$('#txtmdfirmnameshow').val(frmname);
        //   $('#txtmdfirmnameshow').val(frmname);
        //  $('#txtmdfirmnameshow').val(frmname);
    }



</script>

<script>
    $( document ).ready(function() {

         $('.old-crd').show();
        $('.old-crd').html('Loading...')


         $.ajax({
             url: "/Retailer/payment_request/R_Creditchk",
             data: {MID:'Distributor'},
            success: function (data) {

                $('.old-crd').empty();

                if (data.diff < 0) {

                    $('.old-crd').html('CR. ' + data.diff)


                }
                else {
                    $('.old-crd').html('<b>No Old Credit Balance</b>')

                }

                $("#dealerbank").html("");

                $("#dealerbank").append($('<option></option>').val('').html('Select Bank'));
                for (var x = 0; x < data.listbank.length; x++) {
                    $("#dealerbank").append($('<option></option>').val(data.listbank[x].Value).html(data.listbank[x].Text));
                }
                $("#dealerwallets").html("");
                $("#dealerwallets").append($('<option></option>').val('').html('Select Wallet'));
                for (var x = 0; x < data.walletinfo.length; x++) {
                    $("#dealerwallets").append($('<option></option>').val(data.walletinfo[x].Value).html(data.walletinfo[x].Text));
                }
            }

        })


});



</script>


<script>
    $('.chkoldcredit').click(function () {
        $('.old-crd').show();
        $('.old-crd').html('Loading...')

        $.ajax({
            url: $(this).attr('data-oldcr'),
            success: function (data) {

                $('.old-crd').empty();
                if (data.diff < 0) {

                    $('.old-crd').html('CR. ' + data.diff)


                }
                else {
                    $('.old-crd').html('<b>No Old Credit Balance</b>')

                }

                $("#dealerbank").html("");

                $("#dealerbank").append($('<option></option>').val('').html('Select Bank'));
                for (var x = 0; x < data.listbank.length; x++) {
                    $("#dealerbank").append($('<option></option>').val(data.listbank[x].Value).html(data.listbank[x].Text));
                }
                $("#dealerwallets").html("");
                $("#dealerwallets").append($('<option></option>').val('').html('Select Wallet'));
                for (var x = 0; x < data.walletinfo.length; x++) {
                    $("#dealerwallets").append($('<option></option>').val(data.walletinfo[x].Value).html(data.walletinfo[x].Text));
                }
            }

        })


    })
</script>


















<script>
    $('.tabChangeType').click(function () {
        $.ajax({
            url: $(this).attr('data-href'),
            success: function (data) {
                $('#tblshowMasterD').html(data)

            }

        })



    })
</script>




<script>
    function buttonClick(theButton) {

        $('#hdtype').val(theButton.name);

        //alert(theButton.name+"  "+$('#hdidno').val())


        return true;
    }




</script>


<script>

     $("#RetailerId").blur(function (event) {
        //  var character = String.fromCharCode(event.keyCode);
        var mobemail = $("#RetailerId").val()

         debugger

            //   alert(mobemail.val())
            $.ajax({
                url: "/Retailer/payment_request/CheckRetailerEmailMobile",
                data: { emailmobile:mobemail},
                success: function (txt) {




                    //debugger
                    if (txt != '') {
                                  var data = JSON.parse(txt);
                        $('#retailerinform').show();
                        $('#lblfrmname').text(data.frm_name);
                          $('#lblreatilername').text(data.retailername);
                        $('#lblemail').text(data.email);
                        $('#lblmobile').text(data.mobile)
                         $('#shownoneclass').removeattr('disabled');
                    }
                    else {
                        $('#retailerinform').hide();
                         $('#shownoneclass').attr('disabled', 'disabled');
                    }


                },
                 error: function(xhr){
        alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                     }




            })


});


</script>




<script>
    $(document).ready(function () {
        $('.tab-ar').click(function () {

            $(".tabr").removeClass('tab-activer');
            $(".tabr[data-id='" + $(this).attr('data-id') + "']").addClass("tab-activer");
            $(".tab-ar").removeClass('active-ar');
            $(this).parent().find(".tab-ar").addClass('active-ar');
            var usertype = $(this).attr('data-usertype')
            if (usertype == 'Admin') {
                $('#Payto').val('Admin')

            }
            else if (usertype == 'Distributor') {
                $('#Payto').val('Distributor')
            }
        });
    });
</script>


<script>


    function changemasterd(value) {
        var mas = $(value).val();
        if (mas == '') {
            $('.old-crd').hide();

        } else {
            $('.old-crd').show();
        }
    }

</script>

<script>
    $(document).ready(function () {
        $('.new-nextbutton button#shownoneclass').prop('disabled', true);
        $('.fullclassdata input#RetailerId').keyup(function () {
            if ($(this).val() != '') {
                $('.new-nextbutton button#shownoneclass').prop('disabled', false);
            }
        });
    });
</script>

<script>


     function OnSuccess(result) {
        //$("#frmdata1 #errorsssnd").text(result);
         $("#home").find("input[type=text]").val('');

         $('#retailerinform').hide();
         $('#shownoneclass').attr('disabled', 'disabled');
       // cahangeTab('menu1');

        $.ajax({
            url: "/Retailer/payment_request/MDTODealer?tabtype=ReatilertoRetailer",
            success: function (data) {
                $('#tblshowMasterD').html(data)

  }

        })



    }




</script>

<style>

    .tab-menur ul {
        margin: 0;
        padding: 0;
    }



        .tab-menur ul li {
            width: 50%;
            text-align: center;
        }

        .tab-menur ul li {
            float: left;
        }
</style>

<script>


    function changemasterd(value) {
        var mas = $(value).val();
        if (mas == '') {
            $('.old-crd').hide();

        } else {
            $('.old-crd').show();
        }
    }
    function changemoded(value) {
        var res = $(value).val();

        if (res == "Cash") {
            $('.dcollection-by').show();

            $('.dbank-select').hide();
            $('.daccount-no').hide();
            $('.dutr-no').hide();
            $('.dwallet-select').hide();
            $('.dwallet-no').hide();
            $('.dtranstion-no').hide();
            $('.dtransfer-type').hide();
            $('.dsubject-reason').hide();
            $('.ddeposite-slip-no').hide();
            $('.dfund-comment').show();
        }
        else if (res == "Branch / CMS Deposite") {
            $('.dcollection-by').hide();

            $('.dbank-select').show();
            $('.daccount-no').hide();
            $('.dutr-no').hide();
            $('.dwallet-select').hide();
            $('.dwallet-no').hide();
            $('.dtranstion-no').hide();
            $('.dtransfer-type').hide();
            $('.dsubject-reason').hide();
            $('.ddeposite-slip-no').show();
            $('.dfund-comment').show();
        }
        else if (res == "Online Transfer") {
            $('.dcollection-by').hide();
            $('.dtransfer-type').show();
            $('.dbank-select').show();
            $('.daccount-no').show();
            $('.dutr-no').show();
            $('.dwallet-select').hide();
            $('.dwallet-no').hide();
            $('.dtranstion-no').hide();

            $('.dsubject-reason').hide();
            $('.ddeposite-slip-no').hide();
            $('.dfund-comment').hide();


        }
        else if (res == "Wellets Transfer") {
            $('.dcollection-by').hide();
            $('.dtransfer-type').hide();
            $('.dbank-select').hide();
            $('.daccount-no').hide();
            $('.dutr-no').hide();
            $('.dwallet-select').show();
            $('.dwallet-no').show();
            $('.dtranstion-no').show();

            $('.dsubject-reason').hide();
            $('.ddeposite-slip-no').hide();
            $('.dfund-comment').show();
        }
         else if (res == "Credit") {
            $('.dcollection-by').hide();
            $('.dtransfer-type').hide();
            $('.dbank-select').hide();
            $('.daccount-no').hide();
            $('.dutr-no').hide();
            $('.dwallet-select').hide();
            $('.dwallet-no').hide();
            $('.dtranstion-no').hide();
            $('.dtransfer-type').hide();
            $('.dsubject-reason').hide();
            $('.ddeposite-slip-no').hide();
            $('.dfund-comment').show();
        }
    }





</script>


<script>
    $('#dealerbank').change(function () {

        $('#txtdealeraccountno').val($('#dealerbank').val())


    })

     $('#dealerwallets').change(function () {

        $('#txtdealerwalletno').val($('#dealerwallets').val())


    })


</script>


<script>

    ///Distreibutort Start

    $('#btndistributorInform').click(function () {
        $('#hdddninputvalues').empty();

        if ($('#ddldealerPaymentMode').val() == '' || $('#ddldealerPaymentMode').val() == null) {
            $("#errorsssnd").text('Pay mode REQUIRED');
            return false;
        }
        if ($('#ddldealerPaymentMode').val() == 'Cash') {
            if ($('#txtdlmretcollection').val() == '' || $('#txtdlmretcollection').val() == null) {
                $("#errorsssnd").text('Collection Person Name');
                return false;
            }
            if ($('#txtdlmretamount').val() == '' || $('#txtdlmretamount').val() == null) {
                $("#errorsssnd").text('Amount Required');
                return false;
            }
            if ($('#dlmretcomment').val() == '' || $('#dlmretcomment').val() == null) {
                $("#errorsssnd").text('Comment Required');
                return false;
            }


        }
        else if ($('#ddldealerPaymentMode').val() == 'Branch / CMS Deposite') {

            if ($('#dealerbank').val() == '' || $('#dealerbank').val() == null) {
                $("#errorsssnd").text('Select Bank Name');
                return false;
            }
            if ($('#txtdlmretamount').val() == '' || $('#txtdlmretamount').val() == null) {
                $("#errorsssnd").text('Amount Required');
                return false;
            }
            if ($('#txtdeposno').val() == '' || $('#txtdeposno').val() == null) {
                $("#errorsssnd").text('Enter Deposite Slip No.');
                return false;
            }

            if ($('#dlmretcomment').val() == '' || $('#dlmretcomment').val() == null) {
                $("#errorsssnd").text('Comment Required');
                return false;
            }

        }

        else if ($('#ddldealerPaymentMode').val() == 'Online Transfer') {

            //if ($('#DDTransferType').val() == '' || $('#DDTransferType').val() == null) {
            //    $("#errorss").text('Select Transfer Type');
            //    return false;
            //}
            if ($('#dealerbank').val() == '' || $('#dealerbank').val() == null) {
                $("#errorsssnd").text('Select Bank Name');
                return false;
            }
            if ($('#txtdealeraccountno').val() == '' || $('#txtdealeraccountno').val() == null) {
                $("#errorsssnd").text('Account No Required');
                return false;
            }
            if ($('#txtdelmretutr').val() == '' || $('#txtdelmretutr').val() == null) {
                $("#errorsssnd").text('UTR No Required');
                return false;
            }
            if ($('#txtdlmretamount').val() == '' || $('#txtdlmretamount').val() == null) {
                $("#errorsssnd").text('Amount Required');
                return false;
            }

        }
        else if ($('#ddldealerPaymentMode').val() == 'Wellets Transfer') {

            if ($('#dealerwallets').val() == '' || $('#dealerwallets').val() == null) {
                $("#errorsssnd").text('Select Wallets');
                return false;
            }
            if ($('#txtdealerwalletno').val() == '' || $('#txtdealerwalletno').val() == null) {
                $("#errorsssnd").text('Wallet No. Required');
                return false;
            }
            if ($('#txtdlmrettranctionno').val() == '' || $('#txtdlmrettranctionno').val() == null) {
                $("#errorsssnd").text('Transtion No.');
                return false;
            }
            if ($('#txtdlmretamount').val() == '' || $('#txtdlmretamount').val() == null) {
                $("#errorsssnd").text('Amount Required');
                return false;
            }
            //if ($('#txtDISTCOMMENTS').val() == '' || $('#txtDISTCOMMENTS').val() == null) {
            //    $("#errorss").text('Comment Required');
            //    return false;
            //}
        }

         else if ($('#ddldealerPaymentMode').val() == 'Credit') {

           
            
            if ($('#txtdlmretamount').val() == '' || $('#txtdlmretamount').val() == null) {
                $("#errorsssnd").text('Amount Required');
                return false;
            }
            if ($('#dlmretcomment').val() == '' || $('#dlmretcomment').val() == null) {
                $("#errorsssnd").text('Comment Required');
                return false;
            }
        }


        var idst = $("#ddldealerPaymentMode option:selected").text();
        var collper = $('#txtdlmretcollection').val();
        var amount = $('#txtdlmretamount').val();

        var comment = $('#dlmretcomment').val();
        var bankname = $("#dealerbank option:selected").text();
        var depositeslip = $('#txtdeposno').val();
        var tranftype = $("#ddlAdmintransfertype option:selected");
        var accountno = $('#txtdealeraccountno').val();
        var UTRnos = $('#txtdelmretutr').val();
        var walletname = $("#dealerwallets option:selected");
        var walletno = $('#txtdealerwalletno').val();
        var transectionno = $('#txtdlmrettranctionno').val();
        //var setteltype = $('#txtDISTSETTLEMENTTYPE').val();
        //var crdetails = $('#txtDISTCREDITDETAILS').val();
        var sbject = $('#txtdlmretreason').val();
        var accnosele = $("#dealerbank").val();


        var thtm = '<div id="hdidsss">';

        thtm += '<input id="hdPaymentMode" required name="hdPaymentMode" type="hidden"  value="' + idst + '" />';
        //  thtm += '<input id="hdPaymentAmount" name="hdPaymentAmount" type="hidden"  value="' +amount + '" />';


        if ($("#ddldealerPaymentMode").val() === "Cash") {

            thtm += '<input id="hdMDcollection" required name="hdMDcollection" type="hidden"  value="' + collper + '" />';
            thtm += '<input id="hdMDComments" required name="hdMDComments" type="hidden"  value="' + comment + '" />';
            thtm += '<input id="hdPaymentAmount" required name="hdPaymentAmount" type="hidden"  value="' + amount + '" />';
        }
        if ($("#ddldealerPaymentMode").val() === "Branch / CMS Deposite") {

            thtm += '<input id="hdMDBank" required name="hdMDBank" type="hidden"  value="' + bankname + '" />';
            thtm += '<input id="hdMDaccountno" required name="hdMDaccountno" type="hidden"  value="' + accnosele + '" />';
            thtm += '<input id="hdPaymentAmount" required name="hdPaymentAmount" type="hidden"  value="' + amount + '" />';
            thtm += '<input id="hdMDDepositeSlipNo" required name="hdMDDepositeSlipNo" type="hidden"  value="' + depositeslip + '" />';
            thtm += '<input id="hdMDComments" required name="hdMDComments" type="hidden"  value="' + comment + '" />';


        }
        if ($("#ddldealerPaymentMode").val() === "Online Transfer") {

            thtm += '<input id="hdMDTransferType" required name="hdMDTransferType" type="hidden"  value="' + tranftype.text() + '" />';
            thtm += '<input id="hdMDBank" required name="hdMDBank" type="hidden"  value="' + bankname + '" />';
            thtm += '<input id="hdMDaccountno" required  name="hdMDaccountno" type="hidden"  value="' + accountno + '" />';
            thtm += '<input id="hdMDutrno" required name="hdMDutrno" type="hidden"  value="' + UTRnos + '" />';
            thtm += '<input id="hdPaymentAmount" required name="hdPaymentAmount" type="hidden"  value="' + amount + '" />';
        }
        if ($("#ddldealerPaymentMode").val() === "Wellets Transfer") {

            thtm += '<input id="hdMDwallet" required name="hdMDwallet" type="hidden"  value="' + walletname.text() + '" />';
            thtm += '<input id="hdMDwalletno" required name="hdMDwalletno" type="hidden"  value="' + walletno + '" />';
            thtm += '<input id="hdMDtransationno" required name="hdMDtransationno" type="hidden"  value="' + transectionno + '" />';
            thtm += '<input id="hdPaymentAmount" required name="hdPaymentAmount" type="hidden"  value="' + amount + '" />';
            thtm += '<input id="hdMDComments" required name="hdMDComments" type="hidden"  value="' + comment + '" />';
        }
          if ($("#ddldealerPaymentMode").val() === "Credit") {

           
            thtm += '<input id="hdMDComments" required name="hdMDComments" type="hidden"  value="' + comment + '" />';
            thtm += '<input id="hdPaymentAmount" required name="hdPaymentAmount" type="hidden"  value="' + amount + '" />';
        }

        thtm += '</div>';

        $('.txtcodecodec').val('');
        // $('#txtcode').val('')
        $('#hdddninputvalues').html(thtm);
        $('#btnsendpurorder').click();


    })

    ///Distreibutort END

</script>

<script>

     function OnSuccess11(result) {
        $("#frmdata1 #errorsssnd").text(result);


        $('.old-crd').empty();

        $('#hdddninputvalues').empty();

       // cahangeTab('menu1');

        $.ajax({
            url: "/Retailer/payment_request/MDTODealer?tabtype=Purchase_ORDER",
            success: function (data) {
                $('#tblshowMasterD').html(data)

  }

        })



    }




</script>





<!--Active_Class_jQuery-->

<script>
    $(document).ready(function () {
        var current = location.pathname;
        $('.report-list-change li a').each(function () {
            var $this = $(this);
            if ($this.attr('href').indexOf(current) !== -1) {
                $this.addClass('active');


            }
        })
    });
</script>

<script>
    $(document).ready(function () {
        $(".date-sateclassee input").click(function () {
            $(".datepicker").addClass('daqqqqkerrteyyecharge daqqqqkerrteyyechargedfdgdfgfh');
        });
    });
</script>

<script>
    function myFunction() {

        //  var value = $(this).val().toLowerCase();
        var value = $('#myInput').val().toLowerCase();

        $("#tblbody .tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }


</script>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url();?>vfiles/jquery.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/datatablejquery.js.download"></script>
    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url();?>vfiles/bootstrap.js.download"></script>
    <!-- Autosize Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/autosize.js.download"></script>
    <!-- Select Plugin Js -->
    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/jquery.slimscroll.js.download"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/waves.js.download"></script>
    <!-- Jquery CountTo Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/jquery.countTo.js.download"></script>
    <!-- Morris Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/raphael.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/morris.js.download"></script>
    <!-- ChartJs -->
    <!-- Flot Charts Plugin Js -->
    <script src="<?php echo base_url();?>vfiles/jquery.flot.js.download"></script>
    <script>
        $(function () {
            var current = location.pathname;
            var chk = 0;
            $('#leftulbar li a').each(function () {
                var $this = $(this);
                // if the current path is like this link, make it active
                if ($this.attr('href').indexOf(current) !== -1) {
                    //alert("djdjdj")
                    $(this).closest("li").addClass("active");
                    if (chk == 5) {
                        return false;
                    }
                    chk++;
                }
            })
        })
    </script>


    <!-- Sparkline Chart Plugin Js -->
    <!-- Custom Js -->
    <script src="<?php echo base_url();?>vfiles/admin.js.download"></script>
    
    <!-- Demo Js -->
    <script src="<?php echo base_url();?>vfiles/demo.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/moment.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/daterangepicker.js.download"></script>
    <!--data table -->
    <script src="<?php echo base_url();?>vfiles/jquery.dataTables.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/dataTables.bootstrap.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/dataTables.buttons.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/buttons.flash.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/jszip.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/pdfmake.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/vfs_fonts.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/buttons.html5.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/buttons.print.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/jquery-datatable.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/bootstrap-material-datetimepicker.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/sweetalert.min.js.download"></script>
    <link href="<?php echo base_url();?>vfiles/datatable.css" rel="stylesheet">

    <script src="<?php echo base_url();?>vfiles/basic-form-elements.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/bootstrap-datepicker.min.js.download"></script>
    <script src="<?php echo base_url();?>vfiles/bootstrap-datetimepicker.min.js.download"></script>









<!--Redirect to Index view with javascript-->


<script>
    function gocomplaint()
    {
        var url = '/Retailer/payment_request/Complaint';
        window.location.href = url;
    }
</script>
<!-- Push Nitification using SignalR-->
<script src="<?php echo base_url();?>vfiles/jquery.signalR-2.4.0.min.js.download"></script>
<script src="<?php echo base_url();?>vfiles/hubs"></script>
<script type="text/javascript">

    window.onload = function () {
        //alert("chal gaya kya???");

        var hub = $.connection.notificationHub;
        //alert("notificationHub");
        //Client Call
        hub.client.broadcaastNotif = function (totalNotif) {
            //alert("broadcaastNotif");
            console.log("Notif Data: " + totalNotif);
            console.log("total items : " + totalNotif.length)
            if (totalNotif.length > 0) {
                $.each(totalNotif, function (i, obj) {
                    console.log("i : " + i);
                    console.log("Title : " + obj.Title);
                    console.log("Details : " + obj.Details);
                    console.log("DetailsURL : " + obj.DetailsURL);
                    //setNotification(obj.Title, obj.Details, obj.DetailsURL);
                    customnotify(obj.Title, obj.Details, obj.DetailsURL, obj.Id);
                });

            }
        };
        //$.connection.hub.start().done(function () { });
        $.connection.hub.start()
            .done(function () {
                console.log("Hub Connected!");

                //Server Call
                hub.server.getNotification();

            })
            .fail(function () {
                console.log("Could not Connect!");
            });
    };
</script>


<script> 
    function SetAsReaded(idn,url)
    {
        //alert("sjbskjdfbaaaaaaaaaaaaasjkdfb");
       // alert('maharshimulti.co.in');
        var urlSiteName = 'master.maharshimulti.co.in';
        var setObj = { Id : idn};
        var Url = "https://www." + urlSiteName +"/api/Notification/UpdateReadProperty";
        //alert(Url);
        $.ajax({
            type: "POST",
            //url: "/api/Values/SendNotification",
            url: Url,
            data: JSON.stringify(setObj),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                //reset field
                //$("#myMessage").val("");
            },
            error: function (xhr,err) {
                console.log("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                console.log("responseText: " + xhr.responseText);
            }
        });
        //window.open(url,"_blank");
    }
</script>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        if (Notification.permission !== "granted") {
            Notification.requestPermission();
        }
    });
    function customnotify(title, desc, url, id) {
        if (Notification.permission !== "granted") {
           // alert("permission=granted");
            Notification.requestPermission();
        }
        else {
            //alert('');
            var notification = new Notification(title, {
                icon: '',
                body: desc,
            });

            /* Remove the notification from Notification Center when clicked.*/
            notification.onclick = function () {
                //alert("Click");
                SetAsReaded(id, url);
                notification.close();
            };


            ///* Callback function when the notification is closed. */
            notification.onclose = function () {
                SetAsReaded(id, url);
                notification.close();
                console.log('Notification closed');
            };
        }


    }
</script>

<!-- Push Nitification using SignalR END-->
<!--  Get Total  My Credit Balance-->
<script>
        function showoutstandingbal()
        {
            $("#showoutstandingbalance").empty();
            $.ajax({
                type: 'Post',
                url: "/Retailer/payment_request/Chkbalance",
                dataType: 'html',
            cache: false,
            async: false,
            success: function (data) {
                var x = JSON.parse(data);
                var newRow =

 "<tr>" +
"<td><a href='/Retailer/payment_request/Show_Credit_report_by_admin',style='text-decoration:none;cursor:pointer;'><p>My Credit From Admin</p></a></td>" +
"<td><p style='text-align:center;'>" + x.admincreditbal + "</p></td>" + "</tr>" +
"<tr>"+
 "<tr>" +
"<td><a href='/Retailer/payment_request/Show_Credit_report_by_dealer',style='text-decoration:none;cursor:pointer;'><p>My Credit From Distributor</p></a></td>" +
"<td><p style='text-align:center;'>" + x.dealercreditbal + "</p></td>" + "</tr>" +
"<tr>";
  $('#showoutstandingbalance').append(newRow);
            }
        });
        }
</script>

<!--Transfer Total Balance Retailer To Retailer and Recived Balannce from Dealer and admin-->
<script>
        function showtransferbal()
        {
            $("#showtransferbalancetableid").empty();
            $.ajax({
                type: 'POST',
                url:'/Retailer/payment_request/Totalbaltransfer',
                dataType:'html',
                cache:false,
                async:false,
                success: function(data)
                {
                       var x = JSON.parse(data);
                       var newRow =

    "<tr>" +
   "<td><a href='/Retailer/payment_request/Retailer_to_retailer',style='text-decoration:none;cursor:pointer;'><p>Total&nbsp;Transfer&nbsp;Retailer&nbsp;to&nbsp;Retailer</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.retailertoretailer + "</p></td>" + "</tr>" +
    "<tr>" +
    "<tr>" +
   "<td><a href='/Retailer/payment_request/ReceiveFund_by_admin',style='text-decoration:none;cursor:pointer;'><p>Received&nbsp;From&nbsp;Admin</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.admintoretailer + "</p></td>" + "</tr>" +
    "<tr>" +
    "<tr>" +
   "<td><a href='/Retailer/payment_request/ReceiveFund_by_dealer',style='text-decoration:none;cursor:pointer;'><p>Received&nbsp;From&nbsp;Distributor</p></a></td>" +
   "<td><p style='text-align:center;'>" + x.dealertoretailer + "</p></td>" + "</tr>" +
    "<tr>";

   $('#showtransferbalancetableid').append(newRow);
            }
            });
        }
</script>










</body></html>