
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | DMT</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--Favicon-->
    <link href="<?php echo base_url(); ?>assets2/images/Favicon/favicon502.png" rel="icon" />
    <!--Favicon End-->
    <script src="<?php echo base_url(); ?>mpayfiles/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>mpayfiles/RG-DEv.css" rel="stylesheet" />
    <!--sweet alert-->
    <script src="<?php echo base_url(); ?>js/Sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url(); ?>js/Sweetalert/sweetalert.css" rel="stylesheet" />
    <!--sweet alert End-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!--Font Style-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <!--Font Style End-->
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Font Awesome End-->
    <!-- Page plugins -->
    <link href="<?php echo base_url(); ?>mpayfiles/argon.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>mpayfiles/Main1.css" rel="stylesheet" />
    <!--Color theme style-->
    <link href="<?php echo base_url(); ?>mpayfiles/Theme.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
</head>
<body>
    
    <!--sweet alert start-->


     <?php include("elements/distsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
         <?php include("elements/distheader.php"); ?>
        <!-- Header -->
        
<!--page style-->
<link href="<?php echo base_url(); ?>mpayfiles/bbps.css" rel="stylesheet" />
<!--page style End-->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">BBPS</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 text-right">
                    <img src="<?php echo base_url(); ?>mpayfiles/BBPS_Logo.png" style="height:30px;background:#fff;" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6" data-ng-app="rgapp">
    <div data-ng-controller="MAINRGBS">
        <div class="row mg-t-20">
           
            <div class="col-md-3 pd-xs-0">
                <div class="card card-mini">
                    <div class="card-content">
                        <div class="card-body  pd-xs-10">
                            <div class="widget-title">
                                <h5><b>BBPS Services</b></h5>
                            </div>
                            <div id="bbps">
                                <ul class="mylist">
                                    <li class="list-group-item1" data-ng-repeat="item in categoriesdata">
                                        <a href="#" class="effect-underline" value="{{item.Categoryid}}" data-ng-click="dobindopnamebycate(item)">
                                            <img style="width:20px;" src="<?php echo base_url(); ?>mpayfiles/{{item.ImageUrl}}" /> {{item.Categoryname}} <i class="fa fa-angle-double-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 pd-md-0 pd-xs-0">
                <div class="card card-mini">
                    <div class="card-content">
                        <div class="card-body pd-xs-10">
                            <div class="widget-title" style="height: 28px;">
                                <h5 class="pull-left"><b>Basic List Group</b></h5>
                                <input type="text" placeholder="Search Here" class="opListSearch pull-right" id="txtsearchbbps" autocomplete="off" />
                            </div>
                            <div id="list">
                                <ul class="mylist1">
                                    <li data-ng-repeat="row in subcategoriesdata">
                                        <a href="#" data-ng-click="dobindvalidateparam(row)">
                                            <img src="<?php echo base_url();?>mpayfiles/{{row.Imageurl}}" />
                                            <p>{{row.Billername}}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 pd-xs-0">
                <div class="card card-mini">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-md-12 pd-xs-lr-0 bank-details" style="display:none;">

                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>OperatorName : {{OperatorName}}</label>
                                        
                                    </div>
                                </div>



                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>{{maintransnumber}}</label>
                                        <input type="text" class="form-control formtext" id="MainNumber" data-ng-model="MainNumber" required="required" placeholder="{{maintransnumber}}" maxlength="{{maintransnumbermaxlen}}" minlength="{{maintransnumberminlen}}" onkeypress="return ValidateNumber(event);" pattern="{{maintransnumberregpattern}}" autocomplete="off" />
                                        <input type="hidden" data-ng-model="Biller_Name" />
                                    </div>
                                </div>

                                

                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Mobile Number</label>
                                        <div class="editor-field">
                                            <input type="text" class="form-control fotmtxt" id="Retailer_MobileNumber" data-ng-model="Retailer_MobileNumber" required="required" placeholder="Enter Customer Mobile Number" maxlength="10" onkeypress="return ValidateNumber(event);" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-sm-12" data-ng-hide="accountnumverview">
                                    <div class="form-group">
                                        <label data-ng-bind="mainaccountlabel"></label>
                                        <div class="editor-field">
                                            <input type="text" id="MainAccount_Number" data-ng-model="MainAccount_Number" class="form-control" maxlength="20" placeholder="{{mainaccountlabel}}" required="required" onkeypress="return ValidateNumber(event);" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-sm-12" data-ng-hide="cyclenumbernumverview">
                                    <div class="form-group">
                                        <label data-ng-bind="maincyclelabel">Cycle</label>
                                        <div class="editor-field">
                                            <input type="text" id="MainCyclPay_Amounte_Number" data-ng-model="MainCycle_Number" class="form-control" maxlength="20" placeholder="{{maincyclelabel}}" required="required" onkeypress="return ValidateNumber(event);" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-sm-12" data-ng-hide="pptypenumbernumverview">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <div class="editor-field">
                                            <select class="form-control" id="PostpaidLand_Type" data-ng-model="PostpaidLand_Type">
                                                <option value="">Select</option>
                                                <option value="LLI">LLI</option>
                                                <option value="LLC">LLC</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-sm-12" data-ng-hide="payable_amount">
                                    <div class="form-group">
                                        <label>Amount</label>
                                        <div class="editor-field">
                                            <input type="text" class="form-control fotmtxt" id="Pay_Amount" data-ng-model="Pay_Amount" required="" placeholder="Enter Amount" maxlength="6" onkeypress="return ValidateNumber(event);" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Payment Mode</label>
                                        <div class="editor-field">
                                            <select id="Payment_Mode" data-ng-model="Payment_Mode" class="form-control fotmtxt">
                                                <option value="">Select</option>
                                                <option value="Cash">Cash</option>
                                                <option value="DebitCard">Debit Card</option>
                                                <option value="CreditCard">Credit Card</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-12 col-sm-12" style="display:none">
                                    <div class="form-group">
                                        <label>Net Payable Amount</label>
                                        <div class="editor-field">
                                            <input type="text" class="form-control fotmtxt" id="netpaymentamount" data-ng-model="netpaymentamount" readonly="readonly" placeholder="Enter Amount" value="{{Pay_Amount}}" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>TPIN</label>
                                        <div class="editor-field">
                                            <input type="text" class="form-control fotmtxt" id="Pay_TPIN" data-ng-model="Pay_TPIN" required="" placeholder="Enter TPIN" maxlength="4" onkeypress="return ValidateNumber(event);" autocomplete="new-password" style="text-security:disc; -webkit-text-security:disc;" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-md-12 col-sm-12  pd-xs-lr-0 bank-details" style="display:none;">
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <button class="btn btn-primary" type="submit" data-ng-hide="btnpaymentprocess" data-ng-click="dooutprocbillpay()">Pay</button>
                                    <button class="btn btn-primary" data-ng-hide="btnfeachindvalidateinfo" type="submit" data-ng-click="doforfeachingbalfor()">FETCH BILL</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-12 col-md-12 col-sm-12">
                                    <p id="M_Message" style="color: red;">{{ErrorMessage}}</p>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="note">Note : Request you to check details before proceeding. </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!--Modal Confirmation-->
            <div class="modal fade" id="Perconfirmmodal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="margin-top:50px;">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <input name="__RequestVerificationToken" type="hidden" value="VrBQ8GDRTGWp9nI8ONC_5JTbAmnjmaQl9AS9F55kZZXp9ix3Y03Lvyru_J5Zf-mgZd9ZIZPM_uDnfKZU6pqQX9gSNEXqLC6iuOZmd933MeU1" />
                        <div class="modal-header">
                            <h4 class="modal-title modalhead">
                                {{showbillername}}
                                <img id="Elec_Image" src="{{shobillerimage}}" style="height: 80px; width: 80px;float:right;margin-right:20px;" />
                            </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-10 col-md-offset-1">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td><b>Number</b></td>
                                            <td>{{shomainnumber}} <input type="hidden" value="{{refNumbers}}" /> </td>
                                        </tr>
                                        <tr>
                                            <td><b>Amount</b></td>
                                            <td>
                                                {{shopayamount}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Due Date</b></td>
                                            <td><label id="shopduedate">{{shopduedate}}</label></td>
                                        </tr>
                                        <tr>
                                            <td><b>Bill Date</b></td>
                                            <td>{{shopbilldate}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Consumer Name</b></td>
                                            <td>{{shopconsumername}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Bill Number</b></td>
                                            <td>{{shopbillnumbers}}</td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <p style="float: left;">Are you sure you want to do payment?</p>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" data-ng-click="dooutprocbillpay()">Yes</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                        </div>

                    </div>
                </div>
            </div>
            <!--Modal Confirmation End-->
            <!--Modal Receipt-->
            <div id="myReciept" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="max-width: 900px !important;">
                    <div class="modal-content" style="border: 5px solid rgb(252, 193, 1);">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <button type="button" class="btn" data-dismiss="modal" style="color:#666; padding: 6px ! important; top: -5px; right: -47px; background-color: rgb(255, 255, 255) ! important; position: absolute; border: 2px solid rgb(252, 193, 1);">&times;</button>
                            </div>
                            <div class="containers" style="height: 550px; overflow: auto; width: 100%">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" style="margin-bottom: 3px; padding: 8px;background:#337ab7 !important;">Print / Download Receipt of Transaction ID : <span id="prt_trxn_head_id"></span></div>
                                    <div class="panel-body" style="padding: 0% 4%">
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success btn-block" style="color: #FFF !important; text-shadow: none;" id="printbtn" onclick="printreciept()"><i class="fa fa-print"></i>PRINT</button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="clearfix"></div>
                                        <div id="reciept" style="margin-top: 5px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <style>
                                                        td {
                                                            padding: 5px;
                                                        }
                                                    </style>
                                                    <div id="printableArea">
                                                        <table style="width: 100%; border: 1px solid #000;">
                                                            <tr>
                                                                <th colspan="3" style="border-bottom:1px solid #337ab7 !important; font: 18px; text-align:center;  padding: 2px">
                                                                    <div class="thback">
                                                                        <img src="https://mpayonline.co.in/assets/images/Logo/logo502.png" style="width:150px;height: 37px;" />
                                                                        <br />
                                                                        <b>RECIEPT</b>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td><b>RECEIPT # :</b> R - <span id="prt_InvoiceId"></span></td>
                                                                <td></td>
                                                                <td style="text-align: right">Date : 3/16/2021</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="border-bottom: 1px solid #ccc; border-top: 1px solid #ccc;"><b>TRANSACTION DETAILS</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Service Provider</b></td>
                                                                <td><span id="prt_operatorname"></span></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b id="Sender_No">Service Number</b></td>
                                                                <td><span id="prt_operator_number"></span></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Transaction ID </b></td>
                                                                <td><span id="prt_transactionid"></span></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b id="Tran_Ref_No">Operator Reference Number </b></td>
                                                                <td><span id="prt_operatorref"></span></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Time </b></td>
                                                                <td><span id="prt_transaction_date"></span></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Amount </b></td>
                                                                <td>
                                                                    Rs.<span id="prt_trxn_amount"></span>
                                                                    <input type="hidden" id="hdamt" value="0" />
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="border-bottom: 1px solid #ccc;">
                                                                <td><b>Service Charge / Sur-charge </b></td>
                                                                <td>
                                                                    Rs.
                                                                    <input type="number" id="sercharge" value="0" onkeyup="ptrcalamt()" />
                                                                    <label id="lsercharge" style="display: none">0</label>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr style="font-size: 20px">
                                                                <td><b>Total Amount </b></td>
                                                                <td>Rs.<label id="prt_total_amount"></label></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" style="text-align: center; background: #ddd">
                                                                    <p style="font-size: 12px">This is a system generated Receipt. Hence no seal or signature required.</p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--Modal Receipt-->
        </div>
    </div>
</div>


<!--Page Scripts-->



<script src="<?php echo base_url(); ?>mpayfiles/angular.min.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/jquery.rgprocjx.service.auto1.9.6.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/ag.jquery-validate05.js"></script>

<!--Select Option Plugins-->

<script>
    //$(".Category_name").select2({
    //    placeholder: "Select Category"
    //});
    //$("#Biller_Name").select2({
    //    placeholder: "Select Operator"
    //});
    //$("#Payment_Mode").select2({
    //    placeholder: "Select Payment Mode"
    //});

    function ptrcalamt() {
        var Amount = $('#hdamt').val();
        var surcharge = $('#sercharge').val();
        if (surcharge > 0) {
            var total = parseInt(Amount) + parseInt(surcharge);
            $('#prt_total_amount').html(total);
        } else {
            $('#prt_total_amount').html(Amount);
        }
    }
</script>
<!--Select Option Plugins End-->
<!--Textbox Search-->
<script src="<?php echo base_url(); ?>mpayfiles/Search.js"></script>
<!--Textbox Search End-->

        <div class="container-fluid">
            <?php include("elements/agentfooter.php"); ?>
        </div>
    </div>
        <!--Start Bottom to top-->
        <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
        <!--End Bottom to top-->

        <div id="ModalSearchTrxn" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Transaction Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table" style="border-bottom:1px solid #ddd;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction ID</th>
                                            <th>Trans. AMT</th>
                                            <th>Charged AMT</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="srchTxnDate"></td>
                                            <td id="srchTxnOrderID"></td>
                                            <td id="srchTxnAmount"></td>
                                            <td id="srchTxnCharge"></td>
                                            <td id="srchTxnStatus"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mg-t-10 table-responsive">
                                <table class="table table-transdet" id="srchTxnDetails"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Start Page Plugins-->
        <!--Modal Processing-->
        <div class="modal" id="ProcessingBox">
            <div class="modal-dialog" style="margin-top:15%;">
                <div class="modal-content" style="background: transparent;">
                    <div class="modal-body ConfirmBox text-center" style="padding:20px !important;">
                        <h3 class="text-white">Processing your transaction...</h3>
                        <img src="<?php echo base_url(); ?>Processing.gif" style="width:70px;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="ConfirmBox" style="margin-top:30%;">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #ddd;">
                    <div class="modal-header ConfirmBoxhead">
                        <h4 class="modal-title">Message</h4>
                        <button type="button" class="close" aria-hidden="true" onclick="closepopup();">×</button>
                    </div>
                    <div class="modal-body ConfirmBox" style="padding:20px !important;">
                        <p id="message"></p>
                    </div>
                    <div class="modal-footer" id="btnsuccessBox" style="display:none;">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsuccessPrint">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->

       <script src="<?php echo base_url(); ?>mpayfiles/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/bootstrap.bundle.min.js"></script>
        <script src="https://demos.creative-tim.com/argon-dashboard-pro/assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/jquery.scrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="<?php echo base_url(); ?>mpayfiles/Chart.min.js"></script>
        <script src="<?php echo base_url(); ?>mpayfiles/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="<?php echo base_url(); ?>mpayfiles/argon.min.js"></script>
        <!-- Demo JS - remove this in your project -->
        <script src="<?php echo base_url(); ?>mpayfiles/demo.min.js"></script>
        <script>
            // ===== Scroll to Top ====
            $(window).scroll(function () {
                if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                    $('#return-to-top').fadeIn(200);    // Fade in the arrow
                } else {
                    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
                }
            });
            $('#return-to-top').click(function () {      // When arrow is clicked
                $('body,html').animate({
                    scrollTop: 0                       // Scroll to top of body
                }, 500);
            });

            function closepopup() {
                jQuery('#ConfirmBox').attr("style", "display:none;");
            };
        </script>
        <!--Start Calendar Plugins-->
        <script src="<?php echo base_url(); ?>mpayfiles/jquery-ui.js"></script>

        <script>
            $('.editable-on-click').click(function (e) {
                var input = $(this).find('input');
                if (input.length) {
                    input.trigger('click');
                    return;
                }
                var textarea = $(this).find('textarea');
                if (textarea.length) {
                    textarea.trigger('click');
                    return;
                }
            });
            $('.fileUpload').click(function (e) {
                e.stopPropagation();
            });
            jQuery(function () {
                jQuery('#txtSearchTrxn').keyup(function () {
                    var refNumber = jQuery('#txtSearchTrxn').val();
                    if (refNumber.length === 15) {
                        jQuery.post('/Reports/SubShowTransaction', { transactionRef: refNumber }, function (response) {
                            if (response != null && response != '') {
                                $('#ModalSearchTrxn').modal('show');
                                jQuery('#srchTxnDate').html(response.TxnDatetime);
                                jQuery('#srchTxnOrderID').html(response.OrderID);
                                jQuery('#srchTxnAmount').html(response.TxnAmount);
                                jQuery('#srchTxnCharge').html(response.ServiceCharge);
                                jQuery('#srchTxnStatus').html(response.TxnStatus === 'Success' ? '<span class="success" style="margin-left:0px;">Success</span>' : response.TxnStatus === 'Pending' ? '<span class="pending" style="margin-left:0px;">Pending</span>' : '<span class="failure" style="margin-left:0px;">' + response.TxnStatus + '</span>');
                                if (response.ServiceID === 9) {
                                    var htmlStr = '<tr><td>Remitter Mobile</td><td>' + response.TxnNumber + '</td></tr><tr><td>Beneficiary Name</td><td>' + response.RecipientName + '</td></tr><tr><td>Bank</td><td>' + response.BankName + '</td></tr><tr><td>Account No</td><td>' + response.AccountNo + '</td></tr><tr><td>IFSC</td><td>' + response.IfscCode + '</td></tr><tr><td>MODE</td><td>' + response.PaymentType + '</td></tr><tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                } else {
                                    var htmlStr = '<tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                }
                            } else {
                                jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                                jQuery('#message').html('Transaction not found.');
                                jQuery('#message').attr("style", "color:red;");
                            }
                        });
                    }
                });
            });
        </script>
        
</body>
</html>
