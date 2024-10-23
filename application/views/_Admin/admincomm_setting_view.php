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
    <title>Admin Commission</title>
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
<script language="javascript">
	  	function getData()
		{
		if(document.getElementById("ddlgroup").value != 0)
		{
				$.ajax({
				url:'<?php echo base_url(); ?>_Admin/admincomm_setting/getresult?groupid='+document.getElementById("ddlgroup").value,
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
		
		function changecommission(company_id,api_id)
		{
		var com = document.getElementById("txtComm"+company_id).value;
		document.getElementById("ajaxprocess").style.display = "block";
		
		$.ajax({
  url: '<?php echo base_url(); ?>_Admin/admincomm_setting/changecommission?api_id='+api_id+'&com='+document.getElementById("txtComm"+company_id).value+'&company_id='+company_id,
  type: 'POST',
  success:function(html)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
  },
  complate:function(msg)
  {
  	document.getElementById("ajaxprocess").style.display = "none";
  	getData();
  }
});
       
		}
	  </script>
    <style>
	.row1
	{
		background-color:#BFCDDD;
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Admin Commission Settings</h4>
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
                                <h4 class="card-title"></h4>
                                <div class="table-responsive">
                                         <form method="post"  name="frmscheme_view" id="frmscheme_view" autocomplete="off">  
                                         <div class="breadcrumb" style="padding:20px;"> 
                                          
                                         <table cellpadding="3" cellspacing="3" border="0"> 	
                                         <tr> 
                                         <td align="right">
                                            Select Api Name :
                                         </td>
                                         <td align="left"> 
                                         <select id="ddlgroup" name="ddlgroup" onChange="getData()" class="form-control-sm" >  
                                         	<option value="0">Select</option> 
											<?php 	
											$group_rslt = $this->db->query("select * from tblapi"); 	
											foreach($group_rslt->result() as $row) 	
											{  ?>  
                                            <option value="<?php echo $row->api_id; ?>"><?php echo $row->api_name; ?></option>  
											<?php } ?> 
                                          </select>  
                                          </td> 
                                          </tr> 
                                          </table> 
                                         </div>  
                                         <input type="hidden" id="hidID" name="hidID" /> 
                                         </form>    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <div class="box">                 <div class="box-header">                                    <div id="ajaxprocess" style="display:none">                   <img src="<?php echo base_url(); ?>ajax-loader_bert.gif">                   </div>                 </div><!-- /.box-header -->                 <div class="box-body table-responsive no-padding">                                    <div id="ajxdata">  </div> <div id="ajaxload" style="display:none;"> 	<img src="<?php echo base_url()."ajax-loader.gif"?>"> </div>                 </div><!-- /.box-body -->               </div><!-- /.box -->
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