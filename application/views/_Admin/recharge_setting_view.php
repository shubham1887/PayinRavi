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
    <title>Recharge Settings</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo base_url(); ?>css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="<?php echo base_url(); ?>js/jquery-1.4.4.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
.mytable-border
{
    border-top: thin;
    border-bottom: thin;
    border-right: thin;
	border-left:thin;
}
.mytable-border tr td{
    border-top: thin !important;
    border-bottom: thin !important;
	border-left: thin !important;
    border-right: thin !important;
}
.mytable-border  tr{
    border-right: thin;
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
.retry
{
	background:#FBC6FB;
}
.dont
{
	background:#C0C0C0;
}
.manual
{
background:#C0C6C0;
}
</style>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">RECHARGE SETTINGS</h4>
                    
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
                                    <form method="post" action="<?php echo base_url()."_Admin/recharge_setting"; ?>" name="frmapi_view" id="frmapi_view" autocomplete="off">
							  <input type="hidden" id="hidId" name="hidId" value="">

 <table cellspacing="10" cellpadding="3">
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
<td align="right"><label for="txtUserName"><span style="color:#F06">*</span> Type :</label></td><td align="left">
<select  id="ddldudtype" class="form-control" style="width:120px;"  name="ddldudtype" >
<option value="S">S</option>
<option value="F">F</option>
<option value="FS">FS</option>
<option value="FF">FF</option>	
</select>
<span id="usernameInfo"></span>
</td>
</tr>
<tr>
<td align="right"><label for="txtBalance"><span style="color:#F06">*</span>Balance :</label></td>
<td align="left"><input type="text" class="text" id="txtBalance" name="txtBalance" maxlength="50"/>

</td>
</tr>


<tr>
<td align="right"><label for="txtBalance"><span style="color:#F06">*</span>Transaction Count :</label></td>
<td align="left"><input type="text" class="text" id="txtTransactions" name="txtTransactions" maxlength="50"/>

</td>
</tr>

<tr>
<td></td><td align="left"><input type="submit" class="button" id="btnSubmit" name="btnSubmit" value="Submit"/> <input type="reset" class="button" onClick="SetReset()" id="bttnCancel" name="bttnCancel" value="Cancel"/></td>
</tr>
</table>
<input type="hidden" id="hidID" name="hidID" />
</form>

<form action="<?php echo base_url()."_Admin/recharge_setting"; ?>" method="post" autocomplete="off" name="frmDelete" id="frmDelete">
    <input type="hidden" id="hidValue" name="hidValue" />
    <input type="hidden" id="action" name="action" value="Delete" />
</form>
					
<script language="javascript">
function Confirmation(value)
	{
		
		if(confirm("Are you sure?") == true)
		{
			document.getElementById('hidValue').value = value;
			document.getElementById('frmDelete').submit();
		}
	}
	function setedit(id)
	{
	    
	    document.getElementById("txtAmountFrom").value = document.getElementById("hidamount_from"+id).value;
	    document.getElementById("txtAmountTo").value = document.getElementById("hidamount_to"+id).value;
	    document.getElementById("txtBalance").value = document.getElementById("hidmin_balance"+id).value;
	    document.getElementById("txtTransactions").value = document.getElementById("hidmin_transaction"+id).value;
	    document.getElementById("ddldudtype").value = document.getElementById("hidtype"+id).value;
	    document.getElementById("hidId").value = id;
	    document.getElementById("btnSubmit").value = "Update";
	    
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
                                    <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
     <thead> 
        <tr class="ColHeader"> 
            <th height="30" >Amount Range</th> 
            <th height="30" >Min Balance</th>
            <th height="30" >Min Transaction</th> 
            <th  height="30" >Type</th> 
            <th  height="30" >Status</th>
              
            <th  height="30" >Actions</th> 
        </tr> </thead>
    <?php	$i = 0;foreach($result_slabs->result() as $result) 	{  ?>
    <tbody> 
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="name_<?php echo $result->Id; ?>"><?php echo $result->amount_from."  -  ".$result->amount_to; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->min_balance; ?></span></td>
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->min_transaction; ?></span></td>
             <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;"><span id="uname_<?php echo $result->Id; ?>"><?php echo $result->type; ?></span></td>
             
              <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                  <input type="hidden" id="hidamount_from<?php echo $result->Id; ?>" value="<?php echo $result->amount_from; ?>">
                  <input type="hidden" id="hidamount_to<?php echo $result->Id; ?>" value="<?php echo $result->amount_to; ?>">
                  <input type="hidden" id="hidmin_balance<?php echo $result->Id; ?>" value="<?php echo $result->min_balance; ?>">
                  <input type="hidden" id="hidmin_transaction<?php echo $result->Id; ?>" value="<?php echo $result->min_transaction; ?>">
                  <input type="hidden" id="hidtype<?php echo $result->Id; ?>" value="<?php echo $result->type; ?>">
                  <span>
                      <?php if($result->status == "live")
                    {?>
                    <span class='btn btn-success' >
                    	<a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->Id;?>","stopped")'>Live</a>
                    </span>
                    <?php }
                    else
                    {?>
                    	<span class='btn btn-danger btn-sm'>
                    		<a href='#' style="color:#FFFFFF" onclick='actionToggle("<?php echo $result->Id;?>","live")'>Stopped</a>
                    	</span>
                    <?php } ?>
                  </span>
              </td>              
            <td class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:120px;width:150px;">
                <a style="cursor:pointer" class="fas fa-pencil-alt" onClick="setedit('<?php echo $result->Id; ?>')">Edit</a> 
              <a style="cursor:pointer" class="fas fa-trash-alt" onClick="Confirmation('<?php echo $result->Id; ?>')">Delete</a> 
              
              
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
                
                <input type="hidden" id="hidurltoggle" value="<?php echo base_url()."_Admin/recharge_setting/togglestatus"; ?>">
        <script language="javascript">
		function actionToggle(id,sts)
		{
			$.ajax({
				url:document.getElementById("hidurltoggle").value+'?id='+id+'&sts='+sts,
				cache:false,
				type:'POST',
				success:function(html)
				{
					window.location.reload(1);
				}
			
			});
		}
		</script>
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