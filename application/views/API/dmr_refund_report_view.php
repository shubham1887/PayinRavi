<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>PRIMEPAY::DMT REFUND RERPOT</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
       <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
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
		reset();
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
  
     <!-- for prompt dialog -->

	<link rel="stylesheet" href="<?php echo base_url()."alertify/themes/alertify.core.css";?>" />
	<link rel="stylesheet" href="<?php echo base_url()."alertify/themes/alertify.default.css";?>" id="toggleCSS" />
	<meta name="viewport" content="width=device-width">
	
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
    <style>
	
		.alertify-log-custom {
			background: blue;
		}
	</style>
  <style>
    .yellow
    {
      background-color: #ff6f6f !important;
    }
    .green
    {
      background-color: #268e40 !important;
    }
  </style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/apisidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/apiheader.php"); ?><!-- br-header -->
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
          <span class="breadcrumb-item active">DMT REFUND RERPOT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-sm-6 col-lg-6">
          <h4>DMT REFUND RERPOT</h4>
        </div>
        <div class="col-sm-6 col-lg-6">
        <span class="breadcrumb-item active">
          	<button class="btn btn-success btn-sm" type="button" style="font-size:14px;">Success : <?php echo $summary_array["Success"]; ?></button>
          </span>
          <span class="breadcrumb-item active">
          	<button class="btn btn-primary btn-sm" type="button" style="font-size:14px;">Pending : <?php echo $summary_array["Pending"]; ?></button>
          </span>
          <span class="breadcrumb-item active">
          	<button class="btn btn-danger btn-sm" type="button" style="font-size:14px;">Failure : <?php echo $summary_array["Failure"]; ?></button>
          </span>
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
                 <form action="<?php echo base_url()."API/dmr_refund_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">
            <table class="table">
            <tr>
            	<td>
                	<label>From Date :</label>
                    <input type="text" readonly name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control-sm" title="Select From Date." maxlength="10"  style="cursor: pointer"/>
                </td>
                <td>
                	<label>To Date :</label>
                    <input type="text" readonly name="txtTo" id="txtTo" class="form-control-sm" value="<?php echo $to; ?>" title="Select From To." maxlength="10" style="cursor: pointer"/ />
                </td>
				<td>
                	<label>Status :</label>
                    <select id="ddlstatus" name="ddlstatus" class="form-control-sm" >
						<option value="ALL">ALL</option>
						<option value="SUCCESS">SUCCESS</option>
						<option value="PENDING">PENDING</option>
						<option value="FAILURE">FAILURE</option>
						<option value="HOLD">HOLD</option>
					</select>
                </td>
               
                </tr>
                <tr>
				<td>
                	<label>Remitter :</label>
                    <input type="text" name="txtRemitter" id="txtRemitter" class="form-control-sm" value="<?php echo $txtRemitter; ?>"  maxlength="10" />
                </td>
                <td>
                	<label>Account No :</label>
                    <input type="text" name="txtAccNo" id="txtAccNo" class="form-control-sm" value="<?php echo $txtAccNo; ?>"  maxlength="30" />
                </td>
				
				
				<td>
                	<label>Data :</label>
                    <select id="ddldb" name="ddldb" class="form-control-sm" >
						<option value="LIVE">LIVE</option>
						<option value="ARCHIVE">ARCHIVE</option>
					</select>
                </td>
                </tr>
                <tr>
                <td colspan="4">
                	<label></label>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
				 <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary btn-sm" onClick="startexoprt()"  />	
                </td>
				<td style="padding-top:30px;">
                	<label></label>
                
					
                </td>
				<td >
                	<label></label>

					
					
                </td>
            </tr>
            </table>
	
							</form>
							<form id="frmexport" name="frmexport" action="<?php echo base_url()."API/dmr_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
                                     <form id="frmcomplain"  method="post">
    <input type="hidden" id="hidrecid" name="hidrecid" />
    <input type="hidden" id="hidmsg" name="hidmsg">
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
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                  	<th>ID</th>
                    <th>OrderId</th>
                    <th>DateTime</th>
                    <th>Time</th>
                    <th>RefundTime</th>
                    <th>AgentName</th>
                    <th>Remitter</th> 
                 
                    <th>AccountNo</th>
                         
                    <th>Amount</th>
                    <th>Bank Ref No</th>        
                    <th>Status</th> 
                   
                        
                </tr>
              </thead>
              <tbody>
               <?php	$strrecid = '';
			$totaldr = 0;$totalcr = 0;$total_amount=0;$total_commission=0;$i = 0;
			foreach($result_all->result() as $result) 	
			{


        $row_class = "";
        $rec_date = date_format(date_create($result->add_date),'Y-m-d');
        $refund_date =  date_format(date_create($result->refund_date),'Y-m-d');
        if($refund_date > $rec_date)
        {
          $row_class = "yellow";
        }
        if($refund_date < $rec_date)
        {
          $row_class = "green";
        }




	?>
    <tr id="<?php echo "Print_".$i ?>" class="<?php echo $row_class; ?>">
	
	
	
			
 
<td>
<?php echo $result->Id;?>
 </td> 
 <td >
<?php echo $result->order_id;?>
 </td> 
  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>
  <td>
     <?php 
        if($result->edit_date != "")
        {
            $recdatetime =date_format(date_create($result->add_date),'Y-m-d h:i:s');
            $cdate =date_format(date_create($result->edit_date),'Y-m-d h:i:s');
            $now_date = strtotime (date ($cdate)); // the current date 
    		$key_date = strtotime (date ($recdatetime));
    		$diff = $now_date - $key_date;
    		echo $diff;
    		//echo  "<br>";    
        }
        
     //echo $result->update_time; 
     ?>
 </td>
  <td><?php echo "<span id='db_date".$i."'>".$result->refund_date; ?></td>
  <td><?php echo "<span id='db_date".$i."'>".$result->businessname."<br>[".$result->mobile_no."]"."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->RemiterMobile."</span>"; ?></td>
  
 <td><?php echo "<span id='db_company".$i."'>".$result->AccountNumber."<br>IFSC : ".$result->IFSC."<br>".$result->RESP_name."<br>Mode: ".$result->mode."</span>"; ?></td> 
 

 <td style="min-width:120px">
 	<?php 
		echo "AMT : ".$result->Amount; 
		echo "<br>";
		echo "DR : ".round($result->debit_amount,2);
		echo "<br>";
		echo "CR : ".round($result->credit_amount,2);
	?>
 </td>
 <td><?php echo $result->RESP_opr_id."<br>".$result->RESP_status; ?></td>

 <td>
 <img id="imgloader<?php echo $result->Id; ?>" style="display:none;width:40px;height:40px;" src="<?php echo base_url()."ajax-loader.gif"; ?>" >
 <?php if($result->Status == "PENDING" or $result->Status == "HOLD"){echo "<span  style='word-break: break-all;' id='db_status".$result->Id."' class='label label-primary' onclick='checkpending(\"".$result->Id."\")'>".$result->Status."</span>";} ?>
  <?php if($result->Status == "SUCCESS"){echo "<span id='db_status".$i."' class='label label-success'>".$result->Status."</span>";} ?>
  <?php if($result->Status == "FAILURE"){echo "<span id='db_status".$i."' class='label label-warning'>".$result->Status."</span>";} ?>
  </td>
  
  
 
  </tr>
		<?php
		 $totaldr += $result->debit_amount;
		 $totalcr += $result->credit_amount;
		if($result->Status == "SUCCESS"){
		$total_amount= $total_amount + $result->Amount;}
		$i++;} ?>
              </tbody>
            </table>
              </div><!-- card-body -->
            </div>
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
