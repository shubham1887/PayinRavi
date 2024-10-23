<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>REQUEST RESPONSE LOG</title>

    
     
    
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

<style>
.myselect {
  margin: 1px  !important; ;
  width: 70px  !important; ;
  padding: 1px 5px 1px 1px  !important; ;
  font-size: 12px  !important; ;
  border: 1px solid #ccc  !important; ;
  height: 24px  !important; ;
}
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
          <a class="breadcrumb-item" href="#">DEVELOPER OPTIONS</a>
          <span class="breadcrumb-item active">Request Response Log</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Request Response Log</h4>
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
                  <form action="<?php echo base_url()."_Admin/requestlog?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                            <input class="form-control" id="txtFromDate" name="txtFromDate" type="text" value="<?php echo $from; ?>" style="width:120px;cursor:pointer;" readonly>
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control" id="txtToDate" name="txtToDate" type="text" value="<?php echo $to; ?>" style="width:120px;cursor:pointer;" readonly>
                                        </td>
                                        
                                        <td style="padding-right:10px;">
                                        	 <h5>Search Text</h5>
                                            <input class="form-control" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:180px;">
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">REQUEST RESPONSE LOG</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
				<table class="table table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
    <tr>  
    
    <th>Id</th>
    <th>DateTime</th>
    <th style="width:400px;max-width:400px;word-wrap:break-word;overflow:hidden">Request</th>  
    <th>Response</th>
    <th>Ip</th>
                     
    </tr>
    <?php $i=0;foreach($result_recharge->result() as $result) 	{  ?>
    
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
           
 <td><?php echo $result->Id; ?></td>
 <td><?php echo $result->add_date; ?></td>
 <td style="width:400px;max-width:400px;word-wrap:break-word;overflow:hidden"><?php print htmlentities($result->request); ?></td>
 <td style="width:400px;max-width:400px;word-wrap:break-word;overflow:hidden;"><?php echo htmlentities($result->response); ?></td>
 <td><?php echo $result->ipaddress; ?></td>
 
 </tr>
		<?php 	
	$i++;	} ?>
        <tr class="ColHeader" style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
      <th > </th>
     <th  > </th>
     <th > </th>
      <!--<th > </th>-->
    </tr>
		</table> 
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
