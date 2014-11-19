#!/bin/sh
# setup script for the SMP2 project

# lets install the third party libraries required by the SMP2 project
# using Composer
php composer.phar install
chmod 777 ./library/includes
echo "***********************************************"
echo "*** the folder to save connection info to   ***"
echo "*** has been opened up so that the settings ***"
echo "*** can be saved after this setup has ran.  ***"
echo "*** You MUST run the security script to     ***"
echo "*** secure your website from HACKERS...     ***"
echo "*** Make sure you completely follow the     ***"
echo "*** remaining instructions, thanks Ian.     ***"
echo "***********************************************"
