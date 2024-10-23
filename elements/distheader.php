<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
<ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item dropdown" >

                    <!-- Sidenav toggler -->
                   <div class="sidenav-toggler  d-xl-block " data-action="sidenav-unpin"
                        data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner p-4">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">
                                Rec : ₹ <span id="currentMBal">0</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">
                                DMT : ₹ <span id="currentMBal2">0</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="<?php echo base_url(); ?>assets2/img/DPPRG3192.png">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold"><?php echo substr($this->session->userdata("DistBusinessName"),0,15); ?></span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="<?php echo base_url(); ?>Distributor_new/userProfile" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>My profile</span>
                                </a>
                                <a href="<?php echo base_url(); ?>Distributor_new/Change_password" class="dropdown-item">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span>Settings</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo base_url(); ?>Agentlogout" class="dropdown-item">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <style>
            .card {
                min-height: initial;
                margin-bottom: 20px;
            }
        </style>
        
        <!-- Header -->
        <style>
            .icon {
                width: 3rem;
                height: 3rem;
            }
        </style>
<script language="javascript">
  $(document).ready(function()
  {
    //alert("her");
      get_balance();
    getAccessDetails();
   // window.setInterval(gethourlysale, 60000); 
    window.setInterval(get_balance, 60000);
  
    
    setTimeout(function(){$('div.message').fadeOut(1000);}, 5000);
               });
               
               
               
  function get_balance()
  {
    $.ajax({
        type: "GET",
        url: '<?php echo base_url(); ?>/Distributor_new/Dashboard/getBalance',
        cache: false,
            success: function(html)
            {
                //alert(html);
                $("#currentMBal").html(html.split("#")[0]);
                $("#currentMBal2").html(html.split("#")[1]);
            }
        });
        $("#balanceddl").fadeOut(1000);
        $("#balanceddl").fadeIn(2000);
    }
    function getAccessDetails()
    {
        $.ajax({
        type: "GET",
        url: '<?php echo base_url(); ?>/Distributor_new/Dashboard/getAccessDetails',
        cache: false,
            success: function(html)
            {
                var jsonobj = JSON.parse(html);
                for(i=0;i<jsonobj.length;i++)
                {
                    var data_json = jsonobj[i];
                    var tempvar = document.getElementById(data_json);
                    if(tempvar == null)
                    {
                       
                    }
                    else
                    {
                       document.getElementById(data_json).style.display = "block";
                    }
                }
            }
        });
       
    } 
  function gethourlysale()
    {
      
    $.ajax({
          type: "GET",
          url: '<?php echo base_url(); ?>Distributor_new/dashboard/getTodaysHourSale',
          cache: false,
          success: function(html)
          {
            var jsonobj = JSON.parse(html);
            var hourlysale = jsonobj.hourlysale;
            var totalsale = jsonobj.totalsale;
            var totalcount = jsonobj.totalcount;
            var totalcharge = jsonobj.totalcharge;
            
            
            //document.getElementById("spark1").innerHTML = hourlysale;
            //document.getElementById("spark1_totalsale").innerHTML = totalsale;
            //document.getElementById("spark1_totalsale2").innerHTML = totalsale;
            //document.getElementById("spark1_totalcharge").innerHTML = totalcharge;
            
            //document.getElementById("spark1_totalcount").innerHTML = totalcount;
            
            //sidebar
            document.getElementById("sidebargrosssuccess").innerHTML = totalsale;
            
            
            
          },
          complete:function()
          {
          
            $('#spark1').sparkline('html', {
    type: 'bar',
    barWidth: 8,
    height: 30,
    barColor: '#29B0D0',
    chartRangeMax: 12
  });
            //document.getElementById("sp"+tempapiname+"bal").style.display="block";
            //document.getElementById("spin"+tempapiname+"balload").style.display="none";
          } });
    }
  </script>
        <!-- Header -->