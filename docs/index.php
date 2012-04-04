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
	          <?php
	          require "connect.php";
	          session_start();
	          if ($_SESSION['username'])
	          {
	          	echo "<li class=\"active\"><a href=\"logout.php\">Sign Out</a></li>";
	          }
	          else 
	          {
	          	echo "<li class=\"active\"><a href=\"sign_in.php\">Sign In</a></li>";
	          }
	          ?>
            </ul>
            <p class="navbar-text pull-right">
		    <?php     
		    session_start();       
            if ($_SESSION["username"])
            {
            	echo "Login As <a href=\"member.php\">".$_SESSION['username']."</a>";
            }
            ?>
            </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
         <div class="row-fluid">
           <form class="form-search">
           	<input type="text" class="input-medium search-query">
			<button type="submit" class="btn">Search</button>
           </form>
          </div>
      <div class="row-fluid">
        <div class="span3">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Choose a subject</li>
             
            <?php     
		    $s = oci_parse($conn, 'select * from Speciality');
		    oci_execute($s);
		    
		    while (($row = oci_fetch_array($s, OCI_ASSOC)))
            {
            	echo "<li><a href=\"#\">".$row['SNAME']."</a></li>";
            	
            }
            ?>
          </ul>
          <br/> <br/>
            <ul class="nav nav-list">
              <li class="nav-header">Most Popular Topics</li>
            <?php     
		    session_start();
		    $s = oci_parse($conn, 'select * from tag order by count');
		    oci_execute($s);
			   
            while (($row = oci_fetch_array($s, OCI_ASSOC)))
            {
            	if($row['SNAME']=='COMPUTER PROGRAMMING')
            	echo "<button class=\"btn btn-success\" href=\"#\">".$row['TAGNAME']."</button> ";
            	else if($row['SNAME']=='MATH')
            	echo "<button class=\"btn btn-info\" href=\"#\">".$row['TAGNAME']."</button> ";
            	else 
            	echo "<button class=\"btn btn-inverse\" href=\"#\">".$row['TAGNAME']."</button> ";
            }
            ?>
                      
            </ul>
            <br/><br/>  
            <?php  if ($_SESSION["username"]) {
            echo "<ul class=\"nav nav-list\"> <li class=\"nav-header\">You may interested in:</li>";
                   
            	$username=$_SESSION["username"];
            	$query = "select * from preference p where p.username = '$username'";
            	$s = oci_parse($conn, $query);
            	oci_execute($s);
            	while (($row = oci_fetch_array($s, OCI_ASSOC)))
            	{
            		echo "<li><a href=\"#\">".$row['SNAME']."</a></li>";
            	}
            }
            echo "</ul>";
            ?>
           
          </div><!--/.well -->
        </div><!--/span-->
        
        <div class="span9">

          <div class="row-fluid">
            <div class="span9">
              <h2>Top Tutors in New York</h2>
						<?php
						$s = oci_parse($conn, 'select * from users u, tutor t where u.istutor=1 and u.username=t.tutorname order by t.rate');
						oci_execute($s);
						//Define table layout
						echo "<table class=\"table table-striped\">";
						echo "<tbody>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							$uname=$row['USERNAME'];
							echo "<tr>";
							echo "<td width=160px><img style=\"height:200px;width:140px\" src =".$row['PHOTO']."></td>";
							echo "<td> <table><tr>";
							echo "<td width=300px><a href=\"tutor.php?name=".$row['USERNAME']."\"><h2>".$row['FIRSTNAME']." ".$row['LASTNAME']."</h2></a>Rating: ".$row['RATE']."</td></tr>";
							echo "<tr><td>".$row['REGION']." ".$row['ZIP']."</td></tr>";
							echo "<tr><td>".$row['EMAIL']." ".$row['PHONE']."</td></tr>";
							echo "<tr><td colspan=2 style=\"width:150px;\">".$row['DESCRIPTION']."</td></tr>"; 
							echo "</table></td>";
							echo "<td><h3>Main Subject</h3>";
							$querys = "select * from tutor_spec ts where ts.tutorname = '".$uname."'";
							$ss = oci_parse($conn, $querys);
							oci_execute($ss);
							while (($rows = oci_fetch_array($ss, OCI_ASSOC)))
							{
								echo $rows['SNAME']."<br/>";
							}
							echo "<br/><h3>Good At </h3><br/>";
							$queryt = "select * from tutor_tag tt where tt.tutorname = '".$uname."'";
							$st = oci_parse($conn, $queryt);
							oci_execute($st);
							while (($rowt = oci_fetch_array($st, OCI_ASSOC)))
							{
								if($rowt['SNAME']=='COMPUTER PROGRAMMING')
									echo "<button class=\"btn btn-success\" href=\"#\">".$rowt['TAGNAME']."</button> ";
								else if($rowt['SNAME']=='MATH')
									echo "<button class=\"btn btn-info\" href=\"#\">".$rowt['TAGNAME']."</button> ";
								else
									echo "<button class=\"btn btn-inverse\" href=\"#\">".$rowt['TAGNAME']."</button> ";
							}
							echo "</td></tr>";
						}
						echo "</tbody></table>";
						 
						oci_free_statement($s);
						oci_close($conn);
						?>
						
							
            </div><!--/span-->
          </div><!--/row-->
        </div><!--/span-->
      </div><!--/row-->
    </div><!--/.fluid-container-->

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
