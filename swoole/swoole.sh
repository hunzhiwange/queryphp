#!/bin/bash

apppidpath="/data/codes/queryphp/runtime/swoole/pid/http.pid"
pid="/data/codes/queryphp/runtime/swoole.pid"

if [ -e $pid ]
then
        exit 0
fi
echo $$ > ${pid}

       if [ -f ${apppidpath} ]
        then
            nohup php /data/codes/queryphp/swoole/daemon.php  </dev/null &>/dev/null &           
        echo "deamon is ok!"
        else
            echo "swoole is stopped!"
        fi

rm $pid -rf