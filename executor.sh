#!/bin/bash

# Define the container name
CONTAINER_NAME="api_app"

docker exec $CONTAINER_NAME bash -c "composer install"