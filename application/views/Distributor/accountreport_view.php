<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>ACCOUNT REPORT</title>

    
     
    
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
	
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
	
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
	
		document.getElementById("frmexport").submit();
	
}
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
          <span class="breadcrumb-item active">ACCOUNT REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ACCOUNT REPORT</h4>
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
                  <form action="<?php echo base_url()."Distributor/accountreport?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">                            
                                    <input type="hidden" id="hidID" name="hidID">                                     
                                    <table cellspacing="10" cellpadding="3">                                     
                                    <tr>                                     
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>From Date</h5>                                             
                                    <input class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;cursor:pointer;" readonly placeholder="Select Date">                                         </td>                                     	
                                    <td style="padding-right:10px;">                                         	 
                                    <h5>To Date</h5>                                             
                                    <input class="form-control" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:120px;cursor:pointer;" readonly placeholder="Select Date">                                         
                                    </td>                                                                                                                           
                                    <td valign="bottom">                                         
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">                                                                                 
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">
                                    </td>                                     
                                    </tr>                                     
                                    </table>                                                                                                                                                              </form>
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
                <table class="table table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
                                        <tr>     
                                        <th>Payment Date</th>     
                                        <th>Payment Id</th>     
                                        <th>Payment To</th>     
                                        <th>User type</th>     
                                        <th>Transaction type</th>      
                                        <th>Payment type</th>     
                                        <th>Description</th>     
                                        <th>Remark</th>     
                                        <th>Credit Amount</th>
                                        <th>Debit Amount</th>          
                                        <th>Balance</th>          
                                        </tr>     
										<?php	
										$i = 0;
										foreach($result_mdealer->result() as $result) 	 	
										{ 			
											  ?> 			
                                        <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>"> 
                                        <td><?php echo date_format(date_create($result->payment_date),'d-M-Y H:i:s'); ?></td>  
                                        <td ><?php echo $result->payment_id; ?></td>   <td><?php echo $result->bname; ?></td>   
                                        <td><?php echo $result->usertype; ?></td>   
                                        <td ><?php echo $result->transaction_type; ?></td>    
                                        <td ><?php echo $result->payment_type; ?></td>  
                                        <td><?php echo $result->description; ?></td>  
                                        <td ><?php echo $result->remark; ?></td>  
                                        <td><?php echo $result->credit_amount ?></td>    
                                        <td><?php echo $result->debit_amount ?></td>    
                                         <td><?php echo $result->balance; ?></td>  </tr> 		<?php 	 		$i++;} ?> 		</table>
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
        </div>
      </div><!-- br-pagebody -->
      
<form id="frmexport" name="frmexport" action="<?php echo base_url()."Distributor/accountreport/dataexport" ?>" method="get">
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
