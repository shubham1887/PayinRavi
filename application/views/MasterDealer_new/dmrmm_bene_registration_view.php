<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>RETAILER::BENE REGISTRATION</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtBirthDate" ).datepicker({dateFormat:'yy-mm-dd',changeMonth: true,
			changeYear: true,yearRange: "-100:+0"});
         });
});
	
	
	</script>
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    height:1000%;
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
</style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/mdsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/mdheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Retailer/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">BENE REGISTRATION</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>BENE REGISTRATION</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <?php include_once("elements/messagebox.php"); ?>
                                <form id="frmregister" name="frmregister" method="post" action="<?php echo base_url()."Retailer/dmrmm_bene_registration?idgs=".$this->Common_methods->encrypt("ravikant"); ?>" autocomplete="off">
								<input type="hidden" id="hidbankname" name="hidbankname" >
								<input type="hidden" id="hidbankcode" name="hidbankcode" >
									
                                <input type="hidden" id="hidsession_id" name="hidsession_id" value="<?php echo session_id(); ?>">
                                 <input type="hidden" id="hidaction" name="hidformaction">
                                   <table border="0" class="table">
    									<tbody>
                                          
                                           
                                          <tr>
                                            <td style="font-size:14px;font-weight:bold;width:120px;min-width:120px;">Account Number:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:15px;font-weight:bold" type="text" class="form-control"  id="txtAccountNumber" maxlength="40" name="txtAccountNo" placeholder="Enter Account Number"  >
                                                
        									</td>
                                            </tr>
                                           
											
                                          
                                          <tr >
                                            <td style="font-size:14px;font-weight:bold;width:120px;min-width:120px;">Select bank:</span></label></td>
                                            <td align="left">
                                            	<select id="dropdownbank" name="ddlbank" class="form-control" style="width:300px;height:50px;font-size:15px;font-weight:bold" onChange="setifsctotxt()">
                                                <option value="">Select</option>
                                                <?php 
													$rsltbank = $this->db->query("select * from dezire_banklist order by priority desc");
													foreach($rsltbank->result() as $rbank)
													{?>
														<option value="<?php echo $rbank->Id; ?>" ifsc="<?php echo $rbank->ifsc; ?>"><?php echo $rbank->bank_name; ?></option>
													<?php }
													?>                                              
                                                </select>
                                                 <script language="javascript">
    											  function setifsctotxt()
    											  {
    												  var ifsc = $('#dropdownbank option:selected').attr('ifsc');
    												  var bank_name = $("#dropdownbank option:selected").val();
    												  document.getElementById("hidbankname").value = bank_name;
    												  
    												  
    											  	  document.getElementById("txtIfsc").value = ifsc;
    											  }
											  </script> 
        									</td>
                                            <td style="font-size:18px;font-weight:bold;width:120px;min-width:120px;"></span></label></td>
                                            <td align="left">
                                            	
                                                
        									</td>
                                          </tr>
                                          
                                          
                                          
                                          
                                          <tr>
                                            <td style="font-size:15px;font-weight:bold;width:120px;min-width:120px;">IFSC Code :</span></label></td>
                                            <td align="left">
                                            	<input  style="width:300px;height:50px;font-size:15px;font-weight:bold" type="text" class="form-control"  id="txtIfsc" maxlength="11" name="txtIfsc"  placeholder="Enter IFSC"  value="">
                                                
        									</td>
                                            
                                          </tr>
                                          
                                          
                                          <tr>
                                            <td style="font-size:14px;font-weight:bold;width:120px;min-width:120px;">Beneficiary Name:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:15px;font-weight:bold" type="text" class="form-control"  id="txtName" maxlength="40" name="txtbeneName" placeholder="Enter Name" >
                                                
        									</td>
                                           </tr>
                                          <tr>
                                            <td style="font-size:14px;font-weight:bold;width:120px;min-width:120px;">Bene Mobile:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:15px;font-weight:bold" type="text" class="form-control"  id="txtMobile"
                                            	maxlength="10" name="txtMobile" value="<?php echo $this->session->userdata("SenderMobile"); ?>" placeholder="Enter Beneficiary Mobile Number">
                                                
        									</td>
                                          </tr>
                                          
                                          <tr>
                                          
                                          <td colspan="2"  align="left">
                                         
                                          
                                          <input type="button" class="btn btn-success" value="Submit" id="btnReg" name="btnReg"  onClick="bene_registration()" style="background-color:#BF6000;width:120px;">
                                          <input type="button" class="btn btn-primary" value="Cancel" id="btnCancel" name="btnCancel"  tabindex="5" onClick="cancel()">
												 
										<input type="button" class="btn btn-success" value="Verify" id="btnVerify" name="btnVerify" tabindex="5" onClick="validate_bene_name()">
                                          
                                          </td>
                                          </tr>
										</tbody>
									</table>
                                    <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                                    <script language="javascript">
									function cancel()
									{
									    window.setTimeout(function () {
															location.href = document.getElementById("hiddashboardurl").value;
														}, 100);
									}
									function formsubmission()
									{
										if(validatename() & validate_accountnumber()  & validateifsc())
										{
											document.getElementById('modaltitle').innerHTML = "Please Wait.....!! ";
											document.getElementById('spanbtnclode').style.display = 'none';
											document.getElementById('spanloader').style.display = 'block';
											document.getElementById('responsespan').style.display  = 'none';
											document.getElementById('responsespan').innerHTML = "";
											 $('#myModal').modal({show:true});
											
											document.getElementById("hidaction").value = "NewRegistration";
											document.getElementById("frmregister").submit();
										}	
										else
										{
											alert("Please Fill All The Fields");
										}								
									}
									
									
									function validatemobile()
									{
										var mob = document.getElementById("txtMobileNumber").value;
										if(mob == "")
										{
											$("#txtMobileNumber").css("background","#ffb7b7");
											$("#txtMobileNumber").addClass("error");
											return false;
										}
										else
										{
											$("#txtMobileNumber").css("background","#FFF");
											$("#txtMobileNumber").removeClass("error");
											return true;
										}
									}
									function validatename()
									{
										var fname = document.getElementById("txtName").value;
										if(fname == "")
										{
											$("#txtName").css("background","#ffb7b7");
											$("#txtName").addClass("error");
											return false;
										}
										else
										{
											$("#txtName").css("background","#FFF");
											$("#txtName").removeClass("error");
											return true;
										}
									}
									function validate_accountnumber()
									{
										var accnum = document.getElementById("txtAccountNumber").value;
										if(accnum == "")
										{
											$("#txtAccountNumber").css("background","#ffb7b7");
											$("#txtAccountNumber").addClass("error");
											return false;
										}
										else
										{
											$("#txtAccountNumber").css("background","#FFF");
											$("#txtAccountNumber").removeClass("error");
											return true;
										}
									}
									
									function validate_c_accountnumber()
									{
										var caacount_num = document.getElementById("txtCAccountNumber").value;
										if(caacount_num == "")
										{
											$("#txtCAccountNumber").css("background","#ffb7b7");
											$("#txtCAccountNumber").addClass("error");
											return false;
										}
										else
										{
										    if(caacount_num == document.getElementById("txtAccountNumber").value)
										    {
										        $("#txtCAccountNumber").css("background","#FFF");
    											$("#txtCAccountNumber").removeClass("error");
    											return true;
										    }
										    else
										    {
										            $("#txtCAccountNumber").css("background","#ffb7b7");
        											$("#txtCAccountNumber").addClass("error");
        											return false;
										    }
										    
											
										}
									}
									
									function validateaddressone()
									{
										var addrone = document.getElementById("txtTxtAddressOne").value;
										if(addrone == "")
										{
											$("#txtTxtAddressOne").css("background","#ffb7b7");
											$("#txtTxtAddressOne").addClass("error");
											return false;
										}
										else
										{
											$("#txtTxtAddressOne").css("background","#FFF");
											$("#txtTxtAddressOne").removeClass("error");
											return true;
										}
									}
									function validateaddresstwo()
									{
										var addrtwo = document.getElementById("txtTxtAddressTwo").value;
										if(addrtwo == "")
										{
											$("#txtTxtAddressTwo").css("background","#ffb7b7");
											$("#txtTxtAddressTwo").addClass("error");
											return false;
										}
										else
										{
											$("#txtTxtAddressTwo").css("background","#FFF");
											$("#txtTxtAddressTwo").removeClass("error");
											return true;
										}
									}
									
									
									function validateifsc()
									{
										var ifsc = document.getElementById("txtIfsc").value;
										if(ifsc == "")
										{
											$("#txtIfsc").css("background","#ffb7b7");
											$("#txtIfsc").addClass("error");
											return false;
										}
										else
										{
											if(ifsc.length == 11)
											{
											    $("#txtIfsc").css("background","#FFF");
													$("#txtIfsc").removeClass("error");
													return true;
												/*var alphaExp = /^[A-Za-z]{4}\d{7}$/;
            									if(document.getElementById("txtIfsc").value.match(alphaExp))
												{
													$("#txtIfsc").css("background","#FFF");
													$("#txtIfsc").removeClass("error");
													return true;
												}
											   else
											   {
													$("#txtIfsc").css("background","#ffb7b7");
													$("#txtIfsc").addClass("error");
													return false;
											   }*/
												
											}
											else
											{
												$("#txtIfsc").css("background","#ffb7b7");
												$("#txtIfsc").addClass("error");
												return false;
											}
											
										}
									}
								
									
									
									</script>
                                </form>        
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	
      </div><!-- br-pagebody -->
      <script language="javascript">
             function bene_registration()
             {
                 	if(validatename() & validate_accountnumber() & validate_c_accountnumber() & validateifsc())
					{
						bene_registration2();
					}	
					else
					{
						alert("Please Fill All The Fields");
					}	
             }
	
		function bene_registration2()
		{
			$('#myBenedeleteModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("hidaction").value = "BENEREGISTRATION";
			document.getElementById("responsespanfailure_BDEL").style.display = 'none'
			document.getElementById("responsespansuccess_BDEL").style.display = 'none'
			document.getElementById("responsespanotpinput_BDEL").style.display = 'none'
			
			document.getElementById("modelmp_success_msg_BDEL").innerHTML  = "";
			document.getElementById("modelmp_failure_msg_BDEL").innerHTML  = "";
			document.getElementById("modalmptitle_BDEL").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmregister').serialize(),
				method:'POST',
				success:function(data)
				{
			        alert(data);
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						document.getElementById("modalmptitle_BDEL").innerHTML  = msg;
						document.getElementById("responsespansuccess_BDEL").style.display = 'block'
						document.getElementById("modelmp_success_msg_BDEL").innerHTML = msg;
					}
					else
					{
						document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
						document.getElementById("responsespanfailure_BDEL").style.display = 'block'
						document.getElementById("modelmp_failure_msg_BDEL").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
					document.getElementById("responsespanfailure_BDEL").style.display = 'block'
					document.getElementById("modelmp_failure_msg_BDEL").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myBenedeleteModal').modal({show:true});
					
					
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
					
				}
				});
		}
		
	</script>
      

