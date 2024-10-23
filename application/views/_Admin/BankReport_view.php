<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Bank Report</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	
	
	//document.getElementById("ddluser").value = '<?php echo $ddluser; ?>';
	document.getElementById("ddlbank").value = '<?php echo $ddlbank; ?>';
	
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
          <span class="breadcrumb-item active">BANK REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>BANK REPORT</h4>
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
                  <form action="<?php echo base_url()."_Admin/BankReport" ?>" method="post" name="frmCallAction" id="frmCallAction">
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
                                        	 <label>Select Bank</label>
                                           <select id="ddlbank" name="ddlbank" class="form-control" style="width: 120px">
                    											   <option value="ALL">ALL</option>
                    											   <option value="ROYAL_SBI">ROYAL_SBI</option>
                    											   <option value="ROYAL_BOI">ROYAL_BOI</option>
                    											</select>
                                        </td>




                                        <td style="padding-right:10px;">
                                           <label>Select User</label>
                                           <input class="form-control" value="" id="txtUser" name="txtUser" type="text" style="width:120px;">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">BANK REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
    <th>BankName</th>
    <th>TxnDate</th>
    <th>ValueDate</th>
    <th>Description</th>
    
    <th>BranchCode</th>
    <th>Debit</th>
    <th>Credit</th>
    <th>Balance</th>
    <th>Party1</th>
    <th>Party2</th>
    <th>Remark</th>
    <th>Change Remark</th>
                        
                </tr>
              </thead>
              <tbody>
              <?php	
			$i = 0;
			foreach($result_bank->result() as $result)
	 		{
				if(true)
				{	
		  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
        <td><?php echo $result->BankName; ?></td>
        <td><?php echo $result->TxnDate; ?></td>
        <td><?php echo $result->ValueDate; ?></td>
        <td>
          <?php echo $result->Description; ?>
            <br>
            <?php echo $result->RefNoChqNo; ?>

          </td>
        <td><?php echo $result->BranchCode; ?></td>
        <td><?php echo $result->Debit; ?></td>
        <td><?php echo $result->Credit; ?></td>
        <td><?php echo $result->Balance; ?></td>
        <td><?php echo $result->party_name1; ?></td>
        <td><?php echo $result->party_name2; ?></td>
				<td><?php echo $result->admin_remark; ?></td>

      <td>
        <input type="text" id="txtparty1<?php echo $result->Id; ?>" onKeyUP="updateparty1('PARTY1',<?php echo $result->Id; ?>)">

      
        <input type="text" id="txtparty2<?php echo $result->Id; ?>" onKeyUP="updateparty2('PARTY2',<?php echo $result->Id; ?>)">

      </td>

				
 </tr>
		<?php 	
		$i++;} } ?>
              </tbody>
            </table>
              </div><!-- card-body -->
            </div>
           
        </div>
        </div>
      </div><!-- br-pagebody -->
<input type="hidden" id="hidupdateurl" value="<?php echo base_url()."_Admin/BankReport/setValues"; ?>">
      <script language="javascript">
          function updateparty2(field,id)
          {

                  var party1 = document.getElementById("txtparty2"+id).value;
                 
                    $.ajax({
                          type:"POST",
                          url:document.getElementById("hidupdateurl").value,
                          data:{'Id':id,"value":party1,'field':field},
                          beforeSend: function() 
                          {
                              document.getElementById("txtparty2"+id).style.backgroundColor  = "yellow";
                           //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                    },
                          success: function(response)
                          {
                             
                             //$('#myModalProgress').modal('hide');
                             document.getElementById("txtparty2"+id).style.backgroundColor  = "";
                            console.log(response);  
                          },
                          error:function(response)
                          {
                            // $('#myModalProgress').modal('hide');
                          },
                          complete:function()
                          {
                            //$('#myModalProgress').modal('hide');
                            document.getElementById("txtparty2"+id).style.backgroundColor  = "";
                            
                          }
                        });      
                }

          function updateparty1(field,id)
          {

                  var party1 = document.getElementById("txtparty1"+id).value;
                 
                    $.ajax({
                          type:"POST",
                          url:document.getElementById("hidupdateurl").value,
                          data:{'Id':id,"value":party1,'field':field},
                          beforeSend: function() 
                          {
                              document.getElementById("txtparty1"+id).style.backgroundColor  = "yellow";
                           //$('#myModalProgress').modal({show:true,backdrop: 'static',keyboard: false});
                                    },
                          success: function(response)
                          {
                             
                             //$('#myModalProgress').modal('hide');
                             document.getElementById("txtparty1"+id).style.backgroundColor  = "";
                            console.log(response);  
                          },
                          error:function(response)
                          {
                            // $('#myModalProgress').modal('hide');
                          },
                          complete:function()
                          {
                            //$('#myModalProgress').modal('hide');
                            document.getElementById("txtparty1"+id).style.backgroundColor  = "";
                            
                          }
                        });      
                }
      </script>
   
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
