# Dialotel technical test

 Describe the project ....

## Prerequisites

- Docker
- Docker Compose

## Installation

1. Clone the Git repository:
    ```
    git clone [REPOSITORY_URL]
    ```

2. Move to the project folder:
    ```
    cd dialotel
    ```
3. Copies the .env.example to .env and changes the values

4. Launch the Docker containers:
    ```
    docker-compose up -d
    ```

5. Install PHP dependencies with Composer:
    ```
    docker-compose run --rm  composer install
    ```

6. Create the database (if necessary):
    ```
    docker-compose exec app bin/console doctrine:database:create
    ```

7. Apply migrations:
    ```
    docker-compose exec app bin/console doctrine:migrations:migrate
    ```
8. (Optional) Load fixtures:
    ```
    docker-compose exec app bin/console doctrine:fixtures:load
    ```
   
## Usage

- Access the application at `http://localhost:[APP_PORT]`.