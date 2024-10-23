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
    <title>API BALANCE RECON</title>
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
<style>
.ui-datepicker { position: relative; z-index: 10000 !important; }
</style>
 <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
     <script>
	 	
$(document).ready(function(){
 $(function() {
            $( "#txtDate" ).datepicker({dateFormat:'yy-mm-dd'});
           
         });
});
	
	function startexoprt()
{
		$('.DialogMask').show();
		
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
		document.getElementById("frmexport").submit();
	$('.DialogMask').hide();
}
	</script>
    <!--    ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all-->
    <style>
	.error
	{
  		background-color: #ffdddd;
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
</head>
<body class="fix-header card-no-border logo-center">
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modaltitle">Please wait we process your data.</h4>
          
        </div>
        <div class="modal-body">
        <span id="spanloader">
          <img src="<?php echo base_url()."images/ajax-loader.gif"; ?>"></span>
          <span id="responsespan" class="btn btn-warning" style="display:none"></span>
        
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode" style="display:none"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>
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
                        <h4 class="text-themecolor m-b-0 m-t-0">API BALANCE RECON</h4>
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
                                    <form style="margin-left:50px;" action="<?php echo base_url()."_Admin/apibalance_recon" ?>" method="post" name="frmSearch" id="frmSearch">
                                    
                                    
<table class="table table-striped .table-bordered border" style="color:#000000;font-size:14px;font-family:sans-serif">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <h5>Date</h5>
                                           <input type="text" id="txtDate" name="txtDate" class="form-control-sm"  placeholder="Select Date">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>API</h5>
                                            <select id="ddlapi" name="ddlapi" class="form-control-sm"  onChange="getvalues()" >
    <option value="">Select</option>
    <?php
	$raltapi = $this->db->query("select api_id,api_name from tblapi order by api_name");
	foreach($raltapi->result() as $rapi)
	{?>
    <option value="<?php echo $rapi->api_id; ?>"><?php echo $rapi->api_name; ?></option>
	<?php }
	 ?>
    </select>
    <script language="javascript">
	function getvalues()
	{
		
					//recbox#ajaxloader
					
						 $('#myModal').modal({show:true});
					$.ajax({
					url:'<?php echo base_url()."_Admin/apibalance_recon/getvalues"; ?>?date='+document.getElementById("txtDate").value+"&imid="+document.getElementById("ddlapi").value,
					type:'POST',
					cache:false,
					data:$('#frmPaytmWalletTopup').serialize(),
					success:function(html)
					{
						 $('#myModal').modal({show:true});
						var htmlarr = html.split("#");
						document.getElementById("txtOpening").value = htmlarr[0];
						document.getElementById("txtTotalrec").value = htmlarr[1];
						document.getElementById("txtTotalComm").value = htmlarr[2];
						document.getElementById("txtClossing").value = htmlarr[3];
						
						document.getElementById("spanloader").style.display = 'none';
						document.getElementById("spanbtnclode").style.display = 'block';
					
						
						document.getElementById("modaltitle").innerHTML = "";
						
							document.getElementById("responsespan").style.display = 'block';
							document.getElementById("responsespan").innerHTML = html;
						//$("#myModal").modal().hide();
						
						$('#myModal').modal('hide');
						
					}
					});
				
	}
	</script>
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Opening</h5>
                                             <input type="text" id="txtOpening" name="txtOpening" class="form-control-sm"  placeholder="">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Purchase</h5>
                                            <input type="text" id="txtPurchase" name="txtPurchase" class="form-control-sm"  placeholder="" onKeyUp="calculatevalues()">
                                        </td>
                                        <td style="padding-right:10px;">
                                        	 <h5>Purchase return</h5>
                                             <input type="text" id="txtPurchaseRet" name="txtPurchaseRet" class="form-control-sm"  placeholder="" onKeyUp="calculatevalues()">
                                        </td>
                                        <td valign="bottom">
                                        <input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success" value="Submit" onClick="submitformtodata()">
                                        </td>
                                    </tr>
									<tr>
									
									<td style="padding-right:10px;">
										 <h5>TotalRecharge</h5>
										<input type="text" id="txtTotalrec" name="txtTotalrec" class="form-control-sm"  placeholder="">
									</td>
									<td style="padding-right:10px;">
										 <h5>TotalCommission</h5>
										 <input type="text" id="txtTotalComm" name="txtTotalComm" class="form-control-sm"  placeholder="">
									</td>
                                    <td  style="padding-right:10px;">
										 <h5>Closing</h5>
										 <input type="text" id="txtClossing" name="txtClossing" class="form-control-sm"  placeholder="">
									</td>
										<td>
											 <h5>Calculation <br>Closing</h5>
										<input type="text" id="txtCalcClossing" name="txtCalcClossing" class="form-control-sm"  placeholder="">
										</td>
                                        <td>
											 <h5>Difference</h5>
										<input type="text" id="txtDiff" name="txtDiff" class="form-control-sm"  placeholder="">
										</td>
                                        <td>
											 <h5>Remark</h5>
										<input type="text" id="txtremark" name="txtremark" class="form-control-sm"  placeholder="">
										</td>
								</tr>
                                    </table>
 </form>
 <script language="javascript">
 function submitformtodata()
 {
 	document.getElementById("frmSearch").submit();
 }
 </script>
 <script language="javascript">
 function calculatevalues()
 {
 	var opening = document.getElementById("txtOpening").value;
	var purchase = document.getElementById("txtPurchase").value;
	var purchasereturn = document.getElementById("txtPurchaseRet").value;
	var recharge = document.getElementById("txtTotalrec").value;
	var commission = document.getElementById("txtTotalComm").value;
	var closing = document.getElementById("txtClossing").value;
	
	var positivesum = (+opening + +purchase + +commission);
	var negativesum = (+recharge + +purchasereturn );
	//alert("positive : "+positivesum+ "    neg = "+negativesum);
	
	var calculationsum = positivesum - negativesum;
	document.getElementById("txtCalcClossing").value = calculationsum;
	document.getElementById("txtDiff").value = (+calculationsum - +closing);
	
 }
 </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">ACCOUNT REPORT</h4>
                                <div class="table-responsive">
                                    <table class="table  table-striped table-bordered mytable-border" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                 
 <tr>
 	<td>Id</td>
    <td>Date</td>
    <td>api</td>
    <td>Opening</td>
    <td>Purchase</td>
    <td>Rev.Purchase</td>
    <td>Recharge</td>
    <td>Commission</td>
    <td>Closing</td>
    <td>Calc.Closing</td>
    <td>Diff</td>
    <td>Remark</td>
 </tr>
 <?php
 
 	$rsltapirslt = $this->db->query("select a.Id,a.Date,a.api_id,a.add_date,a.opening,a.purchase,a.revert_purchase,a.recharge_total,a.commission_received,a.closing,a.calc_closing,a.difference,a.remark,b.api_name from tblapirecon a left join tblapi b on a.api_id = b.api_id order by a.Date desc");
	foreach($rsltapirslt->result() as $row)
	{
  ?>
  <tr>
  	<td><?php echo $row->Id; ?></td>
    <td><?php echo $row->Date; ?></td>
    <td><?php echo $row->api_name; ?></td>
    <td><?php echo $row->opening; ?></td>
    <td><?php echo $row->purchase; ?></td>
    <td><?php echo $row->revert_purchase; ?></td>
    <td><?php echo $row->recharge_total; ?></td>
    <td><?php echo $row->commission_received; ?></td>
    <td><?php echo $row->closing; ?></td>
    <td><?php echo $row->calc_closing; ?></td>
    <td><?php echo $row->difference; ?></td>
    <td><?php echo $row->remark; ?></td>
  </tr>
  <?php  } ?>
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
   
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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