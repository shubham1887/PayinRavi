<!DOCTYPE html>
<html lang="en">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title>API Aeps Report</title>
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">API AEPS REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>API AEPS REPORT</h4>
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
                  <form action="<?php echo base_url();?>_Admin/Aeps_report_api" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input class="form-control" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
										

                                        <td style="padding-right:10px;">
                                        	 <label>Data</label>
                                           <select id="ddldb" name="ddldb" class="form-control" style="width: 120px">
											   <option value="LIVE">LIVE</option>
											   <option value="ARCHIVE">ARCHIVE</option>
											</select>
                                        </td>
                                        
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">
                                      <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">AEPS REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <div class="table-responsive">
                                     <?php
    if ($message != ''){echo "<div class='message'>".$message."</div>"; }
    if(isset($result_recharge))
    {
        if($result_recharge->num_rows() > 0)
        {
    ?>
  
    <div id="all_transaction">
<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>
    <th>Sr No</th>
   <th >ID</th>
   <th >Client Name</th>
   <th >OrderID</th>
   <th >Transaction Id</th>
    <th>Date Time</th> 
    <th>SPKEY</th>
   <th>Aadhar No</th>
    <th>Mobile No</th>
    <th>Amount</th>
    <th>Commission</th>
    <th>Status</th>
    <th>Response</th>
            
    </tr>
    <?php   $total_amount=0;$total_commission=0;$i = 0;foreach($result_recharge->result() as $result)   {  ?>
            <tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
 <td><?php echo ($i + 1); ?></td>
  <td>
  <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->Id; ?>')">
         <?php echo $result->Id;?>
    </a>
</td>
  <td><?php echo "<span id='db_ssid".$i."'>".$result->businessname."</span>"; ?></td> 
   <td><?php echo "<span id='db_ssid".$i."'>".$result->agent_id."</span>"; ?></td> 
  <td style="max-width: 180px;word-break: break-all;"><?php echo "<span id='db_ssid".$i."'>".$result->resp_opr_id."</span>"; ?></td>
 <td>
    <?php echo date_format(date_create($result->add_date),'Y-m-d'); ?><br>
    <?php echo date_format(date_create($result->add_date),'H:i:s'); ?>
  </td> 
 

<td><?php echo "<span id='db_company".$i."'>".$result->sp_key."</span>"; ?></td> 

  
 <td><?php echo "<span id='db_company".$i."'>".$result->aadhaar_uid."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->mobile."</span>"; ?></td> 
 <td><?php echo "<span id='db_amount".$i."'>".$result->amount."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->Commission." </span>"; ?></td>
    <?php 
    if($result->resp_txn_status == "SUCCESS")
    {
        $total_commission += $result->Commission;

        $credit_amount = $result->amount - $result->Commission;
    }
    else
    {
        $credit_amount = 0;
    }
    ?>
  
  <td>
    <?php if($result->resp_txn_status == "PENDING"){echo "<span id='db_status".$i."' class='btn btn-warning btn-sm'>".$result->resp_txn_status."</span>";} ?>
  <?php if($result->resp_txn_status == "SUCCESS"){echo "<span id='db_status".$i."' class='btn btn-success btn-sm'>".$result->resp_txn_status."</span>";} ?>
  <?php if($result->resp_txn_status == "FAILED"){echo "<span id='db_status".$i."' class='btn btn-danger btn-sm'>".$result->resp_txn_status."</span>";} ?>
  </td>
  <td><?php echo "<span id='db_amount".$i."'>".$result->resp_status."</span>"; ?></td>
    
 </tr>
 
 </tr>
 <tr id="tr_reqresp<?php echo $result->Id; ?>" style="display:none">
     <td>Request </td><td colspan="6" id="tdreq<?php echo $result->Id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="7" id="tdresp<?php echo $result->Id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->Id; ?>')" >Hide</a></td>
 </tr>
        <?php
        if($result->resp_txn_status == "SUCCESS"){
        $total_amount= $total_amount + $result->amount;}
        $i++;} ?>
        
         <tr class="ColHeader">
    <th></th>
   
    <th></th>
    <th></th>
    <th></th>
     <th></th>
    
   
       <th></th>
    <th></th>
    <th>Total :</th>        
   <th><?php echo $total_amount; ?></th>        
    
    <th><?php echo $total_commission; ?></th>     <th></th>    
     <th></th>        

                
    </tr>        
        </table>
  
        </div>
        
       <?php
        }
       else{
           echo "<div class='message'>Record Not Found.</div>";
           }
       
       }?>
                                </div>
                                <?php  echo $pagination; ?>      
              </div><!-- card-body -->
            </div>
             
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script language="javascript">
	function changestatus(val1,id)
	{
		
				$.ajax({
				url:'<?php echo base_url()."_Admin/account_report/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,
				cache:false,
				method:'POST',
				success:function(html)
				{
					if(html == "cash")
					{
						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>  	';
						document.getElementById("ptype"+id).innerHTML = str;		
					}
					else
					{
						var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>  	';
						document.getElementById("ptype"+id).innerHTML = str;		
					}
					
				}
				}); 
			
		
	}
</script>
<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/aeps_report/dataexport" ?>" method="get">
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
