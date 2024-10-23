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
    <title>Payment Request</title>
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
    document.getElementById("ddlbank").value = '<?php echo $ddlbank; ?>';
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	
	</script>
	<input type="hidden" id="hidurl" value="<?php echo base_url()."SuperDealer/payment_request/updaterequest"; ?>">
      <script language="javascript">
function validateform(id)
{
	var txtAmount = $('#txtAmount'+id);
	var txnPwd = $('#txnPwd'+id);
	var ddlstatus = $('#ddlstatus'+id);
	var txtAdminRemark = $('#txtAdminRemark'+id);
	var hidamount = $('#hidamount'+id);
	if(hidamount.val().trim() != txtAmount.val().trim())
	{
		alert("Confirm Amount Not Match With Amount");
		return false;
	}
	document.getElementById('divaltmsg').style.display = 'none';
	var hidrul = document.getElementById('hidurl').value;
	
	if(validatefield(txtAmount) & validatefield(txnPwd) & validatefield(ddlstatus) & validatefield(txtAdminRemark))
	{
		$('.DialogMask').show();
		document.getElementById('divaltmsg').style.display = 'none';
		document.getElementById('trmob').style.display = 'table-row';
		$.ajax( {
		  type: "POST",
		  url:hidrul+'?amount='+txtAmount.val()+'&txnPwd='+txnPwd.val()+'&ddlstatus='+ddlstatus.val()+'&txtAdminRemark='+txtAdminRemark.val()+'&hidid='+id+'&hidamount='+hidamount.val().trim(),
		  success: function( response) 
		  {
		  		document.getElementById('trmob').style.display = 'none';
				document.getElementById('trmobmsg').style.display = 'table-row';
				document.getElementById('divaltmsg').style.display = 'block';
				document.getElementById('spanmsg').innerHTML = response;
				$('.DialogMask').hide();
				window.location.reload();
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
        <?php include("files/sdheader.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sdsidebar.php"); ?>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Payment Request</h4>
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
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SEARCH REPORT</h4>
                                <div class="table-responsive">
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
                           <form action="<?php echo base_url()."SuperDealer/payment_request?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                            <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control-sm" id="txtTo" value="<?php echo $to; ?>" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Bank</h5>
                                            <select id="ddlbank" name="ddlbank" class="form-control-sm">
                                                <option value="ALL">ALL</option>
                                                <option value="SBI">SBI</option>
                                                <option value="ICICI">ICICI</option>
                                                <option value="AXIS">AXIS</option>
                                                <option value="BOI">BOI</option>
                                                <option value="UNION">UNION</option>
                                                
                                            </select>
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                        
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                 </div>
                 <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
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
                  			</div>
                         </div>
                     </div>
               	</div>
                 <div class="row">   
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">PAYMENT REQUEST LIST</h4>
                                <div class="table-responsive">
                                        <?php if($result_mdealer != false){ ?>
 
<table class="table table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
    <tr>
		<th></th>
		<th>Payment<br> Date</th>
		<th>Request<br> Id</th>
		<th>Agent<br> Name</th>
		<th>Wallet<br> Type</th>
		<th>Payment<br> Type</th>
		<th>Ref.Id/<br> Branch</th>
		<th>Amount</th>
		<th>Remark</th>
		<th>Conf.Amount</th>
		<th>Txn.Pwd</th>
		<th>Status</th>
		<th>Admin<br> Remark</th>
		<th>Action</th>
    
    </tr>
      <?php 
	if($result_mdealer->num_rows() > 0){
   
   	$i = 0;foreach($result_mdealer->result() as $result) 	{
	
	  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
				 <td><a href="<?php echo base_url().$result->image_url; ?>" target="_blank"><img style="width:80px;height:40px;" src="<?php echo base_url().$result->image_url; ?>" alt=""></a></td>
             <td><?php echo $result->add_date; ?></td>
             <td ><?php echo $result->Id; ?></td>
             <td ><?php echo $result->businessname." [ ".$result->username." ]"; ?></td>
             <td><?php echo $result->wallet_type; ?></td>
             <td><?php echo $result->payment_type; ?></td>
             <td ><?php echo $result->transaction_id; ?></td>
             <td>
				 <?php echo $result->amount; ?>
            	<input type="hidden" id="hidamount<?php echo $result->Id; ?>" name="hidamount<?php echo $result->Id; ?>" value="<?php echo $result->amount; ?>">
			 </td>
             <td><?php echo $result->remark; ?></td>
             <td>
			 <input type="text" id="txtAmount<?php echo $result->Id; ?>" name="txtAmount<?php echo $result->Id; ?>" class="form-control-sm" style="width:80px" placeholder="Confirm Amount">
	</td>
     <td>
			 <input type="text" id="txnPwd<?php echo $result->Id; ?>" name="txnPwd<?php echo $result->Id; ?>" class="form-control-sm" style="width:80px" placeholder="Transaction Password">
	</td>
              <td>
			  <select id="ddlstatus<?php echo $result->Id; ?>" name="ddlstatus" class="form-control-sm" style="width:80px;">
              <option value="">Select</option>
              <option value="Approve">Approve</option>
              <option value="Reject">Reject</option>
              </select>
			  </td>
             <td>
			 <input type="text" id="txtAdminRemark<?php echo $result->Id; ?>" name="txtAdminRemark<?php echo $result->Id; ?>" class="form-control-sm" style="width:120px" placeholder="Admin Remark">
	</td>
     <td>
     <input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-primary" value="Submit" onClick="validateform('<?php echo $result->Id; ?>')">
     </td>        
             
  
 </tr>
		<?php 	
		$i++;}  ?>
      <?php } else{?>
       <tr>
       <td colspan="13">
       <div class='message'> No Records Found</div>
       </td>
       </tr>
      <?php } ?>
		</table>
   
<?php } ?>
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
</style>
</body>
</html>