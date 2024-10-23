#!/bin/bash

# Define the container name
CONTAINER_NAME="app"

# Define the path to the storage directory inside the container
STORAGE_DIR="/var/www/storage"

docker exec $CONTAINER_NAME bash -c "chown -R www-data:www-data $STORAGE_DIR"
docker exec $CONTAINER_NAME bash -c "find $STORAGE_DIR -type d -exec chmod 755 {} \;"
docker exec $CONTAINER_NAME bash -c "find $STORAGE_DIR -type f -exec chmod 644 {} \;"
