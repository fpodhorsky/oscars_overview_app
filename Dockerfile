FROM php:8.2-apache
RUN apt-get update && apt upgrade -y
ADD ./src /var/www/html
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80