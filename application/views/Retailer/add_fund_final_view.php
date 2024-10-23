
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | Index</title>
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
      <script type="text/javascript">
      
      $(document).ready(function(){setTimeout(function(){$('div.alert').fadeOut(1000);}, 15000); });
      
      
      
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) 
        {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        }
    </script>
</head>
<body>
    
    <!--sweet alert start-->

   
              <?php
    if($this->session->flashdata('message')){
    echo "<div class='message'>".$this->session->flashdata('message')."</div>";}    
    if($message != ''){
    echo "<div class='message'>".$message."</div>";}
    ?>
            
     <?php include("elements/agentsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
         <?php include("elements/agentheader.php"); ?>
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
                            <li class="breadcrumb-item"><a href="#">ADD FUND</a></li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6" data-ng-app="rgapp">
    <div data-ng-controller="MAINRGBS">
        <div class="row mg-t-20">
           
            <div class="col-md-4 pd-xs-0">
                <div class="card card-mini">
                    <div class="card-content">
                        <div class="card-body  pd-xs-10">
                            <div class="widget-title">
                                <h5><b>ADD FUND TO PAYINN WALLET</b></h5>
                            </div>
                            <div id="bbps">
                                 <span style="color:red;font-weight:bold;">You can enter amount above 100</span> <br><br>
                                    

                <form action="<?php echo base_url()."Retailer/add_fund_final"; ?>" method="post" name="frmpay" id="frmpay" >
    <table class="table">
    <tr>
        <td>Enter Amount : </td>
        <td><input type="text" id="txtAmount" name="txtAmount" placeholder="Enter Amount" value="<?php echo $this->input->post("hidAmount") ?>" class="form-control" style="width:320px"></td>
    </tr>
    <tr>
        <td>Remark</td><td><input type="text" id="txtRemark" name="txtRemark" value="<?php echo $this->input->post("hidRemark") ?>" placeholder="Enter Remark" class="form-control" style="width:320px"></td>
    </tr>
    <tr>
        <td></td>
        <td>
    </tr>
    
    </table>
    </form>
     <script language="javascript">
    function submitvalidateform()
    {
        document.getElementById("frmpay").submit();
    }
    
    </script>
                <center>
                    <input  id="btnSubmit" name="btnSubmit" type="button" onclick="submitvalidateform()" value="Pay Now" class="btn btn-success" />
                    <!-- <button type="submit" id="submitpay" class="btn btn-success" onclick="razorpaySubmit(this);">Pay Now</button> -->
                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 pd-md-0 pd-xs-0">
                <div class="card card-mini">
                    <div class="card-content">
                        <div class="card-body pd-xs-10">
                            <div class="widget-title" style="height: 28px;">
                                <h5 class="pull-left"><b>Charges</b></h5>
                                
                            </div>
                            <!--<div id="list">
                               
                                <div class="card-body">
                                    <div class="paytm-charges">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Debit Card</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>1% + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 5000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Rupay Debit Card</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>Rs 10 + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 5000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Credit Card</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>2% + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 5000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Wallet</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>2% + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 50000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>UPI</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>Rs 15 + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 50000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>ICICI/HDFC = Net Banking</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>1.90%  + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 500000/- only.</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Net Banking</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>Rs 15 + GST</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 500000/- only.</span>
                                        </div>

                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>

            

            <!--Modal Confirmation-->
            
            <!--Modal Confirmation End-->
            <!--Modal Receipt-->
        
            <!--Modal Receipt-->
        </div>
    </div>
</div>


<!--Page Scripts-->



<script src="<?php echo base_url(); ?>mpayfiles/angular.min.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/jquery.rgprocjx.service.auto1.9.6.js"></script>
<script src="<?php echo base_url(); ?>mpayfiles/ag.jquery-validate05.js"></script>

<!--Select Option Plugins-->

   <!--Modal End-->
    <script src="<?php echo base_url(); ?>assets2/js/Jquery_MPlan.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="<?php echo base_url(); ?>assets2/js/argon.min5438.js"></script>
    <script src="<?php echo base_url(); ?>assets2/js/select2.js"></script>
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
