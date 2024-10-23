<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Operator Wise Report</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
     <script>
	 	
$(document).ready(function(){
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
 $(function() {
            $( "#txtFromDate" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtToDate" ).datepicker({dateFormat:'yy-mm-dd'});
         });
});
	
	
	function startexoprt()
{


	
		var from = document.getElementById("txtFromDate").value;
		var to = document.getElementById("txtToDate").value;
	var ddlapi = document.getElementById("ddlapi").value;
 //  var ddluser = document.getElementById("ddluser").value;
	
    document.getElementById("hidfrom").value = from;
    document.getElementById("hidto").value = to;
  document.getElementById("hidapi").value = ddlapi;
 //  document.getElementById("hiduser").value = ddluser;
    document.getElementById("frmexport").submit();
}
	
	</script>
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
</style>
    <!--    ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all-->
    <style>
	.error
	{
  		background-color: #ffdddd;
	}
	</style>
    <style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}
#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
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
          <a class="breadcrumb-item" href="#">REPORTS</a>
          <span class="breadcrumb-item active">OPERATOR WISE REPORT</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>OPERATOR WISE REPORT</h4>
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
                  <form action="<?php echo base_url()."_Admin/operatorwisereport" ?>" method="post" name="frmSearch" id="frmSearch">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                            <input class="form-control" value="<?php echo $from; ?>" id="txtFromDate" name="txtFromDate" type="text" style="width:120px;cursor:pointer" readonly >
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control" id="txtToDate" value="<?php echo $to; ?>" name="txtToDate" type="text" style="width:120px;cursor:pointer" readonly>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>API</h5>
                                        	 
                                           <select id="ddlapi" name="ddlapi" style="width:80px;" class="form-control" style="width:120px;hight:30px;">
                                                <option value="0">ALL</option>
                                                <?php echo $this->Api_model->getApiListForDropdownList_whereapi_id_not_equelto(1,2,3);  ?>
                                            </select>
                                        </td>
                                        
                                        
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
 <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/operatorwisereport/dataexport" ?>" method="get">
                                   <input type="hidden" id="hidfrom" name="from" />
<input type="hidden" id="hidto" name="to" />
<input type="hidden" id="hidapi" name="ddlapi" />
<input type="hidden" id="hiduser" name="ddluser"/>
                                    </form>

                            
                                    
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">OPERATOR WISE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <?php if($result_recharge != false) {?>
<table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    <th >Date</th>
    <th >Operator_name</th>
    <th >Success Count</th>
     <th >Success Recharge</th> 
      <th >Admin Comm</th>
      <th >MD Comm</th>
       <th >Dist Comm</th>
     <th >Agent+Api Comm</th>
     <th >Admin Receive</th>
     
    </tr>
    <?php $totalsuccesscount= 0; $i = 0;$TotalRecharge=0;$TotalCommission=0;$TotalMDCommission=0;$TotalDistCommission=0;$TotalAdminComm=0;$AdminReceiveTotal=0; foreach($result_recharge->result() as $result) 	
	{
		
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td><?php echo $from."   To   ".$to; ?></td>

  <td ><?php echo $result->company_name; ?></td>
   <td ><?php echo $result->totalcount; ?></td>
 <td ><?php echo $result->Total; ?></td>
 <td ><?php echo $result->AdminComm; ?></td>
  <td ><?php echo $result->MdComm; ?></td>
   <td ><?php echo $result->DComm; ?></td>
 <td ><?php echo $result->Commission; ?></td>
 <td ><?php
 $AdmiRecive = ($result->AdminComm)-($result->MdComm  + $result->DComm + $result->Commission);
  echo $AdmiRecive; ?></td>
 </tr>
		<?php 	
		
		$TotalCommission += $result->Commission;
		$TotalAdminComm += $result->AdminComm;
		$TotalMDCommission += $result->MdComm;
		$TotalDistCommission += $result->DComm;
		$TotalRecharge += $result->Total;
		 $totalsuccesscount += $result->totalcount;
		 $AdminReceiveTotal += $AdmiRecive;
		$i++;} ?>
        <tr style="background-color:#804000;font-size:14px;font-weight:bold;color:#FFFFFF;">
        <td></td>
         <td></td>
        <td><b>Total : &nbsp;&nbsp;&nbsp; <?php echo $totalsuccesscount;?></b></td>
        <td><?php echo $TotalRecharge; ?></td>
         <td><?php echo $TotalAdminComm; ?></td>
         <td><?php echo $TotalMDCommission; ?></td>
          <td><?php echo $TotalDistCommission; ?></td>
        <td><?php echo $TotalCommission; ?></td>
        <td><?php echo $AdminReceiveTotal; ?></td>
        </tr>
        
		</table>
<?php } ?> 
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
