<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>API</title>

    
     
    
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
          <span class="breadcrumb-item active">OPERATOR REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>OPERATOR REPORT</h4>
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
                 <form action="<?php echo base_url()."API/operatorwisereport" ?>" method="post" name="frmCallAction" id="frmCallAction">

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

                                        <td valign="bottom">

                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">OPERATOR REPORT</h6>
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

<table style="width:100%;" cellpadding="3" cellspacing="0" border="1">
    <tr class="ColHeader" style="background: #4DA6FF;color: #fff;">
        <th >Date</th>
     
        <th >Operator_name</th>
    
        <th >Success Count</th>
    
        <th >Success Recharge</th>
    
        <th >Failure Recharge</th>  
         <th >Pending Recharge</th>  
    
        <th >Commission Given</th>
    </tr>
    <?php $TotalFailure = 0;$TotalPending = 0; $totalsuccesscount= 0; $i = 0;$TotalRecharge=0;$TotalCommission=0; foreach($result_all->result() as $result) 	
	{
	    $row_Failure = 0;
	    $row_Pending = 0;
	    if(isset($result->Failure))
	    {
	        $row_Failure = $result->Failure;
	        $TotalFailure += $result->Failure;   
	        
	    }
	    if(isset($result->Pending))
	    {
	        $TotalPending += $result->Pending;   
	        $row_Pending += $result->Pending;   
	    }
		 
		 
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $from."   To   ".$to; ?></td>
  <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->company_name; ?></td>
   <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->totalcount; ?></td>
 <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->Total; ?></td>
  <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $row_Failure; ?></td>
   <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;">
   <?php echo $row_Pending; ?></td>
 <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->Commission; ?></td>
 </tr>
		<?php 	
		
		$TotalCommission += $result->Commission;
		$TotalRecharge += $result->Total;
		 $totalsuccesscount += $result->totalcount;
		$i++;} ?>
        <tr class="ColHeader" style="background:#769DF8;border:1px solid #000;color: #fff;">
        <th ></th>
        <th >Total : </th>
       <th ><?php echo $totalsuccesscount;?></th>
       <th ><?php echo $TotalRecharge; ?></th>
        <th ><?php echo $TotalFailure; ?></th>
        <th ><?php echo $TotalPending; ?></th>
        <th ><?php echo $TotalCommission; ?></th>
        </tr>
        
		</table>
  
        </div>

       <?php

		}

	   else{

		   echo "<div class='message'>Record Not Found.</div>";

		   }

	   

	   }?>
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
