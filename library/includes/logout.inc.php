<?php
session_start();
unset($_SESSION["LOGGED_IN"]);
echo "Logged out.";