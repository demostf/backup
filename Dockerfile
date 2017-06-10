FROM php:7.1-alpine

COPY . /usr/src/app
WORKDIR /usr/src/app

CMD [ "php", "./backup.php" ]
