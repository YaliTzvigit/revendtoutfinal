# Utiliser l'image officielle PHP avec Apache
FROM php:7.4-apache

# Copier les fichiers de ton projet dans le répertoire Apache
COPY . /var/www/html/

# Exposer le port 80 pour la connexion HTTP
EXPOSE 80
