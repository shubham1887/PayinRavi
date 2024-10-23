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
    <title>Account Report</title>
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
            $( "#txtDate,#txtFrom,#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	</script>
<style>
.green
{
    background-color: #00ff00;
}
	  
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
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
	border-bottom:: 1px solid #ddd;
	overflow:hidden;
}
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
        <?php include("files/header.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sidebar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            
            
<!----- model start -->

<div id="modal-form" class="modal" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="blue bigger">Please fill the following form fields</h4>
			</div>

			<div class="modal-body">
				<div class="row">
					
					<div class="col-xs-12 col-sm-7">
				        <form action="<?php echo base_url()."_Admin/credit_entry?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                                        <input type="hidden" id="hidattribute" name="hidattribute">
                                        <input type="hidden" id="hidpayment_id" name="hidpayment_id">
                                    <table class="table" style="color:#000000;">
                                        <tr>
                                        <td style="padding-right:10px;">
                                        <h5 style="color:#000000">Selected User</h5>
                                        <input type="hidden" id="ddluser" name="ddluser">
                                        <span class="btn btn-success" id="span_user"></span>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-right:10px;">
                                        <h5 style="color:#000000">Select Bank</h5>
                                        <select id="ddlbank" name="ddlbank" class="form-control" style="color:#000000;width:300px;">
                                            <option value="CASH">CASH</option>
                                            <?php
                                        	 	$rslbank = $this->db->query("select a.Id,a.bank_id,a.account_name,a.account_number,a.ifsc,branch,a.add_date,b.bank_name from creditmaster_banks a left join tblbank b on a.bank_id = b.bank_id order by a.Id");
                                        		foreach($rslbank->result() as $row_bank)
                                        		{
                                        			echo "<option value=".$row_bank->Id.">".$row_bank->bank_name."&nbsp;[&nbsp;".$row_bank->account_name."  ".$row_bank->account_number."]</option>";
                                        		}
                                        	  ?>
                                        </select>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5 style="color:#000000">Cash Received Date</h5>
                                            <input class="form-control-sm datepicker"  id="txtDate" name="txtDate" type="text" value="<?php echo $this->common->getMySqlDate() ?>"  placeholder="Select Date" style="color:#000000;width:300px;">
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5 style="color:#000000">Amount</h5>
                                            <input class="form-control-sm"  id="txtAmount" name="txtAmount" type="number"  placeholder="Enter Amount" style="color:#000000;width:300px;">
                                    </td>
                                    </tr>
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5 style="color:#000000">Remark</h5>
                                             <input class="form-control-sm"  id="txtRemark" name="txtRemark" type="text" placeholder="Enter Amount" style="color:#000000;width:300px;">   
                                    </td>
                                    </tr>
                                    <tr>
                                    <td valign="bottom" style="display:none">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Submit" class="btn btn-primary">
                                    </td>
                                    </tr>
                                    </table>
                                    </form>
                                    
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Cancel
				</button>

				<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="validateandsubmit()">
					<i class="ace-icon fa fa-check"></i>
					Save
				</button>
				<script language="javascript">
				function validateandsubmit()
				{
				    
				    document.getElementById("hidattribute").value = "CASH_RECEIVE";
					document.getElementById("frmCallAction").submit();
				}
				</script>
			</div>
		</div>
	</div>
</div>

<!-- model end -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">Cash Receive Entry</h4>
                         <form action="<?php echo base_url()."_Admin/credit_entry?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                                        <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                        <tr>
                                        <td style="padding-right:10px;">
                                        <h5>From Date</h5>
                                    <input class="form-control-sm datepicker" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;cursor:pointer;" readonly placeholder="Select Date">
                                    </td>
                                    <td style="padding-right:10px;">
                                        <h5>To Date</h5>
                                    <input class="form-control-sm datepicker" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:120px;cursor:pointer;" readonly placeholder="Select Date">
                                    </td>
                                    
                                    <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">
                                    </td>
                                    </tr>
                                    </table>
                                    </form>
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
                                
                               <?php include("files/messagebox.php"); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Todays Ledger</h4>
                                <div class="table-responsive">
    <table class="table  table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
    <th>Payment Date</th>
    <th>Payment Id</th>
    <th>Payment From</th>
    <th>Payment To</th>
   
    <th >Description</th>
    <th>Remark</th>
    <th>Admin Remark</th>
    <th>Credit Amount</th>
    <th>Debit Amount</th>
    
    
    </tr>
    <?php	$i = 0;foreach($result_creditledger->result() as $result)
	 	{
		$entry_done_class = "";
		if($result->cash_ref_id > 0)
		{
		    $entry_done_class = "green";
		}
		  ?>
			<tr class="<?php echo $entry_done_class;?> ">
<td><?php echo $result->add_date; ?></td>
 <td>
     <?php echo $result->payment_id; ?>
    <input type="hidden" id="hidcr_user_id<?php echo $result->payment_id; ?>" value="<?php echo $result->cr_user_id; ?>">
    <input type="hidden" id="hidcr_bname<?php echo $result->payment_id; ?>" value="<?php echo $result->bname." [ ".$result->username." ] "; ?>">
    
 </td>
  <td><?php echo $result->dr_bname."<br>".$result->dr_username; ?></td>
  <td><?php echo $result->bname."<br>".$result->username; ?></td>
  
 <td><?php echo $result->description; ?></td>
 <td ><?php echo $result->remark; ?></td>
 <td ><?php echo $result->admin_remark; ?></td>
 <td ><?php echo round($result->credit_amount,2); ?></td>  
 <td><a href="#modal-form" role="button" class="blue btn btn-primary" data-toggle="modal"   onClick="openoppup(<?php echo $result->payment_id; ?>)"><?php echo number_format($result->debit_amount,2,'.',','); ?></a></td>  
 
 </tr>
		<?php 	
		$i++; } ?>
		</table>
 <script language="javascript">
     function openoppup(payment_id)
     {
        
        document.getElementById("span_user").innerHTML = "";
        document.getElementById("hidpayment_id").value = 0;
        document.getElementById("ddluser").value = 0;
        
         
         
        var cr_user_id = $("#hidcr_user_id"+payment_id).val();
        //alert($("#hidcr_bname"+payment_id).val());
        document.getElementById("span_user").innerHTML = $("#hidcr_bname"+payment_id).val();
        document.getElementById("hidpayment_id").value = payment_id;
        document.getElementById("ddluser").value = cr_user_id;
     }
 </script>
                                    
                                 
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
                © 2019 TULSYANRECHARGE.COM
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
</body>
</html>