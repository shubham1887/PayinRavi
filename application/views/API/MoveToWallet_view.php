<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Move To Wallet</title>
    <?php include("elements/linksheader.php"); ?>
    
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
          <span class="breadcrumb-item active">Move To Wallet</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">Move To Wallet</h4>
                        
                    </div>
                    
      </div><!-- d-flex -->

      <div class="br-pagebody">
        <div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-12">
            <?php include("elements/messagebox.php"); ?>
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Search Filters</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                 <form class="form" action="" method="post">
                                  

                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Available Balance </h5>
                                        <div class="col-5 text-dark">
                                           <strong> <?php echo $this->Ewallet_aeps->getAgentBalance($this->session->userdata("ApiId")); ?></strong>
                                        </div>
                                    </div>


                                   


                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Move To Wallet Amount</h5>
                                        <div class="col-5">

                                            <input class="form-control" type="text" id="txtAmount" name="txtAmount" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                        </div>

                                        
                                    </div>
                              



                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;"></h5>
                                        <div class="col-5">
                                           <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary">
                                        </div>
                                    </div>
                                    
                                    
                                </form>

                        
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
