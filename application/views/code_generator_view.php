
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>

<title></title>
<style>
body
{
	margin:0;
	padding:0;
}
.container
{
	margin:0 auto;
	padding:0;
	width:90%;
}
.header
{
	margin:0 auto;
	padding:0;
	background:#CDCEFC;
	text-align:center;
	text-decoration:none;
	height:80px;
}
h2
{
	padding:0;
	margin:0;
}
</style>
<style type="text/css">
     
		 table {  
    color: #333; /* Lighten up font color */
    font-family: Helvetica, Arial, sans-serif; /* Nicer font */

    border-collapse: 
    collapse; border-spacing: 0; 
}

td, th { border: 1px solid #CCC; height: 30px; } /* Make cells a bit taller */

th {  
    background: #F3F3F3; /* Light grey background */
    font-weight: bold; /* Make sure they're bold */
}

td {  
    background: #FAFAFA; /* Lighter grey background */
    text-align: center; /* Center our text */
}
      </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h2>Welcome To Code Generator</h2>
    </div>
	<?php echo form_open('code_generator',array('id'=>"frmCodeGen",'method'=>'post'))?>
												<input type="hidden" id="hidtoken" name="hidtoken" value="helleo">
												 <input type="hidden" name="tokendata" value="<?php echo $this->security->get_csrf_hash();?>" />
    <table>
    <tr>
    	<td>
            <table border="">
                <tr>
                    <td>PageName :</td>
                    <td><input type="text" value="<?php echo $this->session->userdata("txtPageName"); ?>" id="txtPageName" name="txtPageName"></td>
                </tr>
                <tr>
                    <td>Page Title</td>
                    <td><input type="text" id="txtPageTitle" name="txtPageTitle" value="<?php echo $this->session->userdata("txtPageTitle"); ?>"></td>
                </tr>
        </table>
        </td>
        <td>
        	<table border="">
                <tr>
                    <td>Page For :</td>
                    <td>
                    	<select id="ddlPageFor" name="ddlPageFor">
                        	<option value="Admin">Admin</option>
                            <option value="Retailer">Retailer</option>
                            <option value="Distributor">Distributor</option>
                            <option value="MasterDealer">MasterDealer</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Table Name</td>
                    <td><input type="text" id="txtTableName" name="txtTableName" value="<?php echo $this->session->userdata("txtTableName"); ?>"></td>
                </tr>
        </table>
        </td>
        <td>
        	<table border="">
                <tr>
                    <td>Page Type :</td>
                    <td>
                    	<select id="ddlPageType" name="ddlPageType">
                        	<option value="MasterEntry">MasterEntry</option>
                            <option value="Report">Report</option>
                            <option value="RegForm">Registration Form</option>
                        </select>
                    </td>
                </tr>
                <tr>
                   
                </tr>
        </table>
        </td>
        
        <td>
        
        </td>
    </tr>
    
    </table>
    
    <br>
    
    
    <br><br>
    
    <table border="">
                <tr>
                                    <td>Parameter</td>
                                    <td>Parameter Name</td>
                                    <td>Type</td>
                                    <td>Database Field</td>
                                    
                                    <td>check exist</td>
                                    <td>Ref Table Name</td>
                                    <td>Ref Table Id</td>
                                    <td>Ref Table Value</td>
                                </tr>
                <tr>
                    <td>Parameter 1:</td>
                    <td>
                    	<input type="text" id="txtParam1" name="txtParam1" value="<?php echo $this->session->userdata("txtParam1"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type1" name="ddlparameter_type1" onChange="ddlparameter_type_change(1)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        
                        <input type="text" id="txtddlvalues1" name="txtddlvalues1" value="<?php echo $this->session->userdata("txtddlvalues1"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName1" name="txtFieldName1" value="<?php echo $this->session->userdata("txtFieldName1"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield1" name="chkfield1" value="<?php echo $this->session->userdata("chkfield1"); ?>">
                    </td>
                    
                     <td>
                    	<input type="text" id="txtTblRef1" name="txtTblRef1" value="<?php echo $this->session->userdata("txtTblRef1"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id1" name="txtTblRef_Id1" value="<?php echo $this->session->userdata("txtTblRef_Id1"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name1" name="txtTblRef_Name1" value="<?php echo $this->session->userdata("txtTblRef_Name1"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 2:</td>
                    <td>
                    	<input type="text" id="txtParam2" name="txtParam2" value="<?php echo $this->session->userdata("txtParam2"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type2" name="ddlparameter_type2" onChange="ddlparameter_type_change(2)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues2" name="txtddlvalues2" value="<?php echo $this->session->userdata("txtddlvalues2"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName2" name="txtFieldName2" value="<?php echo $this->session->userdata("txtFieldName2"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield2" name="chkfield2" value="<?php echo $this->session->userdata("chkfield2"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef2" name="txtTblRef2" value="<?php echo $this->session->userdata("txtTblRef2"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id2" name="txtTblRef_Id2" value="<?php echo $this->session->userdata("txtTblRef_Id2"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name2" name="txtTblRef_Name2" value="<?php echo $this->session->userdata("txtTblRef_Name2"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 3:</td>
                    <td>
                    	<input type="text" id="txtParam3" name="txtParam3" value="<?php echo $this->session->userdata("txtParam3"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type3" name="ddlparameter_type3" onChange="ddlparameter_type_change(3)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues3" name="txtddlvalues3" value="<?php echo $this->session->userdata("txtddlvalues3"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName3" name="txtFieldName3" value="<?php echo $this->session->userdata("txtFieldName3"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield3" name="chkfield3" value="<?php echo $this->session->userdata("chkfield3"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef3" name="txtTblRef3" value="<?php echo $this->session->userdata("txtTblRef3"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id3" name="txtTblRef_Id3" value="<?php echo $this->session->userdata("txtTblRef_Id3"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name3" name="txtTblRef_Name3" value="<?php echo $this->session->userdata("txtTblRef_Name3"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 4:</td>
                    <td>
                    	<input type="text" id="txtParam4" name="txtParam4" value="<?php echo $this->session->userdata("txtParam4"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type4" name="ddlparameter_type4" onChange="ddlparameter_type_change(4)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues4" name="txtddlvalues4" value="<?php echo $this->session->userdata("txtddlvalues4"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName4" name="txtFieldName4" value="<?php echo $this->session->userdata("txtFieldName4"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield4" name="chkfield4" value="<?php echo $this->session->userdata("chkfield4"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef4" name="txtTblRef4" value="<?php echo $this->session->userdata("txtTblRef4"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id4" name="txtTblRef_Id4" value="<?php echo $this->session->userdata("txtTblRef_Id4"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name4" name="txtTblRef_Name4" value="<?php echo $this->session->userdata("txtTblRef_Name4"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 5:</td>
                    <td>
                    	<input type="text" id="txtParam5" name="txtParam5" value="<?php echo $this->session->userdata("txtParam5"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type5" name="ddlparameter_type5" onChange="ddlparameter_type_change(5)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues5" name="txtddlvalues5" value="<?php echo $this->session->userdata("txtddlvalues5"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName5" name="txtFieldName5" value="<?php echo $this->session->userdata("txtFieldName5"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield5" name="chkfield5" value="<?php echo $this->session->userdata("chkfield5"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef5" name="txtTblRef5" value="<?php echo $this->session->userdata("txtTblRef5"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id5" name="txtTblRef_Id5" value="<?php echo $this->session->userdata("txtTblRef_Id5"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name5" name="txtTblRef_Name5" value="<?php echo $this->session->userdata("txtTblRef_Name5"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 6:</td>
                    <td>
                    	<input type="text" id="txtParam6" name="txtParam6" value="<?php echo $this->session->userdata("txtParam6"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type6" name="ddlparameter_type6" onChange="ddlparameter_type_change(6)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues6" name="txtddlvalues6" value="<?php echo $this->session->userdata("txtddlvalues6"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName6" name="txtFieldName6" value="<?php echo $this->session->userdata("txtFieldName6"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield6" name="chkfield6" value="<?php echo $this->session->userdata("chkfield6"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef6" name="txtTblRef6" value="<?php echo $this->session->userdata("txtTblRef6"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id6" name="txtTblRef_Id6" value="<?php echo $this->session->userdata("txtTblRef_Id6"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name6" name="txtTblRef_Name6" value="<?php echo $this->session->userdata("txtTblRef_Name6"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 7:</td>
                    <td>
                    	<input type="text" id="txtParam7" name="txtParam7" value="<?php echo $this->session->userdata("txtParam7"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type7" name="ddlparameter_type7" onChange="ddlparameter_type_change(7)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues7" name="txtddlvalues7" value="<?php echo $this->session->userdata("txtddlvalues7"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName7" name="txtFieldName7" value="<?php echo $this->session->userdata("txtFieldName7"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield7" name="chkfield7" value="<?php echo $this->session->userdata("chkfield7"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef7" name="txtTblRef7" value="<?php echo $this->session->userdata("txtTblRef7"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id7" name="txtTblRef_Id7" value="<?php echo $this->session->userdata("txtTblRef_Id7"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name7" name="txtTblRef_Name7" value="<?php echo $this->session->userdata("txtTblRef_Name7"); ?>">
                    </td>
                </tr>
                <tr>
                    <td>Parameter 8:</td>
                    <td>
                    	<input type="text" id="txtParam8" name="txtParam8" value="<?php echo $this->session->userdata("txtParam8"); ?>">
                    </td>
                    <td>
                    	<select id="ddlparameter_type8" name="ddlparameter_type8" onChange="ddlparameter_type_change(8)">
                        	<option value="text">text</option>
                            <option value="select">select</option>
                            <option value="select_static">select_static</option>
                            <option value="button">button</option>
                            <option value="img">img</option>
                        </select>
                        <input type="text" id="txtddlvalues8" name="txtddlvalues8" value="<?php echo $this->session->userdata("txtddlvalues8"); ?>" style="display:none">
                    </td>
                    <td>
                    	<input type="text" id="txtFieldName8" name="txtFieldName8" value="<?php echo $this->session->userdata("txtFieldName8"); ?>">
                    </td>
                    <td>
                    	<input type="checkbox" id="chkfield8" name="chkfield8" value="<?php echo $this->session->userdata("chkfield8"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef8" name="txtTblRef8" value="<?php echo $this->session->userdata("txtTblRef8"); ?>">
                    </td>
                    <td>
                    	<input type="text" id="txtTblRef_Id8" name="txtTblRef_Id8" value="<?php echo $this->session->userdata("txtTblRef_Id8"); ?>">
                    </td>
                     <td>
                    	<input type="text" id="txtTblRef_Name8" name="txtTblRef_Name8" value="<?php echo $this->session->userdata("txtTblRef_Name8"); ?>">
                    </td>
                </tr>
                
        </table>
    
    <table style="width:400px;margin:0 auto;">
        <tr>
    <td><input style="width:200px;" type="button" id="btnGenerate" name="btnGenerate" value="Fire" onClick="submitaftervalidate()"></td>
    </tr>
    </table>
    
    <?php echo form_close();?>
    <script language="javascript">
	function submitaftervalidate()
	{
		document.getElementById("frmCodeGen").submit()
	}
	function ddlparameter_type_change(id)
	{
		var ddlparameter_type = document.getElementById("ddlparameter_type"+id).value;
		if(ddlparameter_type == "select_static")
		{
			document.getElementById("txtddlvalues"+id).style.display = "block";
		}
		else
		{
		document.getElementById("txtddlvalues"+id).style.display = "none";
		}
	}
	</script>
    
	</div>    
</body>
</html>
