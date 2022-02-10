## Installation

- [Installation](#installation)
  - [Pre-requisites](#pre-requisites)
    - [Docker](#docker)
  - [Installation steps](#installation-steps)

### Pre-requisites
#### Docker
Download docker for your operating system: https://docs.docker.com/get-docker/

### Installation steps
Follow the steps below to set up the repo for development
1. Clone the repository and change the working directory
    ```sh
    git clone https://github.com/coloredcow/campaigns
    cd campaigns
    ```
2. For **DEVELOPMENT PURPOSE** only, make sure Docker Desktop application is running and docker version is giving a proper output.
    ```sh
    docker --version
    ```
3. Set up your `.env` file by copying `.env.example` file
    ```sh
    cp .env.example .env
    ```
4. Update environment variables in your `.env` file based on your environment.
5. Create a system alias for sail. Add the following to your `.bash_profile` or `.bashrc` or `.zshrc` file.
    ```sh
    alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
    source ~/.bash_profile # or ~/.bashrc or ~/.zshrc
    ```
6. Install composer dependencies with the following command.
    ```sh
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v $(pwd):/var/www/html \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    ```
7. Build the docker images and run the containers using just one command:
    ```sh
    sail up
    # or
    sail up -d # to run docker containers in detached mode
    ```
8. Building docker images will take some time when you're running the command for the first time. Be patient!
9. Set up the Laravel application key
    ```sh
    sail php artisan key:generate
    ```
10. Once the docker containers are up and running, your app should be accessible at the `APP_URL` configured in your `.env` file.
