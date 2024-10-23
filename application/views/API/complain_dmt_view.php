<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>COMPLAIN BOX</title>
    
     
    
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
          <a class="breadcrumb-item" href="<?php echo base_url()."API/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">REPORT</a>
          <span class="breadcrumb-item active">COMPLAIN BOX</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>COMPLAIN BOX</h4>
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
                  <form action="<?php echo base_url()."API/complain_dmt" ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <label>From Date</label>
                                            <input readonly class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;cursor:pointer" placeholder="Select Date">
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>To Date</label>
                                            <input readonly class="form-control" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:120px;;cursor:pointer" placeholder="Select Date">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>Search</label>
                                            <input class="form-control" value="<?php echo $searchword; ?>" id="txtSearch" name="txtSearch" type="text" style="width:120px;" placeholder="">
                                        </td>
										<td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSearch" value="Search" class="btn btn-primary">
                                      
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">COMPLAIN LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">

<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
        <tr> 
          <th>Comp<br>Id</th>
          <th>Dmr.Id</th>
          <th>Order.Id</th>
          <th>Sender No </th>
         
          <th>DMT Date</th>
          <th>Complain Date</th> 
          <th>Refund Date</th> 
          <th>Comp.Status</th> 
          <th>Message</th> 
         
          <th>Response Message</th>
          
              
        </tr> </thead>
     <tbody>
    <?php
	
		$i = 0;foreach($result_complain->result() as $result) 	{  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
                <td>
                    <?php echo $result->complain_id; ?>
                   
                </td>
                <td>
                    <?php echo $result->dmr_id; ?>
                   
                </td>
                <td><?php echo $result->order_id; ?></td>
                
                
                
                 <td style="min-width:220px;">			
						Sender : <?php echo $result->RemiterMobile; ?>
						<br>
						Account No : <?php echo $result->AccountNumber; ?>
						<br>
						<?php echo $result->IFSC; ?>
						<br>
						Amt : <?php echo $result->Amount; ?>
						<br>
						 <?php 
						        if($result->Status == "Failure")
						        {
						            echo '<span class="btn btn-danger btn-sm">Failure</span>';
						        }
						        if($result->Status == "Success")
						        {
						            echo '<span class="btn btn-success btn-sm">Success</span>';
						        }
						        if($result->Status == "Pending")
						        {
						            echo '<span class="btn btn-primary btn-sm">Pending</span>';
						        }
						 ?>
						  OprId:<?php echo $result->RESP_opr_id; ?><br>
						  Status:<?php 
						                if($result->Status == "SUCCESS"){$class = "btn btn-success btn-sm";}
						                if($result->Status == "FAILURE"){$class = "btn btn-danger btn-sm";}
						                if($result->Status == "PENDING"){$class = "btn btn-primary btn-sm";}
						                
						  ?><span class="<?php echo $class; ?>"><?php echo $result->Status; ?></span>
						 
                </td>
                 
                 <td >			
						<?php echo $result->add_date; ?>
                </td>
                
            	
                
                 
               
              <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->complain_date; ?>
            </td>
            
            <td><?php if($result->refund_date != "0000-00-00 00:00:00"){echo $result->refund_date;} ?></td>
                
                
                <td >			
						<?php if($result->complain_status == "Pending"){echo "<span class='btn btn-primary btn-sm'>".$result->complain_status."</span>";} ?>
                      <?php if($result->complain_status == "Solved"){echo "<span class='btn btn-success btn-sm'>".$result->complain_status."</span>";} ?>
                      <?php if($result->complain_status == "Unsolved"){echo "<span class='btn btn-danger btn-sm'>".$result->complain_status."</span>";} ?>
                      <?php if($result->complain_status == "InProcess"){echo "<span class='btn btn-warning btn-sm'>".$result->complain_status."</span>";} ?>
                </td>
                
                
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->message; ?>
                </td>
                
                
                <td class="padding_left_10px box_border_bottom box_border_right" align="left" height="34" style="min-width:120px;width:150px;">			
						<?php echo $result->response_message; ?>
                </td>
                
                
                
 				
 </tr>
		<?php 	
		$i++;} ?>
        </tbody>
		</table>
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
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>     ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    else
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>   ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    
                }
                }); 
            
        
    }
</script>
<form id="frmexport" name="frmexport" action="<?php echo base_url()."API/Account_report/dataexport" ?>" method="get">
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
