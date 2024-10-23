<!DOCTYPE html>
<html lang="en">
<?php
	$user_id = $this->Common_methods->decrypt($this->input->get("id"));
	$result_user = $this->db->query("
		select 
			a.user_id,
			a.parentid,
			a.businessname,
			a.mobile_no,
			a.usertype_name,
			a.username,
			a.state_id,a.city_id,
			b.postal_address,
			b.pincode,
			b.aadhar_number,
			b.pan_no,
			b.gst_no,
			b.landline,
			b.emailid,
			b.contact_person,
			b.call_back_url,
			b.client_ip,
			b.client_ip2,
			b.client_ip3,
			b.client_ip4,
			a.scheme_id
			from tblusers a
			left join tblusers_info b on a.user_id = b.user_id
			where a.user_id=?",array($user_id));	
			
	
 ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>APIUSER EDIT</title>
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
<script type="text/javascript" language="javascript">					
		function getCityName(urlToSend)
	{
		if(document.getElementById('ddlState').selectedIndex != 0)
		{
			document.getElementById('hidStateCode').value = $("#ddlState")[0].options[document.getElementById('ddlState').selectedIndex].getAttribute('code');					
		$.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlState').value,
  success: function(html){
    $("#ddlCity").html(html);
  }
});
		}
	}

function getCityNameOnLoad(urlToSend)
	{
		if(document.getElementById('ddlState').selectedIndex != 0)
		{
								
		$.ajax({
  type: "GET",
  url: urlToSend+""+document.getElementById('ddlState').value,
  success: function(html){
    $("#ddlCity").html(html);
	document.getElementById('ddlCity').value = document.getElementById('hidCityID').value;		
  }
});
		}
	}
$(document).ready(function(){
	//global vars
	var form = $("#frmdistributer_form1");
	var dname = $("#txtDistname");var postaladdr = $("#txtPostalAddr");
	var pin = $("#txtPin");var mobileno = $("#txtMobNo");var emailid = $("#txtEmail");
	var ddlsch = $("#ddlSchDesc");
	//On Submitting
	form.submit(function(){
		if(validateDname() & validateAddress() & validatePin() & validateMobileno() & validateEmail() & validateScheme())
			{				
			return true;
			}
		else
			return false;
	});
	//validation functions	
	function validateDname(){
		if(dname.val() == ""){
			dname.addClass("error");return false;
		}
		else{
			dname.removeClass("error");return true;
		}		
	}	
	function validateAddress(){
		if(postaladdr.val() == ""){
			postaladdr.addClass("error");return false;
		}
		else{
			postaladdr.removeClass("error");return true;
		}		
	}
	function validatePin(){
		if(pin.val() == ""){
			pin.addClass("error");
			return false;
		}
		else{
			pin.removeClass("error");
			return true;
		}
		
	}
	function validateMobileno(){
		if(mobileno.val().length < 10){
			mobileno.addClass("error");return false;
		}
		else{
			mobileno.removeClass("error");return true;
		}
	}
	function validateEmail(){
		var a = $("#txtEmail").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		if(filter.test(a)){
			emailid.removeClass("error");
			return true;
		}
		else{
			emailid.addClass("error");			
			return false;
		}
	}
	function validateScheme(){
		if(ddlsch[0].selectedIndex == 0){
			ddlsch.addClass("error");			
			return false;
		}
		else{
			ddlsch.removeClass("error");		
			return true;
		}
	}
	setTimeout(function(){$('div.message').fadeOut(1000);}, 10000);
	
	
});
	function ChangeAmount()
	{
		if(document.getElementById('ddlSchDesc').selectedIndex != 0)
		{
			document.getElementById('spAmount').innerHTML = $("#ddlSchDesc")[0].options[document.getElementById('ddlSchDesc').selectedIndex].getAttribute("amount");
			document.getElementById('hid_scheme_amount').value = document.getElementById('spAmount').innerHTML;
		}
	}	
	function setLoadValues()
	{
		document.getElementById('ddlSchDesc').value = document.getElementById('hidScheme').value;		
		document.getElementById('ddlState').value = document.getElementById('hidStateID').value;
		getCityNameOnLoad('<?php echo base_url()."_Admin/city/getCity/"; ?>');
					
	}	
