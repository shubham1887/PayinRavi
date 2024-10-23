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
    <title>Api</title>
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
    <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
      <?php include("files/apijaxscripts.php"); ?>
<script>
function SetEdit(value)
	{
		document.getElementById('txtAPIName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('txtUserName').value=document.getElementById("uname_"+value).innerHTML;		
		document.getElementById('txtPassword').value=document.getElementById("pwd_"+value).innerHTML;
		document.getElementById('txtIp').value=document.getElementById("ipaddr_"+value).innerHTML;
		document.getElementById('ddlhttpmethod').value=document.getElementById("method_"+value).innerHTML;
		document.getElementById('txtparameters').value=document.getElementById("params_"+value).innerHTML;
		document.getElementById('ddlstatus').value=document.getElementById("hidstatus_"+value).value;
		
		
		document.getElementById('txtToken').value=document.getElementById("token_"+value).innerHTML;
		
		
		
		
		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
</script>
<script>
	
$(document).ready(function(){
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
document.getElementById("ddlcompany").value = '<?php echo $ddlcompany; ?>';
});
	
	
	</script>
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
<style>
	.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
	padding-top:2px;
	padding-bottom:2px;
	padding-left:4px;
	padding-right:4px;
    /*line-height: 1.42857143;*/
	
    vertical-align: middle;
    border-top: 1px solid #ddd;
}
	</style>
</head>
<body class="fix-header card-no-border logo-center">
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">API CONFIGURATION</h4>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form action="<?php echo base_url()."_Admin/operatorapi2?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">                            
                                    <table cellspacing="10" cellpadding="3">                                     
                                    <tr>
                                        <td> 
                                            <h5>Select API</h5>  
                                        </td>                                     
                                    	<td style="padding-right:10px;">                                         	 
                                       
                                            <select id="ddlapi" name="ddlapi" class="form-control-sm">
                                            	<option value="0"></option>
                                                <?php
    												$rsltapi = $this->db->query("select a.api_id,a.api_name from tblapi a  order by api_name");
    												foreach($rsltapi->result() as $rw)
    												{?>
    												<option value="<?php echo $rw->api_id; ?>"><?php echo $rw->api_name; ?></option>
    												<?php }
    											 ?>
                                            </select>
                                        </td>                                     	
                                        <td style="padding-right:10px;">                                         	 
                                       
                                            <select id="ddlcompany" name="ddlcompany" class="form-control-sm">
                                            	<option value="0"></option>
                                                <?php
    												$rsltoperator = $this->db->query("select a.company_id,a.company_name from tblcompany a where a.service_id <= 3  order by company_name");
    												foreach($rsltoperator->result() as $rwop)
    												{?>
    												<option value="<?php echo $rwop->company_id; ?>"><?php echo $rwop->company_name; ?></option>
    												<?php }
    											 ?>
                                            </select>
                                        </td>        
                                        <td valign="bottom">                                         
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary btn-sm">                                                                                 
                                        </td>                                     
                                      </tr>                                     
                                     </table>                                                                                                                                                              </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <!-- column -->
                    
                    <!-- column -->
                    
                    <?php 
						$apiddl= '';
						$apiresult = $this->db->query("select api_id,api_name from tblapi where status = 1 order by api_name");
						foreach($apiresult->result() as $apirw)
						{
							$apiddl .='<option value="'.$apirw->api_id.'">'.$apirw->api_name.'</option>';
						}
						
					 ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Operator API Settings</h4>
                                <div class="table-responsive">
                                  <table class="table  table-striped .table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                             <th>Name</th>
                                             <th>ApiId</th>
                                             <th>CompanyName</th>
                                             <th>Pending<br>Limit</th>
                                             <th>Total<br>Pending</th>
                                             <th>Priority</th>
											 <th>Status</th>
                                             <th>Multi<br>Threaded</th>
											 <th>Series<br>Check</th>
                                             <th>Failure<br>Limit</th>
                                             <th>Re-Root</th>
                                             <th>Select API</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1; 
								   if($result_api != false)
								   {
								   foreach($result_api->result() as $row)
								   {?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><span id="name_<?php echo $row->company_id; ?>"><?php echo $row->api_name; ?></span></td>
                                            <td><span id="uname_<?php echo $row->company_id; ?>"><?php echo $row->username; ?></span></td>
                                            <td><span id="uname_<?php echo $row->company_id; ?>"><?php echo $row->company_name; ?></span></td>
                                            <td>
                                            <input onKeyUp="updateoperatorapi(<?php echo $row->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $row->company_id; ?>)" type="number" id="txtPendingLimit<?php echo $row->company_id; ?>" name="txtPendingLimit" class="form-control-sm" style="width:60px;height:24px;" value="<?php echo $row->pendinglimit; ?>">
                                            </td>
                                           <td><span id="totalpending_<?php echo $row->company_id; ?>"><?php echo $row->totalpending; ?></span></td>
                                           <td>
                                            <input onKeyUp="updateoperatorapi(<?php echo $row->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $row->company_id; ?>)" type="number" id="txtPriority<?php echo $row->company_id; ?>" name="txtPriority" class="form-control-sm" style="width:60px;height:24px;" value="<?php echo $row->priority; ?>">
                                            </td>
											<td>
												<?php 
													if($row->operator_status == "active")
													{?>
													<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" checked type="checkbox" id="md_checkbox_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
													<?php }
													else
													{?>
														<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" type="checkbox" id="md_checkbox_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
												<?php 	}
												?>
											</td>
                                            
<!------------ multi thread ------------------------------------------------------------------->                                            
                                            <td>
												<?php 
												
													if($row->multi_threaded == "yes")
													{?>
													<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" checked type="checkbox" id="md_checkbox_multi_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_multi_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
													<?php }
													else
													{?>
														<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" type="checkbox" id="md_checkbox_multi_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_multi_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
												<?php 	}
												?>
											</td>
<!------------------ End multi Thread -------------------------------------------->
											
											
											
<!------------ Series Wise Routing ------------------------------------------------------------------->                                            
                                            <td>
												<?php 
												
													if($row->statewise == "yes")
													{?>
													<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" checked type="checkbox" id="md_checkbox_series_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_series_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
													<?php }
													else
													{?>
														<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" type="checkbox" id="md_checkbox_series_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_series_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
												<?php 	}
												?>
											</td>
<!------------------ End Series Wise -------------------------------------------->
											
                                          
                                           <td>
                                            <input onKeyUp="updateoperatorapi(<?php echo $row->company_id; ?>)" onBlur="updateoperatorapi(<?php echo $row->company_id; ?>)"  type="number" id="txtFailureLimit<?php echo $row->company_id; ?>" name="txtFailureLimit" class="form-control-sm" style="width:60px;height:24px;" value="<?php echo $row->failurelimit; ?>">
                                            </td>
<!------------ Re-Root thread -------------------------------------->                                            
                                            <td>
												<?php 
												
													if($row->reroot == "yes")
													{?>
													<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" checked type="checkbox" id="md_checkbox_reroot_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_reroot_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
													<?php }
													else
													{?>
														<div class="panel panel-default"> 
                                    					<input onClick="updateoperatorapi(<?php echo $row->company_id; ?>)" type="checkbox" id="md_checkbox_reroot_<?php echo $row->company_id; ?>" class="filled-in chk-col-purple" />
                                                        <label for="md_checkbox_reroot_<?php echo $row->company_id; ?>"></label>
                                                    
                                                    </div>
												<?php 	}
												?>
											</td>
                                            <td>
                                            	<select id="ddlrerootapi<?php echo $row->company_id; ?>" name="ddlrerootapi<?php echo $row->company_id; ?>" class="form-control-sm" onChange="updateoperatorapi(<?php echo $row->company_id; ?>)">
                                                <option value="0"></option>
                                                <?php echo $apiddl; ?>
                                                </select>
                                                <script language="javascript">
                                                document.getElementById("ddlrerootapi<?php echo $row->company_id; ?>").value = '<?php echo $row->reroot_api_id; ?>';
												</script>
                                            </td>
                                            
                                            
<!------------------ End Re-Root Thread ---------------------------------------->  
                                             <td>
                                             	<input type="button" id="btnUpdate" name="btnUpdate" value="Search" class="btn btn-primary btn-xs" onClick="updateoperatorapi(<?php echo $row->company_id; ?>)">                                 
                                  <input type="hidden" id="hidapi_id<?php echo $row->company_id; ?>" value="<?php echo $row->api_id; ?>">
                                      
                                  
                                             </td>
                                        </tr>
                                   <?php $i++;} } ?>  
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <script language="javascript">
			function updateoperatorapi(id)
			{
				
					 $('#myOverlay').show();
    				$('#loadingGIF').show();
					
					
					
					if(document.getElementById("md_checkbox_"+id).checked)
					{
						var status = "1";
					}
					else
					{
						var status = "0";
					}
					if(document.getElementById("md_checkbox_multi_"+id).checked)
					{
						var multi = "yes";
					}
					else
					{
						var multi = "no";
					}
					if(document.getElementById("md_checkbox_reroot_"+id).checked)
					{
						var reroot = "yes";
					}
					else
					{
						var reroot = "no";
					}
				
					if(document.getElementById("md_checkbox_series_"+id).checked)
					{
						var series = "yes";
					}
					else
					{
						var series = "no";
					}
				
				
					
					
					var ddlrerootapi = document.getElementById("ddlrerootapi"+id).value;
					
					
					$.ajax({
						url:document.getElementById("hidbregvalurl").value,
						cache:false,
						data:{ "api_id":document.getElementById("hidapi_id"+id).value , "company_id" :id,"status":status,"failurelimit":document.getElementById("txtFailureLimit"+id).value,"pendinglimit":document.getElementById("txtPendingLimit"+id).value,"priority":document.getElementById("txtPriority"+id).value,"multi":multi,"reroot":reroot,"reroot_api_id":ddlrerootapi,"series":series} ,
						method:'POST',
						type:'POST',
						success:function(data)
						{
							
							document.getElementById("totalpending_"+id).innerHTML = data;
							
						},
						error:function()
						{
							//document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
							//document.getElementById("responsespanfailure").style.display = 'block'
							//document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
						},
						complete:function()
						{
							 $('#myOverlay').hide();
							$('#loadingGIF').hide();
						}
						});
				
			}
		</script>
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
    <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."_Admin/operatorapi2"; ?>">
    
    
    
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