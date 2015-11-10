MEDIASENDER-PHP
===========

L'API MediaSender a été développé pour être conforme aux normes RESTful.
En effet, l'API communique via des requêtes HTTP et permet selon les quatre opérations CRUD (Create Read Update Delete) de créer, lire, mettre à jour et supprimer des données.

Installation
------------

Pour utiliser l'API, vous devez installer [Composer](http://getcomposer.org/) 
dans votre projet. 
Si vous n'utilisez pas encore Composer, voici comment l'installer simplement ainsi que la librairie PHP Mediasender.

```PHP
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Mailgun as a dependency
php composer.phar require slsdata/mediasender-api-php:dev-master
``` 

Une fois installé, il suffit d'intégrer l'autoloader de Composer dans votre application, qui permettra ainsi de charger
automatiquement la librairie Mediasender et ses dépendences au sein de votre projet:
```PHP
require 'vendor/autoload.php';
use Mediasender\Mediasender;
```

Utilisation
-----
Here's how to send a message using the SDK:

```php
# First, instantiate the SDK with your API credentials and define your domain. 
$client = new Mediasender(array(
    "api_user" => API_USER,
    "api_password" => API_KEY,
    "api_enctype" => "json"
));

$bases = $client->get_bases();
var_dump(json_decode($bases->http_response_body, false));
```
