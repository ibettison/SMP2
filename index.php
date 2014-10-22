<?php
session_start();
$_SESSION["sessionId"]=session_id();
include("header.inc");
error_reporting(E_ALL);

echo "<div class='row'>";
echo "<div class='row navbar' id='nav1' gumby-fixed='top'>";
echo "<a class='toggle' gumby-trigger='#nav1 > ul' href='#'><i class='icon-menu'></i></a>
  <h1 class='four columns logo'>
    <a href='#'>
      <img src='img/gumby_mainlogo.png' gumby-retina />
    </a>
  </h1>
  <ul class='eight columns'>
    <li><a href='#' id='newSample'>New Sample</a></li>
    <li>
      <a href='#'>Actions</a>
      <div class='dropdown'>
        <ul>
          <li><a href='#' id='sendFTP'>Send Selected via sFTP</a></li>
          <li><a href='#' id='viewSelected'>View/Edit Selected</a></li>
          <li><a href='#' id='deleteFTPFiles'>Delete Selected</a></li>
          <li><a href='#' id='checkResults'>Check for Results</a></li>
        </ul>
      </div>
    </li>
    <li><a href='#'>Settings</a>
    <div class='dropdown'>
        <ul>
          <li><a href='#' id='setconn'>Set connection information</a></li>
          <li><a href='#' id='setftp'>Ftp Settings</a></li>
          <li><a href='#' id='setpw'>Set/Reset Password</a></li>
        </ul>
      </div>
    </li>
     <li><a href='#' id='html_logout'  ><img src='img/exit.png' title='Logout' alt='Logout' /></a>
    </li>
  </ul>
</div>";
echo "</div>";
if(isset($_SESSION["LOGGED_IN"])) {
	include("library/includes/show_display.inc.php");
	include("library/includes/connection.inc.php");
	include("library/includes/ftpConnection.inc.php");
	include("library/includes/show_password.inc.php");
	include("library/includes/samples.inc.php");
	include("library/includes/dialogBox.inc.php");
	include("library/includes/ajax.inc.php");
}else{
	echo "<BR><BR><br><div class='row'>";
		echo "<div class='four columns'></div>";
		echo "<div class='four columns' style='text-align: center;'>Log in to the SMP2 system</div>";
		echo "<div class='four columns'></div>";
	echo "</div>";
	echo "<div class='row'>";
		echo "<div class='four columns'></div>";
		echo "<div class='four columns' style='text-align: center;'>";
			echo "<li class='field'>";
			echo "<input id='entry-password' name='entry-password' class='input' type='password' placeholder='Password' />";
			echo "</li>";
		echo "</div>";
		echo "<div class='four columns'></div>";
	echo "</div>";
	echo "<div class='row'>";
		echo "<div class='four columns'></div>";
		echo "<div class='four columns'>";
		echo "<div style='float:right;' class='medium rounded metro primary btn'><a href='#' id='accept'>Login</a></div>";
		echo "</div>";
		echo "<div class='four columns'></div>";
	echo "</div>";
	include("library/includes/connection.inc.php");
	include("library/includes/ftpConnection.inc.php");
	include("library/includes/show_password.inc.php");
	include("library/includes/ajax.inc.php");
}
/*Message div*/
echo "<div class='row'>";
	echo "<div id='samplesMessage'></div>";
echo "</div>";
/*The bottom spacing to show that the page has ended*/
echo "<div class='bottom_spacer'>";
echo "<div class='bottom_image left'><img src='img/nu_logo.png' style='max-width:100%; max-height: 100%;' /></div>";
echo "<div class='bottom_image left'><img src='img/ecmc_logo.png' style='max-width:100%; max-height: 100%;'  /></div>";
echo "<div class='bottom_image'><img src='img/cancerresearchuk.png' style='max-width:100%; max-height: 100%;'  /></div>";
echo "</div>";
echo "<div class='bottom_surround'>";
echo "<div class='bottom_signature'><a href='mailto:ian.bettison@ncl.ac.uk'>Coding by Ian Bettison</a> (Newcastle University)</div>";
echo "</div>";


