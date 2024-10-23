        <div class="ratailer-header-page fullbodydycolorbg" id="header-fixed-sticy">
            <nav class="navbar navbarr">
                <div class="container-fluid asd-allapp">
                    <div class="navbar-header" style="padding:0px 0px;">
                        <a href="javascript:void(0);" class="navbar-toggle collapsed newchangeclassrespo" id="z-index" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                        <a href="javascript:void(0);" class="bars" style="display: none;"></a>
                        <a href="<?php echo base_url()."Distributor/Dashboard" ?>">
                            <center>
                                <img src="<?php echo base_url();?>vfiles/79444dab-571e-4737-99c1-99ffa47ea94d_M.png" class="img-responsive ad-ppp" style="width:148px;">
                            </center>
                        </a>
                    </div>
                    <div class="collapse navbar-collapse tt newclasscustome" id="navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            <li class="w-50">
                                <div class="top-searchbarr">

                                    



                                    <div class="col-xs-6 col-xs-offset-2 top-search-responsive">
                                        <form>
                                            <div class="input-group">
                                                <div class="input-group-btn search-panel">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                                        <span id="search_concept">All</span> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu scrollable-dropdown" role="menu">
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Automots</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Cell Phs</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Computer Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Health and Personal Care</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Automotive Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Cell Phone Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Computer Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Health and Personal Care</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Automotive Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Cell </a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Computer Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Health and Personal Care</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Automotive Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Cell Phone Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Computer Accesories</a></li>
                                                        <li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#" class=" waves-effect waves-block">Health and Personal Care</a></li>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="search_param" value="all" id="search_param">
                                                <input type="text" class="form-control" name="x" id="search" placeholder="Search">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" style="height:31px;margin-top:1px;">
                                                        <span class="glyphicon glyphicon-search"><img src="<?php echo base_url();?>vfiles/search(3).svg" style="width: 15px;height: 18px;"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>




                                    <script>
                                        $(document).ready(function (e) {
                                            $('.search-panel .dropdown-menu').find('a').click(function (e) {
                                                e.preventDefault();
                                                var param = $(this).attr("href").replace("#", "");
                                                var concept = $(this).text();
                                                $('.search-panel span#search_concept').text(concept);
                                                $('.input-group #search_param').val(param);
                                            });
                                        });
                                        var a = document.getElementsByTagName('a').item(0);
                                        $(a).on('keyup', function (evt) {
                                            console.log(evt);
                                            if (evt.keycode === 13) {

                                                alert('search?');
                                            }
                                        });</script>
                                    <div class="col-md-6 responshive-rightclass">
                                        <div class="row">
                                            
                                            <div class="col-md-12" id="aj">
                                                <ul class="bal-nav">
                                                    


                                                    <!--add to cart design-->
                                                    <li class="header__submenuu shoping-cartpt" id="submenuu">
                                                        <button class="header__cart-btn" id="toggle-cart-btn">
                                                            <i class="cart">
                                                                <img src="<?php echo base_url();?>vfiles/discount.png" style="width:21px !important;height:auto !important;margin-top:3px !important;"> <span>3</span><label style="font-weight:600;margin-bottom:0px;font-size: 16px;">Cart</label>
                                                                    </i>
                                                                </button>
                                                                <div class="custum-dropdown" style="display:none">
                                                                    <ul><li><a href="<?php echo base_url(); ?>Distributor/Recharge_home#">E-Commerce</a></li></ul>
                                                                </div>
                                                            </li>

                                                            <script>
                                                                $(document).ready(function () {
                                                                    $(".header__cart-btn").click(function () {
                                                                        $(".custum-dropdown").slideToggle()


                                                                    });
                                                                });
                                                            </script>

                                                            <!--add to cart design-->






                                                            




                                                                <!--AEPS Wallet-->
                                                                
                                         
