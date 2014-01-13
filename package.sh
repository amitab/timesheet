#!/usr/bin/env bash

## Functions ##
# FUNCTION: Print Usage and Exit
print_usage()
{
    echo "Script to package application for upload/deploy. This script should be placed inside the application directory."
    echo "Usage: $0 <application name>"
    exit 1
}

#################################################################
# Sets the script path and directory
#
# Return 1: SCRIPT_PATH absolute path to this script
# Return 2: SCRIPT_DIR absolute path to this script's dir
#################################################################
set_script_dir()
{
    SCRIPT_RDIR=$(dirname $0)
    SCRIPT_NAME=$(basename $0)

    # cd to the directory of the script and run pwd
    # filter it through echo | xargs to trim whitecharacters
    SCRIPT_DIR=$(echo $(cd ${SCRIPT_RDIR} && pwd) | xargs)
    SCRIPT_PATH=${SCRIPT_DIR}/${SCRIPT_NAME}
}

## Script Starts ##

# Parameter check
if [ $# -ne 1 ]; then
    print_usage
fi

# Set the script absolute directory & path
set_script_dir

# Check that we are indeed running from inside the app directory
if [ ! -f ${SCRIPT_DIR}/index.php ] || [ ! -f ${SCRIPT_DIR}/REVISION ] || [ ! -f ${SCRIPT_DIR}/composer.json ]; then
    echo 
fi
    
APPNAME=${1}
APPPKG=${SCRIPT_DIR}/../${APPNAME}.tgz

# Exclude unrequired items
tar --exclude=".git*" --exclude="cache" --exclude="vendor" --exclude="logs" --exclude="settings.local.yml" -czf ${APPPKG} .

echo "Generated application package for upload/deploy @ ${APPPKG}"

exit 0
