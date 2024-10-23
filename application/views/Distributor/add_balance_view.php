<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Balance Transfer</title>

    
     
    
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
	
	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
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
    
    <?php include("elements/distsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/distheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Distributor/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">Balance Transfer</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Balance Transfer</h4>
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
                  <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($userinfo))
	{
	if($userinfo->num_rows() == 1)
	{
	?>    
    <fieldset>
    <form id="frmaddbal" name="frmaddbal" method="post" action="<?php echo base_url()."Distributor/add_balance?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                	  <input type="hidden" id="hidid" name="hidid" value="<?php echo $userinfo->row(0)->user_id; ?>">
					
                	  <table style="width:450px">
                                    <tr>
                                    	<td style="padding-right:10px;" align="right">Agent Name :</td>
                                        	 <td>
                                           	<span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->businessname; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">AgentId</td>
                                        	 <td>
                                            <span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->username; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	Current  Balance</td>
                                        	 <td>
                                             <span style="font-weight:bold;color:#000000">
											 	<?php 
												$this->load->model("Common_methods");
												echo $this->Common_methods->getAgentBalance($userinfo->row(0)->user_id); ?>
                                             </span>
                                        </td>
                                      </tr>
                                      <tr>
                                       <td style="padding-right:10px;"  align="right">
                                        	 Action</td>
                                        	 <td>
                                            <select id="ddlaction" name="ddlaction" class="form-control" style="width:200px">
                                                <option value="ADD">ADD</option>
                                                <option value="REVERT">REVERT</option>
											</select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Amount</td>
                                        	 <td>
                                            <input type="text" id="txtAmount" name="txtAmount" style="width:200px" class="form-control" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Remark</td>
                                        	 <td>
                                            <input type="text" id="txtRemark" name="txtRemark" style="width:200px" class="form-control" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        	 <td> 
                                        	<input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" value="Submit" onClick="validateandsubmit()">
                                        </td>
                                     
                                    </tr>
                                    </table>
                </form>
                <script language="javascript">
				function validateandsubmit()
				{
					if(validateamount() & validateremark())
					{
						document.getElementById("frmaddbal").submit();
					}
				}
				function validateamount()
				{
					var amt = document.getElementById("txtAmount").value;
					if(amt == "")
					{
						$("#txtAmount").addClass("error");
						return false;
					}
					else
					{
						$("#txtAmount").removeClass("error");
						return true;
					}
				}
				function validateremark()
				{
					var remark = document.getElementById("txtRemark").value;
					if(remark == "")
					{
						$("#txtRemark").addClass("error");
						return false;
					}
					else
					{
						$("#txtRemark").removeClass("error");
						return true;
					}
				}
				</script>
        </fieldset>
        <?php }else{echo "No Data Found.";} }?>  
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
