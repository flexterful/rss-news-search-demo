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
