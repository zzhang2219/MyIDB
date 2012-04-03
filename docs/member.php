
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
	          <li class="active"><a href="logout.php">Sign Out</a></li>
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

    <div class="container">
      <div class="content">
		<div class="row">
		  <ul id="tab" class="nav nav-tabs">
    		<li><a href="#profile" data-toggle="tab">Profile</a></li>
    		<li><a href="#messages" data-toggle="tab">Messages</a></li>
    		<li><a href="#setting" data-toggle="tab">Setting</a></li>
    	  </ul>
    	  <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="profile">
              	<div class="row">
              	  <div class="span8">
              	    <form class="form-horizontal"> 
              	      <fieldset>             
              	    <?php
                	session_start();
                	require 'connect.php';
                	$username = $_SESSION['username'];
                	$query = "select * from users U where U.username='$username'";
                	//echo $query;
                	$s = oci_parse($conn, $query);
	    			oci_execute($s); 

	    			while(($row = oci_fetch_array($s, OCI_ASSOC)))
	    			{
              			echo "<div><td>Username:</td><td> </td><td>".$row['USERNAME']."</td></div>";
              			echo "<div><td>Firstname:</td><td> </td><td>".$row['FIRSTNAME']."</td></div>";
              			echo "<div><td>Lastname:</td><td> </td><td>".$row['LASTNAME']."</td></div>";
              			echo "<div><td>Gender:</td><td> </td><td>".$row['GENDER']."</td></div>";
              			echo "<div><td>Email:</td><td> </td><td>".$row['EMAIL']."</td></div>";
              			echo "<div><td>Phone:</td><td> </td><td>".$row['PHONE']."</td></div>";
              			
              			$username = $row['USERNAME'];
              			$password = $row['PASSWORD'];
              			$firstname = $row['FIRSTNAME'];
              			$lastname = $row['LASTNAME'];
              			$phone = $row['PHONE'];
              			$email = $row['EMAIL'];
              			$gender = $row['GENDER'];
    
	    			}
	    			oci_free_statement($s);
              		?>
              	      </fieldset>
              	    </form>
              	  </div>
              	</div>
            </div>
            <div class="tab-pane fade" id="messages">
              <p>
              <?php 
              	require 'connect.php';
              	$stat = "select * from message M where M.sender='$username' or M.receiver='$username'";
              	$result = oci_parse($conn, $stat);
              	oci_execute($result);
              	echo "<table class=\"table table-striped\"><thead><tr><th>Sender</th><th>Receiver</th><th>Topic</th><th>Content</th><th>Time</th></tr></thead>";
	    		echo "<tbody>";
	    		while (($mrow = oci_fetch_array($result, OCI_ASSOC)))
	    		{
	    			echo "<tr>";
	    			echo "<td>".$mrow['SENDER']."</td>";
	    			echo "<td>".$mrow['RECEIVER']."</td>";
	    			echo "<td>".$mrow['TOPIC']."</td>";
	    			echo "<td>".$mrow['CONTENT']."</td>";
	    			echo "<td>".$mrow['MTIME']."</td>";
	    			echo "</tr>";
	    		}
	    		echo "</tbody></table>";
	    		oci_free_statement($result);
              ?>
              <div id="myModal" class="modal hide fade">
            	<div class="modal-header">
              		<a class="close" data-dismiss="modal" >&times;</a>
              		<h3>Message</h3>
            	</div>
              	<div class="modal-body">
              		<form action="msg.php" method="POST">
						<fieldset>
		   				<div class="clearfix">
		      	  			<label><b>Receiver</b></label><input type="text" name="receiver">
		   				</div>
		   				<div class="clearfix">
		       	  			<label><b>Topic</b></label><input type="text" name="topic">
		   				</div>
		   				<div class="clearfix">
		   					<div>
		       	  				<label><b>Content</b></label>
		       	  			</div>
		       	  			<div class="controls">
              					<textarea class="input-xlarge" id="textarea" rows="3" name="content"></textarea>
            				</div>
		   				</div>
		   				</fieldset>
		   					<div class="modal-footer">
              					<a href="#" class="btn" data-dismiss="modal" >Close</a>
              					<input class="btn btn-primary" type="submit" name=send value="Send">
            				</div>
		   			</form>
            	</div>
          		</div>
          		<a data-toggle="modal" href="#myModal" class="btn btn-primary btn-large">Send Message</a>
              	</p>
            </div>  
            <div class="tab-pane fade" id="setting">
              <p>
				<div class="container">
      <div class="content">
		<div class="row">
	  	   <div class="login-form">
	     	  <h2>Update Information</h2>
	     	  <form class="well" action="update.php" method="POST">
				<fieldset>
		   		<div class="clearfix">
		       	  <label><b>Firstname</b></label><input type="text" name="firstname" value=<?php echo $firstname ?>>
		   		</div>
		   		<div class="clearfix">
		       	  <label><b>Lastname</b></label><input type="text" name="lastname" value=<?php echo $lastname ?>>
    		    </div>
		   		<div class="clearfix">
 		      	  <label><b>Password</b></label><input type="password" name="password" value=<?php echo $password ?>>
		   		</div>
		   	    <div class="clearfix">
		      	  <label><b>Phone</b></label><input type="text" name="phone" value=<?php echo $phone ?>>
                </div>
	       	    <div class="clearfix">
		      	  <label><b>Profile Picture</b></label><input type="text" name="picture">
		   	    </div>  
			  </fieldset>
			  <input class="btn" type="submit" name=update value="Update">
	  		</form>
	  	  </div>
		</div>
      </div>
    </div> <!-- /container -->
              </p>
            </div>
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



