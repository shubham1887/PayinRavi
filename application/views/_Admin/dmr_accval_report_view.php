<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>DMT ACCOUNT VALIDATION</title>

    
     
    
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
	document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
	document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
});
	

	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
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
          <a class="breadcrumb-item" href="#">DMT</a>
          <span class="breadcrumb-item active">DMT Transactions</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
       <div class="col-sm-6 col-lg-3">
          <h4>DMT ACCOUNT VALIDATION</h4>
        </div>
        <div class="col-sm-6 col-lg-9">
            
           
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
                 <form action="<?php echo base_url()."_Admin/dmr_accval_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table class="table table-bordered">
            <tr>
            	<td>
                	<label>From Date :</label>
                    <input type="text" readonly name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control datepicker" title="Select From Date." maxlength="10"  style="cursor: pointer"/>
                </td>
                <td>
                	<label>To Date :</label>
                    <input type="text" readonly name="txtTo" id="txtTo" class="form-control datepicker" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"/ />
                </td>
				<td>
                	<label>Status :</label>
                    <select id="ddlstatus" name="ddlstatus" class="form-control" style="width: 120px">
						<option value="ALL">ALL</option>
						<option value="SUCCESS">SUCCESS</option>
						<option value="PENDING">PENDING</option>
						<option value="FAILED">FAILURE</option>
					</select>
                </td>
				<td>
                	<label>Remitter :</label>
                    <input type="text" name="txtRemitter" id="txtRemitter" class="form-control" value="<?php echo $txtRemitter; ?>"  maxlength="10" />
                </td>
                <td>
                	<label>Account No :</label>
                    <input type="text" name="txtAccNo" id="txtAccNo" class="form-control" value="<?php echo $txtAccNo; ?>"  maxlength="30" />
                </td>
				 <td>
                	<label>UserId :</label>
                    <input type="text" name="txtUserId" id="txtUserId" class="form-control" value="<?php echo $txtUserId; ?>"  maxlength="10" />
                </td>
                <td style="padding-top:30px;">
                	<label></label>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success" title="Click to search." />
					
                </td>
				<td style="padding-top:30px;">
                	<label></label>
                  <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary" onclick="startexoprt()"  />
					
                </td>
            </tr>
            </table>
	
							</form>
							<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/dmr_accval_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($result_all))
	{
		if($result_all->num_rows() > 0)
		{
	?>
	    <div id="all_transaction">
     

<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
	<tr>
	
    <th>Sr</th>
	<th>ID</th>
    <th>DateTime</th>
    <th>AgentName</th>
    <th>Remitter</th> 
 
   	<th>AccountNo</th>

    <th>Debit Amount</th>       
    <th>Credit Amount</th>       
    <th>Bank Ref No</th>        
    <th>Status</th> 
	    
	<th style="display:none"></th>
	<th style="display:none"></th>
	        
    </tr>
    </thead>
    <?php	$totaldr = 0;$totalcr = 0;$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	{  ?>
			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">

 <td><?php echo ($i + 1); ?></td>
 <td><?php echo "<span id='db_ssid".$i."'>".$result->Id."</span>"; ?></td> 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>
  <td><?php echo "<span id='db_date".$i."'>".$result->businessname."<br>[".$result->username."]"."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->remitter_mobile."</span>"; ?></td>
  <td><?php echo "<span id='db_company".$i."'>".$result->account_no."<br>IFSC : ".$result->IFSC."<br>".$result->RESP_benename."</span>"; ?></td> 

 <td><?php echo "<span id='db_amount".$i."'>".$result->debit_amount."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->credit_amount."</span>"; ?></td>
 <td><?php echo "<span id='db_amount".$i."'>".$result->RESP_bankrefno."<br>".$result->RESP_status."</span>"; ?></td>
<td>
 
 <?php if($result->status == "PENDING" or $result->status == "HOLD"){echo "<span id='db_status".$i."' class='label label-primary' onclick='checkstatus(\"".$result->Id."\")'>".$result->status."</span>";} ?>
  <?php if($result->status == "SUCCESS"){echo "<span id='db_status".$i."' class='label label-success'>".$result->status."</span>";} ?>
  <?php if($result->status == "FAILED" or $result->status == "FAILURE"){echo "<span id='db_status".$i."' class='label label-warning'>".$result->status."</span>";} ?>
  </td>
 <td style="display:none"> 
		<select id="ddlstatus<?php echo $result->Id; ?>" name="ddlstatus" class="form-control" style="width: 80px;font-size: 12px;font-weight: bold;height: 30px;">
			<option value="0">Select Action</option>
			<option value="Success">Success</option>
			<option value="Failure">Failure</option>
		</select>
	</td>
	<td style="display:none">
		<input type="button" id="btnstatuschange" class="btn btn-primary btn-mini" style="width: 60px;font-size: 10px;font-weight: bold" value="Submit" onClick="doaction('<?php echo $result->Id; ?>')"> 
		
	</td>

 </tr>
		<?php
		 $totaldr += $result->debit_amount;
		 $totalcr += $result->credit_amount;
		
		$i++;} ?>
		
         <tr class="ColHeader">
			 <th></th>
    <th></th>
    <th></th>
	<th></th>
    <th></th>
    
 
   
       <th></th>
    <th></th>
    <th>Total:</th>   
	
  
 <th><?php echo $totaldr; ?></th>      
 <th><?php echo $totalcr; ?></th>      
    
    <th></th>     
	<th></th>          
	
     
	            
    </tr>        
		</table>
		
		
        </div>
       <?php
		}
	   else{?>
		   <div class='message'>Record Not Found.</div>
		   <?php }
	   
	   }?>    
              </div><!-- card-body -->
            </div>
        </div>
        </div>
      </div><!-- br-pagebody -->
      <?php include("elements/footer.php"); ?>




<input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."_Admin/dmr_report/checkstatus"; ?>">
  <form id="frmstatuschange" action="" method="post">
      <input type="hidden" id="hidstsupdtid" name="hidId" value="">
     <input type="hidden" id="hidstsupdtstatus" name="hidstatus" >
     <input type="hidden" id="hidstsupdate_action" name="hidaction">
</form> 

<script language="javascript">
			function doaction(id)
			{
				if(confirm("Are You Sure ..???"))
				{
					//frmstatuschange
					//hidstsupdtid
					//hidstsupdtstatus
					//hidstsupdate_action
				
					var status = document.getElementById("ddlstatus"+id).value;
					
					document.getElementById("hidstsupdtstatus").value = status;
					document.getElementById("hidstsupdtid").value = id;
					document.getElementById("hidstsupdate_action").value = "STATUSUPDATE";
					document.getElementById("frmstatuschange").submit();
					
				}
			}
		</script>



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
