<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Retailer | Recharge History</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      <script language="javascript">
function startexoprt()
{
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		var db = document.getElementById("ddldb").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("hiddb").value = db;
		document.getElementById("frmexport").submit();
	
}

</script>
<script>	
$(document).ready(function(){

$( "#txtFrom,#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
	setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
	
	document.getElementById("ddlstatus").value = "<?php echo $ddlstatus; ?>";
	document.getElementById("ddldb").value = "<?php echo $ddldb; ?>";
	document.getElementById("ddloperator").value = "<?php echo $ddloperator; ?>";
	});
	
	
	

	</script>
	<script language="javascript">
/*	function complainadd(recahrge_id)
	{
		
		document.getElementById("hidcomplain").value = "Set";
		document.getElementById("recid").value = recahrge_id;
		document.getElementById("frmcomplain").submit();
	}*/
	</script>
    <script language="javascript">
	function complainadd(recahrge_id)
	{
		//var msg  = prompt("Enter Your Complain Remark");
		//if(msg != null)
		//{
			//document.getElementById("hidmsg").value = msg;
			//document.getElementById("hidrecid").value = recahrge_id;
			//document.getElementById("frmcomplain").submit();
		//}
	//	reset();
			alertify.prompt("Enter Your Complain Remark", function (e, str) {
				if (e) {
					alertify.success("You've clicked OK and typed: " + str);
					document.getElementById("hidmsg").value = str;
					document.getElementById("hidrecid").value = recahrge_id;
					document.getElementById("frmcomplain").submit();	
				} else {
					alertify.error("You've clicked Cancel");
				}
			}, "Default Value");
			return false;
		
	}
	</script>
    <style>
	
		.alertify-log-custom {
			background: blue;
		}
	</style>

	<script src="<?php echo base_url()."alertify/lib/alertify.min.js";?>"></script>
	<script>
		function reset () {
			$("#toggleCSS").attr("href", "<?php echo base_url()."alertify/themes/alertify.default.css"; ?>");
			alertify.set({
				labels : {
					ok     : "OK",
					cancel : "Cancel"
				},
				delay : 5000,
				buttonReverse : false,
				buttonFocus   : "ok"
			});
		}

		// ==============================
		// Standard Dialogs
		

		$("#prompt").on( 'click', function () {
			reset();
			alertify.prompt("This is a prompt dialog", function (e, str) {
				if (e) {
					alertify.success("You've clicked OK and typed: " + str);
				} else {
					alertify.error("You've clicked Cancel");
				}
			}, "Default Value");
			return false;
		});

		
	</script>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/agentsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/agentheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Retailer/dashboard"; ?>">Dashboard</a>
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
                  <form id="frmcomplain"  method="post">
                    <input type="hidden" id="hidrecid" name="hidrecid" />
                    <input type="hidden" id="hidmsg" name="hidmsg">
                  </form>
  				 <form action="<?php echo base_url()."Retailer/recharge_history" ?>" method="post" name="frmCallAction" id="frmCallAction">

                           <input type="hidden" id="hidID" name="hidID">

                                    <table cellspacing="10" cellpadding="3">

                                    <tr>
 
                                    <td style="padding-right:10px;">

                                        	 <label>From Date</label>

                                            <input class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>

                                    	<td style="padding-right:10px;">

                                        	 <label>To Date</label>

                                            <input class="form-control" id="txtTo" value="<?php echo $to; ?>" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>
										<td style="padding-right:10px;">
                                        	 <label>Status</label>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control">
                                           	<option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>
                                        </td>
										<td style="padding-right:10px;">
                                        	 <label>Operator</label>
                                           <select id="ddloperator" name="ddloperator" class="form-control">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select company_id,company_name from tblcompany where service_id  <= 3 order by service_id,company_name");
											foreach($rsltcompany->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">

                                        	 <label>Id/ Number</label>

                                            <input class="form-control" id="txtNumId" value="<?php echo $word; ?>" name="txtNumId" type="text" style="width:120px;" placeholder="Id / Mobile Number">

                                        </td>
<td style="padding-right:10px;">
                                        	 <label>Data</label>
                                           <select id="ddldb" name="ddldb" class="form-control">
                                           	<option value="LIVE">LIVE</option>
                                           <option value="ARCHIVE">ARCHIVE</option>
                                           </select>
                                        </td>

                                        <td valign="bottom">

                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">

                                      

                                        </td>

                                    </tr>

                                    </table>

                                        

                                       

                                       

                                    </form>
				 <form id="frmexport" name="frmexport" action="<?php echo base_url()."Retailer/recharge_history/dataexport" ?>" method="get">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>
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
					<h2 class="h2">Search Result</h2>
					<div id="all_transaction">
				  <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" border="1">
					<tr>
					<th>Sr No</th>
				   <th >Recharge ID</th>
				 
					<th>Recharge Date Time</th> 
				   <th>Company Name</th>
					<th>Mobile No</th>   
				   <th>Amount</th>
					<th>Rate</th>        
				   
					   <th>Operator Id</th>  
						<th>Status</th>        
					<th>Complain</th>        
							
					</tr>
					<?php	
					$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	
					{ 
					
					
					 $recdt = $result->add_date;
					 $recdatetime =date_format(date_create($recdt),'Y-m-d H:i:s');
					 $cdate =date_format(date_create($this->common->getDate()),'Y-m-d H:i:s');
					 $this->load->model("Update_methods");
					 $diff = $this->Update_methods->gethoursbetweentwodates($recdatetime,$cdate);
					 $dtfr = date_format(date_create($this->common->getDate()),'YmdHis');
					 $operator_trans_id = "MP".$dtfr.$transaction_id;
					?>
							<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
				 <td ><?php echo ($i + 1); ?></td>
				  <td ><?php echo "<span id='db_ssid".$i."'>".$result->recharge_id."</span>"; ?></td> 
				
				 <td ><?php echo "<span id='db_date".$i."'>".$result->add_date."</span>"; ?></td> 
				  
				 <td ><?php echo "<span id='db_company".$i."'>".$result->company_name."</span>"; ?></td> 
				 <td ><?php echo "<span id='db_mobile".$i."'>".$result->mobile_no."</span>"; ?></td> 
				
				 <td ><?php echo "<span id='db_amount".$i."'>".$result->amount."</span>"; ?></td>
					<?php 
					if($result->recharge_status == "Success")
					{
						$total_commission += $result->commission_amount;
						$debit_amount = $result->amount - $result->commission_amount;
					}
					else
					{
						$debit_amount = 0;
					}
					?>
				  <td ><?php echo "<span id='db_amount".$i."'>".$debit_amount."</span>"; ?></td>
				  <td ><?php echo "<span id='db_mobile".$i."'>";
				  if($result->recharge_status == 'Pending')
					  {
						if($diff > 2)
						 {
							 echo $operator_trans_id;
						 }
						 else
						 {
							 echo $result->operator_id;  
						 }
					  }
					  else
					  {
						echo $result->operator_id;   
					  }
				  
				  echo "</span>"; ?></td> 
				  <td >
				   <?php
					if($result->recharge_status == "Pending")
					{
					  if($diff > $this->common->getsuccesstime())
					 {
						 $totalRecharge += $result->amount;
						 echo "<span class='label label-success'>Success</span>";
					 }
					 else
					 {
						echo "<span class='label label-warning'>Pending</span>";
					 }
					}?>
					 <?php
					if($result->recharge_status == "Failure")
					{?>
						<span class="label-default label label-danger">Failure</span>
					<?php }?>
					<?php
					if($result->recharge_status == "Success")
					{?>
					<span class="label-success label label-default">Success</span>
					<?php }?>
					
					 
					   
				  </td>
				 
				   
				 <td align="center"><a href="javascript:void(0)" style="height:15px;width:20px;" onClick="javascript:complainadd('<?php echo $result->recharge_id; ?>')" > Complain</a></td>
				 </tr>
						<?php
						if($result->recharge_status == "Success"){
						$total_amount= $total_amount + $result->amount;}
						$i++;} ?>
						
						 <tr class="ColHeader">
					<th></th>
					<th></th>
					
					
				   
					   <th></th>
					<th></th>
					<th>Total</th>        
				   <th><?php echo $total_amount; ?></th>        
					
					<th><?php echo $total_amount - $total_commission; ?></th>     <th></th>    
						 
					<th></th>
								
					</tr>        
						</table>
						 <?php  echo $pagination; ?>      
						</div>
					   <?php
						}
					   else{
						   echo "<div class='message'>Record Not Found.</div>";
						   }
					   
					   }?>
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
