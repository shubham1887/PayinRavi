<!DOCTYPE html>

<html>



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>::RECHARGE LIST</title>

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
		var user = document.getElementById("ddlUser").value;
		var from = document.getElementById("txtFrom").value;
		var to = document.getElementById("txtTo").value;
	$.ajax({
			url:'<?php echo base_url()."/all_transaction_report/dataexport"?>?from='+from+'&to='+to+'&user='+user,
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



<body>
<div class="DialogMask" style="display:none"></div>
    <!--  wrapper -->

    <div id="wrapper">

        <!-- navbar top -->

        

        <!-- end navbar top -->



        <!-- navbar side -->

        <?php include("files/mdheader.php"); ?> 

        <!-- END HEADER SECTION -->







        <!-- MENU SECTION -->

       <?php include("files/mdsidebar.php"); ?>

        <!-- end navbar side -->

        <!--  page-wrapper -->

          <div id="page-wrapper">

            <div class="row">

                 <!-- page header -->

                <div class="col-lg-12">

                    <h1 class="page-header">Forms</h1>

                <button class="btn btn-success" type="button">Success : <?php echo $totalRecahrge; ?></button>
                <button class="btn btn-warning" type="button">Pending : <?php echo $totalpRecahrge; ?></button>
                <button class="btn btn-danger" type="button">Failure : <?php echo $totalfRecahrge; ?></button>
                 <button class="btn btn-info" type="button">Profit : <?php echo $totalProfit; ?></button>


                </div>

                <!--end page header -->

            </div>

            <div class="row">

                <div class="col-lg-12">

                    <!-- Form Elements -->

                    <div class="panel panel-default">

                        <div class="panel panel-primary">

                        <div class="panel-heading">

                            <i class="fa fa-fw"></i>SEARCH RECHARGE

                            

                        </div>



                        <div class="panel-body">
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
                           <form action="<?php echo base_url()."/all_transaction_report" ?>" method="post" name="frmCallAction" id="frmCallAction">

                           <input type="hidden" id="hidID" name="hidID">

                                    <table cellspacing="10" cellpadding="3">

                                    <tr>
 <td style="padding-right:10px;">

                                        	 <label>From Date</label>

                                          <select id="ddlUser" name="ddlUser" class="form-control" style="width:150px;">
     <option value="ALL">ALL</option>
     <?php
	 	$rsl = $this->db->query("select user_id,username,businessname from tblusers where usertype_name = 'Agent' and parentid IN (select user_id from tblusers where parentid = ?) order by businessname",array($this->session->userdata("SdId")));
		foreach($rsl->result() as $row)
		{
			echo "<option value=".$row->user_id.">".$row->businessname."[".$row->username."]</option>";
		}
	  ?>
     </select>

                                        </td>
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

                            <i class="fa fa-fw"></i>RECHARGE LIST

                            

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

    <h2 class="h2">Search Result</h2>

    <div id="all_transaction">

<table class="table table-striped table-bordered table-hover" border="0">

    <tr>

    <th>Sr No</th>
 <th >AgentName</th>
   <th >Recharge ID</th>

 

    <th>Recharge<br> Date Time</th> 
    <th>Update<br> DateTime</th> 

   <th>Company Name</th>

    <th>Mobile No</th>
    <th>Your Com.</th>
     <th>Dist Com.</th>

  

   <th>Amount</th>

    <th>Debit Amount</th>        

    <th>Status</th>             



	        

    </tr>

    <?php	$total_amount=0;$total_commission=0;$i = 0;foreach($result_all->result() as $result) 	{  ?>

			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">

 <td><?php echo ($i + 1); ?></td>
  <td><?php echo $result->businessname."<br>".$result->username; ?></td>

  <td><?php echo "<span id='db_ssid".$i."'>".$result->recharge_id."<br>".$result->operator_id."</span>"; ?></td> 


 <td><?php echo "<span id='db_date".$i."'>".$result->add_date."</span>"; ?></td>
  <td><?php echo "<span id='db_date".$i."'>".$result->update_time."</span>"; ?></td> 

  

 <td><?php echo "<span id='db_company".$i."'>".$result->company_name."</span>"; ?></td> 

 <td><?php echo "<span id='db_mobile".$i."'>".$result->mobile_no."</span>"; ?></td>
  <td><?php echo "<span id='db_mobile".$i."'>".$result->MdComm."</span>"; ?></td> 
 <td><?php echo "<span id='db_mobile".$i."'>".$result->DComm."</span>"; ?></td> 



 <td><?php echo "<span id='db_amount".$i."'>".$result->amount."</span>"; ?></td>

 	<?php 

	if($result->recharge_status == "Success")

	{

		$total_commission += $result->commission_amount;



		$debit_amount = $result->amount - $result->commission_amount;

	}

	else

	{

		$debit_amount = 0;

	}

	?>

  <td><?php echo "<span id='db_amount".$i."'>".$debit_amount."</span>"; ?></td>

 

  <td>

    <?php if($result->recharge_status == "Pending"){echo "<span id='db_status".$i."' class='btn btn-warning'>".$result->recharge_status."</span>";} ?>

  <?php if($result->recharge_status == "Success"){echo "<span id='db_status".$i."' class='btn btn-success'>".$result->recharge_status."</span>";} ?>

  <?php if($result->recharge_status == "Failure"){echo "<span id='db_status".$i."' class='btn btn-danger'>".$result->recharge_status."</span>";} ?>

  </td>

   

 

 </tr>

		<?php

		if($result->recharge_status == "Success"){

		$total_amount= $total_amount + $result->amount;}

		$i++;} ?>

		

         <tr class="ColHeader">

    <th></th>
 

    <th></th>
    <th></th>

    <th></th>

	<th></th>

    <th></th>

    

   

       <th></th>

    <th></th>

    <th>Total :</th>        

   <th><?php echo $total_amount; ?></th>        

    

    <th><?php echo $total_amount - $total_commission; ?></th>     <th></th>    

	        


	            

    </tr>        

		</table>
   <?php  echo $pagination; ?>
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

