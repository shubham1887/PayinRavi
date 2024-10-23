<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>PAYMENT REQUEST</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	 	
$(document).ready(function(){
	
	
	document.getElementById("ddlpaymenttype").value = '<?php echo $ddlpaymenttype; ?>';
	document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
	
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
          <a class="breadcrumb-item" href="<?php echo base_url()."API/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">PAYMENT REQUEST</a>
          <span class="breadcrumb-item active">PAYMENT REQUEST</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>PAYMENT REQUEST</h4>
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
                  <table>
                    <tr id="trmob" style="display:none">
    	<td align="center" colspan="2" >
            <img src="<?php echo base_url()."ajax-loader_bert.gif"; ?>"/>
        </td>
        
    </tr><tr id="trmobmsg" style="display:none">
    	<td align="center" colspan="2">
        	<span id="mobmsg" class="mobmsg"></span>
        </td>
        
    </tr></table>
    
    
    
    <div id="divaltmsg" class="alert alert-success alert-dismissable" style="display:none">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>	<i class="icon fa fa-check"></i> Success!</h4>
                   <span id="spanmsg"></span>
    </div>
                  
                  
                  <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if($this->session->flashdata('message')){
	echo "<div class='message'>".$this->session->flashdata('message')."</div>";}
	?>
    <div>
<form action="<?php echo base_url().'API/payment_request'; ?>" method="post" name="frmPayment" id="frmPayment">
        
    <table class="table table-hover table-bordered" style="width:700px">
    <tr>
    <td align="right"><label for="txtReqamt"><span style="color:#F06">*</span>Select Bank:</label></td>
    <td align="left">
    <select id="ddlpaymenttype" name="ddlpaymenttype" class="form-control-sm" style="width:200px;">	
    <option value="">Select</option>
     <option value="CASH_OFFICE">CASH OFFICE</option>
     <option value="CREDIT">CREDIT</option>
    <optgroup label="AXIS">
    <option value="AXIS_CASH">AXIS CASH</option>
    <option value="AXIS_NEFT">AXIS NEFT / RTGS</option>
    <option value="AXIS_IMPS">AXIS IMPS</option>
    <option value="AXIS_TO_AXIS">AXIS To AXIS</option>
     <option value="AXIS_CHAQUE">BY CHAQUE</option>
    </optgroup>
   
   
    </select>
   
   
    </td>
  
    <td align="right"><label for="txtPaymentdate"><span style="color:#F06">*</span>Amount :</label></td>
    <td align="left"><input type="text" name="txtAmount" placeholder="Enter Amount" id="txtAmount" class="form-control-sm"  style="width:200px;" onKeyPress="return isNumeric(event);"/>
    </td>
  </tr>
  <tr>
    <td align="right"><label for="txtPaymentdate"><span style="color:#F06">*</span>Ref. Id  / Branch :</label></td>
    <td align="left"><input type="text" name="txtTid" placeholder="Enter Transaction Id" id="txtTid" class="form-control-sm"  style="width:200px;"/>
    </td>
 
   <td align="right"><label for="txtRemarks">Remarks :</label></td>
   <td align="left"><textarea id="txtRemarks" name="txtRemarks" placeholder="Enter Remarks." cols="21" rows="2" class="form-control-sm" style="width:200px;"></textarea><br />
   </td>
  </tr>
  <tr>
    <td align="right"><label for="ddlwallettype"><span style="color:#F06">*</span>Wallet Type :</label></td>
    <td align="left">
      <select id="ddlwallettype" name="ddlwallettype">
        <option value="Wallet1">Wallet1</option>
        <option value="Wallet2">Wallet2</option>
      </select>
    </td>
    <td align="right">&nbsp;</td>
    <td align="left"><input type="botton" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary btn-sm"  onclick="validateform()"/></td>
  </tr>
</table>
</form>
<script language="javascript">
function validateform()
{
	var ddlpaymenttype = $('#ddlpaymenttype');
	var txtAmount = $('#txtAmount');
	var txtTid = $('#txtTid');
	var txtRemarks = $('#txtRemarks');
	var form = $('#frmPayment');
	document.getElementById('divaltmsg').style.display = 'none';
	
	if(validatefield(ddlpaymenttype) & validatefield(txtAmount) & validatefield(txtTid) & validatefield(txtRemarks))
	{
		$('.DialogMask').show();
		document.getElementById('divaltmsg').style.display = 'none';
		document.getElementById('trmob').style.display = 'table-row';
		$.ajax( {
		  type: "POST",
		  url: form.attr( 'action' ),
		  data: form.serialize(),
		  success: function( response) 
		  {
		  		document.getElementById('trmob').style.display = 'none';
				document.getElementById('trmobmsg').style.display = 'table-row';
				document.getElementById('divaltmsg').style.display = 'block';
				document.getElementById('spanmsg').innerHTML = response;
				$('.DialogMask').hide();
      	  }
    } );
		
	}
	else
	{
		alert("Please Fill All The Fields");
	}
	
}
function validatefield(param)
{
	if(param.val() == "")
	{
		param.addClass("error");
		return false;
	}
	else
	{
		param.removeClass("error");
		return true;
	}
}
</script>
 <style>
 .error
 {
 	background:#FFBBBB;
 }
 </style>   
    
    
    
    
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
