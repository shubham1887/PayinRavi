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
    <title>API CLOSING BALANCE</title>
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
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	
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
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">API CLOSING BALANCE</h4>
                        
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                 <div class="col-12">
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                    	<div class="card">
                        <nav class="breadcrumb">
                        			<a class="breadcrumb-item" href="<?php echo base_url()."_Admin/list_recharge_pending?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Pending Recharges</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/requestlog?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Log Inbox</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/company?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Operator Settings</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dmr_margin_slab?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Margin Slab</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dmr_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>">DMR Report</a>
                                    
                                    
                                    <span class="breadcrumb-item active">API CLOSSING</span>
                                </nav>
                        </div>
                    
                    
           
                    </div>
                    <!-- column -->
                 </div>
                 </div>
                </div>
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">API CLOSSING BALANCE REPORT</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped .table-bordered" style="font-size:12px;color:#000000">
    <tr>  
    <th >ID</th>
    <th >DateTime</th>
     <th >Jupiter Balance</th>
     <th >RC24 Balance</th>
     <th >AACHARYA Balance</th>
     <th >CHAMP Balance</th>
      <th >MS Balance</th>
      <th >Total Recharge</th>
     <th >Total Pending</th>  
     <!-- <th >Admin Debit</th> -->
      <th >MD Load</th>  
      <th >Dist Load</th>  
      <th >Retailer Load</th>  
      <th >APIUSER Load</th>  
     
    </tr>
    <?php $i = 0;foreach($rslt->result() as $result) 	
	{
	
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td><?php echo $result->Id; ?></td>
  			 <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >			
						<?php echo $result->add_date; ?>
                </td>
            	<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">			
						<?php echo $result->jupiter; ?>
                </td>
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">			
						<?php echo $result->rc24; ?>
                </td>
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">			
						<?php echo $result->aacharya; ?>
                </td>
                 <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">			
						<?php echo $result->champ; ?>
                </td>
                 <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">			
						<?php echo $result->mastersim; ?>
                </td>
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >			
						<?php echo $result->totalrecharge; ?>
                </td>
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >			
						<?php echo $result->totalpending; ?>
                </td>
                <!--<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >			
					<?php echo $result->admindebit; ?>
                </td>-->
 				<!--<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->agentdebit; ?>
               </td>-->
               <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->mdload; ?>
               </td>
               <!-- <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->mdload_credit; ?>
               </td>-->
               <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->dload; ?>
               </td>
                <!--<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->dload_credit; ?>
               </td>-->
               <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->rload; ?>
               </td>
              <!-- <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->rload_credit; ?>
               </td>-->
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" >
                	<?php echo $result->apiuserbal; ?>
               </td>
 
 
 </tr>
		<?php 	
		$i++;} ?>
        
		</table>
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