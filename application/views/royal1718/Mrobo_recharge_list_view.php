<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>MROBO LAPU Report</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	
	
	
	
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">MROBO LAPU Report</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>MROBO LAPU Report</h4>
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
                  <form action="<?php echo base_url()."royal1718/Mrobo_recharge_list" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input class="form-control" value="<?php echo $from_date; ?>" id="txtFromDate" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input class="form-control" value="<?php echo $to_date; ?>" id="txtToDate" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">
                                      </td>
                                      <td style="padding-right:10px;">
                                           <label>LapuNumber</label>
                                            <input class="form-control" value="<?php echo $LapuNumber; ?>" id="txtLapuNumber" name="txtLapuNumber" type="text" style="width:120px;" >
                                      </td>
										                <td style="padding-right:10px;">
                                           <label>Recharge Number</label>
                                            <input class="form-control" value="<?php echo $RecNumber; ?>" id="txtRecNumber" name="txtRecNumber" type="text" style="width:120px;" >
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">ACCOUNT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
    <th>Id</th>
    <th>DateTime</th>
    <th>mobile</th>
    <th>Amount</th>
    <th>ROffer</th>
    <th>Balance</th>
    <th>Diff</th>
    <th>OrderId</th>
    <th>TxnId</th>
    
    <th>Status</th>
    <th>CreatedAt</th>
    <th>UpdatedAt</th>
    <th>Lapu</th>
    <th>CompanyName</th>
                        
                </tr>
              </thead>
              <tbody>
              <?php	
			$i = 0;
      $totalsuccess = 0;
      $totalFailure = 0;
      $totalpending = 0;
			//($result_mrobo->result() as $result)
      for($k=0;$k <=$result_mrobo->num_rows();$k++)
	 		{

        if($result_mrobo->row($k)->status == "success")
        {
          $totalsuccess += $result_mrobo->row($k)->amount;
        }
       // print_r($result);exit;
				if(true)
				{	

        $balance_diff =   ($result_mrobo->row($k-1)->balnace - $result_mrobo->row($k)->balnace);
        if($balance_diff > 1000 or $balance_diff < -1000)
        {?>
      <tr style="background-color: red"> 
        <?php }
        else
        {?>
          <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>"> 
        <?php }
		  ?>
			
  <td><?php echo $result_mrobo->row($k)->Id; ?></td>
  <td><?php echo $result_mrobo->row($k)->recharge_date; ?></td>
  <td><?php echo $result_mrobo->row($k)->mobile_no; ?></td>
  <td><?php echo $result_mrobo->row($k)->amount; ?></td>
	<td><?php echo $result_mrobo->row($k)->roffer; ?></td>
  <td><?php echo $result_mrobo->row($k)->balnace; ?></td>


  <td><?php echo $balance_diff; ?></td>

  <td><?php echo $result_mrobo->row($k)->order_id; ?></td>
  <td><?php echo $result_mrobo->row($k)->txn_id; ?></td>
  <td><?php echo $result_mrobo->row($k)->status; ?></td>
  <td><?php echo $result_mrobo->row($k)->createdAt; ?></td>
  <td><?php echo $result_mrobo->row($k)->updatedAt; ?></td>
  <td><?php echo $result_mrobo->row($k)->lapu_no; ?></td>
  <td><?php echo $result_mrobo->row($k)->company_name; ?></td>
		
 </tr>
		<?php 	
		$i++;} } ?>
              </tbody>
            </table>


            <div style="panel panel-primary">
              <span class="btn btn-success"><?php echo $totalsuccess; ?></span>
            </div>
              </div><!-- card-body -->
            </div>
            
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
