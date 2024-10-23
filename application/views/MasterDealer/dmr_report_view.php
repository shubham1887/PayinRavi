<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>DMT REPORT</title>



    

     

    

	<?php include("elements/linksheader.php"); ?>

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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

		

		var from = document.getElementById("txtFrom").value;

		var to = document.getElementById("txtTo").value;

		document.getElementById("hidfrm").value = from;

		document.getElementById("hidto").value = to;

		document.getElementById("frmexport").submit();

	$('.DialogMask').hide();

}

	</script>

  </head> 



  <body>

<div class="DialogMask" style="display:none"></div>

   <div id="myOverlay"></div>

<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>

    <!-- ########## START: LEFT PANEL ########## -->

    

    <?php include("elements/mdsidebar.php"); ?><!-- br-sideleft -->

    <!-- ########## END: LEFT PANEL ########## -->



    <!-- ########## START: HEAD PANEL ########## -->

    <?php include("elements/mdheader.php"); ?><!-- br-header -->

    <!-- ########## END: HEAD PANEL ########## -->



    <!-- ########## START: RIGHT PANEL ########## -->

    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->

    <!-- ########## END: RIGHT PANEL ########## --->



    <!-- ########## START: MAIN PANEL ########## -->

    <div class="br-mainpanel">

      <div class="br-pageheader">

        <nav class="breadcrumb pd-0 mg-0 tx-12">

          <a class="breadcrumb-item" href="<?php echo base_url()."MasterDealer/dashboard"; ?>">Dashboard</a>

          <a class="breadcrumb-item" href="#">Reports</a>

          <span class="breadcrumb-item active">DMT REPORT</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>DMT REPORT</h4>

        </div>

      </div><!-- d-flex -->



      <div class="br-pagebody">

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-6 col-lg-12">

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                  <form action="<?php echo base_url()."MasterDealer/dmr_report?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmReport" id="frmReport">

            <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">

            <tr>

            	<td>

                	<h5>From Date :</h5>

                    <input readonly type="text" name="txtFrom" id="txtFrom" value="<?php echo $from; ?>" class="form-control datepicker" title="Select From Date." maxlength="10" style="cursor:pointer" />

                </td>

                <td>

                	<h5>To Date :</h5>

                    <input readonly type="text" name="txtTo" id="txtTo" class="form-control datepicker" value="<?php echo $to; ?>" title="Select From To." maxlength="10"  style="cursor:pointer" />

                </td>

                <td>

                	<h5>Search :</h5>

                    <input type="text" name="txtUserId" id="txtUserId" class="form-control" value="<?php echo $txtUserId; ?>"  maxlength="30" />

                </td>

                <td>

                	<h5>Data :</h5>

                    <select id="ddldb" name="ddldb" class="form-control" style="width: 80px">

						<option value="LIVE">LIVE</option>

						<option value="ARCHIVE">ARCHIVE</option>

					</select>

                </td>

                

                <td style="padding-top:30px;">

                	<h5></h5>

                  <input type="submit" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success" title="Click to search." />

                </td>

				

				<td style="padding-top:30px;">

                	<h5></h5>

                  <input type="button" name="btnExport" id="btnExport" value="Export" class="btn btn-primary" onClick="startexoprt()"  />

					

                </td>

            </tr>

            </table>

           











