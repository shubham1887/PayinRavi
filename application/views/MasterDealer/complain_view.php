<!DOCTYPE html>

<html lang="en">

  <head>

    



    <title>COMPLAIN BOX</title>



    

     

    

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

          <a class="breadcrumb-item" href="#">OTHERS</a>

          <span class="breadcrumb-item active">COMPLAIN BOX</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>COMPLAIN BOX</h4>

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

                  Search :<input type="text" id="txtSearch" name="txtSearch" style="width:120px;" class="" placeholder="Recharge Id">&nbsp;&nbsp;<input type="button" id="btnComplainBoxSearch" name="btnComplainBoxSearch" value="Search" class="btn btn-primary btn-sm">

              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-12 col-lg-12">

         	<div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">COMPLAIN HISTORY</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">

                <table class="table table-striped table-bordered table-hover">
            <tr>
            <th>Complain Id</th>
          
            <th>Recharge ID</th>
            <th>Recharge Date</th>
             <th>Mobile</th>
              <th>Amount</th>
               <th >Message</th>
            <th>Response Message</th>    
             <th>Complain Date</th>
              <th>Solve Date</th>
           <th >Status</th>    
            </tr>
            <?php	$i = 0;foreach($result_complain->result() as $result) 	{ 
            
            if($result->recharge_id > 0)
            {
                $rsltrecharge = $this->db->query("select order_id,recharge_date,mobile_no,amount from tblrecharge where recharge_id = ?",array($result->recharge_id));
                if($rsltrecharge->num_rows() > 0)
                {
                    $order_id = $rsltrecharge->row(0)->order_id;
                    $mobile_no = $rsltrecharge->row(0)->mobile_no;
                    $amount = $rsltrecharge->row(0)->amount;
                    $recharge_date = $rsltrecharge->row(0)->recharge_date;
                }
                else
                {
                    $rsltrecharge2 = $this->db->query("select order_id,recharge_date,mobile_no,amount from atonline_archivedb.tblrecharge where recharge_id = ?",array($result->recharge_id));
                if($rsltrecharge2->num_rows() > 0)
                {
                    $order_id = $rsltrecharge2->row(0)->order_id;
                    $mobile_no = $rsltrecharge2->row(0)->mobile_no;
                    $amount = $rsltrecharge2->row(0)->amount;
                    $recharge_date = $rsltrecharge2->row(0)->recharge_date;
                }
                else
                {
                    $order_id = "";
                    $mobile_no = "";
                    $amount = "";
                    $recharge_date = "";
                }
                }
            }
            else
            {
                    $order_id = "";
                    $mobile_no = "";
                    $amount = "";
                    $recharge_date = "";
            }
             ?>
            <tr>
             <td><?php echo $result->complain_id; ?></td>
        
          
          <td><?php echo $result->recharge_id; ?></td>
          <td><?php echo $recharge_date; ?></td>
           <td><?php echo $mobile_no; ?></td>
             <td><?php echo $amount; ?></td>
           <td><?php echo $result->message; ?></td>
          <td><?php echo $result->response_message; ?></td> 
            <td><?php echo $result->complain_date; ?></td>
              <td><?php echo $result->complainsolve_date; ?></td>
          <td>
              <?php
            if($result->complain_status == "Pending")
            {?>
                <span class="label-warning label label-default">Pending</span>
            <?php }?>
             <?php
            if($result->complain_status == "Revert")
            {?>
                <span class="label-default label label-danger">Solved</span>
            <?php }?>
            <?php
            if($result->complain_status == "Solved")
            {?>
            <span class="label-success label label-default">Solved</span>
            <?php }?>
         </td>      
        </tr>
                <?php 	
                $i++;} ?>
                </table>

              </div><!-- card-body -->

            </div>

             <?php  echo $pagination; ?> 

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

