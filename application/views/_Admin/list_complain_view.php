<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Complain List</title>
    
     
    
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
          <span class="breadcrumb-item active">SOLVED COMPLAINS</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>SOLVED COMPLAINS</h4>
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
                  <form action="<?php echo base_url()."_Admin/list_complain"; ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input class="form-control" value="<?php echo $from; ?>"  id="txtFrom" name="txtFrom" type="text" style="width:120px;cursor:pointer" placeholder="Select Date" readonly>
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input class="form-control" value="<?php echo $to; ?>"  id="txtTo" name="txtTo" type="text" style="width:120px;cursor:pointer" placeholder="Select Date"  readonly>
                                        </td>
										
                                        
                                        
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">
                                     
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">SOLVED COMPLAINS</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
        <tr > 
          <th>Complain<br>Id</th>
          <th>Rec.Id</th>
          <th>Mobile No </th>
         
          <th>Recharge Date</th>
          <th>API</th> 
          <th>Complain Date</th> 
          <th>Business Name</th> 
          <th>Message</th> 
             
             <th>Solve Date</th> 
             <th >Status</th> 
       
             <th >Response Message</th> 
           
              
        </tr> </thead>
     <tbody>
    <?php	$i = 0;foreach($result_complain->result() as $result) 	
    {  
        $recdetail = $this->db->query("select mobile_no,add_date,ExecuteBy,amount,recharge_status from tblrecharge where recharge_id = ?",array($result->recharge_id));
			
    ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td>			
						<?php echo $result->complain_id; ?>
                </td>
                 <td>			
						<?php echo $result->recharge_id; ?>
                </td>
                <td >			
						<?php echo $recdetail->row(0)->mobile_no; ?>
                </td>
                 <td >			
						<?php echo $recdetail->row(0)->amount; ?>
                </td>
                 <td >			
						<?php echo $recdetail->row(0)->add_date; ?>
                </td>
                 <td >			
						<?php echo $recdetail->row(0)->ExecuteBy; ?>
                </td>
            	<td>			
						<?php echo $result->complain_date; ?>
                </td>
                <td>			
						<?php echo $result->businessname; ?>
						<br><?php echo $result->username; ?>
                </td>
               
                <td>			
						<?php echo $result->message; ?>
                </td>
               
                <td>			
						<?php echo $result->complainsolve_date; ?>
                </td>
                <td>			
						<?php echo $result->complain_status; ?>
                </td>
               
                <td>			
						<?php echo $result->response_message; ?>
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
      
<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/account_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
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