</form>

       <form id="frmexport" name="frmexport" action="<?php echo base_url()."MasterDealer/dmr_report/dataexport" ?>" method="get">

                                    <input type="hidden" id="hidfrm" name="from">

                                    <input type="hidden" id="hidto" name="to">

                                    <input type="hidden" id="hiddb" name="db">

                                    

                                    </form>

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-12 col-lg-12">

         	<div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">DMT WALLET REPORT</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                 <?php

	if ($message != ''){echo "<div class='message'>".$message."</div>"; }

	if ($this->session->flashdata("message") != '')

	{?>

	<div class="alert alert-success alert-dismissable">

                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                    <h4>	<i class="icon fa fa-check"></i> <?php echo $this->session->flashdata("message"); ?>!</h4>

                  

                  </div>

	 <?php } 

	if(isset($result_all))

	{

		if($result_all->num_rows() > 0)

		{

	?>

    

    <div id="all_transaction">

<table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">

    <tr>

    <th>Sr No</th>

   <th>ID</th>

   <th>DateTime</th>

    <th>Remitter</th> 

 

   <th>AccountNo</th>        

    <th>Amount</th>

    

    <th>Payable Charge</th>

    <th>Debit Amount</th>       

    <th>Credit Amount</th>       

    <th>Bank Ref No</th>        

    <th>Status</th> 

	<th>Mode</th>         

    <th></th>            



	        

    </tr>

    <?php	$total_amount=0;$total_commission=0;$i = 0;

			foreach($result_all->result() as $result) 	

			{ 

	?>

			<tr id="<?php echo "Print_".$i ?>" class="<?php if($i%2 == 0){echo 'row1';}else{echo 'row2';} ?>">

 <td><?php echo ($i + 1); ?></td>

  <td><?php echo "<span id='db_ssid".$i."'>".$result->Id."</span>"; ?></td> 

  <td><?php echo "<span id='db_ssid".$i."'>".$result->add_date."</span>"; ?></td>

 <td><?php echo "<span id='db_date".$i."'>".$result->RemiterMobile."</span>"; ?></td>

  

 <td><?php echo "<span id='db_company".$i."'>".$result->AccountNumber."<br>".$result->IFSC."<br>".$result->RESP_name."</span>"; ?></td> 

 <td><?php echo "<span id='db_amount".$i."'>".$result->Amount."</span>"; ?></td>

 

 



 <td><?php echo "<span id='db_amount".$i."'>".$result->Charge_Amount."</span>"; ?></td>

 

 <td><?php echo "<span id='db_amount".$i."'>".$result->debit_amount."</span>"; ?></td>

 <td><?php echo "<span id='db_amount".$i."'>".$result->credit_amount."</span>"; ?></td>

 <td><?php 

 

 if( preg_match('/You do not have sufficient balance to perform this/',$result->RESP_status) == 1)

 {

     $statusmsg = "Internal Server Error";

}

 else 

 {

    $statusmsg = $result->RESP_status;

  }

 

 

 echo "<span id='db_amount".$i."'>".$result->RESP_opr_id."<br>". $statusmsg."</span>"; 

 

 

 ?></td>

 <td>

     <?php if($result->Status == "PENDING")

     {

         if($result->RESP_status == "Refund Pending")

         {

             echo "<span id='db_status".$i."' class='label label-primary' onclick='checkpending(".$result->Id.")'>Get Refund</span>";

         }

         else

         {

            echo "<span id='db_status".$i."' class='label label-primary' onclick='checkpending(".$result->Id.")'>".$result->Status."</span>";     

         }

        

    } ?>

    <?php if($result->Status == "HOLD")

     {

        

            echo "<span id='db_status".$i."' class='label label-primary' >Pending</span>";     

       

        

    } ?>

  <?php if($result->Status == "SUCCESS"){echo "<span id='db_status".$i."' class='label label-success'>".$result->Status."</span>";} ?>

  <?php if($result->Status == "FAILED" or $result->Status == "FAILURE"){echo "<span id='db_status".$i."' class='label label-warning'>".$result->Status."</span>";} ?>

  </td>

  <td><?php echo "<span id='db_date".$i."'>".$result->mode."</span>"; ?></td>

  <td><a href="<?php echo base_url()."Retailer/print_dmr_online_copy?idstr=".$this->Common_methods->encrypt($result->Id)."&idstr2=".$this->Common_methods->encrypt($result->user_id); ?>" target="_blank">Print</a></td>	



 </tr>

		<?php

		if($result->Status == "SUCCESS")

		{

		$total_amount= $total_amount + $result->Amount;}

		$i++;} ?>

		

         <tr class="ColHeader">

    <th></th>

    <th></th>

	<th></th>

    <th></th>

    

 

   

    <th>Total :</th>        

   <th><?php echo $total_amount; ?></th>        

    

       <th></th>

    <th></th>

    <th></th>     <th></th>    

	<th></th>          

	<th></th>

    <th></th>

     <th></th>

    <th></th>

	            

    </tr>        

		</table>

        </div>

       <?php

		}

	   else{?>

		   <div class='message'>Record Not Found.</div>

		   <?php }

	   

	   }?> 

              </div><!-- card-body -->

            </div>

             

        </div>

        </div>

      </div><!-- br-pagebody -->

      



      <?php include("elements/footer.php"); ?>

    </div><!-- br-mainpanel -->

    <!-- ########## END: MAIN PANEL ########## -->



    <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>

    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>

    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>

    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>

    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>



    <script src="<?php echo base_url();?>js/bracket.js"></script>

  </body>

</html>

