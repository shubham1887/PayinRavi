<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Add Bank</title>

    
     
    
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
          <span class="breadcrumb-item active">Add Bank</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div class="col-md-5 col-8 align-self-center">
                        <h4 class="text-themecolor m-b-0 m-t-0">Add Bank</h4>
                        
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
                 <form class="form" action="" method="post">
                                    <?php
                                        $add_class_readonly = '';
                                        if(isset($rsltdata))
                                        {
                                            if($rsltdata->num_rows() == 1)
                                            {
                                                $add_class_readonly = 'readonly';
                                            }
                                        }
                                    ?>

                                    <?php if($is_edit == "yes") {?>
                                           <input type="hidden" name="hidEncId" value="<?php echo $this->input->get('bankid'); ?>"> 
                                        <?php } ?>




                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Available Balance </h5>
                                        <div class="col-5 text-dark">
                                           <strong> <?php echo $this->Ewallet_aeps->getAgentBalance($this->session->userdata("ApiId")); ?></strong>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Select Bank</h5>
                                        <div class="col-5">
                                            <select <?php echo $add_class_readonly; ?> id="ddlbank" name="ddlbank" class="form-control" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                                <?php
                                                    $rsltbanks = $this->db->query("select Id,bank_name from dmr_banks order by bank_name");
                                                    foreach($rsltbanks->result() as $rwb)
                                                    {?>
                                                        <option value="<?php echo $rwb->Id; ?>"><?php echo $rwb->bank_name; ?></option>
                                                    <?php }
                                                 ?>
                                            </select>
                                            <?php if($is_edit == "yes") {?>
                                                <script language="javascript">
                                                    document.getElementById("ddlbank").value = '<?php echo $rsltdata->row(0)->bank_id; ?>';
                                                    $( "#ddlapi" ).prop( "disabled", true );

                                                </script>
                                            <?php } ?>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Account Holder Name</h5>
                                        <div class="col-5">
                                            <input <?php echo $add_class_readonly; ?> type="text" name="txtAccHolderName" id="txtAccHolderName" class="form-control" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                        </div>
                                        <?php if($is_edit == "yes") {?>
                                            <script type="text/javascript">
                                                document.getElementById("txtAccHolderName").value = '<?php echo $rsltdata->row(0)->account_name; ?>';    
                                            </script>
                                            
                                        <?php } ?>
                                    </div>

                                    
                                    
                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Account Number</h5>
                                        <div class="col-5">

                                            <input <?php echo $add_class_readonly; ?> class="form-control" type="text" id="txtAccNumber" name="txtAccNumber" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                        </div>

                                        <?php if($is_edit == "yes") {?>
                                            <script type="text/javascript">
                                                document.getElementById("txtAccNumber").value = '<?php echo $rsltdata->row(0)->account_number; ?>';    
                                            </script>
                                            
                                        <?php } ?>
                                    </div>


                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">IFSC CODE</h5>
                                        <div class="col-5">

                                            <input <?php echo $add_class_readonly; ?> class="form-control" type="text" id="txtIfsc" name="txtIfsc" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                        </div>

                                        <?php if($is_edit == "yes") {?>
                                            <script type="text/javascript">
                                                document.getElementById("txtIfsc").value = '<?php echo $rsltdata->row(0)->ifsc; ?>';    
                                            </script>
                                            
                                        <?php } ?>
                                    </div>

                                    <?php
                                    if($is_edit == "yes") 
                                    {

                                    if($rsltdata->row(0)->status == "Active"){
                                     ?>
                                    

                                     <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Mode</h5>
                                        <div class="col-5">
                                            <select id="ddlmode" name="ddlmode" class="form-control">
                                              <option value="NEFT">Icici To Icici</option>
                                              <option value="NEFT">NEFT</option>
                                              <option value="IMPS">IMPS</option>
                                            </select>
                                           
                                        </div>

                                        
                                    </div>



                                    <div class="form-group row">
                                        <h5 class="text-sm text-default col-2 col-form-label  text-right" style="font-size: 16px;">Move To Bank Amount</h5>
                                        <div class="col-5">

                                            <input class="form-control" type="text" id="txtAmount" name="txtAmount" style="font-family: sans-serif;font-size: 16px;font-weight: bold;color: black">
                                        </div>

                                        
                                    </div>
                                <?php }} ?>




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
