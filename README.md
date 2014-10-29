SMP2 Project
============
This software was written for Cancer Research UK in collaboration with the SMP2 Lung Cancer project and is available for the use of other Cancer Research UK locations or indeed the Research Hospitals participating in the SMP2 project.

The system was written by Newcastle University to manage the transimission of XML files to the Technical Hub repository, initiating the transfer of actual Cancer samples from the Research Hospital to the Technical Hub locations around the UK.

The system manages the transfer of the data and captures the results that are uploaded to the sFTP repository, saving the details into a database and providing the means to capture the full Patient and Sample detail subsequently archiving the details at the Technical Hub upon data validation and the completion of the above data.

##Gumby 2 is used as the PHP framework.

The PHPSECLIB application is incorporated into this project to manage the secure connection to the sFTP server and the transfer of the files. The library is added by running `php composer.phar install` at the root of the install, this may require using SSH to connect to the root of the web app on the web server to run the command.

PHP version 5.4.12 was used to develop the SMP2 application.
