<!DOCTYPE html>
<html lang="en">
  <head>
		<title>Change Password</title>
		<?php include("elements/linksheader.php"); ?>
        <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	
	</script>
    
   <script>
	$(document).ready(function(){
	//global vars
	var form = $("#frmChangePassword");
	var oldPwd = $("#txtOldPassword");
	var oldPwdInfo = $("#oldpwdInfo");
	var newPwd = $("#txtNewPassword");
	var newPwdInfo = $("#newpwdInfo");
	var cnfPwd = $("#txtCnfPassword");
	var cnfPwdInfo = $("#cnfpwdInfo");	
	oldPwd.focus();
	oldPwd.blur(validatesOld);
	newPwd.blur(validatesNew);
	cnfPwd.blur(validatesCnf);
	form.submit(function(){
		if(validatesOld() & validatesNew() & validatesCnf())
			{				
			return true;
			}
		else
			return false;
	});
	function validatesOld(){
		if(oldPwd.val() == ""){
			oldPwd.addClass("error");
			oldPwdInfo.text("");
			return false;
		}
		else{
			oldPwd.removeClass("error");
			oldPwdInfo.text("");
			return true;
		}
	}
	function validatesNew(){
		if(newPwd.val() == ""){
			newPwd.addClass("error");
			newPwdInfo.text("");
			return false;
		}
		else{
			newPwd.removeClass("error");
			newPwdInfo.text("");
			return true;
		}
	}
	function validatesCnf(){
		if(cnfPwd.val() == ""){
			cnfPwd.addClass("error");
			cnfPwdInfo.text("");
			return false;
		}
		if(cnfPwd.val() != newPwd.val())
		{
			cnfPwd.addClass("error");
			cnfPwdInfo.text("New password and confirm password does not match.");
			return false;
		}
		else{
			cnfPwd.removeClass("error");
			cnfPwdInfo.text("");
			return true;
		}
	}	
	setTimeout(function(){$('div.message').fadeOut(1000);}, 2000);
	
});
	</script>
    </head><body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/distsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/distheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## ---><div class="br-mainpanel">
					  <div class="br-pageheader">
						<nav class="breadcrumb pd-0 mg-0 tx-12">
						  <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>
						  <span class="breadcrumb-item active">CHANGE PASSWORD</span>
						</nav>
					  </div><!-- br-pageheader -->
					  <!-- d-flex -->
					   
      				 <div class="br-pagebody">
						<?php include("elements/messagebox.php"); ?>
						 <div class="row row-sm mg-t-20">
									  <div class="col-sm-12 col-lg-12">
										<div class="card shadow-base bd-0">
										  <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
											<h6 class="card-title tx-uppercase tx-12 mg-b-0">CHANGE PASSWORD FORM</h6>
											<span class="tx-12 tx-uppercase">
												
											
											</span>
										  </div><!-- card-header -->
										  <div class="card-body">
                                          
									 <form role="form" method="post" action="<?php echo base_url()."Distributor/change_password"; ?>">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <label>OLD PASSWORD</label>
                                            <input class="form-control" id="txtOldPassword" name="txtOldPassword" type="password" style="width:120px;" placeholder="Old Password">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>NEW PASSWORD</label>
                                            <input class="form-control" id="txtNewPassword" name="txtNewPassword" type="password" style="width:120px;" placeholder="NEW PASSWORD">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>CONFIRM PASSWORD</label>
                                             <input class="form-control" id="txtCNewPassword" name="txtCNewPassword" type="password" style="width:120px;" placeholder="CONFIRM PASSWORD">
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        <button type="reset" class="btn btn-success">Reset Button</button>
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
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