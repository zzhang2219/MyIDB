<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MyTutor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="index.php">MyTutor</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li class="active"><a href="about.php">About</a></li>
              <li class="active"><a href="contact.php">Contact</a></li>
	      <li class="active"><a href="list.php">List</a></li>
            </ul>
              <p class="navbar-text pull-right">Logged in as <a href="#">username</a></p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="content">
	<div class="row">
	 <?php

	    require "connect.php";

	    $s = oci_parse($conn, 'select * from review');
	    oci_execute($s);
	    //Define table layout
	    echo "<table class=\"table table-striped\"><thead><tr><th>sid</th><th>rid</th><th>Rating</th><th>Comment</th><th>Ctime</th></tr></thead>";
	    echo "<tbody>";
	    while (($row = oci_fetch_array($s, OCI_ASSOC)))
	    {
	    	echo "<tr>";
	    	echo "<td>".$row['SID']."</td>";
	    	echo "<td>".$row['RID']."</td>";
	    	echo "<td>".$row['RATE']."</td>";
	    	echo "<td>".$row['COMMENTS']."</td>";
	    	echo "<td>".$row['CTIME']."</td>";
	    	echo "</tr>";
	
	    }
	    echo "</tbody></table>";
	    
	    oci_free_statement($s);
	    oci_close($conn);
	?> 
	</div>
      </div>
    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>


