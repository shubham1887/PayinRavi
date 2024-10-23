<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Test Mode credential
     define('RAZOR_KEY_ID', 'rzp_test_xFejxti0YHE8do');
   define('RAZOR_KEY_SECRET', 'aLkjVCZbzeFd8emHgnbWcAad');


    $login_user_id = $this->session->userdata("SdId");
?>
<?php

$productinfo = "Wallet Top up";
$txnid = time().'RozarPaYweB';
$surl = $surl;
$furl = $furl;
$key_id = RAZOR_KEY_ID;
$currency_code = "INR";

$merchant_order_id = 'WeB'.substr(hash('sha256',mt_rand().microtime()),0,5).'Rozerpay'; //time();

$name = 'PayINN';
?>
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


     <?php include("elements/sdsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
         <?php include("elements/sdsidebar.php"); ?>
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
                                    

                <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
                      <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                      <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>"/>
                      <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
                      <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $productinfo; ?>"/>
                      <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $surl; ?>"/>
                      <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $furl; ?>"/>
                      <!-- <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $card_holder_name; ?>"/> -->
                      <!-- <input type="text" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/> -->

                      <!-- <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
                      <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/> -->
                                    <table class="table table-bordered" width="100%">
                                      <tr>
                                                <td>
                                                    <label style="font-size:18px;margin-top:8px;">Amount</label>
                                                </td>
                                                <td>
                                                     <input class="form-control" type="number"  name="merchant_total" id="merchant_total" placeholder="Amount to Pay"

                                                       onKeyPress="return isNumberKey(event)" onchange="chkVal(this.value);" required/>

                                                </td>
                                            </tr>
                                      </table>

                </form>
                <center>
                    <input  id="submitpay" type="submit" onclick="razorpaySubmit(this);" value="Pay Now" class="btn btn-success" />
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
                            <div id="list">
                               
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
                            </div>
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



<!--Page Scripts-->
<style type="text/css">
    .paytm-charges h3 {
        font-size: 15px;
        font-weight: 700;
        color: #d16666;
    }
    .paytm-charges > .row {
        border-bottom: 1px dashed #ddd;
        padding: 10px 0;
    }
    .paytm-charges .chrg-row {
        padding: 10px 0;
    }
    .paytm-charges .chrg-row h5 {
        font-size: 14px;
        font-weight: 700;
        margin: 0;
    }
    .paytm-charges .chrg-row p {
        font-size: 15px;
        font-weight: 400;
        margin: 0;
    }
</style>
        </div>
    </div>
<?php include("files/adminfooter.php"); ?>
<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    }else{
         return true;
    }
}


</script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
 // var total = $('#merchant_total').val();
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    // amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "Order # <?php echo $merchant_order_id; ?>",
    netbanking: false,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
    },
    method : {
      card:<?php if($login_user_id=='4' || $login_user_id=='34627' || $login_user_id=='159507' || $login_user_id=='159508' || $login_user_id=='159509'){ echo 'true'; }else{ echo 'false'; }?>,
      netbanking:<?php if($login_user_id=='4'){ echo 'true'; }else{ echo 'false'; }?>,
      wallet:true,
      upi:true,
      upi_intent:true,
      qr:true,
      emi:false
    },
    handler: function (transaction) {
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){

            location.reload()
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;
  function razorpaySubmit(el){
    if(chkVal($('#merchant_total').val())==false){return false;}

  //    if($('#merchant_total').val()=='')
  //    {
  //        alert('Fil value between 100 to 50000');
  //        $('#merchant_total').val('');
        // location.reload();
        // return false;
  //    }
    razorpay_options.amount = parseInt($('#merchant_total').val())*100;
    if(parseInt($('#merchant_total').val()) > 2500000)
    {
        // razorpay_options.method.card = false;
        razorpay_options.method.emi = false;
    }
    if(parseInt($('#merchant_total').val()) > 2500000){
        razorpay_options.method.card = false;
    }
    if(parseInt($('#merchant_total').val()) > 2500000)
    {
        razorpay_options.method.wallet = false;
        razorpay_options.method.upi = false;
        razorpay_options.method.upi_intent = false;
        razorpay_options.method.qr = false;
    }

    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }

function chkVal(val)
{
    <?php 
    $min_limit = 0;
    if($login_user_id==4)
    {
        $min_limit = 1;
    }
    else
    {
        $min_limit = 99;
    }
    ?>
    if(val><?php echo $min_limit;?> && val<2500001){
        return true;

    }else{
        alert('Add value between 100 to 2500000');
        $('#TXN_AMOUNT').val('');
        return false;
    }

}
</script>



        

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
