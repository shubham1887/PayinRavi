<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>API | My Commission</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>

	 	

$(document).ready(function(){
document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
 $(function() {

            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});

            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});

         });

});
function getexport()
{
    
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(document.getElementById("tabdata").innerHTML));
}
function startexoprt()
{
		$('.DialogMask').show();
		document.getElementById('trmob').style.display = 'table-row';
	
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
	$.ajax({
			url:'<?php echo base_url()."API/accountreport/dataexport"?>?from='+from+'&to='+to,
			type:'post',
			cache:false,
			success:function(html)
			{
				document.getElementById('trmob').style.display = 'none';
				$('.DialogMask').hide();
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    			
			}
			});
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
          <a class="breadcrumb-item" href="#"></a>
          <span class="breadcrumb-item active">My Commission</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>My Commission</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">MY COMMISSION</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                  <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                 <tr>
    <th>Operator</th>  
    <th>Commission</th>
   <th>Limit</th>
   <th>UsedLImit</th>
    </tr>
    </thead>
    <?php	$i = 0;foreach($mycomm->result() as $result) 	{ 
	
	//print_r($result);exit;
	 ?>
	<tr>
    

  
  <td><?php echo $result->company_name; ?></td>
  <td><?php echo $result->commission; ?> %</td>
  <td><?php echo $result->loadlimit; ?></td>
  <td><?php echo $result->usedlimit; ?></td>
</tr>
		<?php 	
		$i++;} ?>
		</table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
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
