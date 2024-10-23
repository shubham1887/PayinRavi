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


    <?php
        if(isset($MESSAGEBOXTYPE))
        {
        if($MESSAGEBOXTYPE == "success" or $MESSAGEBOXTYPE == "error"  or $MESSAGEBOXTYPE == "info")
        {?>
            <script>swal("", "<?php echo $MESSAGEBOX; ?>", "<?php echo $MESSAGEBOXTYPE; ?>")</script>
        <?php }

        } ?>


    <?php
        if($this->session->flashdata("MESSAGEBOXTYPE") == "success" or $this->session->flashdata("MESSAGEBOXTYPE") == "error")
        {?>
       
            <script>swal("", "<?php echo $this->session->flashdata("MESSAGEBOX"); ?>", "<?php echo $this->session->flashdata("MESSAGEBOXTYPE"); ?>")</script>
       <?php  } ?>  
    



                     <?php include("elements/mdsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
       <?php include("elements/mdheader.php"); ?>
        <!-- Header -->
        

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-4 col-9">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="/Default"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Payment Request</a></li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12 mg-t-20 pd-xs-0">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Topup Request To User</label>
                                    <div class="editor-field">
                                        <select class="form-control" id="RequesttoUser" name="RequesttoUser" required="">
                                            <option value="">Select</option>
                                            <option value="<?php echo $this->session->userdata("DistParentId"); ?>">Parent</option>
                                            <option value="1">Administrator</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs nav-tabspayreq headerTopUp">
                            </ul>
                            <div class="tab-content tab-content1 bodyTopUp">

                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>

                        <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>
                                            Submit Deposit Detail
                                        </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo base_url(); ?>MasterDealer_new/TopUpRequest" method="post" enctype="multipart/form-data" autocomplete="off">
                                            <input name="__RequestVerificationToken" type="hidden" value="r5dsfK1n9l0LEOZcrFgyldt9T1TgUNriaoSNchNFiD3Xi8wpTqWqiupWwg931i7FYdCTt787_-FDsNSDTNnO0QEcM7eOb5iRfLt-UWs8bVo1" />
                                            <div class="row">


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>WalletType:</label>
                                                        <select class="form-control" id="WalletType" name="WalletType" required="">
                                                            <option value="Wallet1">Recharge Wallet</option>
                                                            <option value="Wallet2">Dmt Wallet</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Payment Mode:</label>
                                                        <select class="form-control" id="PaymentMode" name="PaymentMode" required="">
                                                            <option value="">Select</option>
                                                            <option>Cash</option>
                                                            <option>Draft</option>
                                                            <option>Cheque</option>
                                                            <option>RTGS</option>
                                                            <option>NEFT</option>
                                                            <option>Fund Transfer</option>
                                                            <option>IMPS</option>
                                                            <option>Credit</option>
                                                        </select>
                                                        <span class="field-validation-valid error" data-valmsg-for="PaymentMode" data-valmsg-replace="true"></span>
                                                        <input data-val="true" data-val-required="Bank Name is required." id="BankName" name="BankName" type="hidden" value="" />
                                                        <input data-val="true" data-val-number="The field RequestUserID must be a number." data-val-required="The RequestUserID field is required." id="RequestUserID" name="RequestUserID" type="hidden" value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" id="ddlcashmode" style="display:none;">
                                                        <label>Cash Types:</label>
                                                        <select class="form-control" id="CashType" name="CashType">
                                                            <option value="">Select</option>
                                                            <option>CDM Machine</option>
                                                            <option>Branch Deposit</option>
                                                        </select>
                                                        <span class="field-validation-valid error" data-valmsg-for="CashType" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12"></div>
                                                <div class="col-md-4" style="display:none;" id="txtAmount">
                                                    <div class="form-group">
                                                        <label>Amount:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Amount should be digit and max 6 digit." data-val-regex-pattern="[0-9]{1,6}" data-val-required="Amount is required." id="PaymentAmount" name="PaymentAmount" placeholder="Enter Amount" required="" type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="PaymentAmount" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="ddlBankName">
                                                    <div class="form-group">
                                                        <label>User Bank Name:</label>
                                                        <select class="form-control select-opt" data-val="true" data-val-required="User Bank Name is required." id="UserBankName" name="UserBankName">
                                                            <option value="">Select</option>
<option value="Abhinav coop bank ltd">Abhinav coop bank ltd</option>

<option value="Yes Bank">Yes Bank</option>
<option value="Zila Sahkari Bank">Zila Sahkari Bank</option>
</select>
                                                        <span class="field-validation-valid error" data-valmsg-for="UserBankName" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtBranch">
                                                    <div class="form-group">
                                                        <label>Branch:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect branch name." data-val-regex-pattern="[a-zA-Z ]{3,30}$" data-val-required="Branch Name is required." id="BranchName" name="BranchName" placeholder="Enter Branch"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="BranchName" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtChequeNo">
                                                    <div class="form-group">
                                                        <label>Cheque No:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect cheque number." data-val-regex-pattern="[0-9]{5,15}" data-val-required="Cheque No is required." id="ChequeNo" name="ChequeNo" placeholder="Enter Cheque No"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="ChequeNo" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtBranchCode">
                                                    <div class="form-group">
                                                        <label>Branch Code:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect branch code." data-val-regex-pattern="[0-9a-zA-Z]{3,30}$" data-val-required="Branch Code is required." id="BranchCode" name="BranchCode" placeholder="Enter Branch Code"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="BranchCode" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="trxsno" style="display:none;">
                                                    <div class="form-group">
                                                        <label>Transaction No:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect transaction number." data-val-regex-pattern="[0-9a-zA-Z]{3,30}$" data-val-required="Transaction No is required." id="TransactionNo" name="TransactionNo" placeholder="Enter Transaction No"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="TransactionNo" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtLocation">
                                                    <div class="form-group">
                                                        <label>Location:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect Location." data-val-regex-pattern="[a-zA-Z ]{3,30}$" data-val-required="Location is required." id="Location" name="Location" placeholder="Enter Location"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="Location" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4" style="display:none" id="txtDate">
                                                    <div class="form-group">
                                                        <label>Date:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-required="Date is required." id="PaymentDate" name="PaymentDate" placeholder="MM/DD/YYYY" required="" type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="PaymentDate" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtTime">
                                                    <div class="form-group">
                                                        <label>Time:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-required="Time is required." id="PaymentTime" name="PaymentTime" placeholder="Enter Time" required="" type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="PaymentTime" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none;" id="txtUTR">
                                                    <div class="form-group">
                                                        <label>UTR No:</label>
                                                        <input autocomplete="off" class="form-control" data-val="true" data-val-regex="Incorrect UTR number." data-val-regex-pattern="[0-9a-zA-Z]{3,30}$" data-val-required="UTR No is required." id="UTRNumber" name="UTRNumber" placeholder="Enter UTR No"  type="text" value="" />
                                                        <span class="field-validation-valid error" data-valmsg-for="UTRNumber" data-valmsg-replace="true"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="display:none" id="txtUpload">
                                                    <div class="form-group">
                                                        <label>Upload Slip:</label>
                                                        <input type="file" style="width: 214px;" id="TransactionSlip" name="TransactionSlip" />
                                                    </div>
                                                </div>




                                                <div class="col-md-12" style="display:none" id="btnsubmit">
                                                    <div class="form-group">
                                                        <button  type="submit" class="btn btn-primary"  >Submit</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
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

<!--Page Scripts-->
<script type="text/javascript">
    function doprocessdata(item, name) 
    { 
        jQuery('#BankName').val(item); 
        jQuery('#RequestUserID').val(name); }
    $(function () {
        $("#PaymentDate").datepicker();
    });
    $(function () {
        $('#PaymentMode').change(function () {
            var paymode = $('#PaymentMode option:selected').val();
            $('#ddlcashmode, #txtBranchCode, #txtLocation, #txtTime, #txtUTR, #trxsno,#txtBranch, #txtChequeNo, #txtAmount, #txtDate, #txtUpload, #ddlBankName, #btnsubmit').css("display", "none");
            if (paymode == "Cash") {
                $('#ddlcashmode').css("display", "block");
            }
            else if (paymode == "Cheque") {
                $('#txtBranch, #txtChequeNo, #txtAmount, #txtDate, #txtUpload, #ddlBankName, #btnsubmit').css("display", "block");
                $('#ddlcashmode, #txtBranchCode, #txtLocation, #txtTime, #txtUTR, #trxsno').css("display", "none");
            }
            else if (paymode == "RTGS" || paymode == "NEFT" || paymode == "Fund Transfer" || paymode == "IMPS") {
                $('#txtTime, #txtUTR, #txtAmount, #txtDate, #txtUpload, #ddlBankName, #btnsubmit').css("display", "block");
                $('#trxsno, #ddlcashmode, #txtBranchCode, #txtLocation, #txtChequeNo, #txtBranch').css("display", "none");
            }else if (paymode == "Credit") {
                $('#txtTime, #txtAmount, #txtDate, #txtUpload, #btnsubmit').css("display", "block");
                $('#trxsno, #ddlcashmode, #txtBranchCode, #txtLocation, #txtChequeNo, #txtBranch, #ddlBankName,#txtUTR').css("display", "none");
            }
        });
        $('#ddlcashmode').change(function () {
            var paymode = $('#ddlcashmode option:selected').val();
            if (paymode == "CDM Machine") {
                $('#trxsno, #txtTime, #txtAmount, #txtDate, #txtUpload, #btnsubmit').css("display", "block");
                $('#txtUTR, #txtChequeNo,#txtBranch, #txtBranchCode, #txtLocation,#ddlBankName').css("display", "none");
            }
            else if (paymode == "Branch Deposit") {
                $('#txtTime, #txtAmount, #txtDate, #txtUpload, #btnsubmit').css("display", "block");
                $('#trxsno, #txtUTR, #txtChequeNo,#txtBranch, #txtBranchCode, #txtLocation, #ddlBankName').css("display", "none");
            }
            //else {
            //    $('#ddnumber').attr("disabled", true);
            //    $('#dddate').attr("disabled", true);
            //}
        });

        jQuery('#RequesttoUser').change(function () 
        {

            var userName = jQuery('#RequesttoUser').val();
            if (userName !== '') {
                jQuery.post('<?php echo base_url(); ?>/MasterDealer_new/TopUpRequest/TopUpRequestBanks', { requestUser: userName }, function (response) {
                    if (response !== '') {
                        var cnt = 1; var headerHtml = '',bodyHtml = '', activeClass = 'active';
                        jQuery.each(response, function () {
                            headerHtml += '<li class="nav-item"><a aria-expanded="true" href="#tab_' + cnt + '" data-toggle="tab" class="nav-link ' + activeClass + '">' + this.BankName + '</a></li>';
                            bodyHtml += '<div class="tab-pane ' + activeClass + ' table-responsive" id="tab_' + cnt + '"> <table class="table table1"> <tbody> <tr> <th></th> <th><b>Account Holder Name</b></th> <th><b>Account</b></th> <th><b>IFSC</b></th> <th><b>Address</b></th> <th><b>Deposit Details</b></th> </tr> <tr> <td> <img src="' + this.ImageUrl + '"> </td> <td>' + this.HolderName + '</td> <td>' + this.AccountNo + '</td> <td>' + this.IFSCCode + '</td> <td>' + this.BranchName + '</td> <td> <a href="#" data-toggle="modal" data-target="#myModal" onclick="doprocessdata(' + this.ReferenceCode + ','+userName+')">Update</a> </td> </tr> </tbody> </table> </div>';
                            activeClass = ''; cnt++;
                        });

                        jQuery('.headerTopUp').html(headerHtml);
                        jQuery('.bodyTopUp').html(bodyHtml);
                    } else {
                        jQuery('.headerTopUp').html('<h6>BANK NOT FOUND</h6>');
                    }
                });
            }
        });
    })
</script>

<!--Select Option Plugin-->
<link href="<?php echo base_url(); ?>mpayfiles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>mpayfiles/select2.min.js"></script>
<script>
    $(".select-opt").select2({
        placeholder: "Select"
    });
</script>
<!--Select Option Plugin End-->
<!--Calnedar Plugin-->
<link href="<?php echo base_url(); ?>mpayfiles/jquery-ui.css" rel="stylesheet" />
<!--Calnedar Plugin End-->
<script src="/bundles/jquery?v=wBUqTIMTmGl9Hj0haQMeRbd8CoM3UaGnAwp4uDEKfnM1"></script>

<script src="/bundles/jqueryval?v=WDt8lf51bnC546FJKW5By7_3bCi9X11Mr6ray08RhNs1"></script>



        <div class="container-fluid"><?php include("elements/footer.php"); ?>
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
                        <img src="<?php echo base_url(); ?>mpayfiles/Processing.gif" style="width:70px;" />
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

        <script src="<?php echo base_url(); ?>assets2/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="<?php echo base_url(); ?>assets2/js/argon.min5438.js?v=1.2.0"></script>
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
