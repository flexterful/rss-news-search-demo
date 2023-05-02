# Dockerfile
FROM php:8-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    curl \
    libxml2-dev

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app/backend

# Copy project files to working directory
COPY . /app/backend

# Set the entrypoint script to be run
ENTRYPOINT ["/app/backend/script/entrypoint.sh"]
