<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Add Fund</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   <script src="<?php echo base_url()."js/jquery-1.4.4.js"; ?>"></script>
      <script type="text/javascript">
	  
	  $(document).ready(function(){setTimeout(function(){$('div.alert').fadeOut(1000);}, 15000); });
	  
	  
	  
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        }
    </script>
      <style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}

.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
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
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.tooltip {
  position: relative;
  display: inline-block;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/websidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/webheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."WEB/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">DMT</a>
          <span class="breadcrumb-item active">DMT Transactions</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>ADD FUND</h4>
        </div>
      </div><!-- d-flex -->
	  <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
      	    
      	      <?php
	if($this->session->flashdata('message')){
	echo "<div class='message'>".$this->session->flashdata('message')."</div>";}	
	if($message != ''){
	echo "<div class='message'>".$message."</div>";}
	?>
      	    
      	    
      	    
      	    
        <?php include("elements/messagebox.php"); ?>
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Add Fund</h6>
                
              </div><!-- card-header -->
              <div class="card-body">
                 	 <div id="process" style="display:none;">
 <img src="<?php echo base_url().'images/ajax.gif'; ?>" width="128" height="15" align="middle" alt="Please wait we process your data." title="Please wait we process your data." border="none" />
 </div>
    <form action="<?php echo base_url()."WEB/add_fund_final"; ?>" method="post" name="frmpay" id="frmpay" >
    <table class="table">
    <tr>
    	<td>Enter Amount : </td>
    	<td><input type="text" id="txtAmount" name="txtAmount" placeholder="Enter Amount" value="<?php echo $this->input->post("hidAmount") ?>" class="form-control" style="width:320px"></td>
    </tr>
    <tr>
    	<td>Remark</td><td><input type="text" id="txtRemark" name="txtRemark" value="<?php echo $this->input->post("hidRemark") ?>" placeholder="Enter Remark" class="form-control" style="width:320px"></td>
    </tr>
    <tr>
    	<td></td>
        <td>
        <input type="button" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Submit" onClick="submitvalidateform()"></td>
    </tr>
    
    </table>
	</form>
    <script language="javascript">
	function submitvalidateform()
	{
		document.getElementById("frmpay").submit();
	}
	
	</script>
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
