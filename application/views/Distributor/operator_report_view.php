<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor::OPERATOR REPORT</title>
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
	

	
	</script>

</head>

<body>
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        
        <!-- end navbar top -->

        <!-- navbar side -->
       <?php include("files/distributorheader.php"); ?> 
        <!-- END HEADER SECTION -->



        <!-- MENU SECTION -->
       <?php include("files/distributorsidebar.php"); ?>
        <!-- end navbar side -->
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>SEARCH REPORT
                            
                        </div>

                        <div class="panel-body">
                           <form action="<?php echo base_url()."Distributor/operator_report"; ?>" method="post" name="frmReport" id="frmReport">
    <table>
    <tr>
    	<td >From Date :&nbsp;&nbsp;<input type="text" value="<?php echo $from; ?>" name="txtFrom" id="txtFrom" class="form-control" maxlength="10" /></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;To Date :&nbsp;&nbsp;<input type="text" value="<?php echo $to; ?>" name="txtTo" id="txtTo" class="form-control"  maxlength="10" /></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                        Select Data:   <select id="ddldb" name="ddldb" class="form-control">
<option value="LIVE">LIVE</option>
<option value="Archived">Archived</option>
</select></td>
        <td valign="bottom"> &nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-primary" title="Click to search." /></td>
    </tr>
    </table>
                    	
                      
                        
                        
                        </form>
                        </div>

                    </div>
                        
                    </div>
                    
                     <!-- End Form Elements -->
                </div>
            </div>
            <div class="row">
                
                <div class="col-lg-12">
                     <!--   Basic Table  -->
                    <div class="panel panel-default">
                        <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-fw"></i>Account Report
                            
                        </div>

                        <div class="panel-body">
                           <div class="table-responsive">
                           <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	if(isset($result_all))
	{
		if($result_all->num_rows() > 0)
		{
	?>
    <div>
       <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" border="1">
    <tr>
  
        <th >Operator</th>
        <th >Success</th>
        <th >Failure</th>  
         <th >Pending</th>
          <th >Total</th>  
        <th >Discount</th>
    </tr>
    <?php $TotalFailure = 0;$TotalPending = 0; $totalsuccesscount= 0; $i = 0;$TotalRecharge=0;$TotalCommission=0; foreach($result_all->result() as $result) 	
	{
		 $TotalFailure += $result->Failure;
		 $TotalPending += $result->Pending;
	 ?>
			<tr>
  
  <td  ><?php echo $result->company_name; ?></td>
 <td  ><?php echo $result->Total; ?></td>
  <td ><?php echo $result->Failure; ?></td>
   <td>
   <?php echo $result->Pending; ?></td>
    <td> <?php echo ($result->Total + $result->Failure + $result->Pending); ?></td>
 <td><?php echo $result->Commission; ?></td>
 </tr>
		<?php 	
		
		$TotalCommission += $result->Commission;
		$TotalRecharge += $result->Total;
		 $totalsuccesscount += $result->totalcount;
		$i++;} ?>
        <tr>
  
        <th >Total : </th>
     
       <th ><?php echo $TotalRecharge; ?></th>
        <th ><?php echo $TotalFailure; ?></th>
        <th ><?php echo $TotalPending; ?></th>
        <th ><?php echo ($TotalPending + $TotalRecharge + $TotalFailure); ?></th>
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
                            </div>
                        </div>

                    </div>
                        
                    </div>
                      <!-- End  Basic Table  -->
                </div>
            </div>
        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

    <!-- Core Scripts - Include with every page -->
   
 
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.js"></script>
    <script src="<?php echo base_url();?>assets/scripts/siminta.js"></script>
</body>

</html>
