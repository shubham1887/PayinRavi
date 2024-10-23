<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket Plus">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/bracketplus">
    <meta property="og:title" content="Bracket Plus">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/bracketplus/img/bracketplus-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Basic Table Design - Bracket Plus Responsive Bootstrap 4 Admin Template</title>

    <!-- vendor css -->
    <link href="lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
		<link href="lib/highlightjs/styles/github.css" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="css/bracket.css">
  </head>

  <body>

    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href=""><span>[</span>bracket <i>plus</i><span>]</span></a></div>
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
          <a class="breadcrumb-item" href="index.html">Bracket</a>
          <a class="breadcrumb-item" href="#">Tables</a>
          <span class="breadcrumb-item active">Basic Table</span>
        </nav>
      </div><!-- br-pageheader -->
      <div class="br-pagetitle">
        <div>
          <h4>Basic Table</h4>
        </div>
      </div><!-- d-flex -->

      <div class="br-pagebody">
      	<div class="row row-sm mg-t-20">
          <div class="col-sm-6 col-lg-4">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Hardware Monitoring</h6>
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <p class="tx-sm tx-inverse tx-medium mg-b-0">Hardware Monitoring</p>
                <p class="tx-12">Intel Dothraki G125H 2.5GHz</p>
                <div class="row align-items-center">
                  <div class="col-3 tx-12">CPU1</div><!-- col-3 -->
                  <div class="col-9">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-info wd-50p lh-3" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                    </div><!-- progress -->
                  </div><!-- col-9 -->
                </div><!-- row -->
                <div class="row align-items-center mg-t-5">
                  <div class="col-3 tx-12">CPU2</div><!-- col-3 -->
                  <div class="col-9">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-pink wd-90p lh-3" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">90%</div>
                    </div><!-- progress -->
                  </div><!-- col-9 -->
                </div><!-- row -->
                <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
          <div class="col-sm-6 col-lg-4 mg-t-20 mg-sm-t-0">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Sales Monitoring</h6>
                <span class="tx-12 tx-uppercase">March 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <p class="tx-sm tx-inverse tx-medium mg-b-0">Bracket Online Store</p>
                <p class="tx-12"><a href="">http://bracketstore.com</a></p>
                <div class="row align-items-center">
                  <div class="col-3 tx-12 tx-bold">Men</div><!-- col-3 -->
                  <div class="col-9">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-teal wd-50p lh-3" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                    </div><!-- progress -->
                  </div><!-- col-9 -->
                </div><!-- row -->
                <div class="row align-items-center mg-t-5">
                  <div class="col-3 tx-12 tx-bold">Women</div><!-- col-3 -->
                  <div class="col-9">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-info wd-45p lh-3" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                    </div><!-- progress -->
                  </div><!-- col-9 -->
                </div><!-- row -->
                <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
          <div class="col-sm-6 col-lg-4 mg-t-20 mg-lg-t-0">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Site Traffic Monitoring</h6>
                <span class="tx-12 tx-uppercase">April 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <p class="tx-sm tx-inverse tx-medium mg-b-0">Bracket Online Store</p>
                <p class="tx-12"><a href="">http://bracketstore.com</a></p>
                <div class="row align-items-center">
                  <div class="col-4 tx-12 tx-inverse tx-medium">Visits</div>
                  <div class="col-8">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-pink wd-25p lh-3" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                    </div><!-- progress -->
                  </div><!-- col-8 -->
                </div><!-- row -->
                <div class="row align-items-center mg-t-5">
                  <div class="col-4 tx-12 tx-inverse tx-medium">Impressions</div>
                  <div class="col-8">
                    <div class="progress rounded-0 mg-b-0">
                      <div class="progress-bar bg-indigo wd-45p lh-3" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                    </div><!-- progress -->
                  </div><!-- col-8 -->
                </div><!-- row -->
                <p class="tx-11 mg-b-0 mg-t-15">Notice: Lorem ipsum dolor sit amet.</p>
              </div><!-- card-body -->
            </div><!-- card -->
          </div><!-- col-4 -->
        </div>
      
      <div class="row row-sm mg-t-20">
          <div class="col-sm-12 col-lg-12">
         	<div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Hardware Monitoring</h6>
                <span class="tx-12 tx-uppercase">February 2017</span>
              </div><!-- card-header -->
              <div class="card-body">
                <table class="table table-bordered">
              <thead class="thead-colored thead-primary">
                <tr>
                  <th class="wd-10p">ID</th>
                  <th class="wd-35p">Name</th>
                  <th class="wd-35p">Position</th>
                  <th class="wd-20p">Salary</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Tiger Nixon</td>
                  <td>System Architect</td>
                  <td>$320,800</td>
                </tr>
                <tr>
                  <th scope="row">2</th>
                  <td>Garrett Winters</td>
                  <td>Accountant</td>
                  <td>$170,750</td>
                </tr>
              </tbody>
            </table>
              </div><!-- card-body -->
            </div>
         
         
         
        
        </div></div>
      </div><!-- br-pagebody -->
      <?php include("elements/footer.php"); ?>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="lib/moment/min/moment.min.js"></script>
    <script src="lib/peity/jquery.peity.min.js"></script>
    <script src="lib/highlightjs/highlight.pack.min.js"></script>

    <script src="js/bracket.js"></script>
  </body>
</html>
