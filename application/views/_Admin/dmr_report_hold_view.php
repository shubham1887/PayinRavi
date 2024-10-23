<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>HOLD TRANSACTIONS</title>

    
     
    
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

<script language="javascript">
            function checkpending(id)
            {
                document.getElementById("db_status"+id).innerHTML  = "...";
                document.getElementById("db_status"+id).disabled = true;
          
                $.ajax({
                  url:document.getElementById("hidbregvalurl").value+"?id="+id,
                  cache:false,
                  method:'POST',
                  success:function(data)
                  {
                  
                    var jsonobj = JSON.parse(data);
                    var msg = jsonobj.message;
                    var sts = jsonobj.status;
                    if(sts == "0")
                    {
                      document.getElementById("db_status"+id).innerHTML  = msg;
                    }
                    else if(sts == "1")
                    {
                      document.getElementById("db_status"+id).innerHTML  = msg; 
                    }
                    else if(sts == "2")
                    {
                      document.getElementById("db_status"+id).innerHTML  = msg; 
                    }
                    else if(sts == "3")
                    {
                      document.getElementById("db_status"+id).innerHTML  = msg; 
                    }
                    else
                    {
                      document.getElementById("db_status"+id).innerHTML  = data;
                    }
                  },
                  error:function(data)
                  {
                      alert(data.message);
                  },
                  complete:function()
                  {
                      document.getElementById("db_status").disabled = false;
                  }
                  });
    
            }
        </script>
        <script language="javascript">
                function testhidstr(id)
                    {
                          document.getElementById("tr_reqresp"+id).style.display = 'none';
                    }
          function tetingalert(id)
          {
          
              document.getElementById("tr_reqresp"+id).style.display = 'none'
            
    
              $.ajax({
                url:document.getElementById("hidgetlogurl").value+"?dmr_id="+id,
                cache:false,
                method:'POST',
                success:function(data)
                {
                  
                  //{"message":"Otp Sent To Registered Mobile Number","status":0,"remiter_id":"160677","beneid":271377}
                  
                  var jsonobj = JSON.parse(data);
                  var msg = jsonobj.message;
                  var sts = jsonobj.status;
                  
                  if(sts == 0)
                  {
                    var request = jsonobj.request;
                    var response = jsonobj.response;
                    
                    document.getElementById("tr_reqresp"+id).style.display = 'table-row'
                          
                    document.getElementById("tdreq"+id).innerHTML  = request;
                    document.getElementById("tdresp"+id).innerHTML  = response;
                    
                  }
                  
                    
                },
                error:function()
                {
                alert("error");
                },
                complete:function()
                {
                
                }
                });
          }
        </script>
         <style>

          .retry
          {
            background-color: #ADD8E6;
          }
          .success
{
  color: green;
  font-weight: bold;
  font-family: sans-serif;
}
.danger
{
  color: red;
  font-weight: bold;
  font-family: sans-serif;
}
.pending
{
  color: blue;
  font-weight: bold;
  font-family: sans-serif;
}
        </style>

  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>

