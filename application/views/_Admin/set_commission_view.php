<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Userwise Api</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
	<?php include("files/set_commission_javascript.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   <script>
function SetEdit(value)
	{
		document.getElementById('txtStatusWord').value=document.getElementById("status_word_"+value).innerHTML;
		document.getElementById('txtOpStart').value=document.getElementById("operator_id_start_"+value).innerHTML;		
		document.getElementById('txtOpIdEnd').value=document.getElementById("operator_id_end_"+value).innerHTML;
		document.getElementById('txtNumStart').value=document.getElementById("number_start_"+value).innerHTML;		
		document.getElementById('txtNumEnd').value=document.getElementById("number_end_"+value).innerHTML;
		document.getElementById('ddlstatus').value=document.getElementById("status_"+value).innerHTML;
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		document.getElementById('ddlapi').value=document.getElementById("api_id_"+value).value;
		
		
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
	function Confirmation(value)
	{
		var varName = document.getElementById("status_word_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" Settings.") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
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
          <a class="breadcrumb-item" href="#">Settings</a>
          <span class="breadcrumb-item active">Userwise Api Switching</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Userwise Api Switching</h4>
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
                  <div id="ajaxprocess" style="display:none">
                  <img src="<?php echo base_url(); ?>ajax-loader_bert.gif">
                  </div>
                	<form id="frmsubmit" name="frmsubmit" action="" method="post">
<input type="hidden" id="hidflag" name="hidflag">
<input type="hidden" id="hidid" name="hidid">
<input type="hidden" id="hidcom" name="hidcom">
</form>
									<form method="post" action="<?php echo base_url()."commission"; ?>" name="frmcommssion_view" id="frmcommssion_view" autocomplete="off">
<table class="table table-striped table-bordered table-hover">
<tr>
<td>MasterDealer</td>
<td>Distributer</td>
<td>Agent</td>
<td>APIUSER</td>
</tr>
<tr>
<td align="left">
<select id="ddlMD" name="ddlMD" placeholder="Select Operator Name." class="form-control-sm" style="width:150px;" onChange="ddlmdchange()"><option>--Select--</option>
    <?php
		$str_query = "select * from tblusers where usertype_name = 'MasterDealer'";
		$result_md = $this->db->query($str_query);		
		for($i=0; $i<$result_md->num_rows(); $i++)
		{
			echo "<option value='".$result_md->row($i)->user_id."'>".$result_md->row($i)->businessname."[".$result_md->row($i)->username."]</option>";
		}
	?>
    </select>
</td>
<td align="left">
<select id="ddlD" name="ddlD" title="Select Dealer." class="form-control-sm" style="width:150px;" onChange="ddldchange()"><option>--Select--</option>
    <?php
		$str_query = "select * from tblusers where usertype_name = 'Distributor'";
		$result_md = $this->db->query($str_query);		
		for($i=0; $i<$result_md->num_rows(); $i++)
		{
			echo "<option value='".$result_md->row($i)->user_id."'>".$result_md->row($i)->businessname."[".$result_md->row($i)->username."]</option>";
		}
	?>
    </select>
</td>
<td align="left">
<select id="ddlAGENT" name="ddlAGENT" title="Select AGENT." class="form-control-sm" style="width:150px;" onChange="ddlachange()"><option>--Select--</option>
    <?php
		$str_query = "select * from tblusers where usertype_name = 'Agent'";
		$result_md = $this->db->query($str_query);		
		for($i=0; $i<$result_md->num_rows(); $i++)
		{
			echo "<option value='".$result_md->row($i)->user_id."'>".$result_md->row($i)->businessname."[".$result_md->row($i)->username."]</option>";
		}
	?>
    </select>
</td>
<td align="left">
<select id="ddlAPIUSER" name="ddlAPIUSER" title="Select APIUSER." class="form-control-sm" style="width:150px;" onChange="ddlAPIchange()"><option>--Select--</option>
    <?php
		$str_query = "select * from tblusers where usertype_name = 'APIUSER'";
		$result_md = $this->db->query($str_query);		
		for($i=0; $i<$result_md->num_rows(); $i++)
		{
			echo "<option value='".$result_md->row($i)->user_id."'>".$result_md->row($i)->businessname."[".$result_md->row($i)->username."]</option>";
		}
	?>
    </select>
</td>
</tr>
</table>
<input type="hidden" id="hidID" name="hidID" />
</form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Operator List</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="table-responsive">
                           <div id="ajaxload" style="display:none">
<img src="<?php echo base_url()."ajax-loader.gif" ?>">
</div>
                                <div id="divcomm">
								</div>
                            </div>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <div class="modal fade" id="myMessgeModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL">Response Message</h4>
          
        </div>
        <div class="modal-body">
        
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
          
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
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
