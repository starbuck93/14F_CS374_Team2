#!/bin/sh
if [ $# -ne 1 ]; then 
    echo "$0 <port>"
    exit 10 
fi

/usr/sbin/apache2 -DFOREGROUND -d. -f.apache-config -C"PidFile `mktemp`" -C"Listen $1" -C"ErrorLog /dev/stdout" -C"DocumentRoot $PWD/../www" -e debug
