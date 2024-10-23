<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>KYC REQUEST</title>

    
     
    
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
          <span class="breadcrumb-item active">KYC REQUESTS</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>KYC REQUESTS</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">ACCOUNT REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">

               <table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                <th>Agent Name</th>
                <th>Role</th>
                <th>Document Type</th>
                <th>Document</th>    
                <th>Status</th> 
                <th></th>  
                <th></th>  
                </tr>
              </thead>
<tbody>
<?php $i = count($result_recharge->result());
    foreach($result_recharge->result() as $result)  {  ?>
    
      <tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
           
 <td style="width:120px; word-break: break-all;">
    
         <?php echo $result->businessname; ?>
         
         <br>
         <?php echo $result->mobile_no; ?>
    
     </td>
 
 <td><?php echo $result->usertype_name; ?></td>
 <td><?php echo $result->doc_type; ?></td>
 <td>
     <?php echo $result->document_number; ?>
     <br>
     
     <script language="javascript">var img_<?php echo $result->Id; ?> = '<img style="width:500px;height:500px" src="<?php echo base_url().$result->image_path; ?>">';</script>
     <img id="imagepancard<?php echo $result->Id; ?>" style="width:200px;height:200px;" src="<?php echo base_url().$result->image_path; ?>" onclick="showimageinpopup(img_<?php echo $result->Id; ?>)">
 </td>
 

 <td><?php echo $result->status; ?></td>
        
  <td><input type="text" id="txtRemark<?php echo $result->Id; ?>" name="txtRemark" class="form-control"  style="width:80px"></td>
  <td>
  
   
 <select style="width:80px;" class="form-control" id="action_<?php echo $result->Id; ?>">
     <option value="0"></option>
   <option value="APPROVED">Approve</option>
   <option value="REJECTED">Reject</option>
</select>
   <br>
    <input type="button" id="btnact" name="btnact" class="btn btn-primary btn-mini btn-sm" value="Submit" onClick="ActionSubmit('<?php echo $result->Id; ?>','<?php echo $result->mobile_no; ?>')" >
   
    
 </td>
  
 </tr>
 
 
    <?php   
    $i--;} ?>
</tbody>
</table>
              
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <form action="<?php echo base_url()."_Admin/kycrequest_list?id=".$this->input->get("id"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidrechargeid" name="hidrechargeid" />
<input type="hidden" id="hidremark" name="hidremark">
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
 </form>

<div class="modal fade" id="rechargeplan" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">View Image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
            <span id="imageview"></span>
      </div>
    </div>
   
  </div>
</div>
  <script>
function ActionSubmit(value,name)
{
  if(document.getElementById('action_'+value).selectedIndex != 0)
  {
  
    
    if(confirm('Are you sure?'))
    {
      document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
      document.getElementById('hidrechargeid').value= value;  
      document.getElementById('hidremark').value= document.getElementById('txtRemark'+value).value; 
            
      document.getElementById('frmCallAction').submit();
      }
  }
}
function showimageinpopup(img)
{
document.getElementById('imageview').innerHTML = img;
$('#rechargeplan').modal({show:true});
}
$(function() {
    $('.lazy').lazy({
        delay: 5000
    });
});
</script>
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
