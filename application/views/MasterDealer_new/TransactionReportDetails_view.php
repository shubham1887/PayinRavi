
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
                <div class="col-lg-4 col-12">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Transaction Report Details</a></li>
                        </ol>
                    </nav>
                </div>                
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6 pd-0">
   
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
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
                                            <td><?php echo $dmr_result->row(0)->add_date; ?></td>
                                            <td><?php echo $dmr_result->row(0)->Ud; ?></td>
                                            <td><?php echo $dmr_result->row(0)->Amount; ?></td>
                                            <td><?php echo $dmr_result->row(0)->ccf; ?></td>

                                            <td style="white-space: nowrap;">
                                            <?php if($dmr_result->row(0)->Status == "SUCCESS") {?>
                                            <span class="success" style="margin-left:0px;"><span class="barSuccess"></span>Success</span>
                                            <?php } ?>
                                            <?php if($dmr_result->row(0)->Status == "FAILURE") {?>
                                            <span class="danger" style="margin-left:0px;"><span class="barFailure"></span>Failure</span>
                                            <?php } ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mg-t-10 table-responsive">
                                <table class="table table-transdet">
                                    <tr>
                                        <td>Remitter Mobile</td>
                                        <td><?php echo $dmr_result->row(0)->RemiterMobile;?></td>
                                    </tr>
                                        <tr>
                                            <td>Beneficiary Name</td>
                                            <td><?php echo $dmr_result->row(0)->RESP_name;?></td>
                                        </tr>
                                        <tr>
                                            <td>Bank</td>
                                            <td><?php echo "";?></td>
                                        </tr>
                                        <tr>
                                            <td>Account No</td>
                                            <td><?php echo $dmr_result->row(0)->AccountNumber;?></td>
                                        </tr>
                                        <tr>
                                            <td>IFSC</td>
                                            <td><?php echo $dmr_result->row(0)->IFSC;?></td>
                                        </tr>
                                    <tr>
                                        <td>MODE</td>
                                        <td><?php echo $dmr_result->row(0)->mode;?></td>
                                    </tr>
                                    <tr>
                                        <td>RRN</td>
                                        <td><?php echo $dmr_result->row(0)->RESP_opr_id;?></td>
                                    </tr>
                                    <tr>
                                        <td>Opening Balance</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Charged Amount</td>
                                        <td><?php echo $dmr_result->row(0)->ccf;?></td>
                                    </tr>
                                    <tr>
                                        <td>Margin</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Discount on Commission</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>TDS</td>
                                        <td><?php echo $dmr_result->row(0)->tds;?></td>
                                    </tr>
                                    <tr>
                                        <td>Customer Convenience Fee (CCF)</td>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <td>Response Message</td>
                                        <td>Transfer Successful</td>
                                    </tr>
                                        <tr>
                                            <td>Receipt</td>
                                            <td>
                                                <a href="/Recharge/ViewReceipt/PAYB2B100565188" class="download">View Receipt</a>
                                                
                                            </td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       
</div>
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
                        <img src="/Content/Images/Loader/Processing.gif" style="width:70px;" />
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
        <script src="/Content/Js/main/jquery-ui.js"></script>

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
