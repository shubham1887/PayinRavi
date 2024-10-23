<!DOCTYPE html>
<html lang="en">
  <head>
		<title><?php echo $this->session->userdata("txtPageTitle"); ?></title>
		<?php include("elements/linksheader.php"); ?><link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	  <script type="text/javascript" language="javascript">					
		function getCityName(urlToSend)
	{
		if(document.getElementById('ddlState').selectedIndex != 0)
		{				
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
    </head><body  onLoad="setLoadValues()">
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
						  <a class="breadcrumb-item" href="#">Users</a>
						  <span class="breadcrumb-item active">User Registration</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
						<?php include("elements/messagebox.php"); ?>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Registration Form</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">
                                        	 <form method="post" action="<?php echo base_url()."_Admin/User_edit"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off"> 
                           <input type="hidden" name="hiduserid" id="hiduserid" value="<?php echo $result_user->row(0)->user_id; ?>" /> 
                           <fieldset> 
                           
                           <table class="table table-bordered table-striped" style="color:#00000E">
                               
                               		<tr> 
                                    	<td><h5>APIUSER Name :</h5>
                                        <input type="text" class="form-control-sm"  value="<?php echo $result_user->row(0)->businessname; ?>" id="txtDistname" name="txtDistname"  maxlength="20" readonly/>
                                         </td> 
                                         <td align="right"></td>
                                         
                                      </tr>
                                         
                                
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
                                    	<h5>Mobile No :</h5>
                                    	<input type="text" class="form-control-sm"   onKeyPress="return isNumeric(event);"  id="txtMobNo" name="txtMobNo" value="<?php echo $result_user->row(0)->mobile_no; ?>" maxlength="10"/> 
                                    </td> 
                                    <td>
                                    	<h5> Email :</h5>
                                    	<input type="text" class="form-control-sm" id="txtEmail" value="<?php echo $result_user->row(0)->emailid; ?>"  name="txtEmail"  maxlength="150"/>
                                     </td> </tr><tr> 
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
											echo "<option value='".$result->row($i)->Id."'>".$result->row($i)->state_name."</option>"; } ?> 
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
                         <table class="table table-bordered table-striped" style="color:#00000E">
                              <tr>     
                              	<td colspan="4">
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
                         <table class="table table-bordered table-striped" style="color:#00000E">
                              <tr>    
                               		<td>
                                    	<h5> Scheme :</h5>
                                        <select class="form-control-sm" id="ddlSchDesc"  name="ddlSchDesc">       
                                        	<option>Select Scheme</option>       
											<?php 
											$str_query = "select * from mt3_group"; 		
											$resultScheme = $this->db->query($str_query);		 		
											foreach($resultScheme->result() as $row) 		
											{ 			
												echo "<option  value='".$row->Id."'>".$row->Name."</option>"; 		
											} ?>       
                                            </select>      
                                            <input type="hidden" id="hidScheme" value="<?php echo $result_user->row(0)->dmr_group; ?>" />  
                                      </td>
                                      <td></td>          
                                      <td></td>          
                                      <td></td>          
                               </tr>   
                              <tr>     
                              <td></td>     
                              <td align="left"><input type="submit" style="width:140px" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Update Details"/>       
                              <input type="reset" class="btn btn-default" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>     
                              <td></td>     
                              <td></td>   
                              </tr>   
                              <tr>     
                              <td colspan="4">The field marked with <span style="color:#F06">*</span> are mandatory.</td>   </tr>    
                          </table> 
                          </fieldset>  
                          </form>
										  
										  
										  </div>
            									</div>
        								</div>
									</div><!-- end <div class=row -->
								</div><!-- br-pagebody -->
      	<?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
	
	
	<!-- ########## END: MAIN PANEL ########## -->
	
	
	
	

    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>

    <script src="<?php echo base_url();?>js/bracket.js"></script>
  </body>
</html>
	
	<!-------------------------------------- DELETE MODEL START ----------------------->								
								<div id="modal-formdelete" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Are You Soure Want To Delete <span id="spanDeletePopupName"></span></h4>
											</div>
											<div class="modal-footer">
												<button class="btn btn-sm" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													Cancel
												</button>

												<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="deletesubmit()">
													<i class="ace-icon fa fa-check"></i>
													Yes
												</button>
												<script language="javascript">
													function deletesubmit()
													{
														document.getElementById("HIDACTION").value="DELETE";
														document.getElementById("frmPopup").submit();
													}
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------><!-------------------------------------- INSERT EDIT MODEL START ----------------------->								
								<div id="modal-form" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Please fill the following form fields</h4>
											</div>

											<div class="modal-body">
												<div class="row">
													
													<div class="col-xs-12 col-sm-7">
													<?php echo form_open('',array('id'=>"frmPopup",'method'=>'post'))?>
												
													<input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
													
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">UserId</label>
																            <div>
																	            <input type="text" name="txtUserId" id="txtUserId" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Name</label>
																            <div>
																	            <input type="text" name="txtName" id="txtName" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Mobile</label>
																            <div>
																	            <input type="text" name="txtMobile" id="txtMobile" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Email</label>
																            <div>
																	            <input type="text" name="txtEmail" id="txtEmail" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
																        <input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																        <div class="form-group">
																            <label for="form-field-select-3">Address</label>
																            <div>
																	            <input type="text" name="txtAddress" id="txtAddress" class="form-control">
																            </div>
															            </div>
															            <div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">State</label>
																<div>
																	<select name="txtState" id="txtState" class="form-control">
																	<option value="0">Select</option><?php 
																$qry = "select * from tblstate";
																	$rsltddl6 = $this->db->query($qry);
																	foreach($rsltddl6->result() as $rdd)
																	{?>
																		<option value="<?php echo $rdd->Id?>"><?php echo $rdd->state_name?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">City</label>
																<div>
																	<select name="txtCity" id="txtCity" class="form-control">
																	<option value="0">Select</option>
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
															
																<div class="form-group">
																<label for="form-field-select-3">Group</label>
																<div>
																	<select name="txtGroup" id="txtGroup" class="form-control">
																	<option value="0">Select</option><?php 
																$qry = "select * from mt3_group";
																	$rsltddl8 = $this->db->query($qry);
																	foreach($rsltddl8->result() as $rdd)
																	{?>
																		<option value="<?php echo $rdd->Id?>"><?php echo $rdd->Name?></option>
																	<?php } ?>
																	
																	</select>
																	
																</div>
															</div>
															<div class="space-4"></div>
														<?php echo form_close();?>
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
													document.getElementById("frmPopup").submit();
												}
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
<!----------xxxxxxxxxxxxxxxxxxx INSERT EDIT MODEL END   xxxxxxxxxxxxxxxxxx------------>	