<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-sm">
					  <div class="modal-content">
						<div class="modal-header">
						 <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
						  <h4 class="modal-title" id="modaltitle">Please wait we process your data.</h4>

						</div>
						<div class="modal-body">
						<span id="spanloader">
						  <img style="width:120px" id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>"></span>
						  <span id="responsespan" class="alert alert-primary"  style="font-weight: bold;display:none"></span>
						</div>
						<div class="modal-footer">
						 <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
						</div>
					  </div>
					</div>
				</div>     
<script language="javascript">
             function bene_registration()
             {
                 	if(validatename() & validate_accountnumber() & validateifsc())
					{
						bene_registration2();
					}	
					else
					{
						alert("Please Fill All The Fields");
					}	
             }
	
		function bene_registration2()
		{
			$('#myBenedeleteModal').modal('hide');
			$('#myOverlay').show();
    		$('#loadingGIF').show();
			
			
			document.getElementById("hidaction").value = "BENEREGISTRATION";
			document.getElementById("responsespanfailure_BDEL").style.display = 'none'
			document.getElementById("responsespansuccess_BDEL").style.display = 'none'
			document.getElementById("responsespanotpinput_BDEL").style.display = 'none'
			
			document.getElementById("modelmp_success_msg_BDEL").innerHTML  = "";
			document.getElementById("modelmp_failure_msg_BDEL").innerHTML  = "";
			document.getElementById("modalmptitle_BDEL").innerHTML  = "";
			
			$.ajax({
				url:document.getElementById("hidbregvalurl").value,
				cache:false,
				data:$('#frmregister').serialize(),
				method:'POST',
				success:function(data)
				{
			      //  alert(data);
					//{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
					
					var jsonobj = JSON.parse(data);
					var msg = jsonobj.message;
					var sts = jsonobj.status;
					
					if(sts == 0)
					{
						document.getElementById("modalmptitle_BDEL").innerHTML  = msg;
						document.getElementById("responsespansuccess_BDEL").style.display = 'block'
						document.getElementById("modelmp_success_msg_BDEL").innerHTML = msg;
					}
					else
					{
						document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
						document.getElementById("responsespanfailure_BDEL").style.display = 'block'
						document.getElementById("modelmp_failure_msg_BDEL").innerHTML = msg;
					}
				},
				error:function()
				{
					document.getElementById("modalmptitle_BDEL").innerHTML  = "Bene Registration Failed";
					document.getElementById("responsespanfailure_BDEL").style.display = 'block'
					document.getElementById("modelmp_failure_msg_BDEL").innerHTML = "Internal Server Error. Please try Later..";
				},
				complete:function()
				{
					$('#myOverlay').hide();
    				$('#loadingGIF').hide();
					$('#myBenedeleteModal').modal({show:true});
					
					
					window.setTimeout(function() 
					{
						window.location.href = document.getElementById("hiddashboardurl").value;
					}, 2000);
					
				}
				});
		}
		
	</script>
