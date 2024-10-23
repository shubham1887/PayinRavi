<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>SMS Templates</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
});
	</script>
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
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Manage Users</a>
          <span class="breadcrumb-item active">SMS TEMPLATES</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>SMS TEMPLATES</h4>
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
              <div class="card-body col-sm-8">
                  <?php
                
                
                 ///////////////////////////////
                 ///// REGISTRATION TEMPLATE
                 ///////////////////////////////////
                  $is_sms_REGISTRATION = $REGISTRATION->row(0)->is_sms;
                  $is_notification_REGISTRATION = $REGISTRATION->row(0)->is_notification;
                  $str_template_REGISTRATION = $REGISTRATION->row(0)->str_template;
                  
                  if($is_sms_REGISTRATION == "yes")
                  {$is_sms_REGISTRATION = "checked";}else{ $is_sms_REGISTRATION = ""; }
                  if($is_notification_REGISTRATION == "yes")
                  {$is_notification_REGISTRATION = "checked";}else{ $is_notification_REGISTRATION = ""; }
                  
                  
                  ///////////////////////////////
                 ///// BALANCE ADD TEMPLATE
                 ///////////////////////////////////
                  $is_sms_BALANCE_ADD = $BALANCE_ADD->row(0)->is_sms;
                  $is_notification_BALANCE_ADD = $BALANCE_ADD->row(0)->is_notification;
                  $str_template_BALANCE_ADD = $BALANCE_ADD->row(0)->str_template;
                  
                  if($is_sms_BALANCE_ADD == "yes")
                  {$is_sms_BALANCE_ADD = "checked";}else{ $is_sms_BALANCE_ADD = ""; }
                  if($is_notification_BALANCE_ADD == "yes")
                  {$is_notification_BALANCE_ADD = "checked";}else{ $is_notification_BALANCE_ADD = ""; }
                  
                  
                  ///////////////////////////////
                 ///// BALANCE REVERT TEMPLATE
                 ///////////////////////////////////
                  $is_sms_BALANCE_REVERT = $BALANCE_REVERT->row(0)->is_sms;
                  $is_notification_BALANCE_REVERT = $BALANCE_REVERT->row(0)->is_notification;
                  $str_template_BALANCE_REVERT = $BALANCE_REVERT->row(0)->str_template;
                  
                  if($is_sms_BALANCE_REVERT == "yes")
                  {$is_sms_BALANCE_REVERT = "checked";}else{ $is_sms_BALANCE_REVERT = ""; }
                  if($is_notification_BALANCE_REVERT == "yes")
                  {$is_notification_BALANCE_REVERT = "checked";}else{ $is_notification_BALANCE_REVERT = ""; }
                  
                  
                  ///////////////////////////////
                 ///// DMR BALANCE ADD TEMPLATE
                 ///////////////////////////////////
                  $is_sms_DMRBALANCE_ADD = $DMRBALANCE_ADD->row(0)->is_sms;
                  $is_notification_DMRBALANCE_ADD = $DMRBALANCE_ADD->row(0)->is_notification;
                  $str_template_DMRBALANCE_ADD = $DMRBALANCE_ADD->row(0)->str_template;
                  
                  if($is_sms_DMRBALANCE_ADD == "yes")
                  {$is_sms_DMRBALANCE_ADD = "checked";}else{ $is_sms_DMRBALANCE_ADD = ""; }
                  if($is_notification_DMRBALANCE_ADD == "yes")
                  {$is_notification_DMRBALANCE_ADD = "checked";}else{ $is_notification_DMRBALANCE_ADD = ""; }
                  
                  
                  
                   ///////////////////////////////
                 ///// DMR BALANCE REVERT TEMPLATE
                 ///////////////////////////////////
                  $is_sms_DMRBALANCE_REVERT = $DMRBALANCE_REVERT->row(0)->is_sms;
                  $is_notification_DMRBALANCE_REVERT = $DMRBALANCE_REVERT->row(0)->is_notification;
                  $str_template_DMRBALANCE_REVERT = $DMRBALANCE_REVERT->row(0)->str_template;
                  
                  if($is_sms_DMRBALANCE_REVERT == "yes")
                  {$is_sms_DMRBALANCE_REVERT = "checked";}else{ $is_sms_DMRBALANCE_REVERT = ""; }
                  if($is_notification_DMRBALANCE_REVERT == "yes")
                  {$is_notification_DMRBALANCE_REVERT = "checked";}else{ $is_notification_DMRBALANCE_REVERT = ""; }
                  
                 ///////////////////////////////
                 ///// OTP TEMPLATE
                 ///////////////////////////////////
                  $is_sms_OTP = $OTP->row(0)->is_sms;
                  $is_notification_OTP = $OTP->row(0)->is_notification;
                  $str_template_OTP = $OTP->row(0)->str_template;
                  
                  if($is_sms_OTP == "yes")
                  {$is_sms_OTP = "checked";}else{ $is_sms_OTP = ""; }
                  if($is_notification_OTP == "yes")
                  {$is_notification_OTP = "checked";}else{ $is_notification_OTP = ""; }
                  
                  
                  
                  ?>
                  
                  <form role="form" method="post" action="<?php echo base_url()."_Admin/Sms_template" ?>">
                           <input type="hidden" id="hidID" name="hidID">
                                  <table class="table table-borderless" style="color:#000000;font-size:14px;font-family:sans-serif">
                                    <tr>
                                        <td valign="middle" align="right">Registration SMS</td>
                                    	<td>
                                        	<textarea class="text" id="txtREGISTRATION" name="txtREGISTRATION" rows="4" cols="50" ><?php echo $str_template_REGISTRATION; ?></textarea>
                                        	<p>template Fields : @username, @password,@pin, @websiteurl, @websitename,<br> @retailername, @passcode</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_REGISTRATION" name="chkis_sms_REGISTRATION" value="yes" <?php echo $is_sms_REGISTRATION; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_REGISTRATION" name="chkis_notification_REGISTRATION" value="yes" <?php echo $is_notification_REGISTRATION; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="right">Balance Topup SMS</td>
                                    	<td>
                                        	<textarea class="text" id="txtBALANCE_ADD" name="txtBALANCE_ADD" rows="4" cols="50"><?php echo $str_template_BALANCE_ADD; ?></textarea>
                                        	<p>Template Fields : @amt, @datetime, @websitename,<br> @retailerbalance, @retailername, @wallettype</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_BALANCE_ADD" name="chkis_sms_BALANCE_ADD" value="yes" <?php echo $is_sms_BALANCE_ADD; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_BALANCE_ADD" name="chkis_notification_BALANCE_ADD" value="yes" <?php echo $is_notification_BALANCE_ADD; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="right">Balance Revert SMS</td>
                                    	<td>
                                        	<textarea class="text" id="txtBALANCE_REVERT" name="txtBALANCE_REVERT" rows="4" cols="50"><?php echo $str_template_BALANCE_REVERT; ?></textarea>
                                        	<p>Template Fields : @amt, @datetime, @websitename,<br> @retailerbalance, @retailername, @wallettype</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_BALANCE_REVERT" name="chkis_sms_BALANCE_REVERT" value="yes" <?php echo $is_sms_BALANCE_REVERT; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_BALANCE_REVERT" name="chkis_notification_BALANCE_REVERT" value="yes" <?php echo $is_notification_BALANCE_REVERT; ?>>
                                        </td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <td valign="middle" align="right">DMR Balance Topup SMS</td>
                                    	<td>
                                        	<textarea class="text" id="txtDMRBALANCE_ADD" name="txtDMRBALANCE_ADD" rows="4" cols="50"><?php echo $str_template_DMRBALANCE_ADD; ?></textarea>
                                        	<p>Template Fields : @amt, @datetime, @websitename,<br> @retailerbalance, @retailername, @wallettype</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_DMRBALANCE_ADD" name="chkis_sms_DMRBALANCE_ADD" value="yes" <?php echo $is_sms_DMRBALANCE_ADD; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_DMRBALANCE_ADD" name="chkis_notification_DMRBALANCE_ADD" value="yes" <?php echo $is_notification_DMRBALANCE_ADD; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="right">DMR Balance Revert SMS</td>
                                    	<td>
                                        	<textarea class="text" id="txtDMRBALANCE_REVERT" name="txtDMRBALANCE_REVERT" rows="4" cols="50"><?php echo $str_template_DMRBALANCE_REVERT; ?></textarea>
                                        	<p>Template Fields : @amt, @datetime, @websitename, <br> @retailerbalance, @retailername, @wallettype</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_DMRBALANCE_REVERT" name="chkis_sms_DMRBALANCE_REVERT" value="yes" <?php echo $is_sms_DMRBALANCE_REVERT; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_DMRBALANCE_REVERT" name="chkis_notification_DMRBALANCE_REVERT" value="yes" <?php echo $is_notification_DMRBALANCE_REVERT; ?>>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="middle" align="right">OTP</td>
                                    	<td>
                                        	<textarea class="text" id="txtOTP" name="txtOTP" rows="4" cols="50"><?php echo $str_template_OTP; ?></textarea>
                                        	<p>Template Fields : @otp, @validseconds, @reason</p>
                                        </td>
                                        <td><label>Is Sms</label>
                                            <input type="checkbox" id="chkis_sms_OTP" name="chkis_sms_OTP" value="yes" <?php echo $is_sms_OTP; ?>>
                                        </td>
                                        <td><label>Is Notification</label>
                                            <input type="checkbox" id="chkis_notification_OTP" name="chkis_notification_OTP" value="yes" <?php echo $is_notification_OTP; ?>>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
									
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	
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
