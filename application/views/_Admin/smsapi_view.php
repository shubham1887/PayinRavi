<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>SMS API SETTINGS</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
	
$(document).ready(function(){
});
	function SetEdit(id)
	{
	    document.getElementById("txtAPIName").value = document.getElementById("apiname_"+id).value;
	    document.getElementById("txtUserName").value = document.getElementById("apiurl_"+id).value;
	    document.getElementById("hidID").value  = id;
	    
	    document.getElementById("btnSubmit").value = "Update";
	}

    function Confirmation(value)
    {
    
    	if(confirm("Are you sure?\nyou want to delete ") == true)
    	{
        	document.getElementById("hidValue").value = value;
        	document.getElementById("frmDelete").submit();
    	}
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
          <span class="breadcrumb-item active">SMS API CONFIGURATION</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>SMS API CONFIGURATION</h4>
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
                   <form method="post" action="<?php echo base_url()."_Admin/smsapi"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
<table>
<tr>
    <td align="right"> API Name :</td>
    <td align="left">
        <input type="text" class="form-control-sm" id="txtAPIName" placeholder="Enter API Name" name="txtAPIName" maxlength="20" style="width:200px;" />
        
</td>
</tr>
<tr>
<td align="right"> URL :</td><td align="left"><input type="text" id="txtUserName" class="form-control-sm" placeholder="Enter URL.<br>e.g " name="txtUserName" style="width:1000px">
</td>
</tr>
<tr>
<td></td>
<td align="left">
    <input type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit" value="Submit"/> 
    <input type="reset" class="btn btn-default" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/>
</td>
</tr>
</table>
<input type="hidden" id="hidID" name="hidID" />
</form>
<form action="<?php echo base_url()."_Admin/smsapi"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
</form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">SMS API LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <table class="table table-bordered table-striped" style="color:#00000E">
     <thead class="thead-colored thead-primary" >
        <tr> 
            <th>API Name</th> 
            <th>Url</th>
            <th >Actions</th> 
        </tr> </thead><tbody>
    <?php	$i = 0;foreach($result_api->result() as $result) 	{  ?>
     
			<tr >
              <td><span id="name_<?php echo $result->Id; ?>"><?php echo $result->apiname; ?></span></td>
             <td>
                 <span id="uname_<?php echo $result->Id; ?>"><?php echo urldecode($result->url); ?></span>
                 <input type="hidden" id="apiurl_<?php echo $result->Id; ?>" value="<?php echo $result->url; ?>">
                 <input type="hidden" id="apiname_<?php echo $result->Id; ?>" value="<?php echo $result->apiname; ?>">
             </td>
                <td><input type="button" class="btn btn-danger btn-sm" value="Delete" onClick="Confirmation('<?php echo $result->Id; ?>')"> 
                <input type="button" class="btn btn-primary btn-sm" value="Edit" onClick="SetEdit('<?php echo $result->Id; ?>')"></td>   
             
             </tr>
           
		<?php 	
		$i++;} ?>
        </tbody>
		</table>
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
