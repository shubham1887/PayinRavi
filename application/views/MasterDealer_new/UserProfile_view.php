
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->white->getName() ?>:Providing Financial Services To Every Corner Of India | DMT</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!--Favicon-->
    <link href="<?php echo base_url(); ?>assets2/images/Favicon/favicon502.png" rel="icon" />
    <!--Favicon End-->
    <script src="<?php echo base_url(); ?>mpayfiles/jquery.min.js"></script>
    <link href="<?php echo base_url(); ?>mpayfiles/RG-DEv.css" rel="stylesheet" />
    <!--sweet alert-->
    <script src="<?php echo base_url(); ?>js/Sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url(); ?>js/Sweetalert/sweetalert.css" rel="stylesheet" />
    <!--sweet alert End-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!--Font Style-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <!--Font Style End-->
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--Font Awesome End-->
    <!-- Page plugins -->
    <link href="<?php echo base_url(); ?>mpayfiles/argon.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>mpayfiles/Main1.css" rel="stylesheet" />
    <!--Color theme style-->
    <link href="<?php echo base_url(); ?>mpayfiles/Theme.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.5.95/css/materialdesignicons.min.css">
</head>
<body>
    
    <!--sweet alert start-->


   <?php include("elements/mdsidebar.php"); ?>
    <!-- Sidenav -->
   
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
         <?php include("elements/mdheader.php"); ?>
        <!-- Header -->
        
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-3">
                <div class="col-lg-4 col-9">
                    <nav aria-label="breadcrumb" class="d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Profile</a></li>
                        </ol>
                    </nav>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-md-3 col-12">
            <div class="card" style="min-height:initial;">
                <form action="/Myaccounts/UserProfileUpload" method="post" enctype="multipart/form-data">
                    <input name="__RequestVerificationToken" type="hidden" value="Osc8LijxsXMf94mzAzf2AA5WVHyUmp-MrKfMVeZ6zzby_pEiDl_MOV2ZZf3NQ105GIhKTEkwyDvcg55CqD-4x9PtH36JkvdwVx6QKj27B4o1" />
                    <div class="card-body text-center pd-t-10">
                        
                        <div class="editable-on-click" style="display:block; position:relative">
                            <input type="file" style="display:none" class="fileUpload" name="profileImage" required="">
                            <img class="img-fluid" style="height:65px;border-radius:50%;margin-bottom:10px;" />
                        </div>
                        <h5></h5>
                    </div>
                    <input type="submit" class="btn btn-primary small" style="padding:0px;" value="Upload" />
                </form>
            </div>
            <div class="card mg-t-20" style="min-height:initial;">
                <div class="card-body pd-xs-10">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-6 pd-0 pd-5">
                            <?php
                                if(isset($userdocs["AADHAR_FRONT"]))
                                {?>
                                <img src="<?php echo base_url().$userdocs["AADHAR_FRONT"]; ?>" class="img-fluid" style="height: 110px;" />
                                <?php }
                             ?>
                           
                        </div>
                        <div class="col-md-6 pd-0 col-lg-6 col-6 pd-5 b-l">
                            <?php
                                if(isset($userdocs["AADHAR_BACK"]))
                                {?>
                                <img src="<?php echo base_url().$userdocs["AADHAR_BACK"]; ?>" style="height: 110px;" />
                                <?php }
                             ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mg-t-20" style="min-height:initial;">
                <div class="card-body pd-5 pd-xs-10">
                    <div class="row">
                        <div class="col-md-6 col-lg-12 text-center">
                            <?php
                                if(isset($userdocs["PANCARD"]))
                                {?>
                                    <img src="<?php echo base_url().$userdocs["PANCARD"]; ?>" class="img-fluid" style="height: 150px;" />
                                <?php }

                             ?>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-content">
                    <div class="card-body pd-xs-10">

