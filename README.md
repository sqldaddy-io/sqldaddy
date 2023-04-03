## sql<>daddy.io
[sql<>daddy.io](https://sqldaddy.io/) is open-source sandbox and environment for real-time SQL experimentation

### Installation

A convenient make file has been added to the project, with the necessary commands (install: `sudo apt install make`)

1. Set up the .env file in `/backend/.env`


2. Deploy the project locally. Run the following command to deploy the main project environment
```
# make dc_up
```
This will start php-fpm, mercure, nginx, vue app, symfony api and all databases container

3. Go to localhost/
