<!DOCTYPE html>

<html lang="en">

  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>Revert Balance</title>
<?php include("elements/linksheader.php"); ?>
<style>
    .pretty-table
{
  padding: 0;
  margin: 0;
  border-collapse: collapse;
  border: 1px solid #333;
  font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
  font-size: 0.9em;
  background: #bcd0e4 url("widget-table-bg.jpg") top left repeat-x;
}

.pretty-table caption
{
  caption-side: bottom;
  font-size: 0.9em;
  font-style: italic;
  text-align: right;
  padding: 0.5em 0;
}

.pretty-table th, .pretty-table td
{
  border: 1px dotted #666;
  padding: 0.5em;
  text-align: left;
  color: #632a39;
}

.pretty-table th[scope=col]
{
  
  background-color: #8fadcc;
  text-transform: uppercase;
  font-size: 0.9em;
  border-bottom: 2px solid #333;
  border-right: 2px solid #333;
}

.pretty-table th+th[scope=col]
{
  
  background-color: #7d98b3;
  border-right: 1px dotted #666;
}

.pretty-table th[scope=row]
{
  background-color: #b8cfe5;
  border-right: 2px solid #333;
}

.pretty-table tr.alt th, .pretty-table tr.alt td
{
  color: #2a4763;
}

.pretty-table tr:hover th[scope=row], .pretty-table tr:hover td
{
  //background-color: #632a2a;
}
.error
{
    background-color: #63Fa2a;
}
</style>
<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>

 <link href="http://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

      <script src="http://code.jquery.com/jquery-1.10.2.js"></script>

      <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>


  </head> 



  <body>
<input type="hidden" id="hidautocompletevalues" value="<?php echo $userdata; ?>">
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

          <a class="breadcrumb-item" href="#"></a>

          <span class="breadcrumb-item active">Revert Balance</span>

        </nav>

      </div><!-- br-pageheader -->

      <div class="br-pagetitle">

        <div>

          <h4>Revert Balance</h4>

        </div>

      </div><!-- d-flex -->



      <div class="br-pagebody">

      	<div class="row row-sm mg-t-20">

          <div class="col-sm-6 col-lg-12">
              <?php include("elements/messagebox.php"); ?>

            <div class="card shadow-base bd-0">

              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">

                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Revert Balance</h6>

                <span class="tx-12 tx-uppercase"></span>

              </div><!-- card-header -->

              <div class="card-body">



                   <?php
	if ($message != ''){echo "<div class='message'>".$message."</div>"; }
	
	?>    
    <fieldset>
        <input type="hidden" id="hidgetautocompletedata" value="<?php echo base_url()."_Admin/RevertMainBalance/getUserForAutocompleteTextBox"; ?>">
    <form id="frmaddbal" name="frmaddbal" method="post" action="<?php echo base_url()."_Admin/RevertMainBalance?crypt=".$this->Common_methods->encrypt("MyData"); ?>" autocomplete="off" data-parsley-validate>
                	  <input type="hidden" id="hidid" name="hidid">
					
                	  <table class="pretty-table">
                                    <tr>
                                        <td style="padding-right:10px;" align="right">Flat Commission :</td>
                                        <td>
                                           	<input type="checkbox" id="chkflatcomm" name="chkflatcomm" value="yes" class="checkbox">
                                        </td>
                                        </tr>
                                        <tr>
                                    	<td style="padding-right:10px;" align="right">Mobile Number :</td>
                                        <td>
                                           	<div class="autocomplete" style="width:400px;">
                                                <input id="myInput" type="text" name="txtAgentMobile" >
                                            </div><br>
                                            <span id="err_mobile" style="color:#F00"></span>
                                            
                                        </td>
                                        <script language="javascript">
                                            function getAjaxData()
                                            {
                                               var startword = document.getElementById("myInput").value;
                                               $.ajax({
                                    					type:"POST",
                                    					url:document.getElementById("hidgetautocompletedata").value,
                                    					data:{'inputdata':startword},
                                    					beforeSend: function() 
                                    					{
                                    					   //document.getElementById("popupalertdiv").style.display="none";
                                            //               document.getElementById("spanloader").style.display="block";
                                                        },
                                    					success: function(response)
                                    					{
                                    					    //document.getElementById("hidautocompletevalues").value = response;
                                    					    
                                    						//console.log(response);  
                                    					},
                                    					error:function(response)
                                    					{
                                    					    
                                    					},
                                    					complete:function()
                                    					{
                                    					   
                                    					   // autocomplete(document.getElementById("myInput"), countries);
                                    						//autocomplete(document.getElementById("myInput"), document.getElementById("hidautocompletevalues").value.split("@@"));
                                    					}
                                    				}); 
                                               
                                            }
                                        </script>
                                     </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Name
                                        </td>
                                        <td>
                                            <b><span id="spanAgentBane"></span></b>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 UserType
                                        </td>
                                        <td>
                                            <b><span id="spanAgentType"></span></b>
                                        </td>
                                      </tr>
                                       <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Current Balance
                                        </td>
                                        <td>
                                            <b><span id="spanCurrentBalance"></span></b>
                                        </td>
                                      </tr>
                                     <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Amount
                                        </td>
                                        <td>
                                            <input type="text" id="txtAmount" name="txtAmount"  class="text" onfocusout="validateamount()" >
                                            <span id="err_amount" style="color:#F00"></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	Received Amount</td>
                                        	 <td>
                                            <input type="text" id="txtReceivedAmount" name="txtReceivedAmount"  class="text" >
                                            
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right" >
                                        	Payment Type
                                        </td>
                                        <td>
                                            <select id="ddlpaymentType" name="ddlpaymentType" class="form-control text" style="width:400px;">
                                                <option value=""></option>
                                                <option value="Credit">Credit</option>
                                                <option value="Cash">Cash</option>
                                            </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td style="padding-right:10px;"  align="right">
                                        	 Remark</td>
                                        	 <td>
                                            <input type="text" id="txtRemark" name="txtRemark"  class="text" onfocusout="validateremark()" >
                                            <span id="err_remark" style="color:#F00"></span>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                        	 <td> 
                                        	<input type="button" id="btnSubmit" name="btnSubmit" class="btn btn-success btn-xs" value="Submit" onClick="validateandsubmit()">
                                        </td>
                                     
                                    </tr>
                                    </table>
                </form>
                <script language="javascript">
				function validateandsubmit()
				{
					if(validatemobile() & validateamount() & validateremark())
					{
						document.getElementById("frmaddbal").submit();
					}
				}
				function validatemobile()
				{
				    var mob = document.getElementById("myInput").value;
					if(mob == "")
					{
						$("#myInput").addClass("error");
						$("#err_mobile").html("Please Enter Mobile Number");
						
						return false;
					}
					else
					{
					    if(mob.length == 10)
					    {
					        $("#myInput").removeClass("error");
    						$("#err_mobile").html("");
    						return true;
					    }
					    else
					    {
					        $("#myInput").addClass("error");
    						$("#err_mobile").html("Invalid Mobile Number");
    						return false;
					    }
					
					}
				}
				function validateamount()
				{
					var amt = document.getElementById("txtAmount").value;
					if(amt == "")
					{
						$("#txtAmount").addClass("error");
						$("#err_amount").html("Please Enter Amount");
						
						return false;
					}
					else
					{
						$("#txtAmount").removeClass("error");
						$("#err_amount").html("");
						return true;
					}
				}
				function validateremark()
				{
					var remark = document.getElementById("txtRemark").value;
					if(remark == "")
					{
						$("#txtRemark").addClass("error");
						$("#err_remark").html("Please Enter Remark");
						return false;
					}
					else
					{
						$("#txtRemark").removeClass("error");
						$("#err_remark").html("");
						return true;
					}
				}
				</script>
        </fieldset>
        <?php 
        ?>   


              </div><!-- card-body -->

            </div><!-- card -->

          </div><!-- col-4 -->

        </div>

      

      

      </div><!-- br-pagebody -->

      

      <?php include("elements/footer.php"); ?>

    </div><!-- br-mainpanel -->

    <!-- ########## END: MAIN PANEL ########## -->




