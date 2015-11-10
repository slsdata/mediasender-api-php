MEDIASENDER-PHP
===========

L'API MediaSender a été développé pour être conforme aux normes RESTful.
En effet, l'API communique via des requêtes HTTP et permet selon les quatre opérations CRUD (Create Read Update Delete) de créer, lire, mettre à jour et supprimer des données.

Installation
------------

Pour utiliser l'API, vous devez installer [Composer](http://getcomposer.org/) 
dans votre projet. 
Si vous n'utilisez pas encore Composer, voici comment l'installer simplement ainsi que la librairie Mediasender.

```PHP
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Mailgun as a dependency
php composer.phar require slsdata/mediasender-api-php:dev-master
``` 