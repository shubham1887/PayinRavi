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
    <title>DMR Margin Slab</title>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Table</h4>
                    
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <div class="table-responsive">
                                    <form method="post" action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
							  <input type="hidden" id="hidgroupid" name="hidgroupid" value="<?php echo $this->input->get("crypt2"); ?>">
							  <input type="hidden" id="hidgroupname" name="hidgroupname" value="<?php echo $this->input->get("crypt1"); ?>">
<fieldset>
<table  class="table">
<tr>
<td align="right"><label for="txtAPIName"><span style="color:#F06">*</span> Amount From :</label></td><td align="left"><input type="text" class="text" id="txtAmountFrom"  name="txtAmountFrom" maxlength="10"/>
<span id="APINameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Amount To :</label></td><td align="left"><input type="text" id="txtAmountTo" class="text"  name="txtAmountTo">
<span id="usernameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Deductin Type :</label></td><td align="left">
<select  id="ddldudtype" class="form-control" style="width:120px;"  name="ddldudtype" >
<option value="PER">Percentage</option>
<option value="AMOUNT">Amount</option>
	
</select>
<span id="usernameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtPassword"><span style="color:#F06">*</span> Transaction Charge :</label></td><td align="left"><input type="text" class="text" id="txnCharge" name="txnCharge" maxlength="50"/>
<span id="passwordInfo"></span>
</td>
</tr>

<tr>
<td></td><td align="left"><input type="submit" class="button" id="btnSubmit" name="btnSubmit" value="Submit"/> <input type="reset" class="button" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
</tr>
</table>
</fieldset>
<input type="hidden" id="hidID" name="hidID" />
</form>

<form action="<?php echo base_url()."_Admin/mt_commission_slab"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
	 <input type="hidden" id="hiddelete_groupid" name="hidgroupid" value="<?php echo $this->input->get("crypt2"); ?>" />
	 <input type="hidden" id="hiddelete_groupname" name="hidgroupname" value="<?php echo $this->input->get("crypt1"); ?>" />
</form>
					
<script language="javascript">
function Confirmation(value)
	{
		var varName = document.getElementById("name_"+value).innerHTML;
		if(confirm("Are you sure?\nyou want to delete "+varName+" ") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
</script>	
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <div class="table-responsive">
                                     <table  class="table table-bordered">
     <thead> 
        <tr class="ColHeader"> 
            <th height="30" >Amount Range</th> 
            <th height="30" >Deduction Type</th> 
            <th  height="30" >Transaction Charge</th> 
            <th  height="30" >Add Date</th>
              <th  height="30" >Edite Date</th>
            <th  height="30" >Actions</th> 
        </tr> </thead>
    <?php	$i = 0;foreach($result_slabs->result() as $result) 	{  ?>
    <tbody> 
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="name_<?php echo $result->Id; ?>"><?php echo $result->range_from."  -  ".$result->range_to; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_type; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->charge_amount; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->add_date; ?></span></td>              
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="pwd_<?php echo $result->Id; ?>"><?php echo $result->ipaddress; ?></span></td>              
            <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
              <img src="<?php echo base_url()."images/delete.PNG"; ?>" height="20" width="20" onClick="Confirmation('<?php echo $result->Id; ?>')" title="Delete Row" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>  
             </tr></tbody>
		<?php 	
		$i++;} ?>
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
</body>
</html>