<form action="<?php echo base_url(); ?>MasterDealer_new/UserProfile" method="post"><input name="__RequestVerificationToken" type="hidden" value="_InD7fTISQpE9nYTkn5UtfiIk5dtYc1b7ZU5OuxqFkvru9IUKhEbfYhikd6QCm_60i80eLKpRg-Bv_y8e919S7ezkqnbylZ8soaGHCkIPCc1" /><input data-val="true" data-val-number="The field RefrenceNumber must be a number." data-val-required="The RefrenceNumber field is required." id="RefrenceNumber" name="RefrenceNumber" type="hidden" value="2185" /><input data-val="true" data-val-number="The field WhiteUser must be a number." data-val-required="The WhiteUser field is required." id="WhiteUser" name="WhiteUser" type="hidden" value="5" />                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label> First Name </label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field FirstName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Valid characters: Alphabets and min 3." data-val-regex-pattern="[a-zA-Z]{3,30}$" data-val-required="First Name is required." id="FirstName" name="FirstName" placeholder="Enter First Name" required="" type="text" value="<?php echo $userdata->row(0)->businessname ?>" />
                                            <i class="icon fa fa-user"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="FirstName" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field MiddleName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Valid characters: Alphabets and min 3." data-val-regex-pattern="[a-zA-Z]{3,30}$" id="MiddleName" name="MiddleName" placeholder="Enter Middle Name" required="" type="text" value="" />
                                            <i class="icon fa fa-user"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="MiddleName" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label> Last Name</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field LastName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Valid characters: Alphabets and min 3." data-val-regex-pattern="[a-zA-Z]{3,30}$" data-val-required="Last Name is required." id="LastName" name="LastName" placeholder="Enter Last Name" required="" type="text" value="" />
                                            <i class="icon fa fa-user"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="LastName" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>PAN Number</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-regex="Invalid pancard format." data-val-regex-pattern="[A-Z]{5}\d{4}[A-Z]{1}" data-val-required="Pancard is required." id="PanCardNo" name="PanCardNo" placeholder="Enter pancard" required="" type="text" value="<?php echo $userdata->row(0)->pan_no; ?>" />
                                            <i class="icon fa fa-credit-card"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="PanCardNo" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field ContactNo must be a string or array type with a maximum length of &#39;10&#39;." data-val-maxlength-max="10" data-val-regex="Contact no should be 10 digits." data-val-regex-pattern="[0-9]{10}" data-val-required="Contact Number is required." id="ContactNo" name="ContactNo" placeholder="Enter mobile no" readonly="readonly" required="" type="text" value="<?php echo $userdata->row(0)->mobile_no; ?>" />
                                            <i class="icon fa fa-mobile"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="ContactNo" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field EmailID must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-regex="Invalid email ID format." data-val-regex-pattern="^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" data-val-required="EmailID is required." id="EmailID" name="EmailID" placeholder="Enter Email ID" required="" type="text" value="<?php echo $userdata->row(0)->emailid; ?>" />
                                            <i class="icon fa fa-envelope"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="EmailID" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Aadhar No.</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field AadharNo must be a string or array type with a maximum length of &#39;16&#39;." data-val-maxlength-max="16" data-val-regex="Aadhar no should be 12 digits." data-val-regex-pattern="[0-9]{12,14}" data-val-required="Aadhar No is required." id="AadharNo" name="AadharNo" placeholder="Enter Aadhar no" required="" type="text" value="<?php echo $userdata->row(0)->aadhar_number; ?>" />
                                            <i class="icon fa fa-credit-card"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="AadharNo" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Shop Address</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field ShopAddress must be a string or array type with a maximum length of &#39;250&#39;." data-val-maxlength-max="250" data-val-minlength="Shop Address is required." data-val-minlength-min="3" data-val-required="Shop Address is required." id="ShopAddress" name="ShopAddress" placeholder="Enter Shop Address" required="" type="text" value="<?php echo $userdata->row(0)->postal_address; ?>" />
                                            <i class="icon fa fa-comment"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="ShopAddress" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Permanent Address</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field PermanentAddress must be a string or array type with a maximum length of &#39;250&#39;." data-val-maxlength-max="250" data-val-minlength="Permanent Address is required." data-val-minlength-min="3" data-val-required="Permanent Address is required." id="PermanentAddress" name="PermanentAddress" placeholder="Enter Address" required="" type="text" value="<?php echo $userdata->row(0)->postal_address; ?>" />
                                            <i class="icon fa fa-comment-o"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="PermanentAddress" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Pin Code</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field PinCode must be a string or array type with a maximum length of &#39;6&#39;." data-val-maxlength-max="6" data-val-regex="Pincode should be 6 digits." data-val-regex-pattern="[0-9]{6}" data-val-required="Pincode is required." id="PinCode" name="PinCode" placeholder="Enter Pincode" required="" type="text" value="<?php echo $userdata->row(0)->pincode; ?>" />
                                            <i class="icon fa fa-edit"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="PinCode" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>State</label>
                                        <div class="editor-field">
                                            <select class="form-control" data-val="true" data-val-maxlength="The field StatesName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-required="State Name is required." id="StatesName" name="StatesName" required=""><option value="">Select</option>
                                                <?php
                                                $rsltstate = $this->db->query("select state_id,state_name from tblstate order by state_name");
                                                foreach($rsltstate->result() as $rwstate)
                                                {?>
                                                    <option><?php echo $rwstate->state_name; ?></option>
                                                <?php } ?>

                                            </select>
                                            <span class="field-validation-valid error" data-valmsg-for="StatesName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>District</label>
                                        <div class="editor-field">
                                            <select class="form-control" data-val="true" data-val-maxlength="The field CityName must be a string or array type with a maximum length of &#39;30&#39;." data-val-maxlength-max="30" data-val-required="City Name is required." id="CityName" name="CityName" required=""><option value="">Select</option>
                                                <?php
                                                $rsltcity = $this->db->query("select city_id,city_name from tblcity order by city_name");
                                                foreach($rsltcity->result() as $rwcity)
                                                {?>
                                                    <option><?php echo $rwcity->city_name; ?></option>
                                                <?php } ?>
                                                
                                            </select>
                                            <span class="field-validation-valid error" data-valmsg-for="CityName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5><b>Bank A/C Details</b></h5>
                                    <hr />
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label> Bank Name</label>
                                        <div class="editor-field">
                                            <select class="form-control" data-val="true" data-val-maxlength="The field BanksName must be a string or array type with a maximum length of &#39;50&#39;." data-val-maxlength-max="50" data-val-required="Bank Name is required." id="BanksName" name="BanksName" required=""><option value="">Select</option>
