<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>SuperDistributor List</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url(); ?>css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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
                      <h4 class="text-themecolor m-b-0 m-t-0">SUPER DISTRIBUTOR LIST</h4>
                        
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                
                </div>
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                        <?php include("files/messagebox.php"); ?>
                        <div class="card">
                            <div class="card-body">
                                
                                    <form action="<?php echo base_url()."SuperDealer/sd_list?crypt=".$this->Common_methods->encrypt("MyData") ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Sd.Dist. Name</h5>
                                        	<input class="form-control-sm datepicker" type="text" value="<?php echo $txtAGENTName; ?>"  id="txtAGENTName" name="txtAGENTName"  placeholder="Super Distributor Name" >    
                                    	</div>
                                        	
                                        </td>
                                        <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Sd.Dist. ID</h5>
                                            <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text"  placeholder="Super Distributor USER ID">
                         
                                    	</div>
                                        </td>
                                         <td style="padding-right:10px;">
                                        <div class="form-group">
                                            <h5 for="example-date-input" class="col-form-label">Mobile No</h5>
                                         <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text"  placeholder=" SuperDistributor MOBILE NO">
                         
                                    	</div>
                                        </td>
                                        
                                        <td >
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Super Distributor LIST</h4>
                                <div class="table-responsive">
                 <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
  		<th>Sr No</th>
	   <th>Agent Id</th>
	   <th>Agent Name</th>

	   <th>Mobile</th>
	   <th>State</th>   
	   <th>City</th> 
	   <th>Group Name</th> 
	  
	   <th style="width: 80px;">Balance</th> 
	   <th style="width: 80px;">Login</th>
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
<td ><a href="<?php echo base_url()."_Admin/profile?usertype=".$this->Common_methods->encrypt("SuperDealer")."&user_id=".$this->Common_methods->encrypt($result->user_id);?>" target="_blank"><?php 
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
<td ><?php echo $result->group_name; ?></td>

<td style="width:140px;min-width:140px;"><span id="spanbalance<?php echo $result->user_id; ?>"></span></td>
<td>
<?php if($result->status == 0){echo "Deactive";}else{echo "Active";} ?>
</td>



<td>

</td>



 <td width="180px">
  
 <?php 
 
 echo '<a class="fas fa-plus-square" style="font-size:16px;" title="Transfer Money" href="'.base_url().'SuperDealer/add_balance?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"></a> | ';
 
 
	
	
echo '<a style="font-size:16px;" title="Transfer Money" href="'.base_url().'SuperDealer/add_balance2?encrid='.$this->Common_methods->encrypt($result->user_id).'" class="paging"><img src="'.base_url().'files/rupee.png" style="width:20px;"/></a> | ';
	
	 ?>
 
 </td>
 </tr>
		<?php 	
		$i++;} ?>
		</table>
                                     
                                     
                                     
                                     
                                      <?php  echo $pagination; ?>         
                                     		
                                      <script language="javascript">   
                                      function getuserbalance() 
                                      { 		
                                          
                                          var struser = document.getElementById("hidusers").value; 		
                                          var struserarr = struser.split("#"); 		
                                          for(i=0;i<struserarr.length;i++) 		
                                          { 			
                                              var id = struserarr[i]; 			
                                              if(id > 0) 			
                                              { 			
                                                  $.ajax({ 			
                                                      url:document.getElementById("hidbaseurl").value+'/getbalance?id='+id, 			
                                                      method:'POST', 			
                                                      cache:false, 			
                                                      success:function(html) 		
                                                        {	 				
                                                        var strbalarid = html.split("#"); 				
                                                        //alert(html + "0 = "+strbalarid[0]+"  1 = "+strbalarid[1]); 				
                                                        document.getElementById("spanbalance"+strbalarid[0]).innerHTML = strbalarid[1]+" | "+strbalarid[2];
                                                        } 			 			
                                                        }); 
                                                        
                                                } 			 		
                                            } 		 	
                                        } 	
                                        $(document).ready(function() 	
                                        { 	
                                           
                                        getuserbalance(); 		 	
                                        });	
                                        
                                        
  
                                                        </script> 	
                                      <input type="hidden" id="hidbaseurl" value="<?php echo base_url()."SuperDealer/agent_list"; ?>">  
                                      <input type="hidden" id="hidusers" value="<?php echo  $struser; ?>">  
                                      
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
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/plugins/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url(); ?>js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url(); ?>js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.init.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    
</body>
</html>