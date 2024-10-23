<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Retailer | Money Transfer 2</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
   <?php include("files/links.php"); ?>
   <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   <script type="text/javascript">
	  
	  $(document).ready(function(){setTimeout(function(){$('div.alert').fadeOut(1000);}, 15000); });
	  
	  
	  
        var specialKeys = new Array();
        specialKeys.push(8); //Backspace
        function IsNumeric(e) 
		{
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            return ret;
        }
    </script>
       <style>
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
</style>
    <style>
	.error
	{
  		background-color: #ffdddd;
	}
	</style>
    <style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;

    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
#myOverlay{position:absolute;height:100%;width:100%;}
#myOverlay{background:black;opacity:.7;z-index:2;display:none;}

#loadingGIF{position:absolute;top:40%;left:45%;z-index:3;display:none;}
</style>
<style>
.error
{
	background-color:#D9D9EC;
}
div.DialogMask
{
    padding: 10px;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 50;
    background-color: #606060;
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
    -moz-opacity: .5;
    opacity: .5;
}
</style>
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include("files/mdheader.php"); ?>
      
      <!-- Left side column. contains the logo and sidebar -->
       <?php include("files/mdsidebar.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h3 class="page-header">DMR : GET CUSTOMER INFO</h3>
         
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- /.row -->
          <div class="row">
            <!-- left column -->
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-xs-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                
  				<form action="<?php echo base_url()."Retailer/dmr_home?crypt=".$this->Common_methods->encrypt("MyData"); ?>" method="post" name="frmdmr" id="frmdmr">
            <table class="table table-bordered" style="width:500px;">
            <tr>
            	<td>
                	<input type="hidden" id="hidencrdata" name="hidencrdata" value="<?php echo $this->Common_methods->encrypt($this->session->userdata("session_id")); ?>">
                	<label>Customer Mobile:</label>
                    <input type="text" name="txtNumber" id="txtNumber"  class="form-control"  maxlength="10"  style="width:300px;" onKeyPress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;">
                </td>
                <td style="padding-top:30px;">
                	<label></label>
                  <input type="button" name="btnSearch" id="btnSearch" value="Search" class="btn btn-success" title="Click to search." onClick="validataandsubmit()" />
                </td>
            </tr>
            </table>
</form>
<script language="javascript">
	function validataandsubmit()
	{
			var mob = document.getElementById("txtNumber").value;
			if(mob.length == 10)
			{
					 $('#myOverlay').show();
    $('#loadingGIF').show();
					document.getElementById("frmdmr").submit();
			}
			else
			{
				alert("Please Enter 10 Digit Customer Mobile Number");
			}
	}
</script>
                                    
                 <div class="box-footer">
                   
                  </div>
              </div><!-- /.box -->
              <!-- general form elements disabled -->
              <!-- /.box -->
            </div><!--/.col (right) -->
          </div>
          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      

      <!-- Control Sidebar -->
      <!-- /.control-sidebar -->
     <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2020 Mpayonline
      </footer>
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class='control-sidebar-bg'></div>

    </div><!-- ./wrapper -->

  <?php include("files/adminfooter.php"); ?>
  </body>
</html>