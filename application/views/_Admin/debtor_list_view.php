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
    <title></title>
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
                        <h5 class="text-themecolor m-b-0 m-t-0">Debtor List</h5>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                 <script language="javascript">
							$("#bootbox-regular").on(ace.click_event, function() {
									bootbox.prompt("What is your name?", function(result) {
										if (result === null) {
											
										} else {
											
										}
									});
								});
							</script>	
							
							
							
							
							
			     <div class="row">
                 <div class="col-12">
                    
                    	<div class="card">
                        <nav class="breadcrumb">
                        			<a class="breadcrumb-item" href="<?php echo base_url()."_Admin/admin_banks?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Admin bank</a>
                                     <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/credit_entry?crypt=".$this->Common_methods->encrypt("MyData"); ?>">Payment Receive Entry</a>
                                    
                                    
                                    
                                    <span class="breadcrumb-item active">Debtor List</span>
                                </nav>
                        </div>
                    
                 </div>
                </div>
							
							
							
							
                <div class="row">
                   
                    <!-- column -->
                  
                    <div class="col-12">
                        <?php include("files/messagebox.php"); ?>
                        <div class="card">
                            <div class="card-body">
                                
                                <div style="float:right">

								<a href="#modal-form" role="button" class="blue btn btn-primary" data-toggle="modal" onClick="addform()"> <i class="ace-icon fa fa-plus bigger-120"></i>Add New Debtor </a>
								<script language="javascript">
									function addform()
									{
										document.getElementById("HIDACTION").value = "INSERT";
									}
								</script>
								
								
<!-------------------------------------- INSERT EDIT MODEL START ----------------------->								
							
							</div>
                                <div class="table-responsive">
                                   <?php if($result_dealer != NULL) { ?>
							
                                    <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
											<thead>
												<tr>
													
													<th class="detail-col">Sr.</th>
													<th>Debtor Name</th>
													<th>Mobile</th>
													<th>Usertype</th>
													<th>Balance</th>
													<th>Outstanding</th>
													<th></th>
												</tr>
											</thead>

											<tbody><?php $i=1;foreach($result_dealer->result() as $row)
										{ ?><tr>
													<td><a href="#"><?php echo $i; ?></a></td>
													<td>
													    <?php echo $row->businessname; ?>
													    <input type="hidden" id="hidName<?php echo $row->user_id; ?>" value="<?php echo $row->businessname; ?>">
													</td>
													<td>
													    <?php echo $row->mobile_no; ?>
													    <input type="hidden" id="hidMobile<?php echo $row->user_id; ?>" value="<?php echo $row->mobile_no; ?>">
													</td>
													<td>
													    <?php echo $row->usertype_name; ?>
													    <input type="hidden" id="hidUsertype<?php echo $row->user_id; ?>" value="<?php echo $row->usertype_name; ?>">
													</td>
													<td>
													    <?php echo $row->balance; ?>
													    <input type="hidden" id="hidBalance<?php echo $row->user_id; ?>" value="<?php echo $row->balance; ?>">
													</td>
													<td>
													    <?php 
													        $this->load->model("credit_model");
													        $outstanding =  $this->credit_model->getOutstandindg(1,$row->user_id); 
													        echo $outstanding;
													    ?>
													    
													    <input type="hidden" id="hidOutstanding<?php echo $row->user_id; ?>" value="<?php echo $outstanding; ?>">
													</td>
													<td>
														<div class="hidden-sm hidden-xs btn-group" style="display:none">
															

															<button class="btn btn-xs btn-info" onClick="editform(<?php echo $row->state_id; ?>)" href="#modal-form" data-toggle="modal">
																<i class="ace-icon fa fa-pencil bigger-120"></i>Edit															
															</button>
																<script language="javascript">
																function editform(id)
																{
																    document.getElementById("hidPrimaryId").value =  id;
																	document.getElementById("HIDACTION").value =  "UPDATE";
																	document.getElementById("txtstate_name").value =  document.getElementById("hidName"+id).value;
																}
																</script>

															<button class="btn btn-xs btn-danger" onClick="deletitem(<?php echo $row->state_id; ?>)" href="#modal-formdelete" data-toggle="modal">
																<i class="ace-icon fa fa-trash-o bigger-120"></i>Delete
																</button>
																<script language="javascript">
																function deletitem(id)
																{
																	document.getElementById("hidPrimaryId").value =  id;
																	document.getElementById("HIDACTION").value =  "DELETE";
																}
																</script>

															<button class="btn btn-xs btn-warning">
																<i class="ace-icon fa fa-flag bigger-120"></i>															</button>
														</div>
													</td>
												</tr><?php $i++;} ?>

												

											</tbody>
										</table>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                	<div id="modal-form" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Please fill the following form fields</h4>
											</div>

											<div class="modal-body">
												<div class="row">
													
													<div class="col-xs-12 col-sm-7">
													<form id="frmPopup" method="post" action="">
													<input type="hidden" id="hidPrimaryId" name="hidPrimaryId">
													
																<input type="hidden" id="HIDACTION" name="HIDACTION" value="INSERT">
																<div class="form-group">
																    <label for="form-field-select-3">Mobile Number</label>
    																<div>
    																	<input type="text" name="txtMobileNumber" id="txtMobileNumber" class="form-control" style="color:#000">
    																</div>
															    </div>
															<div class="space-4"></div>
															
        													       <div class="form-group">
        															    <label for="form-field-select-3">Outstanding</label>
        																<div>
        																	<input type="text" name="txtOutstanding" id="txtOutstanding" class="form-control" style="color:#000">
        																</div>
        														    </div>
        												    <div class="space-4"></div>
															
        													       <div class="form-group">
        															    <label for="form-field-select-3">Remark</label>
        																<div>
        																	<input type="text" name="txtRemark" id="txtRemark" class="form-control" style="color:#000">
        																</div>
        														    </div>
        														    
														    
														</form>
													</div>
												</div>
											</div>

											<div class="modal-footer">
												<button class="btn btn-sm" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													Cancel
												</button>

												<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="validateandsubmit()">
													<i class="ace-icon fa fa-check"></i>
													Save
												</button>
												<script language="javascript">
												function validateandsubmit()
												{
													document.getElementById("frmPopup").submit();
												}
												</script>
											</div>
										</div>
									</div>
								</div>
                <!-------------------------------------- DELETE MODEL START ----------------------->								
								<div id="modal-formdelete" class="modal" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="blue bigger">Are You Soure Want To Delete <span id="spanDeletePopupName"></span></h4>
											</div>
											<div class="modal-footer">
												<button class="btn btn-sm" data-dismiss="modal">
													<i class="ace-icon fa fa-times"></i>
													Cancel
												</button>

												<button id="btnPopupSave" class="btn btn-sm btn-primary" onClick="deletesubmit()">
													<i class="ace-icon fa fa-check"></i>
													Yes
												</button>
												<script language="javascript">
													function deletesubmit()
													{
														document.getElementById("HIDACTION").value="DELETE";
														document.getElementById("frmPopup").submit();
													}
												</script>
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