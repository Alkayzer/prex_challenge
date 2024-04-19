# Prex Challenge

This service was crafted as a challenge presented by Prex. The core concept revolves around leveraging the Giphy API to deliver a robust and interactive experience with GIFs.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

Before starting with the project setup, ensure that you have the following software installed:

- **Docker**: A containerization platform to build, run, and share applications with containers. [Get Docker](https://www.docker.com/get-started).
- **Git**: Version control system to track changes in source code during software development. [Download Git](https://git-scm.com/downloads).
- **Postman**: An API platform for building and using APIs. Postman simplifies each step of the API lifecycle and streamlines collaboration. [Download Postman](https://www.postman.com/downloads/).

### Installing

Follow these steps to set up a development environment:

1. **Clone the repository:**
   Open a terminal and run the following git command to clone the project repository:
   > git clone git@github.com:Alkayzer/prex_challenge.git
   
2. **Navigate to the project directory:**
   After cloning the repository, enter the project directory:
   > cd prex_challenge

3. **Set up environment variables:**
   Copy the `.env.example` file to create a `.env` file which will contain your environment-specific configurations:
   > cp .env.example .env


### Running the Tests

To ensure that your installation is functioning correctly and to validate that the software meets the intended requirements, you can run automated tests. The tests cover various functionalities and ensure that the system behaves as expected under different conditions. 

To run the tests, execute the following command:

> docker-compose run --rm test

### Deployment

This section provides guidance on how to deploy the application locally for development and testing purposes. It's primarily focused on using Docker, which simplifies the setup and ensures consistency across various development environments.

#### Local Deployment with Docker

1. **Build and run with Docker**:
   - Use Docker Compose to build and run the application:
     ```
     docker-compose up --build
     ```

2. **Accessing the application**:
   - Once the Docker containers are up and running, the application can be accessed at `http://localhost:8000`

3. **Shutting down**:
   - To stop the Docker containers:
     ```
     docker-compose down
     ```

#### Notes:
- Ensure Docker is properly installed and configured on your machine.
- Make adjustments to the Docker configurations if necessary, depending on your specific requirements or if you encounter any issues during the startup.

## Usage

This service is designed to be used with Postman, which simplifies the process of making API calls. The project comes with a pre-configured Postman collection that sets up the bearer token automatically upon signing up or logging in.

### Importing the Collection into Postman

1. Launch Postman.
2. Import the Prex-challenge collection into your workspace. This collection can be found in the following project directory: `./documentation/colletion/prex-challenge.postman_collection.json`.
3. Once imported, the collection provides a set of organized requests under the "User" and "Gif" categories.

### Interacting with the API

- **User Authentication**:
    - Use the `Signup` request to create a new user. Fill in the required details in the body of the request and send it.
    - To log in, use the `Login` request with your credentials. The token received in the response is automatically stored and used for subsequent API calls.

- **GIF Operations**:
    - **Get Gifs**: Retrieves a list of trending GIFs.
    - **Get Gif By ID**: Fetches a single GIF by its unique identifier.
    - **Create Favorite Gif**: Saves a GIF as a favorite associated with a user account.

The collection is configured with scripts that automatically handle the token assignment, so there is no need for manual token copying or setting up environment variables.

Start by executing the `Signup` or `Login` request to authenticate, and then proceed to the GIF-related requests as needed. Each request in the collection contains brief descriptions and required parameters to guide you through the process.

## Additional Documentation

All documentation related to this project is organized under the `documentation` folder. Here's what you'll find:

- **Use Case Diagrams**: Located in `documentation/uml`. That diagram provides an overview of all the possible interactions users can have with the system.
- **Sequence Diagrams**: Located in `documentation/uml`. These diagrams detail the interactions between system components for each use case.
- **Data or ER Diagrams**: Located in `documentation/erm`. That diagram illustrates the database schema and relationships between the data models.
- **POSTMAN Collection**: Located in `documentation/collection`. The collection includes pre-configured API requests for easy import into Postman, with automatic token handling post-authentication.
- **Dockerfile**: Located at the root of the project directory, the Dockerfile contains all the commands a user could call to assemble an image.

Refer to these documents for a detailed understanding of the project's architecture and setup, or to modify the API requests in Postman.


## Built With

- [Laravel](https://laravel.com/) - The web framework used
- [Composer](https://getcomposer.org/) - Dependency Management
- [PHPUnit](https://phpunit.de/) - Testing Framework
- [Docker](https://www.docker.com/) - Containerization and deployment

## Authors

- **Marcelo Pérez Britos** - *Software Engineer*


---
