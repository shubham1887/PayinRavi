<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>PAYMENT REQUEST</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
  <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
</style>
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
	</script>
    <!--    ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all-->
    <style>
	.error
	{
  		background-color: #ffdddd;
	}
	</style>
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
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}
#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
</head>
<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>-->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include("files/distributorheader.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/distributorsidebar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">PAYMENT REQUEST</h4>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                    <table>
                    <tr id="trmob" style="display:none">
    	<td align="center" colspan="2" >
            <img src="<?php echo base_url()."ajax-loader_bert.gif"; ?>"/>
        </td>
        
    </tr><tr id="trmobmsg" style="display:none">
    	<td align="center" colspan="2">
        	<span id="mobmsg" class="mobmsg"></span>
        </td>
        
    </tr></table>
            <div id="divaltmsg" class="alert alert-success alert-dismissable" style="display:none">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>	<i class="icon fa fa-check"></i> Success!</h4>
                   <span id="spanmsg"></span>
                  </div>
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if($this->session->flashdata('message')){
	echo "<div class='message'>".$this->session->flashdata('message')."</div>";}
	?>
    <div>
<form action="<?php echo base_url().'Distributor/payment_request'; ?>" method="post" name="frmPayment" id="frmPayment">
        
    <table class="table table-hover table-bordered" style="width:700px">
    <tr>
    <td align="right"><label for="txtReqamt"><span style="color:#F06">*</span>Select Bank:</label></td>
    <td align="left">
    <select id="ddlpaymenttype" name="ddlpaymenttype" class="form-control-sm" style="width:200px;">	
    <option value="">Select</option>
     <option value="CASH_OFFICE">CASH OFFICE</option>
    <optgroup label="PNB">
    <option value="PNB_CASH">PNB CASH</option>
    <option value="PNB_NEFT">PNB NEFT / RTGS</option>
    <option value="PNB_IMPS">PNB IMPS</option>
    <option value="PNB_TO_PNB">PNB To PNB</option>
     <option value="PNB_CHAQUE">BY CHAQUE</option>
    </optgroup>
    <optgroup label="PSB">
    <option value="PSB_CASH">PSB CASH</option>
    <option value="PSB_NEFT">PSB NEFT / RTGS</option>
    <option value="PSB_IMPS">PSB IMPS</option>
    <option value="PSB_TO_PSB">PSB To PNB</option>
     <option value="PSB_CHAQUE">BY CHAQUE</option>
    </optgroup>
    <optgroup label="CANARA BANK">
    <option value="CANARA BANK_CASH">CANARA BANK CASH</option>
    <option value="CANARA BANK_NEFT">CANARA BANK NEFT / RTGS</option>
    <option value="CANARA BANK_IMPS">CANARA BANK IMPS</option>
    <option value="CANARA BANK_TO_CANARA BANK">CANARA BANK To PNB</option>
     <option value="CANARA BANK_CHAQUE">BY CHAQUE</option>
    </optgroup>
    <optgroup label="SBI">
    <option value="SBI_CASH">SBI CASH</option>
    <option value="SBI_NEFT">SBI NEFT / RTGS</option>
    <option value="SBI_IMPS">SBI IMPS</option>
    <option value="SBI_TO_SBI">SBI To SBI</option>
     <option value="SBI_CHAQUE">BY CHAQUE</option>
    </optgroup>
   
    </select>
   
   
    </td>
  
    <td align="right"><label for="txtPaymentdate"><span style="color:#F06">*</span>Amount :</label></td>
    <td align="left"><input type="text" name="txtAmount" placeholder="Enter Amount" id="txtAmount" class="form-control-sm"  style="width:200px;" onKeyPress="return isNumeric(event);"/>
    </td>
  </tr>
  <tr>
    <td align="right"><label for="txtPaymentdate"><span style="color:#F06">*</span>Ref. Id  / Branch :</label></td>
    <td align="left"><input type="text" name="txtTid" placeholder="Enter Transaction Id" id="txtTid" class="form-control-sm"  style="width:200px;"/>
    </td>
 
   <td align="right"><label for="txtRemarks">Remarks :</label></td>
   <td align="left"><textarea id="txtRemarks" name="txtRemarks" placeholder="Enter Remarks." cols="21" rows="2" class="form-control-sm" style="width:200px;"></textarea><br />
   </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="botton" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary btn-sm"  onclick="validateform()"/></td>
  </tr>
</table>
</form>
<script language="javascript">
function validateform()
{
	var ddlpaymenttype = $('#ddlpaymenttype');
	var txtAmount = $('#txtAmount');
	var txtTid = $('#txtTid');
	var txtRemarks = $('#txtRemarks');
	var form = $('#frmPayment');
	document.getElementById('divaltmsg').style.display = 'none';
	
	if(validatefield(ddlpaymenttype) & validatefield(txtAmount) & validatefield(txtTid) & validatefield(txtRemarks))
	{
		$('.DialogMask').show();
		document.getElementById('divaltmsg').style.display = 'none';
		document.getElementById('trmob').style.display = 'table-row';
		$.ajax( {
		  type: "POST",
		  url: form.attr( 'action' ),
		  data: form.serialize(),
		  success: function( response) 
		  {
		  		document.getElementById('trmob').style.display = 'none';
				document.getElementById('trmobmsg').style.display = 'table-row';
				document.getElementById('divaltmsg').style.display = 'block';
				document.getElementById('spanmsg').innerHTML = response;
				$('.DialogMask').hide();
      	  }
    } );
		
	}
	else
	{
		alert("Please Fill All The Fields");
	}
	
}
function validatefield(param)
{
	if(param.val() == "")
	{
		param.addClass("error");
		return false;
	}
	else
	{
		param.removeClass("error");
		return true;
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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php include("files/rightbar.php"); ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 <?php echo $this->white->getDomainName(); ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/popper/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="../assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="../assets/plugins/peity/jquery.peity.init.js"></script>
   
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
</style>
</body>
</html>