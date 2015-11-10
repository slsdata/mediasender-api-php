MEDIASENDER-PHP
===========

L'API MediaSender a été développé pour être conforme aux normes RESTful.
En effet, l'API communique via des requêtes HTTP et permet selon les quatre opérations CRUD (Create Read Update Delete) de créer, lire, mettre à jour et supprimer des données.

Installation
------------

Pour utiliser l'API, vous devez installer [Composer](http://getcomposer.org/) 
dans votre projet. 
Si vous n'utilisez pas encore Composer, voici comment l'installer simplement ainsi que la librairie PHP MediaSender.

```PHP
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Mediasender as a dependency
php composer.phar require slsdata/mediasender-api-php:dev-master
``` 

Voici le lien direct pour [Packagist](https://packagist.org/packages/slsdata/mediasender-api-php).

Une fois installé, il suffit d'intégrer l'autoloader de Composer dans votre application, qui permettra ainsi de charger
automatiquement la librairie MediaSender et ses dépendences au sein de votre projet:
```PHP
require 'vendor/autoload.php';
use Mediasender\Mediasender;
```

Utilisation
-----
Voici comment récupérer la liste de vos bases:

```php
# First, instantiate the SDK with your API credentials. 
$client = new Mediasender(array(
    "api_user" => API_USER,
    "api_password" => API_KEY,
    "api_enctype" => "json"
));

$bases = $client->get_bases();
var_dump(json_decode($bases->http_response_body, false));
```


Support
--------------------

N'oublier pas de visiter le site officiel de [l'API MediaSender](http://dev.media-sender.com/v1)
pour connaître les différentes utilisations possibles.

Si vous détectez le moindre problème technique, veuillez décrire ce dernier sur notre support GitHub. 
[MediaSender Issues](https://github.com/slsdata/mediasender-api-php/issues)

Pour toute information supplémentaire, veuillez nous contacter par message électronique sur l'adresse suivante:
[support@media-sender.com](support@media-sender.com)