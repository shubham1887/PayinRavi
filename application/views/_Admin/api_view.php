<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>API LIST</title>

    
     
    
	<?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
<style>
	 
	  
	.divsmcontainer {
    padding: 10px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 5px;
}  
	  
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.message
{
	padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
}
.alert.success {background-color: #4CAF50;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}
.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}
.closebtn:hover {
    color: black;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 2px;
    /*line-height: 1.42857143;*/
    vertical-align: top;
    /*border-top: 1px solid #ddd;*/
    border-left: 1px solid #ddd;
	border-right: 1px solid #ddd;
    border-top: 1px solid #ddd;
	border-bottom:: 1px solid #ddd;
	overflow:hidden;
}
</style>
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
          <a class="breadcrumb-item" href="#">Developers Options</a>
          <span class="breadcrumb-item active">API CONFIGURATION</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
         
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      
      
      	<div class="row row-sm mg-t-20">
      	  
          <div class="col-sm-12 col-lg-12">
               <?php include("elements/messagebox.php"); ?>
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">API LIST</h6>
                <span class="tx-12 tx-uppercase"><a href="<?php echo base_url()."_Admin/Api_integration"; ?>" class="btn btn-primary btn-sm">Add Api</a></span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-striped" style="color:#000000;font-weight:normal;font-family:sans-serif;font-size:14px;overflow:hidden">
                                    <thead>
                                        <tr>
                                            <td align="center">#</td>
                                            <td align="center">API Name</td>
                                            <td align="center">Is Active</td>
                                            <td align="center">Recharge</td>
                                            <td align="center">CheckBalance</td>
                                            <td align="center">Balance</td>
                                            <td align="center">Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php
                                   $strids = '';
                                   $i=1; 
                                   foreach($result_api->result() as $row)
								   {
								       $strids.=$row->Id.",";
								       
								       
								        $is_active = $row->is_active;
                                        $enable_recharge = $row->enable_recharge;
                                        $enable_balance_check = $row->enable_balance_check;
                                        $enable_status_check = $row->enable_status_check;
								        $is_active_prop = '';
                                        $enable_recharge_prop = '';
                                        $enable_balance_check_prop = '';
                                        $enable_status_check_prop = '';
                                        
                                        
                                        if($is_active == 'yes')
                                        {
                                            $is_active_prop = 'checked';
                                        }
                                        if($enable_recharge == 'yes')
                                        {
                                            $enable_recharge_prop = 'checked';
                                        }
                                        if($enable_balance_check == 'yes')
                                        {
                                            $enable_balance_check_prop = 'checked';
                                        }
                                        if($enable_status_check == 'yes')
                                        {
                                            $enable_status_check_prop = 'checked';
                                        }
								   ?>
                                        <tr>
                                            <td align="center"><?php echo $i; ?></td>
                                            <td align="center"><span id="name_<?php echo $row->Id; ?>"><?php echo $row->api_name; ?></span></td>
                                            
                                           
                                           
											<td style="word-break: break-all" align="center">
											<input <?php echo $is_active_prop; ?> type="checkbox" id="chkisapiactive" name="chkisapiactive" value="yes">
											</td>
											<td style="word-break: break-all" align="center">
												<input <?php echo $enable_recharge_prop; ?> type="checkbox" id="chkenableRecharge" name="chkenableRecharge" value="yes">
											</td>
											<td style="word-break: break-all" align="center">
												<input <?php echo $enable_balance_check_prop; ?> type="checkbox" id="chkenableBalanceCheck" name="chkenableBalanceCheck" value="yes">
											</td>
											<td align="center">
											    <a href="#" ><span id="spanbalance<?php echo $row->Id; ?>"></span></a>
											</td>
                                           
                                             <td align="center">
                                                 <a style="color:#FFF" class="btn btn-sm btn-info" href="<?php echo base_url()."_Admin/api_integration?frmaction=EDIT&id=".$this->Common_methods->encrypt($row->Id); ?>">
    												<i class="ace-icon fa fa-pencil bigger-120"></i>Edit	
    											</a>
												<a style="color:#FFF" class="btn btn-sm btn-danger" onClick="Confirmation(<?php echo $row->Id; ?>)">
											        <i class="ace-icon fa fa-trash-o bigger-120"></i>	Delete														
											    </a>


                          <a style="color:#FFF" class="btn btn-sm btn-primary" onClick="copyapi(<?php echo $row->Id; ?>)">
                              <i class="ace-icon fa fa-check-o bigger-120"></i> COPY                            
                          </a>
                                                
             
              								</td>
                                        </tr>
                                   <?php $i++;} ?>  
                                    </tbody>
                                </table>
                                <input type="hidden" id="hidapiids" value="<?php echo $strids; ?>">
                                <input type="hidden" id="hidAPIurl" value="<?php echo base_url()."_Admin/api/getapibalance"; ?>">
                                <input type="hidden" id="hidCopyAPIurl" value="<?php echo base_url()."_Admin/api/copyapi"; ?>">
                                <input type="hidden" id="hiddashboardurl" value="<?php echo base_url()."_Admin/api"; ?>">
                                
                                <script>
                                 $(document).ready(function() 	
                                        { 	
                                           
                                        getuserbalance(); 		 	
                                        });	
                                      function getuserbalance() 
                                      { 		
                                          
                                          var struser = document.getElementById("hidapiids").value; 		
                                          var struserarr = struser.split(","); 		
                                          for(i=0;i<struserarr.length;i++) 		
                                          { 			
                                              var id = struserarr[i]; 			
                                              if(id > 0) 			
                                              { 			
                                                  $.ajax({ 			
                                                      url:document.getElementById("hidAPIurl").value+'?id='+id, 			
                                                      method:'POST', 			
                                                      cache:false, 			
                                                      success:function(html) 		
                                                        {	 				
                                                        var strbalarid = html.split("#"); 				
                                                        //alert(html + "0 = "+strbalarid[0]+"  1 = "+strbalarid[1]); 				
                                                        document.getElementById("spanbalance"+strbalarid[0]).innerHTML = strbalarid[1]+"  "+strbalarid[2];
                                                        } 			 			
                                                        }); 
                                                        
                                                } 			 		
                                            } 		 	
                                        }



                                        function copyapi(id) 
                                      {     
                                          
                                               var api_name = prompt("Enter NEW API Name");
                                                 $.ajax({      
                                                    url:document.getElementById("hidCopyAPIurl").value+'?id='+id+'&name='+api_name,       
                                                    method:'POST',      
                                                    cache:false,      
                                                    success:function(html)    
                                                      {         
                                                        window.setTimeout(function() 
                                                      {
                                                        window.location.href = document.getElementById("hiddashboardurl").value;
                                                      }, 1000);
                                                      }             
                                                      }); 
                                                      
                                                       
                                                 
                                        }

                                                                            
                                                                                            </script> 
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