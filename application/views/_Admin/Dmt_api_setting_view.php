<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>DMT API LIST</title>

    
     
    
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
          <span class="breadcrumb-item active">DMT API CONFIGURATION</span>
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
                <span class="tx-12 tx-uppercase"><a href="<?php echo base_url(); ?>_Admin/Dmt_api_setting" class="btn btn-primary btn-sm">Add Api</a></span>
              </div><!-- card-header -->
              <div class="card-body">
                <div class="card-body">
                <div id="activeapilist"></div>
              </div><!-- card-body -->
              <div class="card-body">
                <div id="deactiveapilist"></div>
              </div><!-- card-body -->
                                <script>
                                 $(document).ready(function() 	
                                        { 	
                                         getapilist();
                                        });	
         function getapilist()
        {
            document.getElementById("activeapilist").innerHTML = "";
      document.getElementById("deactiveapilist").innerHTML = "";
            $('#myOverlay').show();
        $('#loadingGIF').show();
          
          $.ajax({
            url:document.getElementById("hidgetapilisturl").value,
            cache:false,
            method:'POST',
            type:'POST',
            success:function(htmldata)
            {
              var resparray = htmldata.split("^-^");
              document.getElementById("activeapilist").innerHTML = resparray[0];
              document.getElementById("deactiveapilist").innerHTML = resparray[1];
              
            },
            error:function()
            {
              //document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
              //document.getElementById("responsespanfailure").style.display = 'block'
              //document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
            },
            complete:function()
            {
               $('#myOverlay').hide();
              $('#loadingGIF').hide();
              
            }
            });
        }
       
       
       
       
      function updateoperatorapi(id)
      {
        
           $('#myOverlay').show();
            $('#loadingGIF').show();
          
          
          
          if(document.getElementById("md_checkbox_"+id).checked)
          {
            var status = "1";
          }
          else
          {
            var status = "0";
          }
          var multi = "no";
          var reroot = "no";
          var series = "no";
          
        
        
          
          
          var ddlrerootapi = 0;
          
          
          var amtrange = 0;
          $.ajax({
            url:document.getElementById("hidbregvalurl").value,
            cache:false,
            data:{ "company_id":document.getElementById("hidcompany_id"+id).value , "api_id" :id,"status":status,"failurelimit":document.getElementById("txtFailureLimit"+id).value,"pendinglimit":document.getElementById("txtPendingLimit"+id).value,"priority":document.getElementById("txtPriority"+id).value,"multi":multi,"reroot":reroot,"reroot_api_id":ddlrerootapi,"series":series,"amtrange":amtrange} ,
            method:'POST',
            type:'POST',
            success:function(data)
            {
              
              document.getElementById("totalpending_"+id).innerHTML = data;
              
            },
            error:function()
            {
              //document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
              //document.getElementById("responsespanfailure").style.display = 'block'
              //document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
            },
            complete:function()
            {
               $('#myOverlay').hide();
              $('#loadingGIF').hide();
              getapilist();
            }
            });
        
      }
      function updateoperatorapi2(id)
      {
        
           $('#myOverlay').show();
            $('#loadingGIF').show();
          
          
          
        
        
          if(document.getElementById("md_checkbox_series_"+id).checked)
          {
            var series = "yes";
          }
          else
          {
            var series = "no";
          }
        
        
          
          
        
          $.ajax({
            url:document.getElementById("hidapienabledisable").value,
            cache:false,
            data:{ "company_id":document.getElementById("hidcompany_id"+id).value , "api_id" :id,"series":series} ,
            method:'POST',
            type:'POST',
            success:function(data)
            {
              
              //document.getElementById("totalpending_"+id).innerHTML = data;
              
            },
            error:function()
            {
              //document.getElementById("modalmptitle").innerHTML  = "Verification Request Failed";
              //document.getElementById("responsespanfailure").style.display = 'block'
              //document.getElementById("modelmp_failure_msg").innerHTML = "Internal Server Error. Please try Later..";
            },
            complete:function()
            {
               $('#myOverlay').hide();
              $('#loadingGIF').hide();
            //  document.getElementById("frmCallAction").submit();
            }
            });
        
      }

                                                                            
                                                                                            </script> 
              </div><!-- card-body -->
            </div>
            
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script type="text/javascript">

        function updatepriority(id)
        {
            var priority = document.getElementById("txtPriority"+id).value;
             $.ajax({
                url:'<?php echo base_url()."_Admin/Dmt_api_setting/setvalues?"; ?>field=priority&val='+priority+'&Id='+id,
                cache:false,
                method:'POST',
                success:function(html)
                {
                  getapilist();
                }
                }); 
        }

        function updatevalues(id)
        {
            if(document.getElementById("chkisapiactive"+id).checked == true)      
              {      
                $.ajax({
                url:'<?php echo base_url()."_Admin/Dmt_api_setting/setvalues?"; ?>field=is_active&val=yes&Id='+id,
                cache:false,
                method:'POST',
                success:function(html)
                {
                  getapilist();
                }
                }); 
              } 
              else
              {

                $.ajax({
                url:'<?php echo base_url()."_Admin/Dmt_api_setting/setvalues?"; ?>field=is_active&val=no&Id='+id,
                cache:false,
                method:'POST',
                success:function(html)
                {
                  getapilist();
                }
                }); 

              }
        }
      </script>
      
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->


    <input type="hidden" id="hidbregvalurl" value="<?php echo base_url()."_Admin/operatorapi"; ?>">
    <input type="hidden" id="hidapienabledisable" value="<?php echo base_url()."_Admin/operatorapi/apienabledisable"; ?>">
    <input type="hidden" id="hidgetapilisturl" value="<?php echo base_url()."_Admin/Dmt_api_setting/getapilist"; ?>">
   
      
      <div class="modal fade" id="myMessgeModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>-->
          <h4 class="modal-title" id="modalmptitle_BDEL">Response Message</h4>
          
        </div>
        <div class="modal-body">
        
          <div id="responsespansuccess_BDEL" style="display:none">
              <div class="divsmcontainer success">
                  <strong id="modelmp_success_msg_BDEL"></strong>
                </div>
          </div>
          <div id="responsespanfailure_BDEL" style="display:none">
              <div class="divsmcontainer success">
                  <strong id="modelmp_failure_msg_BDEL"></strong>
                </div>
          </div>
          
        </div>
        <div class="modal-footer">
         <span id="spanbtnclode"> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
        </div>
      </div>
    </div>
  </div>          


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