<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Retailer | OperatorWise Report</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
   <?php include("files/links.php"); ?>
   <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

     <script>

	 	

$(document).ready(function(){

 $(function() {

            $( "#txtFrom" ).datepicker({dateFormat:'yy-mm-dd'});

            $( "#txtTo" ).datepicker({dateFormat:'yy-mm-dd'});

         });

});

	


function startexoprt()
{
		$('.DialogMask').show();
		document.getElementById('trmob').style.display = 'table-row';
	
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
	$.ajax({
			url:'<?php echo base_url()."Retailer/operatorwisereport/dataexport"?>?from='+from+'&to='+to,
			type:'post',
			cache:false,
			success:function(html)
			{
				document.getElementById('trmob').style.display = 'none';
				$('.DialogMask').hide();
				window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    			
			}
			});
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
  </head>
  <body class="skin-blue sidebar-mini">
  <div class="DialogMask" style="display:none"></div>
    <div class="wrapper">

      <?php include("files/distheader.php"); ?>
      
      <!-- Left side column. contains the logo and sidebar -->
       <?php include("files/distsidebar.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            OperatorWise Report
          </h1>
         
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- /.row -->
          <div class="row">
            <!-- left column -->
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-xs-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
				<table>
                    <tr id="trmob" style="display:none">
    	<td align="center" colspan="2" >
            <img src="<?php echo base_url()."ajax-loader_bert.gif"; ?>"/>
        </td>
        
    </tr><tr id="trmobmsg" style="display:none">
    	<td align="center" colspan="2">
        	<span id="mobmsg" class="mobmsg"></span>
        </td>
        
    </tr></table>
                           <form action="<?php echo base_url()."Retailer/operatorwisereport" ?>" method="post" name="frmCallAction" id="frmCallAction">

                           <input type="hidden" id="hidID" name="hidID">

                                    <table cellspacing="10" cellpadding="3">

                                    <tr>
 
                                    <td style="padding-right:10px;">

                                        	 <label>From Date</label>

                                            <input class="form-control" value="<?php echo $from; ?>" id="txtFrom" name="txtFrom" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>

                                    	<td style="padding-right:10px;">

                                        	 <label>To Date</label>

                                            <input class="form-control" id="txtTo" value="<?php echo $to; ?>" name="txtTo" type="text" style="width:120px;" placeholder="Select Date">

                                        </td>

                                        <td valign="bottom">

                                        <input type="submit" id="btnSearch" name="btnSearch" value="Search" class="btn btn-primary">
                                        <input type="button" id="btnExport" name="btnExport" value="Export" class="btn btn-success" onClick="startexoprt()">

                                      

                                        </td>

                                    </tr>

                                    </table>

                                        

                                       

                                       

                                    </form>
                                    
                 <div class="box-footer">
                   
                  </div>
              </div><!-- /.box -->
              <!-- general form elements disabled -->
              <!-- /.box -->
            </div><!--/.col (right) -->
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search"/>
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                
                  <?php

	if ($message != ''){echo "<div class='message'>".$message."</div>"; }

	if(isset($result_all))

	{

		if($result_all->num_rows() > 0)

		{

	?>

    <h2 class="h2">Search Result</h2>

    <div id="all_transaction">

<table style="width:100%;" cellpadding="3" cellspacing="0" border="1">
    <tr class="ColHeader" style="background: #4DA6FF;color: #fff;">
        <th >Date</th>
     
        <th >Operator_name</th>
    
        <th >Success Count</th>
    
        <th >Success Recharge</th>
    
        <th >Failure Recharge</th>  
         <th >Pending Recharge</th>  
    
        <th >Commission Given</th>
    </tr>
    <?php $TotalFailure = 0;$TotalPending = 0; $totalsuccesscount= 0; $i = 0;$TotalRecharge=0;$TotalCommission=0; foreach($result_all->result() as $result) 	
	{
	    $row_Failure = 0;
	    $row_Pending = 0;
	    if(isset($result->Failure))
	    {
	        $row_Failure = $result->Failure;
	        $TotalFailure += $result->Failure;   
	        
	    }
	    if(isset($result->Pending))
	    {
	        $TotalPending += $result->Pending;   
	        $row_Pending += $result->Pending;   
	    }
		 
		 
	 ?>
			<tr class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">
            <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $from."   To   ".$to; ?></td>
  <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->company_name; ?></td>
   <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->totalcount; ?></td>
 <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->Total; ?></td>
  <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $row_Failure; ?></td>
   <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;">
   <?php echo $row_Pending; ?></td>
 <td  class="padding_left_10px box_border_bottom box_border_right" align="center" height="34" style="min-width:50px;width:50px;"><?php echo $result->Commission; ?></td>
 </tr>
		<?php 	
		
		$TotalCommission += $result->Commission;
		$TotalRecharge += $result->Total;
		 $totalsuccesscount += $result->totalcount;
		$i++;} ?>
        <tr class="ColHeader" style="background:#769DF8;border:1px solid #000;color: #fff;">
        <th ></th>
        <th >Total : </th>
       <th ><?php echo $totalsuccesscount;?></th>
       <th ><?php echo $TotalRecharge; ?></th>
        <th ><?php echo $TotalFailure; ?></th>
        <th ><?php echo $TotalPending; ?></th>
        <th ><?php echo $TotalCommission; ?></th>
        </tr>
        
		</table>
  
        </div>

       <?php

		}

	   else{

		   echo "<div class='message'>Record Not Found.</div>";

		   }

	   

	   }?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      

      <!-- Control Sidebar -->
      <!-- /.control-sidebar -->
     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015  All rights reserved.
      </footer>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

  <?php include("files/adminfooter.php"); ?>
  </body>
</html>