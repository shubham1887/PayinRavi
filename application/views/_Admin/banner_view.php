<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Banner</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
function SetEdit(value)
	{
		document.getElementById('txtAPIName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('txtUserName').value=document.getElementById("uname_"+value).innerHTML;		
		document.getElementById('txtPassword').value=document.getElementById("pwd_"+value).innerHTML;
		document.getElementById('txtIp').value=document.getElementById("ipaddr_"+value).innerHTML;
		document.getElementById('ddlhttpmethod').value=document.getElementById("method_"+value).innerHTML;
		
		
		document.getElementById('txtparameters').innerHTML=document.getElementById("params_"+value).innerHTML;
		document.getElementById('ddlstatus').value=document.getElementById("hidstatus_"+value).value;
		document.getElementById('txtMinBalanceLimit').value=document.getElementById("minbal_"+value).innerHTML;
		document.getElementById('ddlapigroup').value=document.getElementById("hidapigroup_"+value).value;
		
		document.getElementById('txtToken').value=document.getElementById("token_"+value).innerHTML;
		
		
		
		
		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
</script>
<style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
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
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
	border-bottom:: 1px solid #ddd;
	overflow:hidden;
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
          <a class="breadcrumb-item" href="#">Reports</a>
          <span class="breadcrumb-item active">UPLOAD BANNER</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>UPLOAD BANNER</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                  <form role="form" method="post" action="<?php echo base_url()."_Admin/banner"; ?>" enctype="multipart/form-data">
                           <input type="hidden" id="hidID" name="hidID">
                                  <table class="table table-striped .table-bordered border" style="color:#000000;font-size:14px;font-family:sans-serif">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <h5>File Upload</h5>
                                            <input type="file" name="banner" >
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
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT REPORT</h6>
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>DateTime</th>
											 <th>Status</th>
                                             <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1; foreach($result_api->result() as $row)
								   {?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                               
                                                <a href="<?php echo $row->imageurl; ?>" target="_blank"><img style="width:80px;height:40px;" src="<?php echo $row->imageurl; ?>" alt=""></a></td>
                                            
                                           
                                            
                                            <td style="word-break: break-all;width: 120px;"><?php echo $row->add_date; ?></td>
                                            
											<td>
<?php if($row->status == 0){echo "<span class='red'><a href='#' onclick='actionDeactivate(".$row->Id.",1)'>Deactive</a></span>";}else{echo "<span class='green'><a href='#' onclick='actionDeactivate(".$row->Id.",0)'>Active</a></span>";} ?>
</td>
                                             <td>
                                             
                                             
                                             
            <table>
            <tr>
            	<td><a style="cursor:pointer" class="fas fa-trash-alt" onClick="Confirmation('<?php echo $row->Id; ?>')">Delete</a> </td>
               
            </tr>
            </table>
             
              								</td>
                                        </tr>
                                   <?php $i++;} ?>  
                                    </tbody>
                                </table>
              </div><!-- card-body -->
            </div>
             <?php  echo $pagination; ?> 
        </div>
        </div>
      </div><!-- br-pagebody -->
       <script language="javascript">
function actionDeactivate(id,status)
{
	document.getElementById("hiduserid").value = id;
	document.getElementById("hidstatus").value = status;
	document.getElementById("hidaction").value = "Set";
	document.getElementById("frmstatuschange").submit();
}
function Confirmation(value)
{

	if(confirm("Are you sure?\nyou want to delete ") == true)
	{
		document.getElementById("hiduserid").value = value;
	document.getElementById("hidstatus").value = "DELETE";
	document.getElementById("hidaction").value = "DELETE";
	document.getElementById("frmstatuschange").submit();
	}
}
          
</script>
<form id="frmstatuschange" method="POST" action="">
    <input type="hidden" id="hiduserid" name="hiduserid">
    <input type="hidden" id="hidstatus" name="hidstatus">
    <input type="hidden" id="hidaction" name="hidaction">
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
