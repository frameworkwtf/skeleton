FROM frameworkwtf/docker

# app vars
ENV APP_ENV dev

# database vars
ENV DB_HOST mysql
ENV DB_NAME app
ENV DB_USER app
ENV DB_PASSWORD app

RUN apk --no-cache add php7-pdo_mysql

COPY . /var/www
