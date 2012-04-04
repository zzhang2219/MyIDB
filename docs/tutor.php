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
	padding-top: 60px;
	/* 60px to make the container go all the way to the bottom of the topbar */
}
</style>
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
	href="assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
	href="assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed"
	href="assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse"
					data-target=".nav-collapse"> <span class="icon-bar"></span> <span
					class="icon-bar"></span> <span class="icon-bar"></span>
				</a> <a class="brand" href="index.php">MyTutor</a>
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
				</div>
				<!--/.nav-collapse -->
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
					<br /> <br />
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
					<br /> <br />
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
					$id = $_GET["name"];
					$query = "select distinct * from users u,tutor t where u.username='$id' and t.tutorname = '$id'";
					?>

				</div>
				<!--/.well -->
			</div>
			<!--/span-->

			<div class="span9">

				<div class="row-fluid">
					<div class="span9">
						<h2>Tutor Profile</h2>
						<?php
						$s = oci_parse($conn, $query);
						oci_execute($s);
						$name="";
						//Define table layout
						echo "<table class=\"table table-striped\">";
						echo "<tbody>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo "<tr>";
							echo "<td width=160px><img style=\"height:200px;width:140px\" src =".$row['PHOTO']."> <br/><br/>";
							if ($_SESSION["username"]&&$_SESSION["username"]!=$id)
								echo "<a data-toggle=\"modal\" href=\"#myModal\" class=\"btn btn-primary btn-large\">Make a schedule</a><br/><br/>
								<a data-toggle=\"modal\" href=\"#msgModal\"  class=\"btn btn-primary btn-large\"> &nbsp Send Message  &nbsp</a>
								</td>";
							elseif(!$_SESSION["username"])
								echo "<a data-toggle=\"modal\" href=\"#unlogin\" class=\"btn btn-primary btn-large\">Login to contact</a></td>";

							echo "<td> <table><tr>";
							$name=$row['FIRSTNAME']." ".$row['LASTNAME'];
							echo "<td width=300px><h2>".$row['FIRSTNAME']." ".$row['LASTNAME']."</h2></td></tr>";
							echo "<tr><td>Rating: ".$row['RATE']."   Price: $".$row['PRICE']."/Hour</td></tr>";
							echo "<tr><td>".$row['REGION']." ".$row['ZIP']."</td></tr>";
							echo "<tr><td>".$row['ADDRESS']."</td></tr>";
							echo "<tr><td>Email:".$row['EMAIL']." Phone:".$row['PHONE']."</td></tr>";
							echo "<tr><td style=\"width:150px;\">".$row['DESCRIPTION']."</td></tr>";
							echo "</table></td>";
						}
						echo "<td><h3>Main Subject</h3>";
						$query = "select * from tutor_spec ts where ts.tutorname = '$id'";
						$s = oci_parse($conn, $query);
						oci_execute($s);
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo $row['SNAME']."<br/>";
						}
						echo "<br/><h3>Good At </h3><br/>";
						$query = "select * from tutor_tag tt where tt.tutorname = '$id'";
						$s = oci_parse($conn, $query);
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
						echo "</td></tr>";

						echo "<tr><td colspan=3><h3>Education</h3><br/>";
						$query = "select * from tutor_edu te where te.tutorname = '$id'";
						$s = oci_parse($conn, $query);
						oci_execute($s);
						echo "<table width=\"100%\"><tr><th width=\"25%\">School</th><th width=\"25%\">From</th><th width=\"25%\">To</th><th width=\"25%\">Degree</th></tr>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo "<tr><td>".$row['SCHOOL']."</TD><TD>".$row['START_DATE']."</td><TD>".$row['END_DATE']."</td><TD>".$row['DEGREE']."</td></tr>";
						}
						echo "</table></td>";
						
						echo "<tr><td colspan=3><h3>WorkExperience</h3><br/>";
						$query = "select * from tutor_exp te where te.tutorname = '$id'";
						$s = oci_parse($conn, $query);
						oci_execute($s);
						echo "<table width=\"100%\"><tr><th width=\"25%\">Company</th><th width=\"25%\">From</th><th width=\"25%\">To</th><th width=\"25%\">Duty</th></tr>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo "<tr><td>".$row['COMPANY']."</TD><TD>".$row['STARTDATE']."</td><TD>".$row['ENDDATE']."</td><TD>".$row['DESCRIPTION']."</td></tr>";
						}
						echo "</table></td>";
						
						echo "<tr><td colspan=3><h3>Sample Material</h3><br/>";
						$query = "select * from teachsample te where te.tutorname = '$id'";
						$s = oci_parse($conn, $query);
						oci_execute($s);
						echo "<table width=\"100%\"><tr><th width=\"25%\">SampleName</th><th width=\"25%\" align=\"middle\">Type</th><th width=\"25%\" align=\"middle\">Description</th><th width=\"25%\">Download Path</th></tr>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo "<tr><td>".$row['SAMPLENAME']."</TD><TD>".$row['MATERIALTYPE']."</td><TD>".$row['DESCRIPTION']."</td><TD>".$row['PATH']."</td></tr>";
						}
						echo "</table></td>";
						
						echo "<tr><td colspan=3><h3>Review</h3><br/>";
						$query = "select u.lastname,re.comments,re.ctime,re.rate FROM review re,schedule sch,users u where sch.tutorname = '$id' and sch.username=u.username and re.sid=sch.sid";
						$s = oci_parse($conn, $query);
						oci_execute($s);
						echo "<table width=\"100%\"><tr><th width=\"25%\">User</th><th width=\"50%\" >Comments</th><th width=\"10%\">Rating</th><th width=\"15%\">Date</th></tr>";
						while (($row = oci_fetch_array($s, OCI_ASSOC)))
						{
							echo "<tr><td>".$row['LASTNAME']."</TD><TD>".$row['COMMENTS']."</td><TD>".$row['RATE']."</td><TD>".$row['CTIME']."</td></tr>";
						}
						echo "</table></td>";
						echo "</tbody></table>";
						?>
						<div id="msgModal" class="modal hide fade">
							<div class="modal-header">
								<a class="close" data-dismiss="modal">&times;</a>
								<h3>
									Message to
									<?php echo $name?>
								</h3>
							</div>
							<div class="modal-body">
								<form action="msg.php" method="POST">
									<fieldset>
										<div class="clearfix">
											<label><b>Receiver</b> </label><input type="text"
												name="receiver" value="<?php echo $id?>" readonly="readonly">
										</div>
										<div class="clearfix">
											<label><b>Topic</b> </label><input type="text" name="topic">
										</div>
										<div class="clearfix">
											<div>
												<label><b>Content</b> </label>
											</div>
											<div class="controls">
												<textarea class="input-xlarge" id="textarea" rows="3"
													name="content"></textarea>
											</div>
										</div>
									</fieldset>
									<div class="modal-footer">
										<a href="#" class="btn" data-dismiss="modal">Close</a> <input
											class="btn btn-primary" type="submit" name=send value="Send">
									</div>
								</form>
							</div>
						</div>

					</div>


					<div id="unlogin" class="modal hide fade" style="display: block;">
						<div class="modal-header">
							<a class="close" data-dismiss="modal">×</a>
							<h3>Please Login!</h3>
							<div class="modal-body">
								<a href="sign_in.php">Login In</a>
							</div>
						</div>
					</div>
					<div id="myModal" class="modal hide fade" style="display: block;">
						<form action="schedule.php" method="POST">
							<div class="modal-header">
								<a class="close" data-dismiss="modal">×</a>
								<h3>Make Schedule</h3>
							</div>
							<div class="modal-body">
								<table>
									<tr>
										<td>Tutor:<input style="width: 100px" type="text"
											placeholder="Tutorname" name="tname" value="<?php echo $id?>"
											readonly="readonly">
										</td>
										<td>User:<input style="width: 150px" type="text"
											placeholder="Username" name="uname"
											value="<?php echo $_SESSION["username"]?>"
											readonly="readonly">
										</td>
									</tr>
									<tr>
										<td>Subject:<select name="spec" style="width: 100px">
												<?php 
												$query = "select * from tutor_spec ts where ts.tutorname = '$id'";
												echo $query;
												$s = oci_parse($conn, $query);
												oci_execute($s);
												while (($row = oci_fetch_array($s, OCI_ASSOC)))
												{
													echo "<option value=\"".$row['SNAME']."\">".$row['SNAME']."</option>";
												}

												oci_free_statement($s);
												oci_close($conn);
												?>
										</select>
										</td>
										<td>Period: <input type="text" placeholder="tp" name="tptime"
											style="width: 150px">
									
									</tr>
									<tr>
										<td>Price: <input type="text" placeholder="price" name="price"
											style="width: 100px">
										</td>
										<td>Date: <input type="text" placeholder="date" name="date"
											style="width: 150px">
										</td>
									</tr>
								</table>

							</div>

							<div class="modal-footer">
								<a href="#" class="btn" data-dismiss="modal">Close</a>
								<button class="btn btn-primary" type="submit">Send Request</button>
							</div>
						</form>
					</div>

				</div>
				<!--/span-->
			</div>
			<!--/row-->
		</div>
		<!--/span-->
	</div>
	<!--/row-->
	</div>
	<!--/.fluid-container-->

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
