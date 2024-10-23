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
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/images/favicon.png">
    <title>CALL ME REQUEST</title>
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
    
    
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <?php include("files/apijaxscripts.php"); ?>
<script language="javascript">
		
		</script>
	   
    <script>
	$(document).ready(function()
	  {
	 
	setTimeout(function(){window.location.reload(1);}, (60000 * 5)  );
	setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
		   });
	function ActionSubmit(value)
	{
	    
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}else{isstatus='Failure';}
			
			if(confirm('Are you sure?\n '))
			{
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;		
				document.getElementById('hidid').value=document.getElementById('txtOpId'+value).value;	
				
				document.getElementById('frmCallAction').submit();
			}
		}
	}
	</script>
   
	<style>
	    .error
	    {
	        background-color:#f1ded0 !important;
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
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}
#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
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
    <div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
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
                        <!--<h6 class="text-themecolor m-b-0 m-t-0">PENDING RECHARGES</h6>-->
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                
                
                 <div class="col-8">
                        <div class="card">
                        <div class="card-body">
                        <form action="<?php echo base_url()."_Admin/call_me_req" ?>" method="post" name="frmsrch" id="frmsrch">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table>
                                    <tr>
                                    	
                                         <td >
                                        	 <h5>Number</h5>
                                        	 <input type="text" name="txtNumber" id="txtNumber" class="form-control-sm" style="width:120px;" value="<?php echo ""; ?>">
                                        </td>
                                        <td valign="bottom">
                                            
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-xs">
                                        
                                        </td>
                                        
                                    </tr>
                                    
                                    </table>
                                    </form>
                                    
                                   
 						</div>
                        </div>
                 </div>
               
              </div>
                
               
                <div class="row">
                    
                    <!-- column -->
                    
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Call Req List</h4>
                                
                                <div class="table-responsive">
                                
                                    <form id="frmactall" name="frmactall" method="post"> 
   						   
	<div id="transactions" class="table-responsive">			   
<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  

     <th>SR No.</th> 
     <th>Id</th>
    <th>DateTime</th>
    <th>AgentName</th>
    <th>AgentId</th>
	<th>Mobile No</th>    
	<th>Parent</th> 
    <th>Response</th> 
   	<th>Status</th>    
	<th>Action</th>  
    <th></th>                 
    </tr>
    <?php
	    $strrecid = '';
	    $k = 1;
		$i = $rsltcallreq->num_rows();
		foreach($rsltcallreq->result() as $result) 	
	    {
	 ?>
	 
            <td ><?php echo $i; ?></td>
            <td><?php echo $result->Id; ?></td>
            <td><?php echo $result->add_date; ?></td>
            <td style="word-break:break-all"><?php echo $result->businessname; ?></td>
            <td><?php echo $result->username; ?></td>
            <td><?php echo $result->mobile_no; ?></td>
            <td><?php echo $result->parent_name."<br>".$result->parent_id; ?></td>
 
  <td><input type="text"  id="txtOpId<?php echo $result->Id; ?>" name="txtOpId<?php echo $result->Id; ?>" class="form-control-sm" style="width:80px;"></td>
<td style="width:180px;word-break: break-all;"> 
<?php echo $result->status ?></td>
 <td>
  <?php if($this->session->userdata("ausertype") == "Admin"){ ?>
 <select style="width:80px;height:30px;" class="form-control-sm" id="action_<?php echo $result->Id; ?>" >
     <option value="Select">Select</option>
     <option value="PENDING">PENDING</option>
     <option value="OPEN">OPEN</option>
     <option value="DONE">DONE</option> 
     <option value="CALL_AGAIN">CALL_AGAIN</option> 
 </select>
 <?php } ?>
 </td>
 <td>
 <input type="button" id="btnSubmit<?php echo $result->Id; ?>" name="btnSubmit" value="Submit" class="btn btn-warning btn-xs" onClick="ActionSubmit('<?php echo $result->Id; ?>')">
 </td>
 </tr>
 
		<?php 
		$i--;} ?>
		</table>
		</div>
</form>	
			
    
            
            <form action="<?php echo base_url()."_Admin/call_me_req?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidrechargeid" name="hidrechargeid" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
 </form>
            			     
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
    
    <input type="hidden" id="hidgettxnsurl" value="<?php echo base_url()."_Admin/list_recharge_pending/gettransactions"; ?>">
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
   
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    
    <link href="<?php echo base_url(); ?>css/colors/blue.css" id="theme" rel="stylesheet">
        <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
</body>
</html>