<input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getdmtlogs"; ?>">
    <input type="hidden" id="hidgetuserdataurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
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
          <h4>DMT TRANSACTIONS</h4>
        </div>
        <div class="col-sm-6 col-lg-9">
            
            
            <span class="breadcrumb-item active">
          	<button class="btn btn-success btn-sm" type="button" style="font-size:14px;">Total Hold Amount : <?php echo $summary_array["hold"]; ?></button>
            </span>
          <span class="breadcrumb-item active">
          	<button class="btn btn-primary btn-sm" type="button" style="font-size:14px;">Hold Transactions : <?php echo $summary_array["hold_Count"]; ?></button>
          </span>
        
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <?php include("elements/messagebox.php"); ?>
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form action="<?php echo base_url();?>_Admin/dmr_report_hold" method="post" name="frmReport" id="frmReport">
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
                  <label>Amount :</label>
                    <input type="text" name="txtAmount" id="txtAmount" class="form-control-sm" value="<?php echo $Amount; ?>"  maxlength="5" / />
                </td>


                <td>
                  <label>Hold Filter :</label>
                   <select id="ddlholdtype" name="ddlholdtype" class="form-control-sm">
                     <option value="ALL">ALL</option>
                     <option value="no">MANUAL</option>
                     <option value="yes">AUTO</option>
                   </select>
                   <script type="text/javascript">
                     document.getElementById("ddlholdtype").value = '<?php echo $ddlholdtype; ?>';
                   </script>
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
                	<label>UserId :</label>
                    <input type="text" name="txtUserId" id="txtUserId" class="form-control-sm" value="<?php echo $txtUserId; ?>"  maxlength="10" />
                </td>
				
                </tr>
                <tr>
                <td colspan="4">
                	<label></label>
                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success btn-sm" title="Click to search." />
					  <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary btn-sm" onClick="startexoprt()"  />	
                      <input type="button" name="btncheckstatus" id="btncheckstatus" value="Status Check" class="btn btn-primary btn-sm" onClick="requeryallrecharge()"  />
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
							<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/dmr_report/dataexport" ?>" method="get">
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

              <div class="col-sm-6 col-lg-6">

             <table class="table">
                  
                  <tr>
                    <td>
                                        
                                        <input type="checkbox" id="chkall" class="filled-in chk-col-purple" />
                                                        <label for="chkall"></label>
                                        
                    
                    <script language="javascript">
                  $('#chkall').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $('.checkBoxrecharge').each(function() {
            this.checked = true;   
      //alert(this.value);
        });
    }
  else
  {
  $('.checkBoxrecharge').each(function() {
            this.checked = false;                        
        });
  }
});
                  </script>
                    </td>
                    <td>
                      <select style="width:220px;" class="form-control-sm" id="ddlactall" >
                         <option value="0">Select Action</option>
      <optgroup label="STATUS UPDATE">
         <option value="Success">Success</option>
         <option value="Failure">Failure</option>
      </optgroup>
      <optgroup label="RESEND OPTIONS">
          
          <option value="ResendAIRTEL">Resend AIRTEL</option>
          <option value="ResendPAYTM">Resend PAYTM</option>
          <option value="ResendZPLUS">Resend ZPLUS</option>
          
      </optgroup>
    
                       </select>
                    </td>
                    <td >
                      <input type="button" id="btnactall" value="Submit" class="btn btn-primary btn-sm" style="width:120px;">
                    </td>
                  </tr>
                 </table>
                </div>               
                               
