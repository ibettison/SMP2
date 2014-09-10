<?php
	error_reporting(E_ALL & ~E_NOTICE);
	$database = 'smp2';
	$user = 'smp2';
	$password = 'U0wftw0wcaw!';
	/* Specify the server and connection string attributes. */
	$serverName = "crf88.ncl.ac.uk";
	/* Connect using SQL Server Authentication. */
	$conn= dl::connect($serverName,$user,$password,$database);
