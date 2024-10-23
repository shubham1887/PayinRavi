<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Banner</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url(); ?>css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
      <?php include("files/apijaxscripts.php"); ?>
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
<body class="fix-header card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>-->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include("files/sdheader.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sdsidebar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">UPLOAD BANNER</h3>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                
                <div class="row">
                    
                    <!-- column -->
                    
                    <!-- column -->
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add New Banner</h4>
                                <div class="table-responsive">
                                     <form role="form" method="post" action="<?php echo base_url()."SuperDealer/banner"; ?>" enctype="multipart/form-data">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Banner List</h4>
                                <div class="table-responsive">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
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
</form>                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php include("files/rightbar.php"); ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2019 <?php echo $this->common->getName() ?>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/plugins/popper/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url(); ?>js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url(); ?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url(); ?>js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo base_url(); ?>js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.init.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>