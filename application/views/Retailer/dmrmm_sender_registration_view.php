<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>RETAILER::DMRMM REGISTRATION</title>

    
     
    
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
    
    <?php include("elements/agentsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/agentheader.php"); ?><!-- br-header -->
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
          <span class="breadcrumb-item active">Money Transfer</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Money Transfer</h4>
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
                                <form id="frmregister" name="frmregister" method="post" action="<?php echo base_url()."Retailer/dmrmm_sender_registration?idgs=".$this->Common_methods->encrypt("ravikant"); ?>">
                                <input type="hidden" id="hidsession_id" name="hidsession_id" value="<?php echo $this->session->userdata("session_id"); ?>">
                                 <input type="hidden" id="hidaction" name="hidaction">
                                   <table border="0" class="table">
    									<tbody>
                                          <tr>
                                            <td style="font-size:14px;font-weight:bold;">First Name:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:25px;font-weight:bold" type="text" class="form-control"  id="txtFirstName" maxlength="40" name="txtFirstName" value="<?php echo $txtFirstName;  ?>" placeholder="Enter First Name">
        									</td>
                                            
                                          </tr>
                                          <tr>
                                            <td style="font-size:14px;font-weight:bold;">Last Name:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:25px;font-weight:bold" type="text" class="form-control"  id="txtLastName" maxlength="40" name="txtLastName" value="<?php echo $txtFirstName;  ?>" placeholder="Enter Last Name">
        									</td>
                                            
                                          </tr>
                                         
                                           <tr>
                                            <td style="font-size:14px;font-weight:bold;">Pincode:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:25px;font-weight:bold" type="text" class="form-control"  id="txtPincode" maxlength="40" name="txtPincode" value="<?php echo $txtFirstName;  ?>" placeholder="Enter Area Pincode">
        									</td>
                                            
                                          </tr>
                                          <tr>
                                            
                                            <td style="font-size:14px;font-weight:bold">Mobile Number:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:25px;font-weight:bold" type="text" class="form-control"  id="txtMobileNumber" maxlength="40" name="txtMobileNumber" value="<?php echo $txtMobileNumber;  ?>"  placeholder="Enter Mobile Number">
                                                
        									</td>
                                          </tr>
                                          
                                          <tr>
                                          
                                          <td colspan="2" align="middle">
                                          <input type="button" class="btn btn-success" value="Submit" id="btnReg" name="btnReg"   onClick="formsubmission()" style="background-color:#BF6000;width:220px;">
                                          
                                          </td>
                                          </tr>
										</tbody>
									</table>
                                    <script language="javascript">
									function formsubmission()
									{
										if(validatemobile() & validatefname() & validatepincode() )
										{
										
											document.getElementById("hidaction").value = "Registration";
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
									function validatepincode()
									{
										var pin = document.getElementById("txtPincode").value;
										if(pin == "")
										{
											$("#txtPincode").css("background","#ffb7b7");
											$("#txtPincode").addClass("error");
											return false;
										}
										else
										{
											$("#txtPincode").css("background","#FFF");
											$("#txtPincode").removeClass("error");
											return true;
										}
									}
									function validatefname()
									{
										var fname = document.getElementById("txtFirstName").value;
										if(fname == "")
										{
											$("#txtFirstName").css("background","#ffb7b7");
											$("#txtFirstName").addClass("error");
											return false;
										}
										else
										{
											$("#txtFirstName").css("background","#FFF");
											$("#txtFirstName").removeClass("error");
											return true;
										}
									}
									
									
									function newregsubmit()
									{
										document.getElementById("hidaction").value = "NewRegistration";
										document.getElementById("frmloginforremitance").submit();
									}
									
									</script>
                                    <script language="javascript">
									function resendotpfun()
									{
										$('.DialogMask').show();
										 $('#myModal').modal({show:true});
										var form=$("#frmresendotp");
										document.getElementById('responsespan').innerHTML = "";
										$.ajax({
        										type:"POST",
												url:form.attr("action"),
												data:form.serialize(),
												success: function(response)
												{
													
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = response;
													
													$('.DialogMask').hide();
													console.log(response);  
												},
												error:function(response)
												{
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = "Internal Server Error";
													$('.DialogMask').hide();
												}
    										});
									}
									</script>
                                </form>
                                <form id="frmresendotp" name="frmresendotp" action="<?php echo base_url()."Retailer/dmrmm_sender_registration/resendotp"; ?>" method="post">
                                    <input type="hidden" id="hidsessionid" name="hidsessionid" value="<?php echo base64_encode(trim($this->session->userdata("session_id"))); ?>"> 
                                    <input type="hidden" id="hidmobileno" name="hidmobileno" value="<?php echo base64_encode(trim($txtMobileNumber)); ?>">
                                </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	
      </div><!-- br-pagebody -->
      
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
<div class="modal fade" id="myModal" role="dialog">
			        <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modaltitle">Please wait we process your data.</h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader">
          <img id="imgloading" src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <span id="responsespan" class="btn btn-warning" style="display:none"></span>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div> 
      </div>
    </div>
                </div>
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