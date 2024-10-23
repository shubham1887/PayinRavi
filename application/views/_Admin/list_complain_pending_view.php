<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Pending Complains</title>

    
     
    
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
<script type="text/javascript">
    
    
    function ActionSubmit(value)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			if(confirm('Are you sure?')){
			
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidresponse').value= document.getElementById('message_'+value).value;
				document.getElementById('hidcomplainid').value= value;								 
				document.getElementById('frmCallAction').submit();
			}
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">PENDING COMPLAINS</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>PENDING COMPLAINS</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">PENDING COMPLAIN</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
        <tr> 
          <th>Complain<br>Id</th>
          <th>Rec.Id</th>
          <th>Mobile No </th>
         
          <th>Recharge Date</th>
          
          <th>User Name</th> 
          <th>Message</th> 
          <th>Complain Date</th> 
          <th>Status</th> 
          <th>Response Message</th> 
          <th>Actions</th>
              
        </tr> </thead>
     <tbody>
    <?php
	
		$i = 0;foreach($result_complain->result() as $result) 	{  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td >			
						<?php echo $result->complain_id; ?>
                </td>
                <?php 
				$recdetail = $this->db->query("select mobile_no,add_date,ExecuteBy,amount,recharge_status from tblrecharge where recharge_id = ?",array($result->recharge_id));
				
				?>
                 <td >			
						<?php echo $result->recharge_id; ?>
                </td>
                 <td >			
						<?php echo $recdetail->row(0)->mobile_no; ?>
						<br>
						Amt : <?php echo $recdetail->row(0)->amount; ?>
						<br>
						 <?php 
						        if($recdetail->row(0)->recharge_status == "Failure")
						        {
						            echo '<span class="btn btn-danger btn-sm">Failure</span>';
						        }
						        if($recdetail->row(0)->recharge_status == "Success")
						        {
						            echo '<span class="btn btn-success btn-sm">Success</span>';
						        }
						        if($recdetail->row(0)->recharge_status == "Pending")
						        {
						            echo '<span class="btn btn-primary btn-sm">Pending</span>';
						        }
						 ?>
						 <br>
						 	<?php echo $recdetail->row(0)->ExecuteBy; ?>
                </td>
                 
                 <td >			
						<?php echo $recdetail->row(0)->add_date; ?>
                </td>
                
            	
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->businessname; ?><br>
						<?php echo $result->username; ?>
                </td>
                 <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->message; ?>
                </td>
               
              <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->complain_date; ?>
                </td>
                <td >			
						<?php if($result->complain_status == "Pending"){echo "<span class='orange'>".$result->complain_status."</span>";} ?>
  <?php if($result->complain_status == "Solved"){echo "<span class='green'>".$result->complain_status."</span>";} ?>
  <?php if($result->complain_status == "Unsolved"){echo "<span class='red'>".$result->complain_status."</span>";} ?>
                </td>
                <?php if($result->response_message == ""){ ?>
                <td >			
						 <input type="text" style="width:90px;" class="text" placeholder="Enter Response Message." id="message_<?php echo $result->complain_id; ?>" name="message_<?php echo $result->complain_id; ?>"  />
                </td>
                <?php }else {?>
                <td >			
						<?php echo $result->response_message; ?>
                </td>
                <?php } ?>
 				<td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:40px;">
                	<select style="width:100px;" id="action_<?php echo $result->complain_id; ?>" onChange="ActionSubmit('<?php echo $result->complain_id; ?>')"><option value="Select">Select</option><option value="Solved">Solved</option><option value="Unsolved">Unsolved</option></select>
               </td>
 				
 </tr>
		<?php 	
		$i++;} ?>
        </tbody>
		</table>

              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
        </div>
      </div><!-- br-pagebody -->
       <form action="<?php echo base_url()."_Admin/list_complain_pending" ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidresponse" name="hidresponse" />
<input type="hidden" id="hidcomplainid" name="hidcomplainid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
 </form>
 <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
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
