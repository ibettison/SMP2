
<?php
include("header.inc");
error_reporting(E_ALL);
set_include_path(get_include_path(). PATH_SEPARATOR . "library/classes/phpseclib/phpseclib/");
//link to database access class and connection
require_once                 ("library/mysqli_datalayer.php");
require_once                 ("library/connection.php");
/*include                     ("Net/SFTP.php");
include                     ("library/classes/sendSFTP.Class.php");

$checkConnection = sftpConnect::checkConnection();*/
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
          <li><a href='#'>Send Selected via sFTP</a></li>
          <li><a href='#'>View/Edit Selected</a></li>
          <li><a href='#'>Delete Selected</a></li>
          <li><a href='#'>Check for Results</a></li>
        </ul>
      </div>
    </li>
    <li><a href='#'>Settings</a>
    <div class='dropdown'>
        <ul>
          <li><a href='#' id='setconn'>Set connection information</a></li>
          <li><a href='#' id='setftp'>Ftp Settings</a></li>
        </ul>
      </div>
    </li>
  </ul>
</div>";
echo "</div>";

include("library/includes/display.inc.php");
include("library/includes/connection.inc.php");
include("library/includes/ftpConnection.inc.php");
include("library/includes/samples.inc.php");
/*The bottom spacing to show that the page has ended*/
echo "<div class='bottom_spacer'>";
echo "<div class='bottom_image'><img src='img/cancerresearchuk.png' /></div>";
echo "<div class='bottom_signature'>Coding by Ian Bettison (Newcastle University)</div>";
echo "</div>";
include("library/includes/validation.inc.php");


