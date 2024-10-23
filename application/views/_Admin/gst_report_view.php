<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>GST Report</title>

    
     
    
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
		//var db = document.getElementById("ddldb").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		//document.getElementById("hiddb").value = db;
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
          <span class="breadcrumb-item active">DMT GST REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        
        <div class="col-sm-6 col-lg-5">
          <h4>DMT GST REPORT</h4>
        </div>
        
        <div class="col-sm-6 col-lg-7">
            
            
          
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
                  <form action="<?php echo base_url()."_Admin/gst_report" ?>" method="post" name="frmCallAction" id="frmCallAction">
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
                                           <label>Search</label>
                                            <input class="form-control" value="<?php echo $txtsearch; ?>" id="txtSearch" name="txtSearch" type="text" style="width:120px;">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">GST REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                  	<th>AgentName</th>
                    <th>UserType</th>
                    <th>TotalDmt</th>
                    <th>Txn Count</th>
                    <th>TotalDebit</th>
                    <th>Total CCF</th>
                    <th>Total Cashback</th>
                    <th>Total Gst</th>
                    <th>Total TDS</th>
                     
                </tr>
              </thead>
              <tbody>
              <?php	
			$i = 0;
      $totalAmount = 0;
      $totalCharge_Amount = 0;
      $totalCharge_ccf = 0;
      $totalCharge_cashback = 0;
      $totalCharge_gst = 0;
      $totalCharge_tds = 0;
			foreach($result_mdealer->result() as $result)
	 		{
				if(true)
				{	
		  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
<td><?php echo $result->businessname; ?><br><?php echo $result->username; ?></td>
 <td ><?php echo $result->usertype_name; ?></td>
  <td><?php echo $result->Amount; ?></td>
  <td><?php echo $result->totalcount; ?></td>

  <td><?php echo $result->Charge_Amount; ?></td>
  <td><?php echo $result->ccf; ?></td>
				
				
				
  <td ><?php echo $result->cashback; ?></td>
				
				
		
   
 <td><?php echo $result->gst; ?></td>
 <td ><?php echo $result->tds; ?></td>
 
 </tr>
		<?php

    $totalAmount += $result->Amount;
    $totalCharge_Amount += $result->Charge_Amount;
    $totalCharge_ccf += $result->ccf;
    $totalCharge_cashback += $result->cashback;
    $totalCharge_gst += $result->gst;
    $totalCharge_tds += $result->tds;


		$i++;} } ?>


<tr>
  <th></th>
  <th></th>
  <th>Amount : <?php echo $totalAmount; ?></th>
  <th></th>
  <th>Total Debit : <?php echo $totalCharge_Amount; ?></th>
  <th>CCF : <?php echo $totalCharge_ccf; ?></th>
  <th>CASHBACK : <?php echo $totalCharge_cashback; ?></th>
  <th>GST : <?php echo $totalCharge_gst; ?></th>
  <th>TDS : <?php echo $totalCharge_tds; ?></th>
</tr>



              </tbody>
            </table>
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script language="javascript">
      
      function addremark(Id,payment_id)
      {
           
        document.getElementById('hidtblpayment_id').value = payment_id;
          document.getElementById('spanpaymentid').innerHTML = payment_id;
          document.getElementById('hidpaymentid').value = Id;
       $('#myremarkupdatemodel').modal({'show':true});   
      }
      
      
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


<div class="modal fade" id="myremarkupdatemodel" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
             <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
              <h4 class="modal-title" id="modalmptitle"></h4>
              
            </div>
            <div class="modal-body">
                <form id="frmRemarkUpdate" action="" method="post">
                <table>
                    <tr>
                        <td>
                            <h5 style="color:#000">Payment Id : <span id="spanpaymentid"></span></h5>
                        </td>
                    </tr>
                    <tr>
                        
                        	 <td>
                        	     <label>
                        	 Bank</label>
                            <select id="ddlbank" name="ddlbank" style="width:200px" class="form-control-sm">
                                <option value="SBI">SBI</option>
                                <option value="ICICI">ICICI</option>
                                <option value="MEHSANA">MEHSANA</option>
                                <option value="CREDIT">CREDIT</option>
                                <option value="CASH">CASH</option>
                                <option value="EXCHANGE">EXCHANGE</option>
                                <option value="WRONG">WRONG</option>
                                <option value="OTHER">OTHER</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        
                        <td>
                            <input type="text" id="txtRemark" name="txtRemark" class="form-control" placeholder="Enter Admin Remark" style="width:400px;">
                        </td>
                        <td><input type="button" id="btbsubmitremark" value="Update" class="btn btn-success" onClick="actionupdateremark()"></td>
                    </tr>
                </table>    
                <input type="hidden" id="hidtblpayment_id" name="hidtblpayment_id">
                <input type="hidden" id="hidpaymentid" name="hidpaymentid">
                
                </form>
            </div>
            <div class="modal-footer">
             <span id="spanbtnclode" > <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
            </div>
          </div>
        </div>
    </div>
    <input type="hidden" id="hidremarkupdateurl" value="<?php echo base_url()."_Admin/account_report/updateadminremark" ?>">
<script language="javascript">
    function actionupdateremark()
		{
			$.ajax({
				url:document.getElementById("hidremarkupdateurl").value,
				cache:false,
				data:$('#frmRemarkUpdate').serialize(),
				method:'POST',
				success:function(data)
				{
				
				},
				error:function()
				{
					
				},
				complete:function()
				{
					$('#myremarkupdatemodel').modal('hide');
				}
				});
		}
</script>

<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/gst_report/dataexport" ?>" method="get">
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
