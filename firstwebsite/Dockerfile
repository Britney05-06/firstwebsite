# Utilise l’image officielle PHP avec Apache
FROM php:8.2-apache

# Copie le contenu de src/ dans le dossier où Apache sert les fichiers
COPY src/ /var/www/html/

# (Optionnel) Active les extensions PHP nécessaires à ton projet
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose le port 80 pour que Render puisse accéder à ton serveur
EXPOSE 80

