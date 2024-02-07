#!/bin/bash

start() {
  docker-compose up -d
}

stop() {
  docker-compose down
}

if [ "$1" == "start" ]; then
  start
elif [ "$1" == "stop" ]; then
  stop
else
  echo "Usage: $0 {start|stop}"
  exit 1
fi

