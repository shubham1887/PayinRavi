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
    <title>Balance2 Transfer</title>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Balance2 Transfer</h4>
                    
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
                                   <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($userinfo))
	{
	if($userinfo->num_rows() == 1)
	{
	?>    
    <fieldset>
    <form id="frmaddbal" name="frmaddbal" method="post" action="<?php echo base_url()."SuperDealer/add_balance2?crypt=".$this->Common_methods->encrypt("MyData"); ?>">
                	  <input type="hidden" id="hidid" name="hidid" value="<?php echo $userinfo->row(0)->user_id; ?>">
					
                	  <table style="width:450px">
                                    <tr>
                                    	<td style="padding-right:10px;" align="right">Agent Name :</td>
                                        	 <td>
                                           	<span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->businessname; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">AgentId</td>
                                        	 <td>
                                            <span style="font-weight:bold;color:#000000"><?php echo $userinfo->row(0)->username; ?></span>
                                        </td>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	Current  Balance</td>
                                        	 <td>
                                             <span style="font-weight:bold;color:#000000">
											 	<?php 
												$this->load->model("Common_methods");
												echo $this->Ew2->getAgentBalance($userinfo->row(0)->user_id); ?>
                                             </span>
                                        </td>
                                      </tr>
                                      <tr>
                                       <td style="padding-right:10px;"  align="right">
                                        	 Action</td>
                                        	 <td>
                                            <select id="ddlaction" name="ddlaction" class="form-control-sm" style="width:200px">
                                                <option value="ADD">ADD</option>
                                                <option value="REVERT">REVERT</option>
											</select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Amount</td>
                                        	 <td>
                                            <input type="text" id="txtAmount" name="txtAmount" style="width:200px" class="form-control-sm" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Remark</td>
                                        	 <td>
                                            <input type="text" id="txtRemark" name="txtRemark" style="width:200px" class="form-control-sm" >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        	 <td> 
                                        	<input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success btn-xs" value="Submit" onClick="validateandsubmit()">
                                        </td>
                                     
                                    </tr>
                                    </table>
                </form>
                <script language="javascript">
				function validateandsubmit()
				{
					if(validateamount() & validateremark())
					{
						document.getElementById("frmaddbal").submit();
					}
				}
				function validateamount()
				{
					var amt = document.getElementById("txtAmount").value;
					if(amt == "")
					{
						$("#txtAmount").addClass("error");
						return false;
					}
					else
					{
						$("#txtAmount").removeClass("error");
						return true;
					}
				}
				function validateremark()
				{
					var remark = document.getElementById("txtRemark").value;
					if(remark == "")
					{
						$("#txtRemark").addClass("error");
						return false;
					}
					else
					{
						$("#txtRemark").removeClass("error");
						return true;
					}
				}
				</script>
        </fieldset>
        <?php }else{echo "No Data Found.";} }?>  
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
                © 2019 <?php echo $this->white->getDomainName(); ?>
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