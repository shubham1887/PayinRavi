<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

    <title>Commission Slab</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script>
function SetEdit(value)
	{
		document.getElementById('txtGroupName').value=document.getElementById("name_"+value).innerHTML;
		document.getElementById('ddlretChargeType').value=document.getElementById("charge_type_"+value).innerHTML;		

		document.getElementById('txtRetailerCharge').value=document.getElementById("charge_value_"+value).innerHTML;
		document.getElementById('ddldistChargeType').value=document.getElementById("dist_charge_type_"+value).innerHTML;
		document.getElementById('txtDistCharge').value=document.getElementById("dist_charge_value_"+value).innerHTML;
		
		document.getElementById('btnSubmit').value='Update';
		document.getElementById('hidID').value = value;
		
	}
	function Confirmation(value)
	{
		var con = confirm("Are You Sure Want To Delete "+document.getElementById("name_"+value).innerHTML);
		if(con == true)
		{
			document.getElementById("hidValue").value = value;
			document.getElementById("frmDelete").submit();
		}
	}
</script>
  </head> 

  <body>
<div class="DialogMask" style="display:none"></div>
   <div id="myOverlay"></div>
<div id="loadingGIF"><img style="width:100px;" src="<?PHP echo base_url(); ?>Loading.gif" /></div>
    <!-- ########## START: LEFT PANEL ########## -->
    
    <?php include("elements/sidebar.php"); ?><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <?php include("elements/header.php"); ?><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
    <?php include("elements/rightbar.php"); ?><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
          <a class="breadcrumb-item" href="<?php echo base_url()."_Admin/dashboard"; ?>">Dashboard</a>
          <a class="breadcrumb-item" href="#">Settings</a>
          <span class="breadcrumb-item active">Commission Slabs</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Commission Slabs</h4>
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
                  <form role="form" method="post" action="<?php echo base_url()."_Admin/dmr_margin_slab?crypt=".$this->Common_methods->encrypt("MyData"); ?>">                            
                    <input type="hidden" id="hidID" name="hidID">                                     
                        <table cellspacing="10" cellpadding="3">                                     
                                     <tr>                                     	
                                     <td style="padding-right:10px;">                                         	 
                                     <label>SLAB NAME</label>                                             
                                     <input class="form-control-sm" id="txtGroupName" name="txtGroupName" type="text" style="width:120px;" placeholder="Group NAME">                                         
                                     </td>                                         
                                     <td style="padding-right:10px;display:none">                                         	 
                                     <label>RETAILER CHARGE TYPE</label>                                             
                                     <select id="ddlretChargeType" name="ddlretChargeType" class="form-control-sm"> 												
                                     <option value="AMOUNT">AMOUNT</option> 												
                                     <option value="PER">PER</option> 												
                                     <option value="SLAB">SLAB</option> 											
                                     </select>                                         
                                     </td>                                         
                                     <td style="padding-right:10px;display:none">                                         	 
                                     <label>Retailer Charge</label>                                              
                                     <input class="form-control-sm" id="txtRetailerCharge" name="txtRetailerCharge" type="text" style="width:120px;" placeholder="Retailer Charge">                                         
                                     </td>                                         
                                     <td style="padding-right:10px;display:none">                                         	 
                                     <label>DIST CHARGE TYPE</label>                                             
                                     <select id="ddldistChargeType" name="ddldistChargeType" class="form-control-sm"> 												
                                     <option value="AMOUNT">AMOUNT</option> 												
                                     <option value="PER">PER</option> 												
                                     <option value="SLAB">SLAB</option> 											
                                     </select>                                         
                                     </td>                                         
                                     <td style="padding-right:10px;display:none">                                         	 
                                     <label>DIST CHARGE</label>                                              
                                     <input class="form-control-sm" id="txtDistCharge" name="txtDistCharge" type="text" style="width:120px;" placeholder="Distributor Charge">                                         
                                     </td>                                         
                                     <td>                                         
                                     <input type="submit" id="btnSubmit" name="btnSubmit" value="Submit" class="btn btn-primary btn-sm">                                                                                  
                                     </td>                                     
                                     </tr>                                     
                                     </table>                                                                                                                                                              
                    </form> 							 							 							
                    <form id="frmDelete" name="frmDelete" action="<?php echo base_url()."_Admin/dmr_margin_slab"; ?>" method="post"> 								
                         <input type="hidden" id="hidValue" name="hidValue"> 								
                         <input type="hidden" id="action" name="action" value="DELETE"> 							
                    </form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Margin Group List</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                    <thead>                                         
                                    <tr>                                             
                                    <th>#</th>                                             
                                    <th>Slab Name</th>                                             
                                    <th>Action</th>                                         
                                    </tr>                                     
                                    </thead>                                     
                                    <tbody>                                    
                                    <?php $i=1; foreach($result_api->result() as $row) 								   
                                    {?>                                         
                                    <tr>                                             
                                    <td><?php echo $i; ?></td>                                             
                                    <td><span id="name_<?php echo $row->Id; ?>"><?php echo $row->Name; ?></span></td>                                             
                                    <td> 												
                                 											
                                   
                                    <a href="<?php echo base_url()."_Admin/mt_commission_slab?crypt1=".$this->Common_methods->encrypt($row->Name)."&crypt2=".$this->Common_methods->encrypt($row->Id); ?>" target="_blank"> 													
                                    <?php echo $row->charge_type; ?> 												
                                    </a> 												
                                    								
                                    </td>                                             
                                                                                                                     
                                    <td> 
                                    
                                        
                                    <button class="btn btn-sm btn-info" onClick="SetEdit(<?php echo $row->Id; ?>)" href="#modal-form" data-toggle="modal">
									<i class="ace-icon fa fa-pencil bigger-120"></i>Edit	
									</button>
								

									<button class="btn btn-sm btn-danger" onClick="Confirmation(<?php echo $row->Id; ?>)" href="#modal-formdelete" data-toggle="modal">
								    <i class="ace-icon fa fa-trash-o bigger-120"></i>	Delete														</button>
									                         
                                    </td>                                         
                                    </tr>                                    
                                    <?php $i++;} ?>                                       
                                    </tbody>                                 
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
