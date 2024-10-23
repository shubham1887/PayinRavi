<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RETAILER::VALIDATE SENDER REPORT</title>
      <?php include("files/links.php"); ?>
    <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	
	</script>
</head>
<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->
        <!-- navbar side -->
       <?php include("files/agentheader.php"); ?> 
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <?php include("files/agentsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH RECHARGE
                            
                        </div>
                        <div class="panel-body">
                          <?php include_once("files/messagebox.php"); ?>
                                <form id="frmsendervalidate" name="frmsendervalidate" method="post" action="<?php echo base_url()."Retailer/dmr_validate_sender?idgs=".$this->Common_methods->encrypt("ravikant"); ?>">
                                <input type="hidden" id="hidsession_id" name="hidsession_id" value="<?php echo session_id(); ?>">
                                 <input type="hidden" id="hidaction" name="hidaction">
                                   <table border="0" class="table">
    									<tbody>
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
                                
                                 <form id="frmresendotp" name="frmresendotp" action="<?php echo base_url()."Retailer/dmr2_validate_beneficiary/resendotp"; ?>" method="post">
                               <input type="hidden" id="hidsessionid" name="hidsessionid" value="<?php echo base64_encode(trim($this->session->userdata("session_id"))); ?>"> 
                               
                                </form>
                                
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
                                  <input type="hidden" id="hidredurl" value="<?php echo base_url()."Retailer/dmr_home?idstr=".$this->Common_methods->encrypt("Ravikant") ?>">  
                                  <input type="hidden" id="hidhomeurl" value="<?php echo base_url()."Retailer/dmr_dashboard?idstr=".$this->Common_methods->encrypt("Ravikant") ?>">  
                        </div>
                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
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
          <span id="responsespan"  style="display:none;font-weight: bold"></span>
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>

        </div>
        <!-- end page-wrapper -->
    </div>
    <!-- end wrapper -->
    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>
</html>
