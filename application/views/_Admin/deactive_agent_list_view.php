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
    <title>Deactive Retailer List</title>
    <!-- Favicon icon -->
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
.ui-datepicker { position: relative; z-index: 10000 !important; }
.mytable-border
{
    border-top: thin;
    border-bottom: thin;
    border-right: thin;
	border-left:thin;
}
.mytable-border tr td{
    border-top: thin !important;
    border-bottom: thin !important;
	border-left: thin !important;
    border-right: thin !important;
}
.mytable-border  tr{
    border-right: thin;
}
</style>
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
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Deactive Retailer List</h4>
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
                        			<a class="breadcrumb-item" href="<?php echo base_url()."_Admin/admin_agent_registration?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Add New Retailer</a>
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
                    <div class="col-12">
                    <?php include("files/messagebox.php"); ?>
                    </div>
                </div>
                <div class="row">
                   
                    <!-- column -->
                    <div class="col-12">
                    
                        <div class="card">
                            <div class="card-body">
                               
                                <div class="table-responsive">
                                    <form action="<?php echo base_url()."_Admin/deactive_agent_list" ?>" method="post" name="frmCallAction" id="frmCallAction">                            
                                    <input type="hidden" id="hidID" name="hidID">                                     
                                    <table cellspacing="10" cellpadding="3">                                     
                                    <tr>                                     	
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>AGENT NAME</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTName" value="<?php echo $txtAGENTName; ?>" name="txtAGENTName" type="text" style="width:120px;" placeholder="AGENT NAME">                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>AGENT ID</h5>                                             
                                    <input class="form-control-sm" id="txtAGENTId" value="<?php echo $txtAGENTId; ?>" name="txtAGENTId" type="text" style="width:120px;" placeholder="AGENT USER ID">                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>MOBILE NO</h5>                                              
                                    <input class="form-control-sm" id="txtMOBILENo" value="<?php echo $txtMOBILENo; ?>" name="txtMOBILENo" type="text" style="width:120px;" placeholder="AGENT MOBILE NO">                                         
                                    </td>                                         
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>PARENT MOBILE</h5>                                              
                                    <input class="form-control-sm" id="txtParentMobile" value="<?php echo $txtParentMobile; ?>" name="txtParentMobile" type="text" style="width:120px;" placeholder="PARENT MOBILE NO">                                         
                                    </td>    
                                    <td valign="bottom">                                         
                                    <input type="submit" id="btnSubmit" name="btnSubmit" value="Search" class="btn btn-primary btn-sm">       
                                    <input type="button" id="btnExport" name="btnExport" value="Export To Excel" class="btn btn-success btn-sm" onClick="startexoprttwo()">
                                                                    
                                    </td>                                     </tr>                                     </table>                            </form>
                                </div>
                                <script language="javascript">
	function startexoprttwo()
{
	
		document.getElementById("frmexp").submit();
	
}
	</script>
    <form id="frmexp" action="<?php echo base_url()."_Admin/deactive_agent_list/dataexporttwo" ?>" method="get">
    </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">DEACTIVE RETAILER LIST</h4>
                                <div class="table-responsive">
                                   <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
  		<th>Sr No</th>
	   <th>Agent Id</th>
	   <th>Agent Name</th>
	   <th >Parent Name</th>
	   <th>Mobile</th>
       <th>BirthDate</th>
	   <th>State</th>   
	   <th>City</th> 
	   <th>Host</th> 
	   <th style="width: 80px;">Balance</th> 
	   <th style="width: 80px;">Login</th>
	   <th>Enabled</th>
	   <th>DeactiveDate</th>                 
    </tr>
  
                      
       
    <?php					
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
<td ><a href="<?php echo base_url()."_Admin/profile?usertype=".$this->Common_methods->encrypt("Distributor")."&user_id=".$this->Common_methods->encrypt($result->parentid);?>" target="_blank"><?php echo $result->parent_name; ?></a></td>
  <td ><?php echo $result->mobile_no; ?></td>
    <td style="min-width:80px;">
	<?php 
		if($result->birthdate != "0000-00-00")
		{
			echo $result->birthdate; 
		}
		
	?>
    </td>
 <td ><?php echo $result->state_name; ?></td>
 <td ><?php echo $result->city_name; ?></td>
<td ><?php echo $this->Common_methods->getHostName($result->host_id); ?></td>
<td><span id="spanbalance<?php echo $result->user_id; ?>"></span></td>
<td>
<?php if($result->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$result->user_id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$result->user_id.",0)'>Active</a></span>";} ?>
</td>



