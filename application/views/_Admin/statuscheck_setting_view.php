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
    <title>Status Check Settings</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
function SetEdit(value)
	{
		document.getElementById('txtUrl').value=document.getElementById("status_url_"+value).innerHTML;
		document.getElementById('txtParams').value=document.getElementById("parameters_"+value).innerHTML;		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		document.getElementById('ddlapi').value=document.getElementById("api_id_"+value).value;
		
		
		//document.getElementById('myLabel').innerHTML = "Edit API";
	}
	function Confirmation(value)
	{
		var varName = document.getElementById("api_name_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" Settings.") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('action').value = "delete";
			document.getElementById('frmDelete').submit();
		}
	}
</script>
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
        <?php include("files/header.php"); ?>
        
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include("files/sidebar.php"); ?>
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Message Settins</h3>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                     				<form role="form" method="post" action="<?php echo base_url()."_Admin/statuscheck_setting?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table class="table" style="font-size:14px;color:#000">
                                    <tr>
										<td style="padding-right:10px;">
                                        	 <label>Select API</label>
                                            <select id="ddlapi" name="ddlapi" class="form-control-sm" style="width:120px">
												<option value="0">Select</option>
												
											<?php
												$rsltapi = $this->db->query("select * from tblapi where status = 1 order by api_name ");
												foreach($rsltapi->result() as $rw)
												{?>
													<option value="<?php echo $rw->api_id; ?>"><?php echo $rw->api_name; ?></option>
												
												<?php } ?>
											</select>
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <label>URL</label>
                                            <input  class="form-control-sm"  id="txtUrl" name="txtUrl" type="text"  style="width:420px">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <label>Parameters</label>
                                            <input class="form-control-sm"  id="txtParams" name="txtParams" type="text" style="width:420px" >
                                        </td>
                                        
                                        
                                        <td valign="bottom">
                                        <h5>&nbsp;</h5>
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-sm">
                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                     <form action="<?php echo base_url()."_Admin/statuscheck_setting?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="delete" />
</form>                 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                </div>
                <div class="row">
                    
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                     				<table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                    <thead>
                                        <tr>
                                            <th>#</th>
											<th>API</th>
                                            <th>Url</th>
                                            <th>Parameters</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i=1; foreach($data->result() as $row)
								   {?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
											<td><span id="api_name_<?php echo $row->api_id; ?>"><?php echo $row->api_name; ?></span></td>
                                            <td><span id="status_url_<?php echo $row->api_id; ?>"><?php echo $row->status_url; ?></span></td>
                                            <td><span id="parameters_<?php echo $row->api_id; ?>"><?php echo $row->parameters; ?></span></td>
                                            
                                             <td>
												 <input type="hidden" id="api_id_<?php echo $row->Id; ?>" value="<?php echo $row->api_id; ?>">
                                                 <input type="button" id="btndelete" value="Delete" onClick="Confirmation('<?php echo $row->api_id; ?>')">
                                                  <input type="button" id="btnedit" value="Edit" onClick="SetEdit('<?php echo $row->api_id; ?>')">
             
              
           
             
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
                <!-- ============================================================== -->
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
                © 2019 TULSYANRECHARGE.COM
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
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../assets/plugins/popper/popper.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../js/custom.min.js"></script>
    <!-- jQuery peity -->
    <script src="../assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="../assets/plugins/peity/jquery.peity.init.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="../assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
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
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
</style>
</body>
</html>