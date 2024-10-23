<style>
.alert {
    padding: 20px;
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
<?php 

//print_r($this->session->flashdata("MESSAGEBOXTYPE"));exit;
$flash_MESSAGEBOXTYPE = $this->session->flashdata("MESSAGEBOXTYPE");
$flash_MESSAGEBOX = $this->session->flashdata("MESSAGEBOX");

//echo $flash_MESSAGEBOXTYPE."<<<<>>>>".$flash_MESSAGEBOX."<<<<";exit;
//SUCCESS<<<<>>>>Account Registration Successful<<<<
//var_dump($flash_MESSAGEBOXTYPE != "" and $flash_MESSAGEBOX != "");exit;
if(strlen($flash_MESSAGEBOXTYPE) > 2)
	  {
if($flash_MESSAGEBOXTYPE == "SUCCESS")
{?>
<div class="alert alert-solid alert-success" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<strong class="d-block d-sm-inline-block-force">Well done!</strong> <?php echo $flash_MESSAGEBOX; ?>
</div>

<?php 
}
else
{?>
<div class="alert alert-<?php echo $flash_MESSAGEBOXTYPE; ?>">
<button data-dismiss="alert" class="close">×</button>
<strong></strong>
<?php echo $flash_MESSAGEBOX; ?>
</div>
<?php }
?>






<?php  }  
else if(isset($MESSAGEBOXTYPE) and isset($MESSAGEBOX))
	  { ?>



<div class="alert alert-<?php echo $MESSAGEBOXTYPE; ?>">
<button data-dismiss="alert" class="close">×</button>
<strong></strong>
<?php echo $MESSAGEBOX; ?>
</div>

<?php  }


else if(isset($MESSAGEBOX_MESSAGETYPE))
{
	 if($MESSAGEBOX_MESSAGETYPE == "FAILURE" and isset($MESSAGEBOX_MESSAGEBODY))
	{ ?>
	<div class="alert">
	  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
	  <strong><?php echo $MESSAGEBOX_MESSAGEBODY; ?></strong> 
	</div>
	<?PHP } 

else if($MESSAGEBOX_MESSAGETYPE == "SUCCESS" and isset($MESSAGEBOX_MESSAGEBODY))
{ ?>
<div class="alert success">
  <span class="closebtn">&times;</span>  
  <strong><?php echo $MESSAGEBOX_MESSAGEBODY; ?></strong>
</div>
<?PHP } 
}
else if($this->session->flashdata("MESSAGEBOX_MESSAGETYPE") == "FAILURE" and $this->session->flashdata("MESSAGEBOX_MESSAGEBODY") != "")
{ ?>
<div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $this->session->flashdata("MESSAGEBOX_MESSAGEBODY"); ?></strong> 
</div>
<?php } 
else if($this->session->flashdata("MESSAGEBOX_MESSAGETYPE") == "SUCCESS" and $this->session->flashdata("MESSAGEBOX_MESSAGEBODY") != "")
{?>
<div class="alert success">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php echo $this->session->flashdata("MESSAGEBOX_MESSAGEBODY"); ?></strong>
</div>
<?php } ?>

