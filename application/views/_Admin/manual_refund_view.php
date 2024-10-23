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
    <title>Manual Refund Recharges</title>
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
    
     
     <script>
	
$(document).ready(function(){
document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
document.getElementById("ddldb").value = '<?php echo $ddldb; ?>';
 $(function() {
            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});
            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});
         });
	
});
	
		 
		
function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		var db = document.getElementById("ddldb").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("hiddb").value = db;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
	
	</script>
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
<script type="text/javascript">
    
	function ActionSubmit(value,name)
	{
		if(document.getElementById('action_'+value).selectedIndex != 0)
		{
			var isstatus;
			if(document.getElementById('action_'+value).value == "Success")
			{isstatus = 'Success';}
			else if(document.getElementById('action_'+value).value == "Failure")
			{isstatus='Failure';}
			else if(document.getElementById('action_'+value).value == "Pending")
			{isstatus='Pending';}
			
			if(confirm('Are you sure?\n you want to '+isstatus+' rechrge for - ['+name+']')){
				document.getElementById('hidstatus').value= document.getElementById('action_'+value).value;
				document.getElementById('hidrechargeid').value= value;	
				document.getElementById('hidid').value= "req to get";
							
				document.getElementById('frmCallAction').submit();
				}
		}
	}
	
</script>
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
<script language="javascript">
function viewhidelog()
{
	var flag = document.getElementById("btnviewlog").value;
	if(flag == "VIEW LOG")
	{
		document.getElementById("btnviewlog").value = "HIDE LOG";
		var str = document.getElementById("hisrecids").value;
		var strarr = str.split("#");
		for(i=0;i<strarr.length;i++)
		{
			tetingalert(strarr[i]);
		}
		
	}
	else
	{
			document.getElementById("btnviewlog").value = "VIEW LOG";
			var str = document.getElementById("hisrecids").value;
			var strarr = str.split("#");
			for(i=0;i<strarr.length;i++)
			{
				document.getElementById("tr_reqresp"+strarr[i]).style.display = 'none'
			}
			
	}
	
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
   <!-- <div class="preloader">
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
                        <h4 class="text-themecolor m-b-0 m-t-0">MANUAL REFUND RECHARGE REPORT</h4>
                        
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                        	<div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                	<input type="button" id="btnviewlog" name="btnviewlog" value="VIEW LOG" class="btn btn-info  btn-xs" onClick="viewhidelog()" style="font-size:14px;">
                           		</div>
                            </div>
                            
                            
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                               	<button class="btn btn-success btn-xs" type="button" style="font-size:14px;">Success : <?php echo $totalRecahrge; ?></button>
                                 </div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                	<button class="btn btn-primary btn-xs" type="button" style="font-size:14px;">Pending : <?php echo $totalpRecahrge; ?></button>
                           		</div>
                                
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                	<button class="btn btn-danger btn-xs" type="button" style="font-size:14px;">Failure : <?php echo $totalfRecahrge; ?></button>
                           		</div>
                            </div>
                            
                            
                            
                            
                          <!--  <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>-->
                        </div>
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
                                    
                                    <form action="<?php echo base_url()."_Admin/manual_refund?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmsubmit" id="frmsubmit">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h5>From Date</h5>
                                           <input class="form-control-sm" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                    	<td style="padding-right:10px;">
                                        	 <h5>To Date</h5>
                                            <input class="form-control-sm" value="<?php echo $to; ?>" id="txtTo" name="txtTo" type="text" style="width:100px;cursor:pointer" readonly >
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5><table><tr><td>USER </td><td><img id="imageautoload" src="<?php echo base_url()."ajax-loader.gif"; ?>" style="width:40px;display:none"></td></tr></table></h5>
                                            <input class="form-control-sm"  type="text" placeholder="type username" id="ddluser" name="ddluser" value="<?php echo $ddluser; ?>">
                                        </td>
                                         <td style="padding-right:10px;">
                                        	 <h5>API</h5>
                                           <select id="ddlapi" name="ddlapi" class="form-control-sm">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltapi = $this->db->query("select * from tblapi order by api_name");
											foreach($rsltapi->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->api_name; ?>"><?php echo $r->api_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Operator</h5>
                                           <select id="ddloperator" name="ddloperator" class="form-control-sm" style="width:120px;">
                                           	<option value="ALL">ALL</option>
                                            <?php $rsltcompany = $this->db->query("select * from tblcompany order by company_name");
											foreach($rsltcompany->result() as $r)
											{ ?>
                                            <option value="<?php echo $r->company_id; ?>"><?php echo $r->company_name; ?></option>
                                            <?php } ?>
                                           </select>
                                        </td>
                                        
                                        <td style="padding-right:10px;">
                                        	 <h5>Number / Id</h5>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" value="<?php echo $txtNumId; ?>" style="width:120px;" >
                                        </td>
										<td style="padding-right:10px;">
                                        	 <h5>Data</h5>
                                           <select id="ddldb" name="ddldb" class="form-control-sm" style="width: 120px;">
											   	<option value="LIVE">LIVE</option>
											   <option value="ARCHIVE">ARCHIVE</option>
											</select>
                                        </td>
                                        
                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-xs" style="font-size:12px;">
                                        </td>
                                        <td valign="bottom">
                                       
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success btn-xs" onClick="startexoprt()" style="font-size:12px;">
                                        </td>
                                      
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                    <form action="<?php echo base_url()."_Admin/manual_refund?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
<input type="hidden" id="hidstatus" name="hidstatus" />
<input type="hidden" id="hidrechargeid" name="hidrechargeid" />
<input type="hidden" id="hidid" name="hidid" />
<input type="hidden" id="hidaction" name="hidaction" value="Set" />
 </form>
                                </div>
                            </div>
                        
                        </div>
                    
                    
           
                    </div>
                    <!-- column -->
                
                 </div>
                 
                 <div class="row">
                
                </div>
                <div class="row" >
                    
                    <!-- column -->
                    
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Manual Refund Recharge List</h6>
                                <div class="table-responsive">
     
    <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
    <tr>  
    
    <th>Rec.Id</th>
   <th>EwId</th>
     <th>Transaction Id</th>  
     <th >Rec. Date</th>
     <th>Time</th>
     <th>Agent Name</th>
     <th>opcode</th>
	 <th>Mobile No</th>    
	 <th>Amt</th>  
	 <th>Status</th> 
	  <th>API</th>
	  <th>Bal.</th>
	  <th>Circle</th>
	 <th>Debit<br>Amt</th>
	 
     <th></th>  
       <th></th>            
    </tr>
    
    
    <?php $strrecid = "";$totalRecharge = 0;	$i = count($result_recharge->result());foreach($result_recharge->result() as $result) 	
	{
		if(isset($result->recharge_id)) 
		{
			$strrecid .=$result->recharge_id."#"; 
		}
		$retry =   $result->retry;
	?>
    	<?php
			if($retry == "yes")
			{?>
            	<tr class="retry" style="border-top: 1px solid #000;">
			<?php }
			else if($retry == "manual")
			{?>
            	<tr class="manual" style="border-top: 1px solid #000;">
			<?php }
			else
			{?>
            	<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>" style="border-top: 1px solid #000;">
			<?php }
		 ?>
			
           
 <td>
     <a href="javascript:void(0)" onClick="tetingalert('<?php echo $result->recharge_id; ?>')">
         <?php echo $result->recharge_id; ?>
    </a>
     </td>
 
  <td><a href="<?php echo base_url()."_Admin/check_transaction?recid=".$result->recharge_id; ?>" target="_blank" style="text-decoration:none;color:#000000"><?php echo $result->ewallet_id; ?></a></td>
  
  <td><?php echo $result->operator_id; ?></td>
  
  
  
 <td style="font-size:10px;"><?php echo $result->add_date; ?></td>
 <td>
     <?php 
        if($result->update_time != "0000-00-00 00:00:00")
        {
            $recdatetime =date_format(date_create($result->add_date),'Y-m-d h:i:s');
            $cdate =date_format(date_create($result->update_time),'Y-m-d h:i:s');
            $now_date = strtotime (date ($cdate)); // the current date 
    		$key_date = strtotime (date ($recdatetime));
    		$diff = $now_date - $key_date;
    		echo $diff;
    		//echo  "<br>";    
        }
        
     //echo $result->update_time; 
     ?>
 </td>
 <!-- <td><?php echo $result->update_time; ?></td>-->
 <td><?php echo $this->Common_methods->getHostName($result->host_id)."<br>".$result->username."<br>".$result->businessname; ?></td>
 <td><?php echo $result->mcode; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td>
 <?php 
 if($result->recharge_status == 'Pending'){echo "<span class='label btn-warning'>Pending</span>";}
 if($result->recharge_status == 'Success')
 {
 	$totalRecharge += $result->amount;echo "<span class='label btn-success'>Success</span>";
 }
 if($result->recharge_status == 'Failure')
 {
	 if($result->edit_date == 3)
	 {
			echo "<span class='label btn-primary'>Reverse</span>"; 
	 }
	 else
	 {
		 echo "<span class='label btn-danger'>Failure</span>";
	 }
 	
 }
 
 
 ?></td>
 <td><?php echo $result->ExecuteBy;?></td>
 <td><?php echo $result->lapubalance;?></td>
 <td><?php echo $result->statecode;?></td>
 <td><?php echo ($result->amount - $result->commission_amount); ?></td>
 
 
 
  <td>
  <?php if($this->session->userdata("ausertype") == "Admin"){ ?>
	  <?php if($result->recharge_status == 'Success')
	  { ?>
 <select style="width:80px;" class="myselect" id="action_<?php echo $result->recharge_id; ?>"><option value="Select">Select</option>
	 <option value="Failure">Failure</option>
</select>
	  
	  <?php }
	  else 
	  {?>
	      <select style="width:80px;" class="myselect" id="action_<?php echo $result->recharge_id; ?>"><option value="Select">Select</option>
	 <option value="Failure">Failure</option>
</select>
	  <?php } ?>
	  
	  
 <?php } ?>
 </td>
 <td><input type="button" id="btnact" name="btnact" class="btn btn-primary btn-xs btn-mini myselect" value="Submit" onClick="ActionSubmit('<?php echo $result->recharge_id; ?>','<?php echo $result->mobile_no; ?>')"></td>
  
 </tr>
 <tr id="tr_reqresp<?php echo $result->recharge_id; ?>" style="display:none">
     <td>Request </td><td colspan="4" id="tdreq<?php echo $result->recharge_id; ?>"  style="word-break:break-all"></td>
     <td>Response</td> <td colspan="5" id="tdresp<?php echo $result->recharge_id; ?>" style="word-break:break-all" ></td>
      <td><a href="javascript:void(0)" onClick="testhidstr('<?php echo $result->recharge_id; ?>')" >Hide</a></td>
 </tr>
		<?php 	
		$i--;} ?>
        <tr style="background-color:#CCCCCC;">  
    
    <th></th>  
      <th></th>  
       <th > </th>
      <th > </th>
     <th  > </th>
     <th > </th>
      <th > </th>
     
	 <th >Total </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
			  <th > </th>
   	 <th></th>  
   	 <th></th> 
   	 <th ></th>    
   	 <th></th>
     <th></th>  
       <th></th>         
    </tr>
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
        <!-- end wrapper -->
    <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getlogs"; ?>">
    <input type="hidden" id="hidgetuserdataurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
    
    <!-- Core Scripts - Include with every page -->
   <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/manual_refund/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
 
	
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    
     
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
    
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
<input type="hidden" id="hisrecids" value="<?php echo $strrecid;?>">
</body>
</html>