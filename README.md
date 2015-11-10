MEDIASENDER-PHP
===========

L'API MediaSender a été développé pour être conforme aux normes RESTful.
En effet, l'API communique via des requêtes HTTP et permet selon les quatre opérations CRUD (Create Read Update Delete) de créer, lire, mettre à jour et supprimer des données.

Installation
------------

To install the SDK, you will need to be using [Composer](http://getcomposer.org/) 
in your project. 
If you aren't using Composer yet, it's really simple! Here's how to install 
composer and the Mailgun SDK.

```PHP
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Mailgun as a dependency
php composer.phar require mailgun/mailgun-php:~1.7.2
``` 