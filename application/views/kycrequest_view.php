
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


  
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        
        <!-- Header -->
        
<style>
    .card {
        min-height: initial;
    }

    .card-header {
        padding: 5px;
    }

    .accordion .card-header:after {
        display: none;
    }

    p {
        font-size: 14px;
        color: #333;
        margin-bottom: 0px;
    }

    ul {
        padding-left: 20px;
    }

        ul li {
            font-size: 14px;
            color: #777;
            padding: 3px;
        }
</style>

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-4 col-9">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">UPLOAD KYC</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row match-height mg-t-20">
        <div class="col-xl-12 col-lg-12 pd-xs-0">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pd-xs-10">
                        <div class="auto-container">
                            <div class="row match-height mg-t-20">
                                <div class="col-xl-12 col-lg-12 pd-xs-0">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="card-body">
    <?php
    
    if($message != ''){echo "<div class='alert alert-success'>".$message."</div>"; }
    if($this->session->flashdata('message'))
    {
    echo "<div class='message alert alert-warning'>".$this->session->flashdata('message')."</div>";}
    ?>
    <div>
<form action="<?php echo base_url().'kycrequest'; ?>" method="post" name="frmkycupload" id="frmkycupload" enctype="multipart/form-data">
        
    <table class="table table-hover table-bordered">
    
<!----- pancard row ----------------------->    
    <tr>
        <td align="right"><label for="txtReqamt"><span style="color:#F06">*</span>Pan Number</label></td>
        <td align="left">
            <input type="text" id="txtPanNo" name="txtPanNo" class="form-control" style="width:200px" maxlenth="10" value="<?php if(isset($docdata["PANCARD"])){echo $docdata["PANCARD"]->document_number;} ?>">
        </td>
        <?php 
        $pan = "no";
        if(isset($docdata["PANCARD"])){
            $pan = "yes";
            ?>
        <td align="center" colspan=2>
            <a  href="javascript:void(0)">View Pancard</a>    
        </td>
        <?php }
        else
        {?>
        <td align="right"><label for="txtPaymentdate"><span style="color:#F06">*</span>Upload Pancard</label></td>
<td align="left"><input type="file" name="image" id="image" class="form-control"  style="width:200px;"/>
        <?php } ?>
        
    </td>
  </tr>
 <!----- END  pancard row ----------------------->    
 

  
  
  
<!----- aadhar row ----------------------->    
  <tr>
    <td align="right" rowspan="2"><label for="txtPaymentdate"><span style="color:#F06"></span>Aadhar Number</label></td>
    <td align="left" rowspan="2"><input type="text" name="txtAadhar" placeholder="Enter Aadhar Number" id="txtAadhar" class="form-control"  style="width:200px;" value="<?php if(isset($docdata["AADHAR_FRONT"])){echo $docdata["AADHAR_FRONT"]->document_number;} ?>"/></td>
    
    
    
        <?php 
        $aadhar_front = "no";
        if(isset($docdata["AADHAR_FRONT"]))
        {
            $aadhar_front = "yes";
            ?>
        <td align="center" colspan=2>
            <a  href="javascript:void(0)">View Aadhar Front</a>    
        </td>
        <?php }
        else
        {?>
        <td align="right" ><label for="txtRemarks">Upload Aadhar Front</label></td>
        <td align="left"><input id="image_front" name="image_front" type="file" style="width:200px;"></td>
        <?php } ?>
    
  </tr>
  <tr>
        <?php 
        $aadhar_back = "no";
        if(isset($docdata["AADHAR_BACK"]))
        {
            $aadhar_back = "yes";
            ?>
        <td align="center"  colspan=2>
            <a href="javascript:void(0)">View Aadhar BACK</a>    
        </td>
        <?php }
        else
        {?>
            <td align="right"><label for="file_uploadreceipt">Upload Aadhar Back</label>    </td>
            <td><input type="file" id="image_back" name="image_back"></td>
        <?php } ?>
  </tr>
<!----- END  Aadhar row ----------------------->   





<!----- application form row ----------------------->   
  
 
  
   <tr>
       
       
        <?php 
        $canChq = "no";
        if(isset($docdata["CANCHEQUE"]))
        {
            $canChq = "yes";
            ?>
        <td  align="center" colspan=2>
            <a href="javascript:void(0)">View Cancel Cheque</a>    
        </td>
        <?php }
        else
        {?>
            <td align="right"><label for="txtPaymentdate"><span style="color:#F06"></span>Cancel Cheque</label></td>
            <td align="left"><input type="file" name="cancheq" id="cancheq" class="form-control"  style="width:200px;"/></td>
        <?php } ?>
       
        
  
        <td align="right"><label for="txtPaymentdate"><span style="color:#F06"></span></label></td>
        <td align="left"></td>
  </tr>
  
  
  <?php

  if($pan == "yes" and $aadhar_front == "yes"  and $aadhar_back == "yes" and $canChq == "yes")
{?>

<tr>
    <td align="center" colspan="4">
        <span class="btn btn-primary">Your Kyc Approval Is Pending</span>
    </td>

<?php }
else
{?>


    <tr>
    <td align="center" colspan="4">
        <input type="botton" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary"  onclick="validateform()"/>
    </td>
    
  </tr>

<?php }
 ?>
  
</table>
</form>
<script language="javascript">
function validateform()
{
    if(is_validate_aadhar() & is_validate_pannumber())
    {
        document.getElementById("frmkycupload").submit();
    }
    
}
function is_validate_pannumber()
{
    var txtPanNo = $('#txtPanNo');
    if(txtPanNo.val().length == 10)
    {
        txtPanNo.removeClass("error");
        return true;
    }
    else
    {
        alert("false");
        txtPanNo.addClass("error");
        return false;
    }
}
function is_validate_aadhar()
{
    var txtAadhar = $('#txtAadhar');
    if(txtAadhar.val().length == 12)
    {
        txtAadhar.removeClass("error");
        return true;
    }
    else
    {
        txtAadhar.addClass("error");
        return false;
    }
}
</script>
 <style>
 .error
 {
    background:#FFBBBB;
 }
 </style> 
           
            </div>
                                            </div>


                                        </div>
                                    </div>


                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
            </div>

        </div>
    </div>
</div>



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