<td>
<?php
	//echo $result->mt_access;
	if($result->enabled == 'yes')
	{
	 ?>
	<div class="panel panel-default"> 
    	<input checked class="filled-in chk-col-purple" type="checkbox" id="chksts<?php echo $result->user_id; ?>" name="chksts<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="stscheck('<?php echo $result->user_id; ?>')">
        <label for="chksts<?php echo $result->user_id; ?>"></label>
    </div>
	<?php }
	else
	{?>
	<div class="panel panel-default"> 
    	<input  class="filled-in chk-col-purple"  type="checkbox" id="chksts<?php echo $result->user_id; ?>" name="chksts<?php echo $result->user_id; ?>" value="<?php echo $result->user_id; ?>" onClick="stscheck('<?php echo $result->user_id; ?>')">
        <label for="chksts<?php echo $result->user_id; ?>"></label>
    </div>
    
	<?php }
 ?>
</td>



<td><?php echo $result->deactive_date; ?></td>
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
    <script language="javascript">
 function setrechargelimit(user_id)
 {
 	document.getElementById("txtminrechargelimit"+user_id).style.backgroundColor = "yellow";
 	var minrechargelimit = document.getElementById("txtminrechargelimit"+user_id).value;
	$.ajax({
	url:'<?php echo base_url()."_Admin/agent_list/minRechargeLimit";?>?minrechargelimit='+minrechargelimit+'&id='+user_id,
	method:'POST',
	cache:false,
	success:function(html)
	{
		document.getElementById("txtminrechargelimit"+user_id).style.backgroundColor = "white";
	}
	
	});
 }
 </script>	
		
<script language="javascript">
function changedmrgroup(id)
{
	var myval = document.getElementById("ddldmrgroup_"+id).value;
	document.getElementById("ddldmrgroup_"+id).style.display="none";
	$.ajax({
	url:'<?php echo base_url()."_Admin/agent_list/changedmrgroup?id=";?>'+id+'&field='+myval,
	cache:false,
	method:'POST',
	success:function(html)
	{
			document.getElementById("ddldmrgroup_"+id).style.display="block";
		document.getElementById("ddldmrgroup_"+id).value = html;
	}
	});
}
</script>		
<script language="javascript">
function actionDeactivate(id,status)
{
	document.getElementById("hiduserid").value = id;
	document.getElementById("hidstatus").value = status;
	document.getElementById("hidaction").value = "Set";
	document.getElementById("frmstatuschange").submit();
}
</script>
 <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."_Admin/agent_list/togglegroup"; ?>">
        <script language="javascript">
		function actionToggle(id,sts)
		{
			$.ajax({
				url:document.getElementById("hidurltoggle").value+'?id='+id+'&sts='+sts,
				cache:false,
				type:'POST',
				success:function(html)
				{
				
					window.location.reload(1);
				}
			
			});
		}
		
		
		function mtcheck(id)
		{
			if(document.getElementById("chkmt"+id).checked == true)      
			{      
				$.ajax({
				url:'<?php echo base_url()."_Admin/agent_list/setvalues?"; ?>Id='+id+'&field=MT&val=1',
				cache:false,
				method:'POST',
				success:function(html)
				{
					alert(html);
				}
				}); 
			} 
			else
			{
					  
				$.ajax({
				url:'<?php echo base_url()."_Admin/agent_list/setvalues?"; ?>Id='+id+'&field=MT&val=0',
				cache:false,
				method:'POST',
				success:function(html)
				{
					alert(html);
				}
				}); 
			
			}  
		}
		
		function stscheck(id)
		{
			if(document.getElementById("chksts"+id).checked == true)      
			{      
				$.ajax({
				url:'<?php echo base_url()."_Admin/agent_list/setvalues?"; ?>Id='+id+'&field=ENABLED&val=yes',
				cache:false,
				method:'POST',
				success:function(html)
				{
					alert(html);
				}
				}); 
			} 
			else
			{
					  
				$.ajax({
				url:'<?php echo base_url()."_Admin/agent_list/setvalues?"; ?>Id='+id+'&field=ENABLED&val=no',
				cache:false,
				method:'POST',
				success:function(html)
				{
					alert(html);
				}
				}); 
			
			}  
		}
		
		</script>
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
			    //alert(html);
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
	 function Confirmation(value)
	{
	
		if(confirm("Are you sure?\nyou want to delete ") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
</script>
		<input type="hidden" id="hidbaseurl" value="<?php echo base_url()."_Admin/agent_list"; ?>">
  <input type="hidden" id="hidusers" value="<?php echo  $struser; ?>">
   <form action="<?php echo base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="delete" />
</form> 
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
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
   
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
   
</body>
</html>