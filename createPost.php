<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Formula 1 Talk</title>
   <link rel="stylesheet" href="css/index.css"/>
   <link rel="stylesheet" href="css/createPost.css"/>
   <link rel="stylesheet" href="css/nav.css"/>
</head>
<body>
<?php
session_start();
if (!isset( $_SESSION['username'] ) ){
	header("Location: http://cosc360.ok.ubc.ca/28723147/Project/logIn.php"); /* Redirect browser */
	exit;
} else {
?> 
	<div id="body_wrapper">
	<header id="masthead">
		<figure>
		  <img src="img/logo.jpg" width="75" height="50" alt="Formula 1 Logo" />
		</figure>
		<h1>Formula 1 Talk</h1>
		<div class="menu">
			<nav>
				<ul>
					<li><a href="viewProfile.php">View profile: <?php echo $_SESSION['username']?> </a></li>
					<li><a href="indexUser.php">View All Posts</a></li>
					<li><a href="signUp.php">Create Account</a></li>
					<li><a href="logIn.php">Log-in</a></li>
					<li><a href="logOut.php">Log out</a></li>
				</ul>
			</nav>
		</div>
	</header>
	  <div id="rightcolumn">
		<!-- Start Page Header -->
		<div id="page_header">
		  <h1><span><h1>Formula 1 Talk</h1></span></h1>
		</div>
		<!-- End of Page Header -->
		<!-- Start of Center Column -->
		<div id="centercolumn">
		  <div id="centercolumn_2">
			<div class="createPost">
				<form method="post" action="processPost.php">
					<h2>Create a post</h2>
					<div>
						<input class="formControl" type="text" name="title" placeholder="Title"></div>
					<div>
						<input class="formControl" type="text" name="topic" placeholder="Topic of Post"></div>
					<div>
						<textarea class="formControl2" cols="30" rows="10" name="message" placeholder="Message"></textarea>
					</div>
					<div>
						<input class="primaryButton" type="submit" value="Post">
					</div>
				</form>
			</div>
			<div class="footer">
				<footer>
					<p class="copyright">&copy; Copyright 2017 Norbert Eke</p>	
				</footer>
			</div>
			<!-- End of News Box 2 -->
		  </div>
		</div>
		<!-- End of Center Column -->
		<!-- Start of Right Sidebar -->
		<div id="rightsidebar">
		  <!-- Start of Team Roster -->
		  <div id="driver_roster">
			<div id="drivers_header">
			  <h2><span>Drivers</span></h2>
			</div>
			<div id="drivers_content">
			  <ul>
				<li id="hamilton"><a href="http://www.lewishamilton.com">Lewis Hamilton</a></li>
				<li id="bottas"><a href="http://www.lewishamilton.com">Valtteri Bottas</a></li>
				<li id="ricciardo"><a href="http://www.lewishamilton.com">Daniel Ricciardo</a></li>
				<li id="verstappen"><a href="http://www.lewishamilton.com">Max Verstappen</a></li>
				<li id="kimi"><a href="http://www.lewishamilton.com">Kimi Raikkonen</a></li>
				<li id="vettel"><a href="http://www.lewishamilton.com">Sebastian Vettel</a></li>
				<li id="perez"><a href="http://www.lewishamilton.com">Sergio Perez</a></li>
				<li id="ocon"><a href="http://www.lewishamilton.com">Esteban Ocon</a></li>
				<li id="massa"><a href="http://www.lewishamilton.com">Felipe Massa</a></li>
				<li id="stroll"><a href="http://www.lewishamilton.com">Lance Stroll</a></li>
				<li id="vandoorne"><a href="http://www.lewishamilton.com">Stoffel Vandoorne</a></li>
				<li id="alonso"><a href="http://www.lewishamilton.com">Fernando Alonso</a></li>
				<li id="hulkenberg"><a href="http://www.lewishamilton.com">Nico Hulkenberg</a></li>
				<li id="palmer"><a href="http://www.lewishamilton.com">Jolyon Palmer</a></li>
				<li id="kvyat"><a href="http://www.lewishamilton.com">Daniil Kvyat</a></li>
				<li id="sainz"><a href="http://www.lewishamilton.com">Carlos Sainz</a></li>
				<li id="magnussen"><a href="http://www.lewishamilton.com">Kevin Magnussen</a></li>
				<li id="grosjean"><a href="http://www.lewishamilton.com">Romain Grosjean</a></li>
				<li id="wehrlein"><a href="http://www.lewishamilton.com">Pascal Wehrlein</a></li>
				<li id="ericcson"><a href="http://www.lewishamilton.com">Marcus Ericsson</a></li>
			  </ul>
			  <div class="clearthis">&nbsp;</div>
			</div>
		  </div>
		  <!-- End of Team Roster -->
		</div>
		<!-- End of Right Sidebar -->
		<div class="clearthis">&nbsp;</div>
	  </div>
	  <!-- Start of Left Column -->
	  <div id="leftcolumn">
		<!-- Start of Left Sidebar -->
		<div id="leftsidebar">
		  <h3>Search: </h3>
		  
		  <div class="search">
				<form method="post" action="processSearch.php">
					<fieldset>
						<input id="searchBar" type="search" name="keyword" placeholder="enter keyword"/><input type="submit">
					</fieldset>
				</form>
				<br></br>
		  </div>
		  <!-- Start of Latest Matches -->
		  <div id="latestmatch">
			<h2><span>Discussion Topics:</h2></span>
			<ul>
				<li><a href="http://www.mercedesamgf1.com">Mercedes AMG Petronas</a></li>
				<li><a href="http://www.redbullracing.com">Reb Bull Tag-Hauer</a></li>
				<li><a href="http://www.formula1.ferrari.com/en/">Scuderia Ferrari</a></li>
				<li><a href="http://www.forceindiaf1.com">Force India Mercedes</a></li>
				<li><a href="http://www.williamsf1.com">Williams Mercedes</a></li>
				<li><a href="http://www.mclaren.com/formula1/">McLaren Honda</a></li>
				<li><a href="http://www.scuderiatororosso.com">Toro Rosso Ferrari</a></li>
				<li><a href="http://www.haasf1team.com/">Haas GP</a></li>
				<li><a href="http://www.scuderiatororosso.com">Sauber Ferrari</a></li>
				<li><a href="http://www.renaultsport.com">Renault</a></li>
			</ul>
			<div class="clearthis">&nbsp;</div>
		  </div>
		  <!-- End of Latest Matches -->
		</div>
		<!-- End of Left Sidebar -->
	  </div>
	  <!-- End of Left Column -->
	  <div class="clearthis">&nbsp;</div>
	  <!-- Start of Page Footer -->
	</div>
<?php
}
?>
</body>
</html>