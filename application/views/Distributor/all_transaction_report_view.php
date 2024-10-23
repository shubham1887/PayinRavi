<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>List Recharges</title>
    
     
    
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
          <span class="breadcrumb-item active">RECHARGE REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>RECHARGE REPORT</h4>
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
                  <form action="<?php echo base_url()."Distributor/all_transaction_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                           <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control-sm" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Status</h5>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Operator</h5>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select * from tblcompany order by company_name");
											foreach($rsltcompany->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Number / Id</h5>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:120px;" >
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-xs" style="font-size:12px;">
                                        </td>
                                        <td valign="bottom">
                                       
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-xs" onClick="startexoprt()" style="font-size:12px;">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Rec.Id</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     <th>Time</th>
     <th>Agent Name</th>
     <th>opcode</th>
	 <th>Mobile No</th>    
	 <th>Amt</th>  
	 <th>Status</th> 
	 <th>Debit<br>Amt</th>
    </tr>
    
    
    <?php 
	$totalRecharge = 0;	
	$i = count($result_all->result());
	foreach($result_all->result() as $result) 	
	{
		
	?>
    	
            	<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
		   
 <td><?php echo $result->recharge_id; ?></td>
  
  <td><?php echo $result->operator_id; ?></td>
  
  
  
 <td style="font-size:10px;"><?php echo $result->add_date; ?></td>
 <td>
     <?php 
        if($result->update_time != "0000-00-00 00:00:00")
        {
            $recdatetime =date_format(date_create($result->add_date),'Y-m-d h:i:s');
            $cdate =date_format(date_create($result->update_time),'Y-m-d h:i:s');
            $now_date = strtotime (date ($cdate)); // the current date 
    		$key_date = strtotime (date ($recdatetime));
    		$diff = $now_date - $key_date;
    		echo $diff;
    		//echo  "<br>";    
        }
        
     //echo $result->update_time; 
     ?>
 </td>
 <!-- <td><?php echo $result->update_time; ?></td>-->
 <td><?php echo $result->username; ?></td>
 <td><?php echo $result->company_name; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td>
 <?php 
 if($result->recharge_status == 'Pending'){echo "<span class='label btn-warning'>Pending</span>";}
 if($result->recharge_status == 'Success')
 {
 	$totalRecharge += $result->amount;echo "<span class='label btn-success'>Success</span>";
 }
 if($result->recharge_status == 'Failure')
 {
	 if($result->edit_date == 3)
	 {
			echo "<span class='label btn-primary'>Reverse</span>"; 
	 }
	 else
	 {
		 echo "<span class='label btn-danger'>Failure</span>";
	 }
 	
 }
 
 
 ?></td>
 <td><?php echo ($result->amount - $result->commission_amount); ?></td>
 
  
 </tr>
 
		<?php 	
		$i--;} ?>
        <tr style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
       <th > </th>
      <th > </th>
     <th  > </th>
     <th > </th>
      <th > </th>
     
	 <th >Total </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
			  <th > </th>
   	 <th></th>    
   	 <th ></th>    
   	 <th></th>
     <th></th>  
       <th></th>         
    </tr>
		</table>
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
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
