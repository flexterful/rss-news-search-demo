**Running the project**

* To run the project for the first time use this command

`docker-compose down -v && docker-compose up --build -d`

* To run already built project use this command

`docker-compose down -v && docker-compose up -d`

* To stop all project-related containers use this command

`docker-compose down -v`

**Code Style**

* To check the PHP code for PSR-12 compatibility run this command in the 'backend' container

`composer phpcs`
