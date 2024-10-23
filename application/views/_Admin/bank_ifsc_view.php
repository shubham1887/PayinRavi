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
    <title>Bank IFSC</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Table</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Table</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
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
                        	<ul class="breadcrumb">
	                                    <i class="icon-chevron-left hide-sidebar"><a href="#" title="Hide Sidebar" rel="tooltip">&nbsp;</a></i>
										
	                                    <i class="icon-chevron-right show-sidebar" style="display:none;"><a href="#" title="Show Sidebar" rel="tooltip">&nbsp;</a></i>
										<li>
	                                         <a class="link" href="<?php echo base_url()."_Admin/operator_code?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Operator Code</a>
											<span class="divider">/</span>	
	                                    </li>
	                                    <li>
	                                      <a href="<?php echo base_url()."_Admin/company?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Operator Settings</a>
											<span class="divider">/</span>	
	                                    </li>
	                                    <li>
	                                         <a class="link" href="<?php echo base_url()."_Admin/list_recharge_pending?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Pending Recharges</a>
											<span class="divider">/</span>	
	                                    </li>
	                                    <li>
	                                       <a href="<?php echo base_url()."_Admin/requestlog?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Log Inbox</a>
											<span class="divider">/</span>	
	                                    </li>
										
										<li>
	                                      <a href="<?php echo base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Retailers</a>
											<span class="divider">/</span>	
	                                    </li>
										<li>
	                                     <a href="<?php echo base_url()."_Admin/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Distributors</a>
											<span class="divider">/</span>	
	                                    </li>
										<li>
	                                    <a href="<?php echo base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">MasterDealers</a>
											<span class="divider">/</span>	
	                                    </li>
										<li>
	                                     <a href="<?php echo base_url()."_Admin/apiuser_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Apiusers</a>
											<span class="divider">/</span>	
	                                    </li>
	                                    <li class="active">Dmr Report</li>
	                                </ul>
                        </div>
                    
                    
                        <!--<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bordered Table</h4>
                                <h6 class="card-subtitle">Add<code>.table-bordered</code>for borders on all sides of the table and cells.</h6>
                                <div class="table-responsive">
                                    
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">ADD NEW BANK</h4>
                                <div class="table-responsive">
                                    <form method="post" action="<?php echo base_url()."_Admin/bank_ifsc"; ?>" name="frmscheme_view" id="frmscheme_view" autocomplete="off">   <table cellpadding="3" cellspacing="3" border="0"> <tr> <td>Bank Name :<input type="text" class="form-control-sm" id="txtBankName" placeholder="Enter Bank Name" name="txtBankName" maxlength="100"/ style="width: 500px;"> </td> </tr>   <tr> <td> IFSC :<input type="text" style="width: 500px;" class="form-control-sm" id="txtIFSC"  placeholder="" name="txtIFSC" maxlength="11"/> </td> </tr> <tr> 	<td>     	<input type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Submit"/>     </td> </tr>  </table>    <input type="hidden" id="hidID" name="hidID" /> </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">BANK LIST</h4>
                                <div class="table-responsive">
                                    <table style="width:100%;font-size:16px;"  class='table' cellpadding="3" cellspacing="0" border="0">     <thead>          <tr class="ColHeader">                           <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="left" width="120" height="30" >BANK Name</th>              <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center" width="120" height="30" >IFSC</th>                           <th class="padding_left_10px box_border_bottom box_border_right background_gray" align="center" width="120" height="30" >Action</th>         </tr> </thead>      <tbody>                                   <?php	$i = 0;foreach($result_group->result() as $result) 	{  			 	 ?>      			<tr class="<?php if($i%2==0){echo "row1";}else{echo "row2"; } ?>">                                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;"><span id="name_<?php echo $result->Id; ?>"><?php echo $result->bank_name; ?></span></td>                  <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="IFSC_<?php echo $result->Id; ?>" ><?php echo $result->IFSC; ?></span></td>                                                                               <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><img src="<?php echo base_url()."Edit.PNG"; ?>" onClick="SetEdit('<?php echo $result->Id  ?>')" ></td>                      </tr> 		<?php 	 		$i++;} ?>         </tbody> 		</table>         <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."_Admin/group/togglegroup"; ?>">         <script language="javascript"> 		function enabledisabletoggle(id,sts) 		{ 			$.ajax({ 				url:document.getElementById("hidurltoggle").value+'?id='+id+'&sts='+sts, 				cache:false, 				type:'POST', 				success:function(html) 				{ 					window.location.reload(1); 				} 			 			}); 		} 		</script>
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