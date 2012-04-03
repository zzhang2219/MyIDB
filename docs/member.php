
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
            	$username = $_SESSION["username"];
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
    		<li><a href="#myschedule" data-toggle="tab">MySchedule</a></li>
    		<?php
    			session_start();
    			require 'connect.php';
    			$q = "select * from users U where U.username='$username'";
    			$res = oci_parse($conn, $q);
    			oci_execute($res);
    			while(($row = oci_fetch_array($res, OCI_ASSOC)))
    			{
    				if ($row["ISTUTOR"]==1)
    				{
    					$istutor = 1;
    				}
    				else 
    					$istutor = 0;
    			} 
    			
    			if($istutor==1)
    			{
    				echo "<li><a href=\"#myedu\" data-toggle=\"tab\">MyEducation</a></li>";
    				echo "<li><a href=\"#myexp\" data-toggle=\"tab\">MyExperience</a></li>";
    			}
    			
    		?>
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
	    				echo "<div class=\"span6\">";
              			echo "<table class=\"table\"\"><div><tr><td><strong>Username</strong></td><td>".$row['USERNAME']."</td></tr></div>";
              			echo "<div><tr><td><strong>Firstname</strong></td><td>".$row['FIRSTNAME']."</td></tr></div>";
              			echo "<div><tr><td><strong>Lastname</strong></td><td>".$row['LASTNAME']."</td></tr></div>";
              			echo "<div><tr><td><strong>Gender</strong></td><td>".$row['GENDER']."</td></tr></div>";
              			echo "<div><tr><td><strong>Email</strong></td><td>".$row['EMAIL']."</td></tr></div>";
              			echo "<div><tr><td><strong>Phone<strong></td><td>".$row['PHONE']."</td></tr></div></table>";
              			echo "</div>";
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
              	    <div id="tutorModal" class="modal hide fade">
            	<div class="modal-header">
              		<a class="close" data-dismiss="modal" >&times;</a>
              		<h3>Become a Tutor</h3>
            	</div>
              	<div class="modal-body">
              		<form action="regtutor.php" method="POST">
						<fieldset>
		   				<div class="clearfix">
		      	  			<label><b>Address</b></label><input type="text" name="address">
		   				</div>
		   				<div class="clearfix">
		       	  			<label><b>Zip Code</b></label><input type="text" name="zip">
		   				</div>
		   				<div class="clearfix">
		   					<div>
		       	  				<label><b>Description</b></label>
		       	  			</div>
		       	  			<div class="controls">
              					<textarea class="input-xlarge" id="textarea" rows="3" name="description"></textarea>
            				</div>
		   				</div>
		   				<div class="clearfix">
		       	  			<label><b>Price</b></label><input type="text" name="price">
		   				</div>
		   				<div class="control-group">
            				<label class="control-label" for="optionsCheckboxList"><b>Checkboxes</b></label>
            				<div class="controls">
            					<?php 
            					require 'connect.php';
            					$query = "select distinct sname from speciality";     
                				$s = oci_parse($conn, $query);
	    						oci_execute($s); 
	    						while (($row = oci_fetch_array($s, OCI_ASSOC)))
	    						{
             						echo "<label class=\"checkbox\">";
                					echo "<input type=\"checkbox\" name=\"options[]\" value=\"" .$row["SNAME"]."\">";
                				    echo $row["SNAME"];
 									echo "</label>";
	    						}
              					?>
              					<p class="help-block"><strong>Note:</strong> At least one specialty has been selected</p>
            				</div>
          				</div>
		   				</fieldset>
		   					<div class="modal-footer">
              					<a href="#" class="btn" data-dismiss="modal" >Close</a>
              					<input class="btn btn-primary" type="submit" name=submit value="Submit">
            				</div>
		   			</form>
            	</div>
          		</div>
          		<?php  
          			if ($istutor==0)
          			{
          				echo "<a data-toggle=\"modal\" href=\"#tutorModal\" class=\"btn btn-primary btn-large\">Become a Tutor!</a>"; 
          			}
          		?>
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
	     	  <form class="well" action=<?php
	     	  	 if ($istutor==0)
	     	  	 {
	     	  	 	echo "\"update.php\"";
	     	  	 } 
	     	  	 else
	     	  	 {
	     	  	 	echo "\"tutorupdate.php\"";
	     	  	 } 
	     	  	 	?> method="POST">
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
                <?php
                	if ($istutor==1)
                	{
                		require 'connect.php';
                		$tutorname = $username;
                		$query = "select * from tutor where tutorname = '$tutorname'";
                		$res = oci_parse($conn, $query);
                		oci_execute($res);
                		$row = oci_fetch_array($res, OCI_ASSOC);
                		echo "<div class=\"clearfix\">";
                		echo "<label><b>Address</b></label><input type=\"text\" name=\"address\" value=\"".$row['ADDRESS']."\">";
                		echo "</div>";
                		echo "<div class=\"clearfix\">";
                		echo "<label><b>Zip Code</b></label><input type=\"text\" name=\"zip\" value=\"".$row['ZIP']."\">";
                		echo "</div>";
                		echo "<div class=\"clearfix\">";
                		echo "<label><b>Price</b></label><input type=\"text\" name=\"price\" value=\"".$row['PRICE']."\">";
                		echo "</div>";
                	} 
                ?>
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

	<div class="tab-pane fade" id="myschedule">
	  <div class="row">
		<div class="span8">
		<?php 
            require 'connect.php';
            $stat1 = "select * from schedule S where S.username='$username'";
            $stat2 = "select * from schedule S where S.tutorname='$username'";
            $result = oci_parse($conn, $stat1);
            oci_execute($result);
            echo "<div class=\"row\">";
            echo "<div class=\"span6\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>Sid</th><th>Tutorname</th><th>Username</th><th>Specialty</th><th>Price</th><th>StartDate</th><th>Length</th><th></th></tr></thead>";
	    	echo "<tbody>";
	    	while (($mrow = oci_fetch_array($result, OCI_ASSOC)))
	    	{
	    		echo "<tr>";
	    		echo "<td>".$mrow['SID']."</td>";
	    		echo "<td>".$mrow['TUTORNAME']."</td>";
	    		echo "<td>".$mrow['USERNAME']."</td>";
	    		echo "<td>".$mrow['SNAME']."</td>";
	    		echo "<td>$".$mrow['PRICE']."</td>";
	    		echo "<td>".$mrow['SDATE']."</td>";
	    		echo "<td>".$mrow['TIMEPERIOD']."min</td>";
	    		if ($mrow['STATE']==1)
	    		{
	    			echo "<td><button class=\"bnt\" type=\"submit\">Review</button></td>";
	    		}
	    		echo "</tr>";
	    	}
	    	echo "</tbody></table>";
	    	echo "</div>";
	    	echo "</div>";
	    	echo "<div class=\"row\">";
	    	echo "<div class=\"span6\">";
	    	echo "<table class=\"table table-striped\"><thead><tr><th>Sid</th><th>Tutorname</th><th>Username</th><th>Specialty</th><th>Price</th><th>StartDate</th><th>Length</th><th></th></tr></thead>";
	    	echo "<tbody>";
	    	$result = oci_parse($conn, $stat2);
            oci_execute($result);
            while (($mrow = oci_fetch_array($result, OCI_ASSOC)))
	    	{
	    		echo "<tr>";
	    		echo "<td>".$mrow['SID']."</td>";
	    		echo "<td>".$mrow['TUTORNAME']."</td>";
	    		echo "<td>".$mrow['USERNAME']."</td>";
	    		echo "<td>".$mrow['SNAME']."</td>";
	    		echo "<td>$".$mrow['PRICE']."</td>";
	    		echo "<td>".$mrow['SDATE']."</td>";
	    		echo "<td>".$mrow['TIMEPERIOD']."min</td>";
	    		if ($mrow['STATE']==0)
	    		{
	    			echo "<td><button class=\"bnt\" type=\"submit\">Accept</button></td>";
	    		}
	    		echo "</tr>";
	    	}
            echo "</tbody></table>";
	    	echo "</div>";
	    	echo "</div>";
	    	oci_free_statement($result);
        ?>
		</div>
	  </div>
	</div>
	<div class="tab-pane fade" id="myedu">
	  <div class="row">
		<div class="span8">
		<?php 
			if($istutor)
			{
            require 'connect.php';
            $stat = "select * from TUTOR_EDU T where T.TUTORNAME='$username'";
            $result = oci_parse($conn, $stat);
            oci_execute($result);
            echo "<div class=\"row\">";
            echo "<div class=\"span6\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>ID</th><th>School</th><th>Start_Date</th><th>End_Date</th></tr></thead>";
	    	echo "<tbody>";
	    	$id = 1;
	    	while (($mrow = oci_fetch_array($result, OCI_ASSOC)))
	    	{
	    		echo "<tr>";
	    		echo "<td>".$id++."</td>";
	    		echo "<td>".$mrow['SCHOOL']."</td>";
	    		echo "<td>".$mrow['START_DATE']."</td>";
	    		echo "<td>".$mrow['END_DATE']."</td>";
	    		echo "</tr>";
	    	}
	    	echo "</tbody></table>";
	    	echo "</div>";
	    	echo "</div>";
	    	
	    	oci_free_statement($result);
			}
        ?>
		</div>
	  </div>
	  <!-- ADD NEW EDUCATION RECORD -->
              <div id="ADDEDUModal" class="modal hide fade">
            	<div class="modal-header">
              		<a class="close" data-dismiss="modal" >&times;</a>
              		<h3>Message</h3>
            	</div>
              	<div class="modal-body">
              		<form action="addedu.php" method="POST">
						<fieldset>
		   				<div class="clearfix">
		      	  			<label><b>School</b></label><input type="text" name="school">
		   				</div>
		   				<div class="clearfix">
		       	  			<label><b>Start Date</b></label><input data-datepicker="datepicker" type="text" name="start_date" id="start_date">
		   				</div>
						<div class="clearfix">
		       	  			<label><b>End Date</b></label><input data-datepicker="datepicker" type="text" name="end_date" id="end_date">
		   				</div>
		   				</fieldset>
		   					<div class="modal-footer">
              					<a href="#" class="btn" data-dismiss="modal" >Close</a>
              					<input class="btn btn-primary" type="submit" name="submit" value="Submit">
            				</div>
		   			</form>
            	</div>
          		</div>
          		<a data-toggle="modal" href="#ADDEDUModal" class="btn btn-primary btn-large">Add another one</a>	  
          		<!--END -->
	</div>
	<div class="tab-pane fade" id="myexp">
	  <div class="row">
		<div class="span8">
		<?php 
			if($istutor)
			{
            require 'connect.php';
            $stat = "select * from TUTOR_EXP T where T.TUTORNAME='$username'";
            $result = oci_parse($conn, $stat);
            oci_execute($result);
            echo "<div class=\"row\">";
            echo "<div class=\"span6\">";
            echo "<table class=\"table table-striped\"><thead><tr><th>ID</th><th>Company</th><th>Start_Date</th><th>End_Date</th><th>Description</th></tr></thead>";
	    	echo "<tbody>";
	    	$id = 1;
	    	while (($mrow = oci_fetch_array($result, OCI_ASSOC)))
	    	{
	    		echo "<tr>";
	    		echo "<td>".$id++."</td>";
	    		echo "<td>".$mrow['COMPANY']."</td>";
	    		echo "<td>".$mrow['STARTDATE']."</td>";
	    		echo "<td>".$mrow['ENDDATE']."</td>";
	    		echo "<td>".$mrow['DESCRIPTION']."</td>";
	    		echo "</tr>";
	    	}
	    	echo "</tbody></table>";
	    	echo "</div>";
	    	echo "</div>";
	    	
	    	oci_free_statement($result);
			}
        ?>
		</div>
	  </div>
	  	  <!-- ADD NEW EDUCATION RECORD -->
              <div id="ADDEXPModal" class="modal hide fade">
            	<div class="modal-header">
              		<a class="close" data-dismiss="modal" >&times;</a>
              		<h3>Message</h3>
            	</div>
              	<div class="modal-body">
              		<form action="addexp.php" method="POST">
						<fieldset>
		   				<div class="clearfix">
		      	  			<label><b>Company</b></label><input type="text" name="company">
		   				</div>
		   				<div class="clearfix">
		       	  			<label><b>Start Date</b></label><input data-datepicker="datepicker" type="text" name="start_date" id="start_date">
		   				</div>
						<div class="clearfix">
		       	  			<label><b>End Date</b></label><input data-datepicker="datepicker" type="text" name="end_date" id="end_date">
		   				</div>
		   				<div class="clearfix">
		   					<div>
		       	  				<label><b>Description</b></label>
		       	  			</div>
		       	  			<div class="controls">
              					<textarea class="input-xlarge" id="textarea" rows="3" name="description"></textarea>
            				</div>
		   				</div>
		   				</fieldset>
		   					<div class="modal-footer">
              					<a href="#" class="btn" data-dismiss="modal" >Close</a>
              					<input class="btn btn-primary" type="submit" name="submit" value="Submit">
            				</div>
		   			</form>
            	</div>
          		</div>
          		<a data-toggle="modal" href="#ADDEXPModal" class="btn btn-primary btn-large">Add another one</a>	  
          		<!--END -->
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
    <script src="assets/js/bootstrap-datepicker.js"></script>
    
    

  </body>
</html>



