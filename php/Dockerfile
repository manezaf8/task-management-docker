FROM php:8.1-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# # Use an appropriate base image (e.g., alpine:latest)
# FROM alpine:latest
RUN apt -y install git
RUN apt -y install nano
# # Install Git
# RUN apk --no-cache add git

# # Set the working directory
# WORKDIR /var/www/html/ 

# # Clone your Git repository
# RUN git clone https://github.com/manezaf8/task-dashboard.git /var/www/html/ 