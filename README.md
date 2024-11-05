# Payment Processing Project

## About the Project

This project is a Symfony-based payment processing application designed to handle transactions through multiple payment providers. It supports providers such as Shift4 and ACI, allowing flexibility for expanding the list of providers in the future. The application is structured with a Domain-Driven Design (DDD) approach to ensure maintainability and scalability.

## Running the Project with Docker

This project includes a Docker setup to simplify environment configuration. Make sure Docker and Docker Compose are installed on your machine.

1. **Clone the repository:**
   ```bash
   $ git clone https://github.com/nexezzz/metricalo-test.git
   $ cd project directory
   $ docker-compose up -d --build
   $ run the ./executor.sh file (currently there is only one command which will do composer install. If having trouble executing the file just run `docker exec api_app bash -c "composer install"`)

2. **Testing:**
The following command will run all the tests. Currently there are unit tests for the endpoint and the command and integration test for the endpoint. Run the following command:
    docker exec -it api_app vendor/bin/phpunit

3. **API and Command**
Accessing the API and running the command are described in the file named api_command_docs_v1.pdf

