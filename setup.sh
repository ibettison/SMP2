#!/bin/sh
# setup script for the SMP2 project
# create and setup the permissions on the xml file locations
cd xml-documents
mkdir files-sent
mkdir files-received
mkdir files-archived
cd ..
# now install the third party libraries required by the SMP2 project 
# using Composer
php composer.phar install