<option value="Abhinav coop bank ltd">Abhinav coop bank ltd</option>
<option value="Abhyudaya Co-Op Bank">Abhyudaya Co-Op Bank</option>
<option value="Abu Dhabi Commercial Bank">Abu Dhabi Commercial Bank</option>
<option value="Adarsh Urban Co-Op Bank, Hyderabad">Adarsh Urban Co-Op Bank, Hyderabad</option>
<option value="Ahmedabad District Central Co-Op Bank">Ahmedabad District Central Co-Op Bank</option>
<option value="Ahmedabad Mercantile Co-Op Bank">Ahmedabad Mercantile Co-Op Bank</option>
<option value="Ahmednagar Mer Co-Op Bank">Ahmednagar Mer Co-Op Bank</option>
<option value="Airtel Payments Bank">Airtel Payments Bank</option>
<option value="Akhand Anand Co-Op Bank">Akhand Anand&#160;Co-Op Bank</option>
<option value="Akola District Central Co-operative Bank">Akola District Central Co-operative Bank</option>
<option value="Akola Janata Commercial Co Operative Bank Ltd">Akola Janata Commercial Co Operative Bank Ltd</option>
<option value="Allahabad Bank">Allahabad Bank</option>
<option value="Allahabad UP Gramin Bank">Allahabad UP Gramin Bank</option>
<option value="Ambarnath Jai Hind Co-Op Bank">Ambarnath Jai Hind Co-Op Bank</option>
<option value="Andhra Bank">Andhra Bank</option>
<option value="Andhra Pradesh Grameena Vikas Bank">Andhra Pradesh Grameena Vikas Bank</option>
<option value="Andhra Pragathi Grameena Bank">Andhra Pragathi Grameena Bank</option>
<option value="AP Mahesh Co-Op Urban Bank">AP Mahesh Co-Op Urban Bank</option>
<option value="Apna Sahakari Bank">Apna Sahakari Bank</option>
<option value="Arunachal Pradesh Rural Bank">Arunachal Pradesh Rural Bank</option>
<option value="Aryavart Gramin Bank">Aryavart Gramin Bank</option>
<option value="Assam Gramin Vikash Bank">Assam Gramin Vikash Bank</option>
<option value="AU SMALL FINANCE BANK LIM">AU SMALL FINANCE BANK LIM</option>
<option value="Axis Bank">Axis Bank</option>
<option value="Axis bank credit card">Axis bank credit card</option>
<option value="Baitarani Gramin Bank">Baitarani Gramin Bank</option>
<option value="Ballia Etawah Gramin Bank">Ballia Etawah Gramin Bank</option>
<option value="Bandhan Bank">Bandhan Bank</option>
<option value="Bangiya Gramin Bank">Bangiya Gramin Bank</option>
<option value="Bank of America">Bank of America</option>
<option value="Bank of Bahrain and Kuwait">Bank of Bahrain and Kuwait</option>
<option value="Bank of Baroda">Bank of Baroda</option>
<option value="Bank of Ceylon">Bank of Ceylon</option>
<option value="Bank of India">Bank of India</option>
<option value="Bank Of India Credit Card">Bank Of India Credit Card</option>
<option value="Bank of Maharashtra">Bank of Maharashtra</option>
<option value="Bank of Nova Scotia">Bank of Nova Scotia</option>
<option value="Bank of Tokyo-Mitsubishi UFJ">Bank of Tokyo-Mitsubishi UFJ</option>
<option value="Barclays Bank">Barclays Bank</option>
<option value="Baroda Gujarat Gramin Bank">Baroda Gujarat Gramin Bank</option>
<option value="Baroda Rajasthan Kshetriya Gramin Bank">Baroda Rajasthan Kshetriya Gramin Bank</option>
<option value="Baroda Uttar Pradesh Gramin Bank">Baroda Uttar Pradesh Gramin Bank</option>
<option value="Bassein Catholic Co-Op Bank">Bassein Catholic Co-Op Bank</option>
<option value="Bharat Co-Op Bank Mumbai">Bharat Co-Op Bank Mumbai</option>
<option value="Bhartiya Mahila Bank">Bhartiya Mahila Bank</option>
<option value="Bihar Kshetriya Gramin Bank">Bihar Kshetriya Gramin Bank</option>
<option value="BNP Paribas">BNP Paribas</option>
<option value="Bombay Mercantile Co-Op Bank">Bombay Mercantile Co-Op Bank</option>
<option value="Canara Bank">Canara Bank</option>
<option value="Canara Bank Credit Card">Canara Bank Credit Card</option>
<option value="Catholic Syrian Bank">Catholic Syrian Bank</option>
<option value="Central Bank of India">Central Bank of India</option>
<option value="Central Madhya Pra Gramin">Central Madhya Pra Gramin</option>
<option value="Chaitanya Godavari Grameena Bank">Chaitanya Godavari Grameena Bank</option>
<option value="Chhattisgarh Gramin Bank">Chhattisgarh Gramin Bank</option>
<option value="Chickmangalur Kodagu Gramin Bank">Chickmangalur Kodagu Gramin Bank</option>
<option value="Chikhli Urban Co-Op Bank">Chikhli Urban Co-Op Bank</option>
<option value="Chinatrust Commercial Bank">Chinatrust Commercial Bank</option>
<option value="Citibank">Citibank</option>
<option value="Citibank Credit Card">Citibank Credit Card</option>
<option value="Citizen Co-Op Bank, Noida">Citizen Co-Op Bank, Noida</option>
<option value="Citizen Credit Co-Op Bank">Citizen Credit Co-Op Bank</option>
<option value="City Union Bank">City Union Bank</option>
<option value="Corporation Bank">Corporation Bank</option>
<option value="Cosmos Co-Op Bank">Cosmos Co-Op Bank</option>
<option value="Dapoli Urban Co-Op Bank">Dapoli Urban Co-Op Bank</option>
<option value="DBS Bank">DBS Bank</option>
<option value="Deccan Grameena Bank">Deccan Grameena Bank</option>
<option value="Delhi State Co-Op Bank">Delhi State Co-Op Bank</option>
<option value="Dena Bank">Dena Bank</option>
<option value="Dena Gujarat Gramin Bank">Dena Gujarat Gramin Bank</option>
<option value="Deutsche Bank AG">Deutsche Bank AG</option>
<option value="Development Credit Bank">Development Credit Bank</option>
<option value="Dhanlaxmi Bank">Dhanlaxmi Bank</option>
<option value="DICGC">DICGC</option>
<option value="Dombivli Nagari Sahakari Bank">Dombivli Nagari Sahakari Bank</option>
<option value="Dr. Annasaheb Chougule Urban Co-Op Bank">Dr. Annasaheb Chougule Urban Co-Op Bank</option>
<option value="Durg Rajnandgaon Gramin Bank">Durg Rajnandgaon Gramin Bank</option>
<option value="Ellaqui Dehati Bank">Ellaqui Dehati Bank</option>
<option value="Equitas Small Finance Bank">Equitas Small Finance Bank</option>
<option value="ESAF Small Finance Bank">ESAF Small Finance Bank</option>
<option value="FINO Payment Bank">FINO Payment Bank</option>
<option value="Firstrand Bank">Firstrand Bank</option>
<option value="Gayatri Bank">Gayatri Bank</option>
<option value="Greater Bombay Co-Op Bank">Greater Bombay Co-Op Bank</option>
<option value="Gujarat State Co-Op Bank">Gujarat State Co-Op Bank</option>
<option value="Gurgaon Gramin Bank">Gurgaon Gramin Bank</option>
<option value="Hadoti Kshetriya Gramin Bank">Hadoti Kshetriya Gramin Bank</option>
<option value="Hamirpur District Co-Op Bank, Mahoba">Hamirpur District Co-Op Bank, Mahoba</option>
<option value="Hasti Co-Op Bank">Hasti Co-Op Bank</option>
<option value="HDFC Bank">HDFC Bank</option>
<option value="HDFC Bank Credit Card">HDFC Bank Credit Card</option>
<option value="HDFC Khamgaon Urban co op">HDFC Khamgaon Urban co op</option>
<option value="Himachal Gramin Bank">Himachal Gramin Bank</option>
<option value="Himachal Pradesh State Co-Op Bank">Himachal Pradesh State Co-Op Bank</option>
<option value="HSBC">HSBC</option>
<option value="HSBC Credit Card">HSBC Credit Card</option>
<option value="Hutatma Sahakari Bank">Hutatma Sahakari Bank</option>
<option value="ICICI Bank">ICICI Bank</option>
<option value="ICICI Bank Credit Card">ICICI Bank Credit Card</option>
<option value="IDBI Bank">IDBI Bank</option>
<option value="IDBI Bank Credit Card">IDBI Bank Credit Card</option>
<option value="IDFC Bank">IDFC Bank</option>
<option value="India Post Payments Bank">India Post Payments Bank</option>
<option value="Indian Bank">Indian Bank</option>
<option value="Indian Overseas Bank">Indian Overseas Bank</option>
<option value="IndusInd Bank">IndusInd Bank</option>
<option value="ING Vysya Bank LTD">ING Vysya Bank LTD</option>
<option value="Integral Urban Co-Op Bank">Integral Urban Co-Op Bank</option>
<option value="Irinjalakuda Town Co-Op Bank">Irinjalakuda Town Co-Op Bank</option>
<option value="J&amp;K Grameen Bank">J&amp;K Grameen Bank</option>
<option value="Jaipur Thar Gramin Bank">Jaipur Thar Gramin Bank</option>
<option value="Jalaun District Co-Op Bank">Jalaun District Co-Op Bank</option>
<option value="Jalgaon Dist Co Op Bank">Jalgaon Dist Co Op Bank</option>
<option value="Jalgaon Janta Sahkri Bank">Jalgaon Janta Sahkri Bank</option>
<option value="Jalgaon Peoples Co-Op Bank">Jalgaon Peoples Co-Op Bank</option>
<option value="Jalna Merchant Cooperative Bank Ltd, Jalna">Jalna Merchant Cooperative Bank Ltd, Jalna</option>
<option value="Jalore Nagrik Sahakari Bank">Jalore Nagrik Sahakari Bank</option>
<option value="Jamia Co-Op Bank">Jamia Co-Op Bank</option>
<option value="Jammu and Kashmir Bank">Jammu and Kashmir Bank</option>
<option value="Janakalyan Sahakari Bank">Janakalyan Sahakari Bank</option>
<option value="Janaseva Sahakari Bank">Janaseva Sahakari Bank</option>
<option value="Janata Co-Op Bank, Malegaon">Janata Co-Op Bank, Malegaon</option>
<option value="Janata Sahakari Bank,Pune">Janata Sahakari Bank,Pune</option>
<option value="Jhabua Dhar Kshetriya Gramin Bank">Jhabua Dhar Kshetriya Gramin Bank</option>
<option value="Jharkhand Gramin Bank">Jharkhand Gramin Bank</option>
<option value="JP Morgan Chase Bank">JP Morgan Chase Bank</option>
<option value="Kalinga Gramya Bank">Kalinga Gramya Bank</option>
<option value="Kallapana Ichalkaranji Awade Janaseva Sahakari Bank">Kallapana Ichalkaranji Awade Janaseva Sahakari Bank</option>
<option value="Kalupur Commercial Co-Op Bank">Kalupur Commercial Co-Op Bank</option>
<option value="Kalyan Janata Sahakari Bank">Kalyan Janata Sahakari Bank</option>
<option value="Kangra Central Co-Op Bank">Kangra Central Co-Op Bank</option>
<option value="Kangra Co-Op Bank">Kangra Co-Op Bank</option>
<option value="Kapole Co-Op Bank">Kapole Co-Op Bank</option>
<option value="Karad Urban Co-Op Bank">Karad Urban Co-Op Bank</option>
<option value="Karnataka Bank">Karnataka Bank</option>
<option value="Karnataka State Apex Co-Op">Karnataka State Apex Co-Op</option>
<option value="Karnataka State Co-Op Apex Bank, Bangalore">Karnataka State Co-Op Apex Bank, Bangalore</option>
<option value="Karnataka Vikas Grameena Bank">Karnataka Vikas Grameena Bank</option>
<option value="Karur Vysya Bank">Karur Vysya Bank</option>
<option value="Kashi Gomati BOB Gra Bank">Kashi Gomati BOB Gra Bank</option>
<option value="Kashi Gomati UBI Gra Bank">Kashi Gomati UBI Gra Bank</option>
<option value="Kaveri Grameena Bank">Kaveri Grameena Bank</option>
<option value="Kerala Gramin Bank">Kerala Gramin Bank</option>
<option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
<option value="Kotak Mahindra Credit Card">Kotak Mahindra Credit Card</option>
<option value="Kottayam Co-operative Urban bank Ltd">Kottayam Co-operative Urban bank Ltd</option>
<option value="Krishna Gramin Bank">Krishna Gramin Bank</option>
<option value="Kurmanchal Nagar Sahkari Bank Ltd">Kurmanchal Nagar Sahkari Bank Ltd</option>
<option value="Lakshmi Vilas Bank">Lakshmi Vilas Bank</option>
<option value="Langpi Dehangi Rural Bank">Langpi Dehangi Rural Bank</option>
<option value="Lokmangal  sahakari Co-op Bank Ltd ">Lokmangal  sahakari Co-op Bank Ltd </option>
<option value="Lokmangal Co-op Bank Ltd">Lokmangal Co-op Bank Ltd</option>
<option value="Madhya Bharat Gramin Bank">Madhya Bharat Gramin Bank</option>
<option value="Madhya Bihar Gramin Bank">Madhya Bihar Gramin Bank</option>
<option value="Madhyanchal Gramin Bank, Sagar">Madhyanchal Gramin Bank, Sagar</option>
<option value="Mahakaushal Kshetriya Gramin Bank">Mahakaushal Kshetriya Gramin Bank</option>
<option value="Mahanagar Co-Op Bank">Mahanagar Co-Op Bank</option>
<option value="Maharashtra Gramin Bank">Maharashtra Gramin Bank</option>
<option value="Maharashtra State Co-Op Bank">Maharashtra State Co-Op Bank</option>
<option value="Malad Sahkari Bank ">Malad Sahkari Bank </option>
<option value="Malda District Central Co-Op Bank">Malda District Central Co-Op Bank</option>
<option value="Malwa Gramin Bank">Malwa Gramin Bank</option>
<option value="Manipur Rural ANK">Manipur Rural ANK</option>
<option value="Manvi Pattana Souharda Sahakari Bank">Manvi Pattana Souharda Sahakari Bank</option>
<option value="Maratha Co-Op Bank">Maratha Co-Op Bank</option>
<option value="Markandey Nagari Sahakari Bank Ltd">Markandey Nagari Sahakari Bank Ltd</option>
<option value="Mashreq Bank PSC">Mashreq Bank PSC</option>
<option value="Mayani Urban Co-Op Bank">Mayani Urban Co-Op Bank</option>
<option value="Meghalaya Rural Bank">Meghalaya Rural Bank</option>
<option value="Mehsana Urban Co-Op Bank">Mehsana Urban Co-Op Bank</option>
<option value="Mewar Anchalik Gramin Bank">Mewar Anchalik Gramin Bank</option>
<option value="MG Baroda Gramin Bank">MG Baroda Gramin Bank</option>
<option value="MGCB Main">MGCB Main</option>
<option value="Mizoram Rural Bank">Mizoram Rural Bank</option>
<option value="Mizuho Corporate Bank">Mizuho Corporate Bank</option>
<option value="Mogaveera Co-Op Bank">Mogaveera Co-Op Bank</option>
<option value="Moradabad Zila Sahkari Bank">Moradabad Zila Sahkari Bank</option>
<option value="Mumbai District Central Co-Operative Bank Ltd">Mumbai District Central Co-Operative Bank Ltd</option>
<option value="Municipal Co-Op Bank">Municipal Co-Op Bank</option>
<option value="Nagar Sahkari Bank">Nagar Sahkari Bank</option>
<option value="Nainital Almora Kshetriya Gramin Bank">Nainital Almora Kshetriya Gramin Bank</option>
<option value="Nainital Bank">Nainital Bank</option>
<option value="Narmada Jhabua GraminBank">Narmada Jhabua GraminBank</option>
<option value="Narmada Malwa Gramin Bank">Narmada Malwa Gramin Bank</option>
<option value="Nashik Merchants Co-Op Bank">Nashik Merchants Co-Op Bank</option>
<option value="National Co-Op Bank">National Co-Op Bank</option>
<option value="Neelachal Gramya Bank">Neelachal Gramya Bank</option>
<option value="NEFT Malwa Gramin Bank">NEFT Malwa Gramin Bank</option>
<option value="New India Co-Op Bank">New India Co-Op Bank</option>
<option value="New Indian Co Op Bank">New Indian Co Op Bank</option>
<option value="NKGSB Co-Op Bank">NKGSB Co-Op Bank</option>
<option value="Noble Co-Op Bank">Noble Co-Op Bank</option>
<option value="North Malabar Gramin Bank">North Malabar Gramin Bank</option>
<option value="Nutan Nagarik Sahakari Bank">Nutan Nagarik Sahakari Bank</option>
<option value="Odisha Gramya Bank">Odisha Gramya Bank</option>
<option value="Oman International Bank Saog">Oman International Bank Saog</option>
<option value="Oriental Bank of Commerce">Oriental Bank of Commerce</option>
<option value="Pachora Peoples Co-Op Bank">Pachora Peoples Co-Op Bank</option>
<option value="Pallavan Grama Bank">Pallavan Grama Bank</option>
<option value="Pandharpur Merchant Co-Op Bank">Pandharpur Merchant Co-Op Bank</option>
<option value="Pandharpur Urban Co-Op Bank">Pandharpur Urban Co-Op Bank</option>
<option value="Pandyan Gramin Bank">Pandyan Gramin Bank</option>
<option value="Parshwanath Co-Op Bank">Parshwanath Co-Op Bank</option>
<option value="Parsik Janata Sahakari Bank">Parsik Janata Sahakari Bank</option>
<option value="Parvatiya Gramin Bank">Parvatiya Gramin Bank</option>
<option value="Paschim Banga Gramin Bank">Paschim Banga Gramin Bank</option>
<option value="Pavana Sahakari Bank">Pavana Sahakari Bank</option>
<option value="Paytm Payments Bank">Paytm Payments Bank</option>
<option value="Pithoragarh Jila Sahkari Bank">Pithoragarh Jila Sahkari Bank</option>
<option value="Pochampally Co-Op Urban Bank">Pochampally Co-Op Urban Bank</option>
<option value="Poornawadi Nagrik Sahakari Bank">Poornawadi Nagrik Sahakari Bank</option>
<option value="Pragathi Gramin Bank">Pragathi Gramin Bank</option>
<option value="Pragathi Krishna Gramin Bank">Pragathi Krishna Gramin Bank</option>
<option value="Prathama Bank">Prathama Bank</option>
<option value="Priyadarshani Nagari Sahakari Bank">Priyadarshani Nagari Sahakari Bank</option>
<option value="Puduvai Bharathiar Grama Bank">Puduvai Bharathiar Grama Bank</option>
<option value="Pune Cantonment Sahakari Bank">Pune Cantonment Sahakari Bank</option>
<option value="Pune Peoples Co-Op Bank">Pune Peoples Co-Op Bank</option>
<option value="Punjab and Maharashtra Co-Op Bank">Punjab and Maharashtra Co-Op Bank</option>
<option value="Punjab and Sind Bank">Punjab and Sind Bank</option>
<option value="Punjab Gramin Bank">Punjab Gramin Bank</option>
<option value="Punjab National Bank">Punjab National Bank</option>
<option value="Punjab National Bank Credit Card">Punjab National Bank Credit Card</option>
<option value="Purvanchal Gramin Bank">Purvanchal Gramin Bank</option>
<option value="Raipur Urban Mercantile Co-Op Bank">Raipur Urban Mercantile Co-Op Bank</option>
<option value="Rajapur Urban Co-Op Bank">Rajapur Urban Co-Op Bank</option>
<option value="Rajarshi shahu sah Bank ">Rajarshi shahu sah Bank </option>
<option value="Rajasthan Gramin Bank">Rajasthan Gramin Bank</option>
<option value="Rajasthan Marudhara Gramin Bank">Rajasthan Marudhara Gramin Bank</option>
<option value="Rajgurunagar Sahakari Bank">Rajgurunagar Sahakari Bank</option>
<option value="Rajkot Nagarik Sahakari Bank">Rajkot Nagarik Sahakari Bank</option>
<option value="Ratnakar Bank">Ratnakar Bank</option>
<option value="RBL BANK">RBL BANK</option>
<option value="Reserve Bank of India">Reserve Bank of India</option>
<option value="Rewa-Sidhi Gramin Bank">Rewa-Sidhi Gramin Bank</option>
<option value="Royal Bank of Scotland">Royal Bank of Scotland</option>
<option value="Rushikulya Gramin Bank">Rushikulya Gramin Bank</option>
<option value="Sadhana Sahakari Bank Ltd">Sadhana Sahakari Bank Ltd</option>
<option value="Samastipur Kshetriya Gramin Bank">Samastipur Kshetriya Gramin Bank</option>
<option value="Samata Sahakari Bank">Samata Sahakari Bank</option>
<option value="Sapthagiri Grameena Bank">Sapthagiri Grameena Bank</option>
<option value="Saraswat Co-Op Bank">Saraswat Co-Op Bank</option>
<option value="Sardar Bhiladwala Pardi Peoples Co-Op Bank">Sardar Bhiladwala Pardi Peoples Co-Op Bank</option>
<option value="Sarva Haryana Gramin Bank">Sarva Haryana Gramin Bank</option>
<option value="Sarva UP Gramin Bank">Sarva UP Gramin Bank</option>
<option value="Satpura Narmada Kshetriya Gramin Bank">Satpura Narmada Kshetriya Gramin Bank</option>
<option value="Saurashtra Gramin Bank">Saurashtra Gramin Bank</option>
<option value="Seva Vikas Co-Op Bank">Seva Vikas Co-Op Bank</option>
<option value="Sharad Sahakari Bank Ltd. Manchar">Sharad Sahakari Bank Ltd. Manchar</option>
<option value="Sharda Gramin Bank">Sharda Gramin Bank</option>
<option value="Shinhan Bank">Shinhan Bank</option>
<option value="Shirpur Peoples Co-Op Bank">Shirpur Peoples Co-Op Bank</option>
<option value="Shivajirao Bhosale Sahakari Bank">Shivajirao Bhosale Sahakari Bank</option>
<option value="Shivalik Mercantile Co-Op Bank">Shivalik Mercantile Co-Op Bank</option>
<option value="Shree Mahalaxmi Co-Op Bank">Shree Mahalaxmi Co-Op Bank</option>
<option value="Shree Sharada Sah Bank L">Shree Sharada Sah Bank L</option>
<option value="Shree Sharada Sahakari Bank">Shree Sharada Sahakari Bank</option>
<option value="Shree Veershaiv Co-Op Bank">Shree Veershaiv Co-Op Bank</option>
<option value="Shreyas Gramin Bank">Shreyas Gramin Bank</option>
<option value="Shri Arihant Co-Op Bank">Shri Arihant Co-Op Bank</option>
<option value="Shri Basaveshwar Sahakari Bank Niyamit Bagalkot">Shri Basaveshwar Sahakari Bank Niyamit Bagalkot</option>
<option value="Shri Chhatrapati Rajarshi Shahu Urban Co-Op Bank Ltd">Shri Chhatrapati Rajarshi Shahu Urban Co-Op Bank Ltd</option>
<option value="Sindhudurg District Central Co-Op Bank">Sindhudurg District Central Co-Op Bank</option>
<option value="Siwan Central Co-Op Bank">Siwan Central Co-Op Bank</option>
<option value="Societe Generale">Societe Generale</option>
<option value="solapur Janata Sah. Bank">solapur Janata Sah. Bank</option>
<option value="South Indian Bank">South Indian Bank</option>
<option value="South Malabar Gramin Bank">South Malabar Gramin Bank</option>
<option value="Standard Chartered Bank">Standard Chartered Bank</option>
<option value="Standard Chartered Credit Card">Standard Chartered Credit Card</option>
<option value="State Bank of Bikaner and Jaipur">State Bank of Bikaner and Jaipur</option>
<option value="State Bank of Hyderabad">State Bank of Hyderabad</option>
<option value="State Bank of India">State Bank of India</option>
<option value="State Bank of India Credit Card">State Bank of India Credit Card</option>
<option value="State Bank of Mauritius">State Bank of Mauritius</option>
<option value="State Bank of Mysore">State Bank of Mysore</option>
<option value="State Bank of Patiala">State Bank of Patiala</option>
<option value="State Bank of Travancore">State Bank of Travancore</option>
<option value="Suco Souharda Sahakari Bank">Suco Souharda Sahakari Bank</option>
<option value="Sudha Cooperative Urban Bank Ltd">Sudha Cooperative Urban Bank Ltd</option>
<option value="Surat District Co-Op Bank">Surat District Co-Op Bank</option>
<option value="Surat National Co-op Bank">Surat National Co-op Bank</option>
<option value="Surat Peoples Co-Op Bank">Surat Peoples Co-Op Bank</option>
<option value="Surguja Kshetriya Gramin Bank">Surguja Kshetriya Gramin Bank</option>
<option value="Suryoday Small Finance Bank">Suryoday Small Finance Bank</option>
<option value="Sutex Co-Op Bank">Sutex Co-Op Bank</option>
<option value="Sutlej Gramin Bank">Sutlej Gramin Bank</option>
<option value="Suvarnayug Sahakari Bank Ltd">Suvarnayug Sahakari Bank Ltd</option>
<option value="Swarna Bharat Trust Cyber Grameen">Swarna Bharat Trust Cyber Grameen</option>
<option value="Syndicate Bank">Syndicate Bank</option>
<option value="Tamilnad Mercantile Bank">Tamilnad Mercantile Bank</option>
<option value="Tamilnadu State Apex Co-Op Bank">Tamilnadu State Apex Co-Op Bank</option>
<option value="Telangana Grameena Bank">Telangana Grameena Bank</option>
<option value="Telangana State Cooperative Apex Bank">Telangana State Cooperative Apex Bank</option>
<option value="test">test</option>
<option value="Thane Bharat Sahakari Bank">Thane Bharat Sahakari Bank</option>
<option value="Thane Janata Sahakari Bank">Thane Janata Sahakari Bank</option>
<option value="The Adarsh Urban Co-op Bank Ltd, Hyderabad ">The Adarsh Urban Co-op Bank Ltd, Hyderabad </option>
<option value="The Assam Coop Apex Bank Ltd">The Assam Coop Apex Bank Ltd</option>
<option value="The Bijnor Urban Co-Operative Bank">The Bijnor Urban Co-Operative Bank</option>
<option value="The Federal Bank Ltd">The Federal Bank Ltd</option>
<option value="The Gopalganj Central Gramin Bank">The Gopalganj Central Gramin Bank</option>
<option value="The Hindusthan Co-operative Bank Ltd.">The Hindusthan Co-operative Bank Ltd.</option>
<option value="THE JAWHAR URBAN CO-OP. B">THE JAWHAR URBAN CO-OP. B</option>
<option value="The Kaira District Central Cooperative Bank Ltd">The Kaira District Central Cooperative Bank Ltd</option>
<option value="The Murshidabad District Central Co Operative Bank Ltd">The Murshidabad District Central Co Operative Bank Ltd</option>
<option value="The Panipat Urban Co-operative Bank Ltd">The Panipat Urban Co-operative Bank Ltd</option>
<option value="The Sabarkantha District Central Cooperative Bank Ltd">The Sabarkantha District Central Cooperative Bank Ltd</option>
<option value="The Sahebrao Deshmukh Co-Op. Bank Ltd">The Sahebrao Deshmukh Co-Op. Bank Ltd</option>
<option value="The Saurashtra Cooperative Bank Ltd">The Saurashtra Cooperative Bank Ltd</option>
<option value="The Shamrao Vithal Co-Operative Bank">The Shamrao Vithal Co-Operative Bank</option>
<option value="The Thane District Central Co-Operative Bank Ltd">The Thane District Central Co-Operative Bank Ltd</option>
<option value="The Zoroastrian Cooperative Bank Limited">The Zoroastrian Cooperative Bank Limited</option>
<option value="Thrissur District Central Co-Op Bank">Thrissur District Central Co-Op Bank</option>
<option value="Tirupati urban co op">Tirupati urban co op</option>
<option value="Titwala">Titwala</option>
<option value="Tripura Gramin Bank">Tripura Gramin Bank</option>
<option value="Triveni Kshetriya Gramin Bank">Triveni Kshetriya Gramin Bank</option>
<option value="UBS AG">UBS AG</option>
<option value="UCO Bank ">UCO Bank </option>
<option value="Udaipur Mahila Samrudhi Urban Co-Op Bank">Udaipur Mahila Samrudhi Urban Co-Op Bank</option>
<option value="Udaipur urban Co-operative bank Ltd">Udaipur urban Co-operative bank Ltd</option>
<option value="Ujjivan Small Finance Bank">Ujjivan Small Finance Bank</option>
<option value="Union Bank of India">Union Bank of India</option>
<option value="United Bank of India">United Bank of India</option>
<option value="Urban Co-Op Bank">Urban Co-Op Bank</option>
<option value="UTI Axis Bank Credit Card">UTI Axis Bank Credit Card</option>
<option value="Utkal Gramya Bank">Utkal Gramya Bank</option>
<option value="Uttar Banga Kshetriya Gramin Bank">Uttar Banga Kshetriya Gramin Bank</option>
<option value="Uttar Bihar Gramin Bank">Uttar Bihar Gramin Bank</option>
<option value="Uttarakhand Gramin Bank">Uttarakhand Gramin Bank</option>
<option value="Vaidyanath Urban Co-Op Bank">Vaidyanath Urban Co-Op Bank</option>
<option value="Vananchal Gramin Bank">Vananchal Gramin Bank</option>
<option value="Varachha Co-Op Bank">Varachha Co-Op Bank</option>
<option value="Vasai Janata sahakar Bank">Vasai Janata sahakar Bank</option>
<option value="Vasai Vikas Co-op Bank">Vasai Vikas Co-op Bank</option>
<option value="Vidharbha Kshetriya Gramin Bank">Vidharbha Kshetriya Gramin Bank</option>
<option value="Vidisha Bhopal Kshetriya Gramin Bank">Vidisha Bhopal Kshetriya Gramin Bank</option>
<option value="Vijaya Bank">Vijaya Bank</option>
<option value="Vikas Souharda Co-operative Bank Limited">Vikas Souharda Co-operative Bank Limited</option>
<option value="Vishweshwar Co-Op Bank">Vishweshwar Co-Op Bank</option>
<option value="Visveshwaraya Gramin Bank">Visveshwaraya Gramin Bank</option>
<option value="Wainganga Krishna Gramin Bank">Wainganga Krishna Gramin Bank</option>
<option value="West Bengal State Co-Op Bank">West Bengal State Co-Op Bank</option>
<option value="Yadagiri Lakshmi Narasimha Swamy Co-Op Urban Bank">Yadagiri Lakshmi Narasimha Swamy Co-Op Urban Bank</option>
<option value="Yavatmal district co-op">Yavatmal district co-op</option>
<option value="Yes Bank">Yes Bank</option>
<option value="Zila Sahkari Bank">Zila Sahkari Bank</option>
</select>
                                            <span class="field-validation-valid error" data-valmsg-for="BanksName" data-valmsg-replace="true"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>Account No.</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field AccountNo must be a string or array type with a maximum length of &#39;16&#39;." data-val-maxlength-max="16" data-val-regex="Bank Account No between 9-16 digit." data-val-regex-pattern="[0-9]{9,16}" data-val-required="Account No is required." id="AccountNo" name="AccountNo" placeholder="Enter Account No" required="" type="text" value="" />
                                            <i class="icon fa fa-user"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="AccountNo" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <div class="inputText">
                                            <input class="form-control" data-val="true" data-val-maxlength="The field IFSCCode must be a string or array type with a maximum length of &#39;11&#39;." data-val-maxlength-max="11" data-val-regex="Invalid IFSC Code format." data-val-regex-pattern="^[A-Za-z]{4}0[A-Z0-9a-z]{6}$" data-val-required="IFSC Code is required." id="IFSCCode" name="IFSCCode" placeholder="Enter IFSC" required="" type="text" value="" />
                                            <i class="icon fa fa-edit"></i>
                                        </div>
                                        <span class="field-validation-valid error" data-valmsg-for="IFSCCode" data-valmsg-replace="true"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <input type="submit" class="btn btn-primary" value="Update" />
                                    </div>
                                </div>
                            </div>
