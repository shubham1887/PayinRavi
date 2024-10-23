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
    <title>APIUSER LIST</title>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">APIUSERS</h4>
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
                    
                    	<div class="card">
                        <nav class="breadcrumb">
                        			<a class="breadcrumb-item" href="<?php echo base_url()."_Admin/api_user_registration?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Add New Apiuser</a>
                                     <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/list_recharge?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Recharge List</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/requestlog?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Log Inbox</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/company?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Operator Settings</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Distributor List</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">MasterDistributor List</a>
                                    
                                    
                                    <span class="breadcrumb-item active">Retailer List</span>
                                </nav>
                        </div>
                    
                 </div>
                </div>
                <div class="row">
                    
                    <!-- column -->
                    
                    <!-- column -->
                    <div class="col-12">
                    	<?php include("files/messagebox.php"); ?>
                    </div>
                    <div class="col-12">
                    
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <form action="<?php echo base_url()."_Admin/apiuser_list?crypt=".$this->Common_methods->encrypt("MyData") ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Apiuser Name</label>
                                        	<input class="form-control-sm datepicker" type="text" value="<?php echo $txtAGENTName; ?>"  id="txtAGENTName" name="txtAGENTName"  >    
                                    	</div>
                                        	
                                        </td>
                                        <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">Apiuser ID</label>
                                            <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text"  >
                         
                                    	</div>
                                        </td>
                                         <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <label for="example-date-input" class="col-form-label">MOBILE NO</label>
                                         <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text"  >
                         
                                    	</div>
                                        </td>
                                        
                                        <td >
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-xs">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Apiuser List</h4>
                                <div class="table-responsive">
               						<table class="table table-responsive table-striped .table-bordered" style="font-size:14px;color:#000000;font-family:sans-serif">
    <tr>
  		<th>Sr No</th>
	   <th>Apiuser Id</th>
	   <th>Apiuser Name</th>
	   <th>Mobile</th>
	   <th>State</th>   
	   <th>City</th> 
	   <th style="width: 80px;">Grouping</th> 
	   <th>DMR.GROUP</th>
	   <th style="width: 80px;">Balance</th> 
	   <th style="width: 80px;">Login</th>
	   <th>DMR</th>
	   <th>Action</th>                 
    </tr>
  
                      
       
    <?php
				$dmrgroup_dropdownitem = '';
				$rsltdmrgroup = $this->db->query("select * from mt3_group ");
				foreach($rsltdmrgroup->result() as $dmrrow)
				{
					$dmrgroup_dropdownitem .='<option value="'.$dmrrow->Id.'">'.$dmrrow->Name.'</option>';
				} 
									
			$struser = '';						
		$i = 0;foreach($result_dealer->result() as $result) 	
		{  
			$balance = '';
			$balance2 = '';
			$struser .= $result->user_id."#";
		?>
    
    
		<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo $i+1; ?></td>
 <td ><?php echo $result->username; ?></td>
<td ><a href="<?php echo base_url()."_Admin/profile?usertype=".$this->Common_methods->encrypt("Agent")."&user_id=".$this->Common_methods->encrypt($result->user_id);?>" target="_blank"><?php 
if($result->businessname == "")
{
        echo "Unknown"; 
}
else
{
    echo $result->businessname;     
}
?></a></td>
  <td ><?php echo $result->mobile_no; ?></td>
 <td ><?php echo $result->state_name; ?></td>
 <td ><?php echo $result->city_name; ?></td>
<td>
<?php if($result->grouping == 0)
{?>
<span class='label btn-success' >
	<a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->user_id;?>",1)'>Individual</a>
</span>
<?php }
else
{?>
	<span class='label btn-success'>
		<a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->user_id;?>",0)'>GroupWise</a>
	</span>
<?php } ?>
</td>
<!-- dmr group td -->			
			
<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34">
 
	<select id="ddldmrgroup_<?php echo $result->user_id; ?>" onChange="changedmrgroup('<?php echo $result->user_id; ?>')" style="width:100px;">
		<option value="0">Select</option>
	 	<option value="0">Default</option>
		<?php echo $dmrgroup_dropdownitem;?>
	</select>
	<script language="javascript">
		document.getElementById("ddldmrgroup_"+<?php echo $result->user_id; ?>).value = '<?php echo $result->dmr_group; ?>';
	</script>
 </td>			
			
<!-- end dmr group td -->
			
<td><?php echo $this->Common_methods->getAgentBalance($result->user_id); ?></td>
<td>
<?php if($result->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$result->user_id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
</td>

<td>
<?php
	//echo $result->mt_access;
	if($result->mt_access == 1)
	{
	 ?>
	
    <input checked type="checkbox" id="chkmt<?php echo $result->user_id; ?>" name="chkmt<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="mtcheck('<?php echo $result->user_id; ?>')">
	<?php }
	else
	{?>
    <input type="checkbox" id="chkmt<?php echo $result->user_id; ?>" name="chkmt<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="mtcheck('<?php echo $result->user_id; ?>')">
	<?php }
 ?>
</td>

 <td width="180px">
  <a class="far fa-edit" style="font-size:18px;" href="<?php echo base_url()."_Admin/apiuser_edit?id=".$this->Common_methods->encrypt($result->user_id); ?>" title="Edit Franchise"></a> 
   |       
 <?php 
 
 echo '<a class="fas fa-plus-square" style="font-size:16px;" title="Transfer Money" href="'.base_url().'_Admin/add_balance?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"></a> | ';
 
 
	
	
echo '<a style="font-size:16px;" title="Transfer Money" href="'.base_url().'_Admin/add_balance2?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"><img src="'.base_url().'files/rupee.png" style="width:20px;"/></a> | ';
	
	
  if($this->session->userdata("ausertype") == "Admin"){
 echo ' <a style="font-size:16px;" class="fas fa-share" href="'.base_url().'directaccess/process/'.$this->Common_methods->encrypt($result->user_id).'" target=_blank></a>';} ?>
 </td>
 </tr>
		<?php 	
		$i++;} ?>
		</table>
       <?php  echo $pagination; ?>
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
</body>
</html>