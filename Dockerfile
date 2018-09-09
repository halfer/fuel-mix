# Docker build script for Fuel Mix site

FROM alpine:3.8

# Install software
RUN apk update
# The web app needs database stuff
RUN apk add php7-pdo_sqlite
# Health endpoint uses JSON
RUN apk add php-apache2 php-json

# Prep Apache
RUN mkdir -p /run/apache2
RUN echo "ServerName localhost" > /etc/apache2/conf.d/server-name.conf

# Copy contents of a web dir
RUN rm -rf /var/www/localhost/htdocs
COPY web /var/www/localhost/htdocs

# Copy resources one level up from the docroot
COPY data /var/www/localhost/data
COPY lib /var/www/localhost/lib

EXPOSE 80

# The healthcheck is used by the Routing Mesh, during a rolling update, to understand
# when to avoid a container that is not ready to receive HTTP traffic.
HEALTHCHECK --interval=5s --timeout=5s --start-period=2s --retries=5 \
    CMD wget -qO- http://localhost/health.php > /dev/null || exit 1

# Start the web server
CMD ["/usr/sbin/httpd", "-DFOREGROUND"]
