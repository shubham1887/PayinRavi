<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Move To Bank</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
     <style>
        strong
        {
            font-family: sans-serif;;
            font-weight: bold;
            font-size: 18px;
            color: #00D;
        }
    </style>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/apisidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/apiheader.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">REPORT</a>
          <span class="breadcrumb-item active">Move To Bank</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">Move To Bank</h4>
                        
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
                 <form id="frmPayout" class="form" action="<?php echo base_url(); ?>API/AddBank/payout" method="post">
                                   
                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Bank Name</h5>
                                        <div class="col-5">
                                            <strong><?php echo $rsltdata->row(0)->bank_name; ?></strong>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Account Holder Name</h5>
                                        <div class="col-5">
                                           <strong><?php echo $rsltdata->row(0)->account_name; ?></strong>
                                        </div>
                                       
                                    </div>

                                    
                                    
                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Account Number</h5>
                                        <div class="col-5">
                                           <strong><?php echo $rsltdata->row(0)->account_number; ?></strong>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">IFSC CODE</h5>
                                        <div class="col-5">
                                           <strong><?php echo $rsltdata->row(0)->ifsc; ?></strong>
                                        </div>
                                    </div>

                                    <?php

                                    if($rsltdata->row(0)->status == "Active"){
                                     ?>
                                    
                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Transfer Mode</h5>
                                        <div class="col-5">
                                           <strong><?php echo $mode; ?></strong>
                                        </div>

                                        
                                    </div>
                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Move To Bank Amount</h5>
                                        <div class="col-5">
                                           <strong><?php echo $amount; ?></strong>
                                        </div>

                                        
                                    </div>
                                    <?php } ?>




                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;"></h5>
                                        <div class="col-5">
                                           <input type="button" name="btnMoveToBank" id="btnMoveToBank" value="Move To Bank" class="btn btn-primary" onclick="MoveToBank()">

                                           <button class="btn btn-primary" id="btn-loader" style="display: none;">
                                              <span class="spinner-border spinner-border-sm"></span>
                                              Loading..
                                            </button>

                                        </div>
                                    </div>
                                    
                                    <input type="hidden" name="hidAmount" value="<?php echo $this->Encr->encrypt($amount); ?>">
                                    <input type="hidden" name="hidMode" value="<?php echo $this->Encr->encrypt($mode); ?>">
                                </form>
<script type="text/javascript">
    function MoveToBank()
    {
        
        // $('#btnMoveToBank').hide();
        // $('#btn-loader').show();
        document.getElementById("btnMoveToBank").style.display = 'none';
        document.getElementById("btn-loader").style.display = 'block';
        document.getElementById("frmPayout").submit();
    }
</script>

                        
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">RECHARGE REPORT</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <h4 class="card-title">RECHARGE REPORT</h4>
                                <div class="table-responsive">
                                </div>
     
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
