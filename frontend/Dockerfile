# Dockerfile
FROM node:14

# Set the working directory in the container
WORKDIR /app/frontend

# Copy the entire project directory into the container at the working directory
COPY . /app/frontend

# Set the entrypoint script to be run
ENTRYPOINT ["/app/frontend/script/entrypoint.sh"]