<script language="javascript">
									function getbeneinfobyifsc()
									{
										$('.DialogMask').show();
										 $('#myModal').modal({show:true});
										var form=$("#frmresendotp");
										var ifsc = document.getElementById("txtIfsc").value;
										
										document.getElementById('imgloading').style.display = 'block';
										document.getElementById('responsespan').innerHTML = "";
										
										
										
										
										
										$.ajax({
        										type:"POST",
												url:document.getElementById("hidbfurl").value+"?ifsc="+ifsc,
												success: function(response)
												{
													document.getElementById('bankdetail').innerHTML = response;
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													
													
													
													$('.DialogMask').hide();
													console.log(response);  
													$('#myModal').modal('hide');
													if(response == "Invalid Login")
													{
														window.setTimeout(function () {
															location.href = document.getElementById("hidredurl").value;
														}, 5000);
													}
													
												},
												error:function(response)
												{
													document.getElementById('bankdetail').innerHTML = response;
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = "Internal Server Error";
													$('.DialogMask').hide();
													$('#myModal').modal('hide');
												}
    										});
									}
									</script>
<input type="hidden" id="hidredurl" value="<?php echo base_url()."Retailer/dmr2_home?idstr=".$this->Common_methods->encrypt("Ravikant") ?>">   
<input type="hidden" id="hidbfurl" value="<?php echo base_url()."Retailer/dmrmm_bene_registration/getbeneinfo"?>">
  <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."Retailer/dmrmm_bene_registration"; ?>">
