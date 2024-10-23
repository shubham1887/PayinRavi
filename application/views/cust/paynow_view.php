<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Processing....</title>
<script language="javascript" src="<?php echo base_url()."js/jquery-1.4.4.js"; ?>" type="text/javascript"></script>
 <script>


 
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
     payuForm.submit();
    }
  </script>
  <style>
  body
  {
  margin:0;
  padding:0;
  }
  #mydiv {
  height:400px;
  position: relative;
  background-color: #a5c339; /* for demonstration */
}
.ajax-loader {
  position: absolute;
  left: 50%;
  top: 50%;
  margin-left: -32px; /* -1 * image width / 2 */
  margin-top: -32px; /* -1 * image height / 2 */
}
  </style>
  <script language="javascript">
   $('#mydiv').css("height", $(document).height());
  </script>
</head>

<body  onLoad="submitPayuForm()">
<div id="mydiv" style="height:800px;text-align: center;">
    <img src="<?php echo base_url()."images/ajax-loader.gif" ?>" class="ajax-loader"/>
</div>
<form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
     <input type="hidden"  name="amount" value="<?php echo $amount; ?>" />
      <input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname; ?>"/>
      <input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
      <input type="hidden" name="phone" value="<?php echo $phone; ?>" />
       <textarea style="display:none" name="productinfo"><?php echo $productinfo; ?></textarea>
       <input type="hidden" name="surl" value="<?php echo $surl; ?>" size="64" />
       <input type="hidden" name="furl" value="<?php echo $furl; ?>"  size="64" />
       <input type="hidden" type="hidden" name="service_provider" value="payu_paisa" size="64" />
       <input type="hidden" name="lastname" id="lastname"  />
       <input type="hidden" name="curl" value="" />
       <input type="hidden" name="address1" />
       <input type="hidden" name="address2"  />
       <input type="hidden" name="city"/>
       <input type="hidden" name="state" />
       <input type="hidden" name="country" />
       <input type="hidden" name="zipcode" />
       <input type="hidden" name="udf1" />
       <input type="hidden" name="udf2" />
       <input type="hidden" name="udf3" />
       <input type="hidden" name="udf4"  />
       <input type="hidden" name="udf5" />
       <input type="hidden" name="pg" />
      
    </form>
</body>
</html>
