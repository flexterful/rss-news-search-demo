#!/bin/bash

# Navigate to project directory
cd /app/frontend

# Install dependencies
npm install
npm install node-sass

# Build the frontend application
npm run build

# Set the default command to run the frontend application using serve
npx serve -s dist -l 9000
