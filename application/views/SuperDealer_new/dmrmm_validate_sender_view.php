<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>RETAILER::VALIDATE SENDER REPORT</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
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
    
    <?php include("elements/sdsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/sdsidebar.php"); ?><!-- br-header -->
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
          <span class="breadcrumb-item active"> Sender Registration Validate OTP</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4> Sender Registration Validate OTP</h4>
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
                                <form id="frmsendervalidate" name="frmsendervalidate" method="post" action="<?php echo base_url()."Retailer/dmrmm_validate_sender?idgs=".$this->Common_methods->encrypt("ravikant"); ?>">
                                <input type="hidden" id="hidsession_id" name="hidsession_id" value="<?php echo session_id(); ?>">
                                 <input type="hidden" id="hidaction" name="hidaction">
                                   <table border="0" class="table">
    									<tbody>
    										<tr>
    										<td><strong>Mobile Number:</strong></label></td>
											<td><?php echo $this->session->userdata("SenderMobile");?></td>											
    										</tr>
                                          <tr>
                                            <td style="font-size:18px;font-weight:bold;width:120px;min-width:120px;">Enter OTP:</span></label></td>
                                            <td align="left">
                                            	<input style="width:300px;height:50px;font-size:25px;font-weight:bold" type="text" class="form-control"  id="txtOTP" maxlength="40" name="txtOTP" placeholder="Enter OTP" tabindex="1">
                                               
        									</td>
                                            <td align="right">
                                          <input type="button" class="btn btn-success" value="Submit" id="btnReg" name="btnReg" tabindex="4" onClick="formsubmission()" style="background-color:#BF6000;width:120px;">
                                          <input type="button" class="btn btn-primary" value="Resend OTP" id="btnReseneOtp" name="btnReseneOtp" tabindex="4" onClick="resendotpfun()" style="background-color:#BF6000;width:120px;">
                                          
                                          </td>
                                            
                                          </tr>
                                          
                                          
                                          
                                          
                                          
										</tbody>
									</table>
                                    <script language="javascript">
									function formsubmission()
									{
										
										if(validateotp())
										{
											document.getElementById("hidaction").value = "VALIDATESENDER";
											
											$('.DialogMask').show();
										 $('#myModal').modal({show:true});
										var form=$("#frmsendervalidate");
										document.getElementById('responsespan').innerHTML = "";
										$.ajax({
        										type:"POST",
												url:form.attr("action"),
												data:form.serialize(),
												success: function(response)
												{
													
													var jsonobj = JSON.parse(response);
													var msg = jsonobj.message;
													var sts = jsonobj.status;

													if(sts == 0)
													{
														window.setTimeout(function () {
															location.href = document.getElementById("hidhomeurl").value;
														}, 2000);

													}
													else
													{
														
													}
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = msg;
													
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
											
											
											
											//document.getElementById("frmregister").submit();
										}	
										else
										{
											alert("Please Fill All The Fields");
										}								
									}
									
									
									function validateotp()
									{
										var otp = document.getElementById("txtOTP").value;
										if(otp == "")
										{
											$("#txtOTP").css("background","#ffb7b7");
											$("#txtOTP").addClass("error");
											return false;
										}
										else
										{
											$("#txtOTP").css("background","#FFF");
											$("#txtOTP").removeClass("error");
											return true;
										}
									}
									
									
									function formresnedotp()
									{
										document.getElementById("hidaction").value = "RESENDOTP";
										document.getElementById("frmregister").submit();
									}
									
									</script>
                                </form>
                                
                                 <form id="frmresendotp" name="frmresendotp" action="<?php echo base_url()."Retailer/dmrmm_validate_sender/resendotp"; ?>" method="post">
                               <input type="hidden" id="hidsessionid" name="hidsessionid" value="<?php echo base64_encode(trim($this->session->userdata("session_id"))); ?>"> 
                               
                                </form>
                                
                                <script language="javascript">
									function resendotpfun()
									{
										$('.DialogMask').show();
										 $('#myModal').modal({show:true});
										 document.getElementById('imgloading').style.display = 'block';
										 document.getElementById('spanbtnclode').style.display = 'none';
										 document.getElementById('responsespan').style.display  = 'none';
										var form=$("#frmresendotp");
										document.getElementById('responsespan').innerHTML = "";
										$.ajax({
        										type:"POST",
												url:form.attr("action"),
												data:form.serialize(),
												success: function(response)
												{
													
												//	alert(response);
													document.getElementById('modaltitle').innerHTML = "Response ";
													document.getElementById('spanbtnclode').style.display = 'block';
													document.getElementById('imgloading').style.display = 'none';
													document.getElementById('responsespan').style.display  = 'block';
													document.getElementById('responsespan').innerHTML = response;
													
													$('.DialogMask').hide();
													console.log(response);  
													if(response == "Invalid Login")
													{
														window.setTimeout(function () {
															location.href = document.getElementById("hidredurl").value;
														}, 5000);
													}
													
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
                                  <input type="hidden" id="hidredurl" value="<?php echo base_url()."Retailer/dmrmm_home?idstr=".$this->Common_methods->encrypt("Ravikant") ?>">  
                                  <input type="hidden" id="hidhomeurl" value="<?php echo base_url()."Retailer/dmrmm_dashboard?idstr=".$this->Common_methods->encrypt("Ravikant") ?>">  
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	
      </div><!-- br-pagebody -->
      <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modaltitle">Please wait we process your data.</h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader">
          <img id="imgloading" style="width:120px;" src="<?php echo base_url()."Loading.gif"; ?>"></span>
          <span id="responsespan"  style="display:none;font-weight: bold"></span>
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