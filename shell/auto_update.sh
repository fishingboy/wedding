#! /bin/sh
BASEDIR=$(dirname "$0")
cd $BASEDIR
hook_file="/tmp/wedding.update.hook"
if [ -f $hook_file ]; then
    bash ./update.sh
    rm -rf $hook_file
else
    echo "no update."
fi