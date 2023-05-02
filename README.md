# Running the project locally

* To run the project for the first time use this command:

`docker-compose up --build -d`

**Note**: The first run of the project may take significant amount of time since all the required dependencies are being installed. Please check docker container logs for the process completion.

* To run already built project use this command:

`docker-compose down -v && docker-compose up -d`

* To stop all project-related containers use this command:

`docker-compose down -v`

---

# Accessing the project locally

**Backend**: 

`localhost:8000`

**Frontend**: 

`localhost:9000`

---

# Code Style

* To check the PHP code for PSR-12 compatibility run this command inside the 'backend' container:

`composer phpcs`

* To check the JS code for Pretify compatibility run this command inside the 'frontend' container

`npm run lint` or `yarn lint`

* To fix the JS code for Pretify compatibility run this command inside the 'frontend' container
  
`npm run lint:fix` or `yarn lint:fix`

---

# Run the project on a server

**Note:** the solution below is **not** tested

**1. Navigate to  project's root directory.**

`cd <path_to_your_project>`

**2. Install necessary packages for the backend.**

`sudo apt-get update`

`sudo apt-get install -y php8.0-cli zlib1g-dev libzip-dev unzip curl libxml2-dev`

**3. Install composer globally**

`curl -sS https://getcomposer.org/installer | php`

`sudo mv composer.phar /usr/local/bin/composer`

**4. Run the entrypoint.sh script**

`cd backend/script`

`chmod +x entrypoint.sh`

`./entrypoint.sh`

**5. Install necessary packages for the frontend.**

`cd <path_to_your_project>`

**6. Install Node.js.**

`curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -`

`sudo apt-get install -y nodejs`

**7. Run the entrypoint.sh script**

`cd frontend/script`

`chmod +x entrypoint.sh`

`./entrypoint.sh`


**Note:** Your backend and frontend services should now be running on ports **8000** and **9000** respectively.

---
