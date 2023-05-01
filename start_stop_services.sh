#!/bin/bash

# Define the services to start/stop
SERVICES=("php" "nginx" "mysql")

# Check if the user passed start or stop as an argument
if [[ "$1" == "start" ]]; then
    # Loop through the services and start them
    for service in "${SERVICES[@]}"; do
        if ! brew services list | grep -Eq "^$service\s+started"; then
            brew services start $service
        fi
    done
    echo "Services started successfully."
elif [[ "$1" == "stop" ]]; then
    # Loop through the services and stop them
    for service in "${SERVICES[@]}"; do
        if brew services list | grep -Eq "^$service\s+started"; then
            brew services stop --verbose $service
        fi
    done
    echo "Services stopped successfully."
else
    echo "Usage: ./start_stop_services.sh [start|stop]"
fi
