<?php
$pagination='';
if($total_page>1){
    $pagination.='<div class="pagination">';
    
    if($total_page>20)$total_page=20;
    for($byt=1;$byt<=$total_page;$byt++)
    {
        $cls="";$link='javascript:void(0);';$submit='onclick="javascript:submitform('.$byt.');"';
        if($byt==$page)
        {
            $cls='class="active"';$submit='';
            $link='javascript:void(0);';
        }
        $pagination.='<a '.$cls.' '.$submit.' href="'.$link.'">'.$byt.'</a>';
    }
    
    $pagination.='</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Aeps Report</title>

    
     
    
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
          <a class="breadcrumb-item" href="<?php echo base_url();?>API/dashboard" >Dashboard</a>
          <a class="breadcrumb-item" href="#">REPORT</a>
          <span class="breadcrumb-item active">AEPS REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
       <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">AEPS REPORT</h4>
                        
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                 <button class="btn btn-success btn-sm" type="button">Success : <?php echo $summary_array["Success"]; ?></button>
                                </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-warning btn-sm" type="button">Pending : <?php echo $summary_array["Pending"];  ?></button>
                                  </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <button class="btn btn-danger btn-sm" type="button">Failure : <?php echo $summary_array["Failure"];  ?></button>
                                  </div>
                                
                            </div>

                            
                        </div>
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
                 <form action="<?php echo base_url()."API2/Aeps_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
 
                                    <td style="padding-right:10px;">
                                             <h5>From Date</h5>
                                            <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>To Date</h5>
                                            <input class="form-control-sm" id="txtTo" value="<?php echo $to; ?>" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>Status</h5>
                                           <select id="ddlstatus" name="ddlstatus" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="Success">Success</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Failure">Failure</option>
                                            
                                           </select>

                                            <script type="text/javascript">
                                               document.getElementById("ddlstatus").value = '<?php echo $ddlstatus; ?>';
                                           </script>
                                           
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>Operator</h5>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm">
                                            <option value="ALL">ALL</option>
                                            <option value="WAP">Withdrawal</option>
                                            <option value="BAP">Balance Check</option>
                                            <option value="MIS">Statement</option>
                                            
                                           </select>
                                           
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>Number / Id</h5>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:180px;" >
                                        </td>
                                        <td style="padding-right:10px;">
                                             <h5>Data</h5>
                                            <select id="ddldb" name="ddldb" class="form-control-sm" style="width:120px;">
                                                <option value="LIVE">LIVE</option>
                                                <option value="ARCHIVE">ARCHIVE</option>
                                            </select>
                                        </td>
                                        <td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary btn-sm">
                                         <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-sm" onClick="startexoprt()">
                                      
                                        </td>
                                    </tr>
                                    </table>
                                        
                                      <input type="hidden" name="page" id="page" value="1"> 
                                       
                                    </form>
                                    <form id="frmexport" name="frmexport" action="<?php echo base_url()."API2/Aeps_report/dataexport" ?>" method="get">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">ACCOUNT REPORT</h6>
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
   <th >Client ID</th>
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
  
  <td><?php echo "<span id='db_ssid".$i."'>".$result->Id."</span>"; ?></td> 
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
    <td><?php echo "<span id='db_amount".$i."'>".$result->resp_status." </span>"; ?></td>
 </tr>
 
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
