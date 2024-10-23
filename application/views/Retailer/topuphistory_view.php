
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
        
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-4 col-9">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Payment Request Report</a></li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    <div class="row match-height mg-t-20">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 col-sm-12 pd-xs-0">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pd-b-0 pd-xs-10">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?php echo base_url(); ?>Retailer/Topuphistory" method="post">
                                    <input name="__RequestVerificationToken" type="hidden" value="5kpqRuwYqOJTJUAwARPeAkYkB-gdZU7EHwTQSKx_hD2ZcnRG3bTdK_raFdPBy4pmeBBx671r8s_Lkq8lwbcZG2ktngpfjlyjORx_cKjjLXE1" />
                                    <div class="row">
                                        <div class="col-md-5 col-10 col-lg-4 col-sm-5">
                                            <div class="form-group mg-t-0">
                                                <div id="dateragne-picker21">
                                                    <div class="input-daterange input-group">
                                                        <input type="text" class="form-control" id="fromDate" name="fromDate" placeholder="From Date" autocomplete="off" required="" value="<?php echo $from; ?>" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                        <input type="text" class="form-control" id="toDate" name="toDate" placeholder="To Date" autocomplete="off" required="" value="<?php echo $to; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-2 col-lg-3 col-sm-2 pd-xs-l-0">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span> </button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-2 col-lg-3 col-sm-2 pull-xs-r pd-xs-r-0">
                                            <div class="form-group">
                                                <a href="#" title="Export Excel" class="btn btn-primary  pull-right" onclick="tableToExcel('fixTable', 'Table')"><i class="fa fa-file-excel-o excel"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-10 col-lg-2 col-sm-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="txtsearch" placeholder="Search" autocomplete="off" data-ng-model="myfilters" />
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 col-12 col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="fixTable">
                                        <thead>
                                            <tr>
                                                <th>SL.No</th>
                                                <th>Bank Details</th>
                                                <th>Type</th>
                                                <th>Mode</th>
                                                <th>Amount</th>
                                                <th>DateTime</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Req. To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=1;
                                            if($result_date != false)
                                            {
                                                foreach($result_date->result() as $rw)
                                                {?>
                                                        <tr>
                                                        <td><?php echo $rw->Id; ?></td>
                                                        <td>
                                                            <?php echo $rw->bank_name."-".$rw->account_name."-".$rw->account_number."-".$rw->ifsc; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rw->wallet_type; ?>
                                                        </td>
                                                         <td>
                                                            <?php echo $rw->payment_type; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rw->amount; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rw->add_date; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $rw->transaction_id ?>
                                                        </td>
                                                        <td>
                                                            <?php if($rw->status == "Reject")
                                                                {?>
                                                                        <span style="color:red;">Rejected</span>
                                                            <?php }?>


                                                            <?php if($rw->status == "Pending")
                                                                {?>
                                                                        <span style="color:blue;">Pending</span>
                                                            <?php }?>

                                                            <?php if($rw->status == "Approve")
                                                                {?>
                                                                        <span style="color:green;">Approve</span>
                                                            <?php }?>

                                                            
                                                            
                                                        </td>
                                                        <td>
                                                            <?php echo $rw->Request_to; ?>
                                                        </td>
                                                    </tr>

                                                <?php $i++;}
                                            }
                                         ?>
                                                
                                        </tbody>
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
<!--Page Scripts-->
<script src="<?php echo base_url(); ?>mpayfiles/tableToExcel.js"></script>
<!--Calnedar Plugin-->
<link href="<?php echo base_url(); ?>mpayfiles/jquery-ui.css" rel="stylesheet" />
<script>
    $(function () {
        jQuery("#fromDate").datepicker({ minDate: -90, maxDate: 0 });
        jQuery("#toDate").datepicker({ minDate: -90, maxDate: 0 });
    });
</script>
<!--Calnedar Plugin End-->
<!--Search Table Plugin-->
<script src="<?php echo base_url(); ?>mpayfiles/Search.js"></script>
<!--Search Table Plugin End-->

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
