<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>RETAILER:DMT RESPONSE</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
   
  </head> 
<style>
    .borderless td, .borderless th {
    border: none;
}
</style>
  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sdsidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/sdsidebar.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."Retailer/Dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">DMT</a>
          <span class="breadcrumb-item active">DMT RESPONSE</span>
        </nav>
      </div><!-- br-pageheader -->
      

      <div class="br-pagebody">
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
         
         
                <div class="alert <?php echo $alertclass; ?>">
                  <span class="closebtn">&times;</span>  
                  <strong><?php echo $alert_message; ?></strong>
                </div>
         
         
         
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">TRANSACTION INFORMATION</h6>
                <span class="tx-12 tx-uppercase"> 
                <a class="btn btn-outline-primary" href="<?php echo base_url()."Retailer/print_dmr_online_copy?idstr=".$this->Common_methods->encrypt($data->row(0)->Id)."&idstr2=".$this->Common_methods->encrypt($data->row(0)->user_id); ?>" target="_blank">Print</a>
                &nbsp;&nbsp;
                <a href="<?php echo base_url()."Retailer/dmrmm_dashboard"; ?>" class="btn btn-outline-success">Go To DMT Dashboard</a>
                </span>
              </div><!-- card-header -->
              <div class="card-body">
                  <table class="table table-bordered bordered ">
								 <tr>
								     <td>Unique Id:</td>
					                 <td><a href="javascript:void(0)"><?php echo $data->row(0)->unique_id; ?></a></td>
					                 <td>Transaction DateTime :</td>
					                 <td><a href="javascript:void(0)"><?php echo date_format(date_create($data->row(0)->add_date),'d-m-Y h:i:s A'); ?></a></td>
					                 <td>Response:</td>
					                 <td><a href="javascript:void(0)"><?php echo $alert_message; ?></a></td>
								</tr>
								<tr>
    				                 <td>Sender Number :</td>
    				                 <td><a href="javascript:void(0)"><?php echo $data->row(0)->RemiterMobile; ?></a></td>
    				                 <td>Beneficiary Name:</td>
    				                 <td><a href="javascript:void(0)"><?php echo $data->row(0)->RESP_name; ?></a></td>
    				                 <td>Type:</td>
    				                 <td><a href="javascript:void(0)"><?php echo $data->row(0)->mode; ?></a></td>
						      </tr>
								         
								         
								     </td>
								     
									
									 
									 
									 
								 </tr>

							</table>
							<table class="table table-bordered table-striped" style="color:#00000E">
              <thead class="thead-colored thead-primary" >
                <tr>
                  	<th>ID</th>
                    <th>AccountNo</th>
                    <th>IFSC Code</th>
                    <th>Amount</th>
                    <th>Bank Ref No</th>        
                    <th>Status</th> 
                    
                        
                </tr>
              </thead>
              <tbody>
               <?php	
			$totaldr = 0;$totalcr = 0;$total_amount=0;$total_commission=0;$i = 0;
			foreach($data->result() as $result) 	
			{
	?>
    <tr>
         <td><?php echo $result->Id;?></td> 
         <td><?php echo $result->AccountNumber; ?></td> 
         <td><?php echo $result->IFSC; ?></td>
         <td><?php echo $result->Amount; ?></td>
         <td><?php echo $result->RESP_opr_id; ?></td>
         <td><?php echo $result->Status; ?></td>
    </tr>
		<?php
	
		if($result->Status == "SUCCESS")
		{
		    $total_amount= $total_amount + $result->Amount;
		}
		$i++;} ?>
              </tbody>
            </table>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
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
