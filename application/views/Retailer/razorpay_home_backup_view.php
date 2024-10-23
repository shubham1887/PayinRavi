<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$login_user_id = $this->session->userdata("AgentId");
?>
<?php

$productinfo = "Wallet Top up";
$txnid = time().'RozarPaYweB';
$surl = $surl;
$furl = $furl;
$key_id = $RAZOR_KEY_ID;
$currency_code = "INR";

$merchant_order_id = 'WeB'.substr(hash('sha256',mt_rand().microtime()),0,5).'Rozerpay'; //time();

$name = 'SAMSSTRATEGY';
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Retailer | ADD FUND</title>
 
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>

        

$(document).ready(function(){

 $(function() {

            

});

    </script>
<style>
.error
{
    background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
</style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/agentsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/agentheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Retailer/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">ADD FUND</a>
          <span class="breadcrumb-item active">ADD FUND TO PAYINN WALLET</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ADD FUND TO PAYINN WALLET</h4>
        </div>
      </div>
      <!-- d-flex -->

      <div class="br-pagebody">
        <div class="">
          <div class="">
            <?php include("elements/messagebox.php"); ?>
            <div class="">
              
              <div>
                  <div >
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
                                    <table class="">
                                      <tr>
                                                
                                                <td>
                                                  <h5>Amount</h5>
                                                     <input class="form-control" type="number"  name="merchant_total" id="merchant_total" placeholder="Amount to Pay"
                                                     style="width: 300px;" 

                                                       onKeyPress="return isNumberKey(event)" onchange="chkVal(this.value);" required/>

                                                </td>
                                                <td>
                                                  <h5>&nbsp;</h5>
                                                  <input  id="submitpay" type="button" onclick="razorpaySubmit(this);" value="Pay Now" class="btn btn-success" /></td>
                                            </tr>
                                      </table>

                </form>
                <center>
                    
                    <!-- <button type="submit" id="submitpay" class="btn btn-success" onclick="razorpaySubmit(this);">Pay Now</button> -->
                </center>
                            </div>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">CHARGES</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <div id="list">
                               
                                <div>
                                    <div class="paytm-charges">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h3>Debit Card</h3>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="chrg-row">
                                                    <h5>2%</h5>
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
                                                    <h5>2%</h5>
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
                                                    <h5>2%</h5>
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
                                                    <h5>2% </h5>
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
                                                    <h5>2%</h5>
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
                                                    <h5>2% </h5>
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
                                                    <h5>2%</h5>
                                                </div>
                                            </div>
                                            <span style="margin-left: 25px;">Note: Transactions are allowed below Rs. 500000/- only.</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
    
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->





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
      card:true,
      netbanking:true,
      wallet:true,
      upi:true,
      upi_intent:true,
      qr:true,
      emi:true
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
    alert('<?php echo $key_id; ?>');
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



    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>
