<!DOCTYPE html>
<html lang="en">
    <head>
       <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-clearmin.min.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/roboto.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/material-design.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/small-n-flat.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/font-awesome.min.css">
        <title>SBI UPLOAD</title>
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
    
        <script language="javascript">
		$('document').ready(function(){
		  $('#li_Uploads').addClass("pre-open");
		 });
		 </script>
    </head>
    <body class="cm-no-transition cm-2-navbar">
        
        
        <div id="global">
	        <div class="container-fluid">
               <div class="panel panel-default">
                            <div class="panel-heading">SBI File Upload</div>
                            <div class="panel-body">
                            <form action="<?php echo base_url()."royal1718/SbiUpload" ?>" method="post" name="frmCallAction" id="frmCallAction" enctype="multipart/form-data">
                         
                                    <table cellspacing="10" cellpadding="3">
                                    <tr>
                                    	<td style="padding-right:10px;">
                                        	 <label>Select File</label>
											
                                        <input type="file" name="file" size="20" />
                                        </td>
                                        

                                        <td valign="bottom">
                                        <input type="submit" id="btnSubmit" name="btnSubmit" value="upload" class="btn btn-primary">

                                        </td>
                                    </tr>
                                    </table>
                                        
                                       
                                       
                                    </form>
                                
                            </div>
                        </div>
            </div>
            <div class="container-fluid">
               <div class="panel panel-default">
                            <div class="panel-heading">Table Data</div>
                            <div class="panel-body">
                            <?php 
							if(isset($data))
							{
								echo $data;
							}
							
							 ?>
                                
                            </div>
                        </div>
                         <?php 
						
							if(isset($dataarray))
							{
								
							}
							else
							{
								$dataarray = "";
							}
						?>
                        <form id="frminsertdata" method="post" action="">
                        <input type="hidden" id="hiddata" name="hiddata" value="<?php echo $dataarray;  ?>">
                        <input type="hidden" id="hidaction" name="hidaction" >
                        <input type="button" id="btnsubmitinsert" value="Insert Data" onClick="validateandsubmitinsert()"> 
                        </form>
                        <script language="javascript">
							function validateandsubmitinsert()
							{
								document.getElementById("hidaction").value = "INSERTDATA";
								document.getElementById("frminsertdata").submit();
							}
						</script>
                     
            </div>
            
            
            <footer class="cm-footer"><span class="pull-left">Connected as John Smith</span><span class="pull-right">&copy; PAOMEDIA SARL</span></footer>
        </div>
       <script src="../assets/js/lib/jquery-2.1.3.min.js"></script>
        <script src="../assets/js/jquery.mousewheel.min.js"></script>
        <script src="../assets/js/jquery.cookie.min.js"></script>
        <script src="../assets/js/fastclick.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/clearmin.min.js"></script>
    </body>
</html>