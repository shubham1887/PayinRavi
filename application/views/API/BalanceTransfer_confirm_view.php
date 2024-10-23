<!DOCTYPE html>
<html lang="en">
  <head>
		<title>Confirm Balance Transfer</title>
		<?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
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
    </head>
<body>
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
						  <span class="breadcrumb-item active">Balance Transfer</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
						<?php include("elements/messagebox.php"); ?>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">Balance Transfer Form</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">
                                        	 <form method="post" action="<?php echo base_url()."_Admin/BalanceTransfer"?>" name="frmdistributer_form1" id="frmdistributer_form1" autocomplete="off"> 
                           <input type="hidden" name="hiduserid" id="hiduserid" value="<?php echo $this->Common_methods->encrypt($result_user->row(0)->user_id); ?>" /> 
                           <input type="hidden" name="encr_hiduserid" id="encr_hiduserid" value="<?php echo $encryptedid; ?>" /> 
                           <input type="hidden" name="encryptedamount" id="encryptedamount" value="<?php echo $encryptedamount; ?>" />
                           <input type="hidden" name="encryptedremark" id="encryptedremark" value="<?php echo $encryptedremark; ?>" /> 
                           
                           <fieldset> 
                           
                           <table class="table table-bordered table-striped" style="color:#00000E">
                               
                               		<tr> 
                                    	<td><label>APIUSER Name :</label>
                                        	<?php echo $result_user->row(0)->businessname; ?>
                                         </td> 
                                         <td>
                                    		<label>Mobile No :</label>
                                    		<?php echo $result_user->row(0)->mobile_no; ?>
                                    	</td> 
                                    </tr>
                                    <tr> 
                                    	<td><label>EmailId :</label>
                                        	<?php echo $result_user->row(0)->emailid; ?>
                                         </td> 
                                         <td>
                                    		<label>Balance :</label>
                                    		<?php echo 0; ?>
                                    	</td> 
                                    </tr>
                                    
                               
                               		<tr> 
                                        <td>
                                            <label> Amount :</label>
                                            <?php echo $amount; ?>
                                        </td> 
                                        <td>
                                            <label> Remark :</label>
                                            <?php echo $remark; ?>
                                        </td>
                                        
                                    </tr>
                                    <tr> 
                                        <td colspan="2">
                                            <label> Amount In Words :</label>
                                            <?php echo $amountinwords; ?>
                                        </td> 
                                        
                                        
                                    </tr>
                                    <tr> 
                                        <td colspan="2">
                                        	<input type="submit" id="btnSubmit" name="btnSubmit" value="Confirm" class="btn btn-success" style="width:200px;"> 
                                            <input type="button" id="btnCancel" name="btnCancel" value="Back" class="btn btn-default" style="width:160px;"> 
                                        </td>
                               		</tr> 
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