<script language="javascript">
$('#btnactall').click(function(event) {   
    var status = $('#ddlactall').val();
  if(status != "Select")
  {
  document.getElementById("hidactionallstatus").value = status;
  document.getElementById("hidactionall").value = "settoall";
  document.getElementById("frmactall").submit();
  }
  else
  {
    alert("Please Select Action");
  }
});
</script>


         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">

                <form id="frmactall" name="frmactall" method="post"> 
    <input type="hidden" name="hidactionall" id="hidactionall">
     <input type="hidden" name="hidactionallstatus" id="hidactionallstatus" value="settoall">

                <table class="table table-bordered" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                    <th></th>
                    <th>API</th>
                    <th>ID</th>
                    
                    <th>DateTime</th>
                    <th>Time</th>
                    <th>AgentName</th>
                    <th>Remitter</th> 
                 
                    <th>AccountNo</th>
                         
                    <th>Amount</th>
                    <th>Bank Ref No</th>        
                    <th>Status</th> 
                   <th></th>
	                <th></th> 
                  <th></th> 
                </tr>
              </thead>
              <tbody>
               <?php	$strrecid = '';
			$totaldr = 0;$totalcr = 0;$total_amount=0;$total_commission=0;$i = 0;
			foreach($result_all->result() as $result) 	
			{
			    $retry = $result->retry;

          $hold_detail = 'MANUAL';
          $is_autohold = $result->is_autohold;
				if($result->Status == "PENDING") 
				{
					$strrecid .=$result->Id."#"; 
				}
				if($is_autohold == "yes")
				{
            $hold_detail = 'AUTO'
          ?>
				    <tr id="<?php echo "Print_".$i ?>" class="retry">
				<?php }
				else
				{?>
				    <tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
				<?php }
	?>
	
	
	
			
 <td><input class="form-control checkBoxrecharge" style="width: 15px;" type="checkbox" id="chkdmr<?php echo $result->Id;  ?>" name="chkdmr[]" value="<?php echo $result->Id; ?>"> </td>
 <td>
  <?php echo $hold_detail; ?>
  <?php echo $result->API; ?>
 <br>
UId :<?php echo $result->unique_id;?></td>
<td >
    <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->Id; ?>')">
         <?php echo $result->Id;?>
    </a>


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
  <td><?php echo "<span id='db_date".$i."'>".$result->businessname."<br>[".$result->mobile_no."]"."</span>"; ?></td>
 <td><?php echo "<span id='db_date".$i."'>".$result->RemiterMobile."</span>"; ?></td>
  
 <td><?php echo "<span id='db_company".$i."'>".$result->AccountNumber."<br>IFSC : ".$result->IFSC."<br>".$result->RESP_name."<br>Mode: ".$result->mode."<br>".$result->bank_name."</span>"; ?></td> 
 

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

 <td style="word-break: break-all;">
 <img id="imgloader<?php echo $result->Id; ?>" style="display:none;width:40px;height:40px;" src="<?php echo base_url()."ajax-loader.gif"; ?>" >
 <?php 
 if($result->Status == "PENDING" or $result->Status == "HOLD")
 {
    echo "<span class='btn btn-primary btn-sm' id='db_status".$result->Id."' onClick='checkpending(".$result->Id.")'>".$result->Status."</span>";
 } ?>
  <?php if($result->Status == "SUCCESS"){echo "<span class='btn btn-success btn-sm'>".$result->Status."</span>";} ?>
  <?php if($result->Status == "FAILURE"){echo "<span class='btn btn-danger btn-sm'>".$result->Status."</span>";} ?>
  </td>
  
  <td>
        <input type="text" id="txtOpId<?php echo $result->Id; ?>" class="form-control" style="width: 80px;">
  </td>




  <td> 
  <?php if($result->Status == "PENDING" or $result->Status == "HOLD" or $result->Status == "SUCCESS"){ ?>
    <select id="ddlstatus<?php echo $result->Id; ?>" name="ddlstatus" class="form-control" style="width: 80px;">
      <option value="0">Select Action</option>
      <optgroup label="STATUS UPDATE">
         <option value="Success">Success</option>
         <option value="Failure">Failure</option>
      </optgroup>
      <optgroup label="RESEND OPTIONS">
          
          <option value="ResendAIRTEL">Resend AIRTEL</option>
          <option value="ResendPAYTM">Resend PAYTM</option>
          <option value="ResendZPLUS">Resend ZPLUS</option>
          
      </optgroup>
    
      
    </select>
    <?php } ?>

    <?php if($result->Status == "FAILURE" ){ ?>
    <select id="ddlstatus<?php echo $result->Id; ?>" name="ddlstatus" class="form-control" style="width: 80px;">
      <option value="0">Select Action</option>
      
      <optgroup label="ROLLBACK">
          <option value="ROLLBACK">ROLLBACK</option>
      </optgroup>
      
    </select>
    <?php } ?>



  </td>
  <td>
      <?php if($result->Status == "PENDING" or $result->Status == "HOLD"  or $result->Status == "SUCCESS"   or $result->Status == "FAILURE"){ ?>
    <input type="button" id="btnstatuschange" class="btn btn-primary btn-mini" style="width: 60px;font-size: 10px;font-weight: bold" value="Submit" onClick="doaction('<?php echo $result->Id; ?>')"> 
    <?php } ?>  
  </td>
  
  
  </tr>

  <tr id="tr_reqresp<?php echo $result->Id; ?>" style="display:none">
     <td>Request </td><td colspan="6" id="tdreq<?php echo $result->Id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="7" id="tdresp<?php echo $result->Id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->Id; ?>')" >Hide</a></td>
 </tr>
		<?php
		 $totaldr += $result->debit_amount;
		 $totalcr += $result->credit_amount;
		if($result->Status == "SUCCESS"){
		$total_amount= $total_amount + $result->Amount;}
		$i++;} ?>
              </tbody>
            </table>
</form>             
              </div><!-- card-body -->
            </div>
        </div>
        </div>
      </div><!-- br-pagebody -->
      <?php include("elements/footer.php"); ?>




<input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."_Admin/dmr_report/checkstatus"; ?>">
  

<script language="javascript">
			function doaction(id)
      {
        if(confirm("Are You Sure ..??? Want Action : "+document.getElementById("ddlstatus"+id).value))
        {
          //frmstatuschange
          //hidstsupdtid
          //hidstsupdtstatus
          //hidstsupdate_action
        
          var status = document.getElementById("ddlstatus"+id).value;
          var opid = document.getElementById("txtOpId"+id).value;
          
          document.getElementById("hidstsupdtstatus").value = status;
          document.getElementById("hidstsupdtid").value = id;
          document.getElementById("hidstsupdopid").value = opid;
          document.getElementById("hidstsupdate_action").value = "STATUSUPDATE";
          document.getElementById("frmstatuschange").submit();
          
        }
      }
		</script>
<form id="frmstatuschange" action="" method="post">
      <input type="hidden" id="hidstsupdtid" name="hidId" value="">
     <input type="hidden" id="hidstsupdtstatus" name="hidstatus" >
     <input type="hidden" id="hidstsupdate_action" name="hidaction">
     <input type="hidden" id="hidstsupdopid" name="hidstsupdopid">
</form> 


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
