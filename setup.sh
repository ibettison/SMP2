#!/bin/sh
# setup script for the SMP2 project
# create and setup the permissions on the xml file locations
cd xml-documents
mkdir files-sent
chmod 766 files-sent
mkdir files-received
chmod 766 files-received
mkdir files-archived
chmod 766 files-archived
chmod 766 schema
cd ..
# now install the third party libraries required by the SMP2 project 
# using Composer
php composer.phar install
cd library
chmod 777 includes
printf "**************IMPORTANT*****************\n"
printf "*** Please read the message below    ***\n"
printf "****************************************\n"
printf "The permissions have been changed to allow you to save additional\nsettings files within the SMP2 application.\nOnce all connections have been tested the security.sh script needs to be ran.\nThis will secure the install of SMP2 and will\nprevent hackers from accessing your Web service."