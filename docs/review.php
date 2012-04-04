

<!DOCTYPE html>
<html lang="en">
<?php
//session_start();
require 'connect.php';
$sid = $_GET['sid'];
//$submit = $_POST['submit'];

if ($_POST['submit'])
{
	$query_s = "UPDATE SCHEDULE 
		SET STATE=2
		WHERE SID=$sid";
	$ctime = date("dd-mm-yy");
	$result = oci_parse($conn, $query_s);
	oci_execute($result);
	$ctime = date("dd-mm-yy");
	$rating = $_POST['rating'];
	$comment = $_POST['comment'];

	$query_r = "insert into review(sid, rid, rating, comment, ctime)
	values($sid, re_seq.nextval,'$rating','$comment','$ctime')";

	$result = oci_parse($conn, $query_r);
	oci_execute($result);
	oci_close($conn);
	header("Location: member.php");
}
//else{
//	oci_close($conn);
//	header("Location: index.php");
//}
?>
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
	          <li class="active"><a href="sign_in.php">Sign In</a></li>
            </ul>
            <p class="navbar-text pull-right">Logged in as <a href="#">username</a></p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <div class="content">
	<div class="row">
	  <div class="login-form">
	     <h2>Review</h2>
	     <form action="review.php" method="POST">
		<fieldset>
		   <div class="clearfix">
		   	<label><b>Rating</b></label><input type="text" name="rating">
		   </div>	
		   <div class="clearfix">
		   		<div>
		       		<label><b>Comment</b></label>
		       	</div>
		       	<div class="controls">
              		<textarea class="input-xlarge" id="textarea" rows="3" name="comment"></textarea>
            	</div>
		   </div>   
		</fieldset>
		  <input class="btn btn-primary" type="submit" name=submit value="Submit">
	     </form>
	  </div>
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