</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!--Page Scripts-->
    <script src="/Scripts/Custom/Jquery/jquery.memeber.route.min.1.7.2.js"></script>
    <script src="/bundles/jquery?v=wBUqTIMTmGl9Hj0haQMeRbd8CoM3UaGnAwp4uDEKfnM1"></script>

    <script src="/bundles/jqueryval?v=WDt8lf51bnC546FJKW5By7_3bCi9X11Mr6ray08RhNs1"></script>


    <!--Select Option Plugin-->
    <link href="<?php echo base_url(); ?>mpayfiles/select2.min.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>mpayfiles/select2.min.js"></script>
    <script>
        $("#StatesName").select2({
            placeholder: "Select State"
        });
        $("#CityName").select2({
            placeholder: "Select City"
        });
        $("#BanksName").select2({
            placeholder: "Select City"
        });
    </script>
    <!--Select Option Plugin-->

        <div class="container-fluid"><?php include("elements/footer.php"); ?>
        </div>
    </div>
        <!--Start Bottom to top-->
        <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
        <!--End Bottom to top-->

        <div id="ModalSearchTrxn" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Transaction Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table" style="border-bottom:1px solid #ddd;">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Transaction ID</th>
                                            <th>Trans. AMT</th>
                                            <th>Charged AMT</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="srchTxnDate"></td>
                                            <td id="srchTxnOrderID"></td>
                                            <td id="srchTxnAmount"></td>
                                            <td id="srchTxnCharge"></td>
                                            <td id="srchTxnStatus"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mg-t-10 table-responsive">
                                <table class="table table-transdet" id="srchTxnDetails"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Start Page Plugins-->
        <!--Modal Processing-->
        <div class="modal" id="ProcessingBox">
            <div class="modal-dialog" style="margin-top:15%;">
                <div class="modal-content" style="background: transparent;">
                    <div class="modal-body ConfirmBox text-center" style="padding:20px !important;">
                        <h3 class="text-white">Processing your transaction...</h3>
                        <img src="<?php echo base_url(); ?>mpayfiles/Processing.gif" style="width:70px;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="ConfirmBox" style="margin-top:30%;">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #ddd;">
                    <div class="modal-header ConfirmBoxhead">
                        <h4 class="modal-title">Message</h4>
                        <button type="button" class="close" aria-hidden="true" onclick="closepopup();">×</button>
                    </div>
                    <div class="modal-body ConfirmBox" style="padding:20px !important;">
                        <p id="message"></p>
                    </div>
                    <div class="modal-footer" id="btnsuccessBox" style="display:none;">
                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="btnsuccessPrint">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal End-->

      <script src="<?php echo base_url(); ?>assets2/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <!-- Optional JS -->
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>assets2/vendor/chart.js/dist/Chart.extension.js"></script>
    <!-- Argon JS -->
    <script src="<?php echo base_url(); ?>assets2/js/argon.min5438.js?v=1.2.0"></script>
        <script>
            // ===== Scroll to Top ====
            $(window).scroll(function () {
                if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                    $('#return-to-top').fadeIn(200);    // Fade in the arrow
                } else {
                    $('#return-to-top').fadeOut(200);   // Else fade out the arrow
                }
            });
            $('#return-to-top').click(function () {      // When arrow is clicked
                $('body,html').animate({
                    scrollTop: 0                       // Scroll to top of body
                }, 500);
            });

            function closepopup() {
                jQuery('#ConfirmBox').attr("style", "display:none;");
            };
        </script>
        <!--Start Calendar Plugins-->
        <script src="<?php echo base_url(); ?>mpayfiles/jquery-ui.js"></script>

        <script>
            $('.editable-on-click').click(function (e) {
                var input = $(this).find('input');
                if (input.length) {
                    input.trigger('click');
                    return;
                }
                var textarea = $(this).find('textarea');
                if (textarea.length) {
                    textarea.trigger('click');
                    return;
                }
            });
            $('.fileUpload').click(function (e) {
                e.stopPropagation();
            });
            jQuery(function () {
                jQuery('#txtSearchTrxn').keyup(function () {
                    var refNumber = jQuery('#txtSearchTrxn').val();
                    if (refNumber.length === 15) {
                        jQuery.post('/Reports/SubShowTransaction', { transactionRef: refNumber }, function (response) {
                            if (response != null && response != '') {
                                $('#ModalSearchTrxn').modal('show');
                                jQuery('#srchTxnDate').html(response.TxnDatetime);
                                jQuery('#srchTxnOrderID').html(response.OrderID);
                                jQuery('#srchTxnAmount').html(response.TxnAmount);
                                jQuery('#srchTxnCharge').html(response.ServiceCharge);
                                jQuery('#srchTxnStatus').html(response.TxnStatus === 'Success' ? '<span class="success" style="margin-left:0px;">Success</span>' : response.TxnStatus === 'Pending' ? '<span class="pending" style="margin-left:0px;">Pending</span>' : '<span class="failure" style="margin-left:0px;">' + response.TxnStatus + '</span>');
                                if (response.ServiceID === 9) {
                                    var htmlStr = '<tr><td>Remitter Mobile</td><td>' + response.TxnNumber + '</td></tr><tr><td>Beneficiary Name</td><td>' + response.RecipientName + '</td></tr><tr><td>Bank</td><td>' + response.BankName + '</td></tr><tr><td>Account No</td><td>' + response.AccountNo + '</td></tr><tr><td>IFSC</td><td>' + response.IfscCode + '</td></tr><tr><td>MODE</td><td>' + response.PaymentType + '</td></tr><tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                } else {
                                    var htmlStr = '<tr><td>RRN</td><td>' + response.RRN + '</td></tr><tr><td>Opening Balance</td><td>' + response.OpeningBal + '</td></tr><tr><td>Charged Amount</td><td>' + response.ServiceCharge + '</td></tr><tr><td>Customer Convenience Fee (CCF)</td><td>' + response.TxnNumber + '</td></tr><tr><td>Response Message</td><td>' + response.Message + '</td></tr>'; if (response.TxnStatus === 'Success') { htmlStr += '<tr><td>Receipt</td><td><a href="/Recharge/ViewReceipt/' + response.OrderID + '" target="_blank" class="download">View Receipt</a></td></tr>'; }
                                    jQuery('#srchTxnDetails').html(htmlStr);
                                }
                            } else {
                                jQuery('#ConfirmBox').attr("style", "display:block;margin-top: 15%;");
                                jQuery('#message').html('Transaction not found.');
                                jQuery('#message').attr("style", "color:red;");
                            }
                        });
                    }
                });
            });
        </script>
        
</body>
</html>