</script>
     <style>
	 .odd { 
        background-color: #FCF7F7;
      }
    .even {
        background-color: #E3DCDB;
    }
	
	 </style>
</head>
<body class="fix-header card-no-border logo-center"  onLoad="setLoadValues()">
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
                        <h5 class="text-themecolor m-b-0 m-t-0">APIUSER EDIT</h5>
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
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/agent_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Retailer List</a>
                                    <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/distributor_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Distributor List</a>
                                      <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/md_list?crypt=".$this->Common_methods->encrypt("MyData"); ?>">MasterDistributor List</a>
                                    
                                    
                                    <span class="breadcrumb-item active">APIUSER EDIT</span>
                                </nav>
                        </div>
                    
                    
           
                    </div>
                    <!-- column -->
                 </div>
                 </div>
                </div>
                <div class="row">
                    
                    <!-- column -->
                    
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <div class="table-responsive">
                                    <div class="panel-body">
                           <form method="post" action="<?php echo base_url()."_Admin/apiuser_edit"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off"> 
                           <input type="hidden" name="hiduserid" id="hiduserid" value="<?php echo $user_id; ?>" /> 
                           <fieldset> 
                           <legend>Personal Information</legend> 
                           <table class="table"> 
                               <tbody> 
                               		<tr> 
                                    	<td><h5>APIUSER Name :</h5>
                                        <input type="text" class="form-control-sm"  value="<?php echo $result_user->row(0)->businessname; ?>" id="txtDistname" name="txtDistname"  maxlength="20" readonly/>
                                         </td> <td align="right"></td><td align="left"> </td>  </tr></tbody> 
                               <tr> 
                                   <td >
                                        <h5> Postal Address :</h5>
                                        <textarea title="Enter Postal Address" id="txtPostalAddr" name="txtPostalAddr" class="form-control-sm"><?php echo $result_user->row(0)->postal_address; ?></textarea> 
                                   </td> 
                                   <td>
                                        <h5>  Pin Code :</h5>
                                        <input type="text" class="form-control-sm" id="txtPin" onKeyPress="return isNumeric(event);" value="<?php echo $result_user->row(0)->pincode; ?>" name="txtPin" maxlength="8" title="Enter Pin Code." /> 
                                   </td> 
                               </tr> 
                               <tr> 
                               	<td>
                                	<h5>State :</h5>
                               		<input type="hidden" name="hidStateCode" id="hidStateCode" /> 
                                    <select class="form-control-sm" id="ddlState" name="ddlState" onChange="getCityName('<?php echo base_url()."_Admin/city/getCity/"; ?>')" >
                                    <option value="0">Select State</option> 
									<?php 
										$str_query = "select * from tblstate order by state_name"; 		
										$result = $this->db->query($str_query);		 		
										for($i=0; $i<$result->num_rows(); $i++) 		
										{ 			
											echo "<option code='".$result->row($i)->codes."' value='".$result->row($i)->state_id."'>".$result->row($i)->state_name."</option>"; } ?> 
                                      </select> 
                                      <input type="hidden" id="hidStateID" value="<?php echo $result_user->row(0)->state_id; ?>" />  
                                      </td> 
                                      <td>
                                      		<h5>City/District :</h5>
                                    		<select class="form-control-sm" id="ddlCity" name="ddlCity" title="Select City.<br />Click on drop down">
                                            <option value="0">Select City</option> 
                                            </select> 
                                            <input type="hidden" id="hidCityID" value="<?php echo $result_user->row(0)->city_id; ?>" />  </td> </tr> 
                               <tr> 
                               		<td>
                                    	<h5>Mobile No :</h5>
                                    	<input type="text" class="form-control-sm"   onKeyPress="return isNumeric(event);"  id="txtMobNo" name="txtMobNo" value="<?php echo $result_user->row(0)->mobile_no; ?>" maxlength="10"/> 
                                    </td> 
                                    <td>
                                    	<h5> Email :</h5>
                                    	<input type="text" class="form-control-sm" id="txtEmail" value="<?php echo $result_user->row(0)->emailid; ?>"  name="txtEmail"  maxlength="150"/>
                                     </td> </tr> 
                               
                               <tr> 
                               		<td>
                                    	<h5>Pan No :</h5>
                                   		<input class="form-control-sm" type="text" name="txtpanNo" id="txtpanNo"  value="<?php echo $result_user->row(0)->pan_no; ?>"/>
                                    </td> 
                                    <td>
                                    <h5> Contact Person :</h5>
                                    <input type="text" class="form-control-sm" id="txtConPer" name="txtConPer" value="<?php echo $result_user->row(0)->contact_person; ?>"  maxlength="150"/> </td> 
                               </tr> 
                           </table> 
                          </fieldset> 
                          <fieldset> 
                          <legend>Response Url</legend> 
                          <table class="table">   
                              <tr>     
                              	<td colspan="2">
                                	<h5>Response Url :</h5>
                                	<input class="form-control-sm" type="text" id="txtRespUrl" style="width:400px;" name="txtRespUrl" value="<?php echo $result_user->row(0)->call_back_url; ?>" />  
                               	</td>     
                                </tr>   
                              <tr>   	
                              <td>
                              		<h5>Ip Address 1</h5>
                              		<input type="text" class="form-control-sm" name="txtIp1" style="width:120px"   value="<?php echo $result_user->row(0)->client_ip; ?>">
                              </td>     
                              <td>
                              		<h5>Ip Address 2</h5>
                                    <input type="text" class="form-control-sm" name="txtIp2" style="width:120px"   value="<?php echo $result_user->row(0)->client_ip2; ?>">
                              </td>     
                              <td>
                              		<h5>Ip Address 3</h5>
                                    <input type="text" class="form-control-sm" name="txtIp3" style="width:120px"   value="<?php echo $result_user->row(0)->client_ip3; ?>">
                              </td>     
                              <td>
                              		<h5>Ip Address 4</h5>
                                    <input type="text" class="form-control-sm" name="txtIp4" style="width:120px"   value="<?php echo $result_user->row(0)->client_ip4; ?>"></td>   </tr>      
                          </table> 
                          </fieldset> 
                          <fieldset> 
                          <legend>Scheme Details</legend> 
                          <table cellpadding="5" cellspacing="0" bordercolor="#f5f5f5" width="80%" border="0">   
                              <tr>    
                               		<td>
                                    	<h5> Scheme :</h5>
                                        <select class="form-control-sm" id="ddlSchDesc"  name="ddlSchDesc">       
                                        	<option>Select Scheme</option>       
											<?php 
											$str_query = "select * from tblgroup where groupfor = 'APIUSER'"; 		
											$resultScheme = $this->db->query($str_query);		 		
											foreach($resultScheme->result() as $row) 		
											{ 			
												echo "<option  value='".$row->Id."'>".$row->group_name."</option>"; 		
											} ?>       
                                            </select>      
                                            <input type="hidden" id="hidScheme" value="<?php echo $result_user->row(0)->scheme_id; ?>" />  
                                      </td>          
                               </tr>   
                              <tr>     <td></td>     <td align="left"><input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Update Details"/>       <input type="reset" class="btn btn-default" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>     <td></td>     <td></td>   </tr>   
                              <tr>     <td colspan="4">The field marked with <span style="color:#F06">*</span> are mandatory.</td>   </tr>    
                          </table> 
                          </fieldset>  
                          </form>
                        </div>
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