<!-- verify baneficiary  -->
 <script language="javascript">
									 function validate_bene_name()
									 {
										document.getElementById('modaltitle').innerHTML = "Please Wait.....!! ";
										document.getElementById('spanbtnclode').style.display = 'none';
										document.getElementById('spanloader').style.display = 'block';
										document.getElementById('responsespan').style.display  = 'none';
										document.getElementById('responsespan').innerHTML = "";
										//$('.DialogMask').show();
										$('#myModal').modal({show:true});
										
										document.getElementById("hidaction").value = "BENEVERIFICATION";
										//document.getElementById("hidaccountno").value = document.getElementById("txtAccountNumber").value;
										 
										 
										//document.getElementById("hidifsc").value = document.getElementById("dropdownbank").value;
										// alert("here");
										var form=$("#frmregister");
										document.getElementById('responsespan').innerHTML = "";
										$.ajax({
												type:"POST",
												url:form.attr("action"),
												data:form.serialize(),
												success: function(response)
												{
												   // alert(response);
														var jsonobj = JSON.parse(response);
														var msg = jsonobj.message;
														var sts = jsonobj.status;
														var recipient_name = jsonobj.recipient_name;
													if(recipient_name == "unknown" || recipient_name == "Unknown")
													{

													}
													else
													{
														document.getElementById("txtName").value = recipient_name;
													}
													
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('spanloader').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = msg;

													$('.DialogMask').hide();
													console.log(response);  


												},
												error:function(response)
												{
												   //alert("eror");
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('spanloader').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = "Internal Server Error";
													$('.DialogMask').hide();
												},
											complete:function()
											{
												$('.DialogMask').hide();
											}
											});

									 }
									 </script>

<!-- End Verify Beneficiary -->                                                                           
  <!-- End Verify Beneficiary -->
   <div class="modal fade" id="myBenedeleteModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL"></h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader" style="display:none">
          <img id="imgloading" src="<?php echo base_url()."Loading.gif"; ?>"></span>
          <div id="responsespansuccess_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_success_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanfailure_BDEL" style="display:none">
          		<div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanotpinput_BDEL" style="display:none">
          		<table class="table">
                <tr>
                	<td><label>Enter OTP</label></td>
                	<td>
                    <input type="text" id="hidotpbenedelete" name="hidotp" class="form-control" maxlength="8" onKeyPress="return IsNumeric(event);">
                    </td>
                    <td>
                    <input type="button" id="btnSubmitOtpbenedelete" name="btnSubmitOtp" class="btn btn-success" value="Submit" onClick="validatedeletebene()">
                    </td>
                    
                </tr>
                </table>
          </div>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>   
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
