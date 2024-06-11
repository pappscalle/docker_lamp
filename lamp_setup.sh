#!/bin/bash

start() {
  docker-compose up -d
  echo "Waiting for MySQL to initialize..."
  sleep 30  # Wait for MySQL to initialize properly

  # Check if the database is already initialized
  docker exec lamp-mysql-container mysql -uyour_user -pyour_password -e "USE your_database; SHOW TABLES;" | grep -q users

  if [ $? -eq 0 ]; then
    echo "Database already initialized."
  else
    echo "Initializing database..."
    docker exec -i lamp-mysql-container mysql -uyour_user -pyour_password your_database < ./docker-entrypoint-initdb.d/init.sql
    echo "Database initialized."
  fi
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

