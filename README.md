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

2. **Setting up environment file**
    ACI_API_KEY=""
    ACI_ENTITY_ID=""
    SHIFT4_API_KEY=""
    
    These variables in .env are must have if we want payment Providers to work. 
    'ACI_ENTITY_ID' and 'ACI_API_KEY' will already have a value for testing purposes, provided by the ACI.
    For Shift4 you will need to create an account, test sandbox, and go to 'GET API KEYS' and take the private key, and use it in the .env file for 'SHIFT4_API_KEY'
    Save the file, and start testing.

3. **Testing:**
The following command will run all the tests. Currently there are unit tests for the endpoint and the command and integration test for the endpoint. Run the following command:
    $ docker exec -it api_app vendor/bin/phpunit

4. **API and Command**
Accessing the API and running the command are described in the file named payment_process_endpoint_v1.pdf and payment_process_command_v1.pdf

5. **POSTMAN**
Postman collection for easy testing the endpoint is provided and the file is called metricalo.postman_collection.json, import this collection and you should have 2 POST requests to test the endpoint.