<li class="bkp">
    <i> 
    <img src="<?php echo base_url();?>vfiles/rupee-r.png" style="width:16px !important;height:auto !important;margin-top:3px !important;">&nbsp;
    <span id="spanoutstanding" style="font-size: 16px;font-weight: 600;color:#000 !important;">
       0
              </span></i>
                                                        <div class="dropdown-submenu">
                                                            <ul>
                                                                <li style="font-weight:700;"> Admin Cr:  0</li>
                                                                <li style="font-weight:700;">Distribuitor Cr:  0</li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <!--Retailer Live  Balance-->
                                                    <li class="bkp india-rupeyy">
                                                        <a href="javascript:void(0);" class="pull-right dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true" style="margin-right:6px;">
                                                   
                                                            <i>
                                                                <img src="<?php echo base_url();?>vfiles/main-rupee.png" style="width:15px !important;height:auto !important;margin-top:4px !important;">&nbsp;
                                                                <span id="remainretailer" style="color:#555 !important;font-size: 16px;font-weight: 600;">0.00</span>
                                                            </i>


                                                        </a>
                                                        <div class="dropdown-submenu">
                                                            <ul>
                                                                <li>Wallet Balance</li>
                                                            </ul>
                                                        </div>


                                                    </li>
                                                    <!--Logout -->
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <ul id="leftulbar" class="nav navbar-nav navbar-left" style="padding-top:5px;display:none;">
                                        <li class="dropdown downlist-ap style=" display:none;"="">
                                            <div class="asd-nav">
                                                <ul id="leftulbar" class="nav nav-tabs tab-nav-left nav1-tabs1" role="tablist" style="padding-top:5px;border-bottom:none;">
                                                    <li id="dashboard" class="listtryp activee active" role="presentation" style="padding:0px;">
                                                        <a href="<?php echo base_url()."Distributor/Dashboard"; ?>" aria-expanded="false" style=" cursor:pointer;"><i class="fa fa-home" style="color:white;top:-3px;"></i></a>
                                                    </li>
                                                    <li id="recharge" class="listtryp activee active" role="presentation" style="padding:0px;">
                                                        <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" id="recharge" aria-expanded="false">RECHARGE &amp; BILL</a>
                                                    </li>
                                                    <li id="finanical" class="listtryp active" role="presentation" style="padding:0px;">
                                                        <a href="<?php echo base_url()."Distributor/dmrmm_home"; ?>" aria-expanded="true">FINANCIAL</a>
                                                    </li>
                                                    <li id="travel" class="listtryp active" role="presentation" style="padding:0px;">
                                                        <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true">TRAVEL</a>
                                                    </li>


                                                    
                                                    <li id="Gift" class="listtryp active" role="presentation" style="padding:0px;">
                                                        <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true">GIFT&nbsp;CARDS</a>
                                                    </li>

                                                    <li id="ecommerce" class="listtryp" role="presentation" style="padding:0px; margin-bottom:-27px;">
                                                        <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true">E-COMMERCE</a>
                                                    </li>


                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                            </div></li>

                            <!--My Credit -->
                            
                            <ul id="showpp" class="dropdown-menu" style="top:143%;margin:2px -125px 0px;">
                                <li class="body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" style="position:inherit;margin-bottom:-5px;">
                                                <table class="table" style="margin-bottom:0px;">
                                                    <tbody id="showoutstandingbalance"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            </ul>
                            

                            

                    </ul></div>
                </div>

            </nav>

            <div class="top-navmenup  finaciall active-balencess" id="nav-my">
                <div class="menus">

                    <!--toggle menu start-->

                    <div id="toggle-poptmenuo">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                    </div>
                    <script>
                        $("#toggle-poptmenuo").click(function () {
                            $(this).toggleClass("on");
                            $(".layoutt .top-navmenup #leftulbar").slideToggle('slow');
                        });
                    </script>


                    <!--toggle menu End-->

                    <ul id="leftulbar" class="nav nav-tabs tab-nav-left nav1-tabs1 navi fullbodydycolorbg addnewlogout addnewlogout-responshive" role="tablist" style="padding-top:5px;border-bottom:none;">
                        <li id="dashboard" class="listtryp active" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/Dashboard"; ?>" aria-expanded="false"><i><img src="<?php echo base_url();?>vfiles/transport.png"></i>DASHBOARD</a>
                        </li>
                        <li id="recharge" class="listtryp" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" id="recharge" aria-expanded="false"><span class="newimgspan"><i><img src="<?php echo base_url();?>vfiles/validating-ticket.svg" style="text-align: center;margin: 0px auto;position: static;float: none;margin-right: 2px;margin-top: -2px;transform:none;"></i>Prepaid&nbsp;&amp;&nbsp;Utility</span></a>
                        </li>
                        <li id="finanical" class="listtryp" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/dmrmm_home"; ?>" aria-expanded="true"><span class="newimgspan"><i><img style="transform:none;height: 21px;text-align: center;margin: 0px auto;position: static;float: none;margin-right: 2px;margin-top: -2px;" src="<?php echo base_url();?>vfiles/business.svg"></i>FINANCIAL</span></a>
                        </li>
                        <li id="travel" class="listtryp" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true"><span class="newimgspan"><i><img style="transform:none;left: 16px;height: 13px;top: 4px;width: 15px !important;text-align: center;margin: 0px auto;position: static;float: none;margin-right: 2px;margin-top: -2px;" src="<?php echo base_url();?>vfiles/interface.png"></i>TRAVEL&nbsp;&amp;&nbsp;Hotels</span></a>
                        </li>


                        
                        <li id="Gift" class="listtryp" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true"><span class="newimgspan"><i><img style="transform:none;left:34px;height: 16px;top: 2px;text-align: center;margin: 0px auto;position: static;float: none;margin-right: 2px;margin-top: -2px;" src="<?php echo base_url();?>vfiles/business(1).png"></i>GIFT&nbsp;CARDS</span></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url()."Distributor/recharge_home"; ?>"><span class="newimgspan"><i><img style="transform:none;text-align:center;margin:0px auto;position: static;float: none;margin-right: 2px;margin-top: -2px;height: 15px;" src="<?php echo base_url();?>vfiles/computer.png"></i>Security<label class="for-blink1" style="font-size: 10px;position: absolute;top: -4px;right: -23px;">New</label></span></a>
                        </li>

                        <li id="ecommerce" class="listtryp" role="presentation" style="padding:0px;">
                            <a href="<?php echo base_url()."Distributor/recharge_home"; ?>" aria-expanded="true"><span class="newimgspan"><i><img style="transform:none;text-align:center;margin:0px auto;position: static;float: none;margin-right: 2px;margin-top: -3px;height: 15px;" src="<?php echo base_url();?>vfiles/interface(1).png"></i>E-COMMERCE</span></a>
                        </li>

                        <li class="bkp logout-bkp">
<form action="<?php echo base_url()."Distributor/recharge_home"; ?>" method="post"><input name="__RequestVerificationToken" type="hidden" value="yLpQg1Aw_MwQUJVx1c9U1YqQGhheBfEjkEeerl9McNEkAdqhIoE6bfVA4OyIxrKh7l7dj6Cxzd5S37z17wb7vqzeXcsQKbezNoZg5EVTmA5ouU88rd91-csWhRS-lKx8Nqrxh24xpdr5gDpfEdK5AA2">                                <button type="submit" class="pull-right">
                                    <span class="newimgspan"><i><img style="transform:none;text-align:center;margin:0px auto;position: static;float: none;margin-right: 2px;margin-top:1px;height: 15px;transform: rotate(-180deg);" src="<?php echo base_url();?>vfiles/signs.png"></i><p>Logout</p></span>
                                    
                                </button>
</form>
                        </li>

                    </ul>

                </div>





            </div>

        </div>

