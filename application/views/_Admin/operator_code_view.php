<!DOCTYPE html>
<html lang="en">
  <head>
    

    <title>Operacor Code Settings</title>

    
     
    
    <?php include("elements/linksheader.php"); ?>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    
    

    <script language="javascript">
        function getData()
        {
        if(document.getElementById("ddlapi").value != 0)
        {
                $.ajax({
                url:'<?php echo base_url(); ?>_Admin/operator_code/getresult?api_id='+document.getElementById("ddlapi").value,
                method:'POST',
                cache:false,
                success:function(msg)
                {
                    document.getElementById("ajxdata").style.display = "block";
                    document.getElementById("ajaxload").style.display = "none";
                    document.getElementById("ajxdata").innerHTML = msg;
                }
            
            
            });
        }
        else
        {
            document.getElementById("ajxdata").innerHTML = "";
        }
        }
        function changeapi(i)
        {
            var apiid= document.getElementById("ddlapi"+i).value;
            var groupid= document.getElementById("uid").value;
            $.ajax({
                url: '<?php echo base_url(); ?>_Admin/groupapi/changeapi?company_id='+i+'&api_id='+apiid+'&group_id='+groupid,
                  type: 'POST',
                  success:function(html)
                  {
                    getData();
                  },
                  complate:function(msg)
                  {
                    getData();
                  }
                });
        
        }
        function changecommission(id)
        {
        var code = document.getElementById("txtCode"+id).value;
        document.getElementById("ajaxprocess").style.display = "block";
        
        if(code.length >= 1)
        {
        
        $.ajax({
  url: '<?php echo base_url(); ?>_Admin/operator_code/changecode?api_id='+document.getElementById("ddlapi").value+'&code='+document.getElementById("txtCode"+id).value+'&company_id='+id,
  type: 'POST',
  success:function(html)
  {
    document.getElementById("ajaxprocess").style.display = "none";
    
    getData();
  },
  complate:function(msg)
  {
    document.getElementById("ajaxprocess").style.display = "none";
    getData();
  }
});
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
          <a class="breadcrumb-item" href="#">DEVELOPER OPTIONS</a>
          <span class="breadcrumb-item active">OPERATOR CODE</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>OPERATOR CODE</h4>
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
                <div id="ajaxprocess" style="display:none">
                  <img src="<?php echo base_url(); ?>ajax-loader_bert.gif">
                  </div> 


                  <form method="post"  name="frmscheme_view" id="frmscheme_view" autocomplete="off">
<div class="breadcrumb" style="padding:20px;">
<table>
<tr>
<td>
<table cellpadding="3" cellspacing="3" border="0">
    <tr>
<td align="right"><label for="txtGroupName" style="font-size:20px;"><span style="color:#F06">*</span>Select Api:</label></td><td align="left">
<select id="ddlapi" name="ddlapi" onChange="getData()" style="font-size:20px;width:200px;height:40px;">
 <option value="0">Select</option>
<?php
    $group_rslt = $this->db->query("select * from tblapi order by api_name ");
    foreach($group_rslt->result() as $row)
    {
 ?>
 <option value="<?php echo $row->api_id; ?>"><?php echo $row->api_name; ?></option>
 <?php } ?>
</select>
</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
<input type="hidden" id="hidID" name="hidID" />
</form>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
        <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">OPERATOR CODE LIST</h6>
                <span class="tx-12 tx-uppercase"></span>
              </div><!-- card-header -->
              <div class="card-body">
               <div class="table-responsive">
                                    <div id="ajxdata">
</div>
                                <div id="ajaxload" style="display:none;">
    <img src="<?php echo base_url()."ajax-loader.gif"?>">
</div>
                                </div>
              </div><!-- card-body -->
            </div>
             
        </div>
        </div>
      </div><!-- br-pagebody -->
      <script language="javascript">
    function changestatus(val1,id)
    {
        
                $.ajax({
                url:'<?php echo base_url()."_Admin/account_report/setvalues?"; ?>Id='+id+'&field=payment_type&val='+val1,
                cache:false,
                method:'POST',
                success:function(html)
                {
                    if(html == "cash")
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'credit\',\''+id+'\')">'+html+'</a>     ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    else
                    {
                        var str = '<a  href="javascript:void(0)" onClick="changestatus(\'cash\',\''+id+'\')">'+html+'</a>   ';
                        document.getElementById("ptype"+id).innerHTML = str;        
                    }
                    
                }
                }); 
            
        
    }
</script>
<form id="frmexport" name="frmexport" action="<?php echo base_url()."_Admin/account_report/dataexport" ?>" method="get">
                                    <input type="hidden" id="hidfrm" name="from">
                                    <input type="hidden" id="hidto" name="to">
                                    <input type="hidden" id="hiddb" name="db">
                                    
                                    </form>
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
