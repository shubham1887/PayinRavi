<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Admin Information</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	
	
	document.getElementById("ddlpaymenttype").value = '<?php echo $ddlpaymenttype; ?>';
	document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
	
 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	

	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFromDate").value;
		var to = document.getElementById("txtToDate").value;
		var db = document.getElementById("ddldb").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("hiddb").value = db;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
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
          <span class="breadcrumb-item active">ADMIN INFORMATION</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ADMIN INFORMATION 1</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form role="form" method="post" action="<?php echo base_url()."_Admin/admin_info" ?>">
                           <input type="hidden" id="hidID" name="hidID">
                                  <table class="table table-striped .table-bordered border" style="color:#000000;font-size:14px;font-family:sans-serif">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <h5>Customer Care</h5>
                                            <input class="form-control-sm" id="txtCustomerCare" name="txtCustomerCare" type="text" maxlength="12" style="width:120px;" value="<?php echo $CustomerCare; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Email Address</h5>
                                            <input class="form-control-sm" id="txtEmail" name="txtEmail" type="text" style="width:220px;" value="<?php echo $EmailId; ?>" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Office Address</h5>
                                             <textarea class="form-control-sm" id="txtOfficeAddress" name="txtOfficeAddress" type="text" rows="5" style="width:100%" ><?php echo $OfficeAddress; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Company Info</h5>
                                             <textarea class="form-control-sm" id="txtCompanyInfo" name="txtCompanyInfo" type="text" rows="5" style="width:100%" ><?php echo $CompanyInfo; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Alert Message</h5>
                                             <textarea class="form-control-sm" id="txtMessage" name="txtMessage" type="text" rows="5" style="width:100%" ><?php echo $Message; ?></textarea>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Show Template</h5>
                                        	 <?php $checked = "";if($show_template == 'yes'){$checked="checked";} ?>
                                             <input <?php echo $checked; ?> type="checkbox" id="chkshowtemplate" name="chkshowtemplate" value="yes">Show Template
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>Template Id</h5>
                                             <select id="ddltemplate" name="ddltemplate" class="form-control">
                                                 <option value="0"></option>
                                                 <?php
                                                    $rsltemplate_rslt = $this->db->query("select Id,Name from tbltemplates order by Name");
                                                    foreach($rsltemplate_rslt->result() as $rw)
                                                    {?>
                                                        <option value="<?php echo $rw->Id; ?>"><?php echo $rw->Name; ?></option>
                                                    <?php }
                                                 ?>
                                             </select>
                                             <script language="javascript">document.getElementById("ddltemplate").value = '<?php echo $template_id; ?>';</script>
                                        </td>
                                    </tr>
                                    
                                    
                                     <tr>
                                        <td style="padding-right:10px;">
                                        	 <h5>MPLAN KEY</h5>
                                             <textarea class="form-control-sm" id="txtMplanKey" name="txtMplanKey" type="text" rows="5" style="width:100%" ><?php echo $MplanKey; ?></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="padding-right:10px;">
                                           <h5>UPI ID</h5>
                                             <textarea class="form-control-sm" id="txtUPI_ID" name="txtUPI_ID" type="text" rows="5" style="width:100%" ><?php echo $UPI_ID; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-right:10px;">
                                           <h5>UPI PARTY NAME</h5>
                                             <textarea class="form-control-sm" id="txtUPI_PARTYNAME" name="txtUPI_PARTYNAME" type="text" rows="5" style="width:100%" ><?php echo $UPI_PARTY_NAME; ?></textarea>
                                        </td>
                                    </tr>













                                    <tr>
                                        <td style="padding-right:10px;">
                                           <h5>Stop Success Recharge Reroot ?</h5>
                                           <?php $checked_ssrr = "";if($stop_success_recharge_reroot == 'yes'){$checked_ssrr="checked";} ?>
                                             <input <?php echo $checked_ssrr; ?> type="checkbox" id="chkstop_success_recharge_reroot" name="chkstop_success_recharge_reroot" value="yes">
                                        </td>
                                    </tr>










                                    
                                    <tr>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        
                                        </td>
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