<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
          
          
          
        /*check if the item starts with the same letters as the text field value:*/
        //if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) 
        if(arr[i].toUpperCase().includes(val.toUpperCase()))
        {
            
            
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value.split(" - ")[1];
              document.getElementById("spanAgentBane").innerHTML  = this.getElementsByTagName("input")[0].value.split(" - ")[0];
              document.getElementById("spanAgentType").innerHTML  = this.getElementsByTagName("input")[0].value.split(" - ")[2];
              document.getElementById("spanCurrentBalance").innerHTML  = this.getElementsByTagName("input")[0].value.split(" - ")[3];
             
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
        //mobile number check
        if (arr[i].split(" - ")[1].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value.split(" - ")[1];
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) 
  {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) 
      {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } 
      else if (e.keyCode == 38) 
      { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } 
      else if (e.keyCode == 13) 
      {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = ["iNDIA@GUJARAT@AHMEDABAD",""];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), document.getElementById("hidautocompletevalues").value.split("@@"));
</script>
 <script src="<?php echo base_url();?>lib/jquery/jquery.min.js"></script>

    <script src="<?php echo base_url();?>lib/jquery-ui/ui/widgets/datepicker.js"></script>

    <script src="<?php echo base_url();?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo base_url();?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="<?php echo base_url();?>lib/moment/min/moment.min.js"></script>

    <script src="<?php echo base_url();?>lib/peity/jquery.peity.min.js"></script>

    <script src="<?php echo base_url();?>lib/highlightjs/highlight.pack.min.js"></script>
    <script src="<?php echo base_url();?>lib/parsleyjs/parsley.min.js"></script>


    <script src="<?php echo base_url();?>js/bracket.js"></script>
   
  </body>

</html>

