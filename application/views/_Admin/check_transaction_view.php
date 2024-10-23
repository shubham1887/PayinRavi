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
    <title>Check Transaction</title>
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
     <script>
  function getdata()
  {
      document.getElementById("imageautoload").style.display = "block";
      $.ajax({
          
          
          url:document.getElementById("hidgetlogurl").value+"?text="+document.getElementById("ddluser").value,
          cache:false,
          type:'POST',
          success:function(data)
          {
             
              var data = data.split("^-^");
              var dataarr = data;
             
              $( "#ddluser" ).autocomplete({
                  
     
     source: function(request, response) {
        var results = $.ui.autocomplete.filter(dataarr, request.term);
        
        response(results.slice(0, 20));
    }
    });
          },
          complete:function()
          {
               document.getElementById("imageautoload").style.display = "none";
          }
          
      });
  }
  
  </script>
     <script>
	
$(document).ready(function(){
document.getElementById("ddlstatus").value = '<?php echo $ddlstatus; ?>';
document.getElementById("ddloperator").value = '<?php echo $ddloperator; ?>';
document.getElementById("ddlapi").value = '<?php echo $ddlapi; ?>';
//document.getElementById("ddluser").value = '<?php echo $ddluser; ?>';

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
		document.getElementById("hidfrm").value = from;
		document.getElementById("hidto").value = to;
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
                        <h4 class="text-themecolor m-b-0 m-t-0">Check Transaction</h4>
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">SEARCH REPORT</h5>
                                <div class="table-responsive">
                                    <form action="<?php echo base_url()."_Admin/check_transaction?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmCallAction" id="frmCallAction">
                           <input type="hidden" id="hidID" name="hidID">
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    <td style="padding-right:10px;">
                                        	 <h6>Recharge Id</h6>
                                            <input class="form-control-sm" id="txtNumId" name="txtNumId" type="text" style="width:120px;">
                                        </td>
                                    	<td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary">
                                        </td>
                                    </tr>
                                    </table>
                                    </form>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                    
                    
           
                    </div>
                    <!-- column -->
                
                 </div>
                 
                 
                <div class="row">
                    
                    <!-- column -->
                    
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Recharge List</h6>
                                <div class="table-responsive">
                                <?php
	
	if(isset($result_recharge)){	
	?>  
      
    <h2>Recharge Report</h2>
<table class="table table-responsive table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
    <tr>  
    <th  >Sr No</th>
    <th  >Recharge Id</th>
     <th  >Transaction Id</th>  
     <th >Recharge Date</th>
     <th>Agent Name</th>
     <th >Company Name</th>
	 <th >Mobile No</th>    
	 <th >Amount</th>    
   	 <th  >API</th>    
	 <th  >Recharge By</th>
   	 <th >Status</th> 
     <th  ></th>                   
    </tr>
    <?php $totalRecharge = 0;	$i = count($result_recharge->result());foreach($result_recharge->result() as $result) 	{  ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td ><?php echo $i; ?></td>
 <td ><?php echo $result->recharge_id; ?></td>
  <td><?php echo $result->transaction_id; ?></td>
 <td><?php echo $result->add_date; ?></td>
 <td><?php echo $result->businessname; ?></td>
 <td ><?php echo $result->company_name; ?></td>
 <td><?php echo $result->mobile_no; ?></td>
 <td><?php echo $result->amount; ?></td>
 <td><?php echo $result->ExecuteBy; ?></td>
 <td ><?php echo $result->recharge_by; ?></td>
 <td>
 <?php if($result->recharge_status == 'Pending'){echo "<span class='orange'><a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Pending</a></span>";}
 if($result->recharge_status == 'Success'){$totalRecharge += $result->amount;echo "<span class='green'>Success</span>";}
 if($result->recharge_status == 'Failure'){echo "<span class='red'>
 <a id='sts".$result->recharge_id."' href='javascript:statuschecking(".$result->recharge_id.")' >Failure</a></span>";}
 
 ?></td>
  <td >
 
 </td>
 </tr>
		<?php 	
		$i--;} ?>
        <tr>  
        <th  ></th>  
    <th  ></th>  
     <th > </th>
      <th > </th>
     <th> </th>
     <th > </th>
	 <th >Total Succesful Recharge </th>    
	 <th ><?php echo $totalRecharge; ?></th>    
   	 <th  ></th>    
	 <th  > </th>
   	 <th ></th>                   
     <th ></th>                   
    </tr>
		</table> 
         <?php  echo $pagination; ?>        
       <?php } ?>
                                    
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
                                <h6 class="card-title">Account Entry</h6>
                                <div class="table-responsive">
                                <?php if(isset($result_account)){ ?>
       <table class="table table-responsive table-striped .table-bordered mytable-border" style="font-size:14px;color:#000000;font-weight:normal;font-family:sans-serif">
      <tr>  
    <th  >Payment Date</th>
     <th  >Business Name</th>
       <th  >recharge_id</th>
        <th  >Transaction Type</th>
        
         <th  >Description</th>
          <th  >Credit Amount</th>
           <th  >Debit Amount</th>
            <th  >Balance</th>
             
       </tr>
       <?php foreach($result_account->result() as $rw){ ?>
       	<tr>
        <td><?php echo $rw->add_date; ?></td>
        <td><?php echo $rw->bname; ?></td>
        <td><?php echo $rw->recharge_id; ?></td>
        <td><?php echo $rw->transaction_type; ?></td>
        <td><?php echo $rw->description; ?></td>
        <td><?php echo $rw->credit_amount; ?></td>
       <td><?php echo $rw->debit_amount; ?></td>
        <td><?php echo $rw->balance; ?></td>
        </tr>
       <?php } ?>
       </table>
       <?php } ?>
                                    
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
    <input type="hidden" id="hidgetlogurl" value="<?php echo base_url()."_Admin/getutils"; ?>">
    <!-- Core Scripts - Include with every page -->
   <form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/list_recharge/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
 
	
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