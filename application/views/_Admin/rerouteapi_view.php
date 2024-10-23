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
    <title>Reroute API</title>
    <!-- Bootstrap Core CSS -->
    <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
         <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script language="javascript">
	  	function getData()
		{
		if(document.getElementById("ddlapi").value != 0)
		{
				$.ajax({
				url:'<?php echo base_url(); ?>_Admin/rerouteapi/getresult?api_id='+document.getElementById("ddlapi").value,
				method:'POST',
				cache:false,
				success:function(msg)
				{
					document.getElementById("ajxdata").style.display = "block";
					document.getElementById("ajaxload").style.display = "none";
					document.getElementById("ajxdata").innerHTML = msg;
				}
			
			
			});
		}
		else
		{
			document.getElementById("ajxdata").innerHTML = "";
		}
		}
		function changeapi(company_id,i)
		{
		
			var second_api_id= document.getElementById("ddlapi"+company_id).value;
				
			var api_id= document.getElementById("uid").value;
			$.ajax({
  				url: '<?php echo base_url(); ?>_Admin/rerouteapi/changeapi?company_id='+company_id+'&api_id='+i+'&second_api='+second_api_id,
				  type: 'POST',
				  success:function(html)
				  {
				  
					getData();
				  },
				  complate:function(msg)
				  {
					getData();
				  }
				});
        
		}
		function changecommission(id)
		{
		var com = document.getElementById("txtComm"+id).value;
		var mincom = document.getElementById("txtMinCom"+id).value;
		var maxcom = document.getElementById("txtMaxCom"+id).value;
		var comtype = document.getElementById("ddlcommission_type"+id).value;
		
		document.getElementById("ajaxprocess").style.display = "block";
		
		
			
			
		document.getElementById("modelmp_failure_msg_BDEL").innerHTML ="";
		document.getElementById("modelmp_success_msg_BDEL").innerHTML ="";
		document.getElementById("responsespansuccess_BDEL").style.display = "none";
		document.getElementById("responsespanfailure_BDEL").style.display = "none";	
			
		if(com.length >= 1 || comAmt.length >= 1)
		{
		
		$.ajax({
  url: '<?php echo base_url(); ?>_Admin/groupapi/changecommission?groupid='+document.getElementById("ddlgroup").value+'&com='+com+'&company_id='+id+'&mincom='+mincom+'&maxcom='+maxcom+'&comtype='+comtype,
  type: 'POST',
  success:function(html)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
	  
	  
	  
	if(html == "OK")
	{
		document.getElementById("modelmp_success_msg_BDEL").innerHTML ="Commission Updated Successfully";
		document.getElementById("responsespansuccess_BDEL").style.display = "block";
		$('#myMessgeModal').modal({show:true});
	}
	else
	{
		document.getElementById("modelmp_failure_msg_BDEL").innerHTML =html;
		document.getElementById("responsespanfailure_BDEL").style.display = "block";
		$('#myMessgeModal').modal({show:true});
	}
  },
  complate:function(msg)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
  }
});
        }
		}
	  </script>
            <?php include("files/apijaxscripts.php"); ?>
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Reroute Api</h3>
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
                        <div id="ajaxprocess" style="display:none">
                  <img src="<?php echo base_url(); ?>ajax-loader_bert.gif">
                  </div>
                            <div class="card-body">
                                <div class="table-responsive">
                     				 <form method="post"  name="frmscheme_view" id="frmscheme_view" autocomplete="off">
<table>
	<tr>
<td align="right"><label for="txtGroupName" style="font-size:20px;"><span style="color:#F06">*</span>Select API :</label></td><td align="left">
<select id="ddlapi" name="ddlapi" onChange="getData()" class="form-control-sm">
 <option value="0">Select</option>
<?php
	$api_rslt = $this->db->query("select api_id,api_name from tblapi order by api_name");
	foreach($api_rslt->result() as $row)
	{?>
 		<option value="<?php echo $row->api_id; ?>"><?php echo $row->api_name; ?></option>
 <?php } ?>
</select>
</td>
</tr>
</table>
<input type="hidden" id="hidID" name="hidID" />
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
                                                                <div id="ajxdata">
</div>
<div id="ajaxload" style="display:none;">
	<img src="<?php echo base_url()."ajax-loader.gif"?>">
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
</body>
</html>