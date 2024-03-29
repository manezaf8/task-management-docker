# task-management-docker

Docker with Apache, PHP, MySQL, phpMyAdmin

These set of images creates a container running an Apache Web server with a
MySQL database backend. PHP is the language of choice in this setup. A running
copy of phpMyAdmin is included for easy database administration.

## Prerequisites
- Install and run Docker Desktop
  - [https://www.docker.com/get-started ](https://www.docker.com/get-started)
  - Insatll vscode and docker extention
  - Install git to pull and push


  ## Run Docker images
On the command line (the terminal)
- Clone this repo
  - `git clone https://github.com/manezaf8/task-management-docker.git` edit `Connection.php` if you have another DB details
- Change into the directory
- `cd task-management-docker`
- Change the MySQL account info in the `docker-compose.yml` file if you want
 - Make sure that PHP files from the `php/src` have a Connection.php file
 
```
  MYSQL_ROOT_PASSWORD: "rootPASS"
  MYSQL_DATABASE: "dbase"
  MYSQL_USER: "dbuser"
  MYSQL_PASSWORD: "dbpass"
```
- Start the container
  - `docker compose up`
  - Or run it in the background to free up the terminal
    - `docker compose up -d`
- To stop the containers
  - press ctrl-c
  - then run `docker compose down`
- When the containers are up open `phpmyadmin` go to `ekomi` database and add tables from `Database.sql` then run the website. 
## Database Connection
- Connect to the MySQL database with the following credentials:

  ```
    $dbHost = 'db';
    $dbName = 'dbase';
    $dbUser = 'dbuser';
    $dbPassword = 'dbpass';
    $db = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

  ```
  - The server/host/database url is `db` which is the name of the MySQL
    container. Because the PHP, Apache and Mysql are all in containers, they
    know to connect to each other through shortcut network names.

# Software Updates
To update a specific software package to a different version, change the image
called in the docker-compose.yml or Dockerfile file. After any changes to
Dockerfile or docker-compose.yml you will need to run `docker compose build` or
add the --build flag the first time you run "docker compose up", like so
`docker compose up --build -d` if those commands don't work add (-) like `docker-compose`

NOTE: When editing the Dockerfile, make sure to add a backslash (`\`) to any
lines that you add to the RUN command, unless it is the last line.

NOTE: Any changes to versions can totally break the setup. Other
changes to commands within the RUN line may need to change based on the version
you choose.

## PHP
For PHP, the image is set on the first line in the Dockerfile `FROM
php:8-apache` will grab the latest version of PHP 8. To get the latest version
of PHP 8.3, change the line to `FROM php:8.3-apache`. PHP developers set the
version of Apache. This can not be changed (easily). For more options, see the
offical DockerHub page [https://hub.docker.com/_/php ](https://hub.docker.com/_/php).


### PHP extensions
To add more PHP extensions, add the package to install in the list of packages
to install after the 'apt-get install' line (put them in alphabetical order).
Then add a 'docker-php-ext-install' line.

FROM php:8-apache

RUN apt-get update && apt-get install -y \
  imagemagick \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libmagickwand-dev --no-install-recommends \
  libpng-dev \
  --> add new software above this line (delete this line)
  && rm -rf /var/lib/apt/lists/* \
  && a2enmod rewrite \
  --> add new php extensions below this line (delete this line)
  && docker-php-ext-install exif \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install -j$(nproc) gd \
  && pecl install imagick && docker-php-ext-enable imagick \
  && docker-php-ext-install mysqli \
  && docker-php-ext-install pdo pdo_mysql

```

## Additional software
To add aditional software, add it to the Dockerfile. Add packages to the list
of packages after the 'apt-get install' line in alphabetical order.

```

## Accessing the Apache Container:

You can access the running Apache container using the docker exec command. For example:
  - `docker exec -it php-apache bash`
  - `cd /etc/apache2`
  -  `nano apache2.conf`
- Add the following code
```
# 000-default.conf
<VirtualHost *:80>
    DocumentRoot ${APACHE_DOCUMENT_ROOT}
    <Directory ${APACHE_DOCUMENT_ROOT}>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
-and `exit`


- 
   -  

