MEDIASENDER-PHP
===========

L'API MediaSender a été développé pour être conforme aux normes RESTful. En effet, l'API communique via des requêtes HTTP et permet selon les quatre opérations CRUD (Create Read Update Delete) de créer, lire, mettre à jour et supprimer des données.

Chaque table présente en base de données aura sa propre URI (Unique Resource Identifier) et ses propres paramètres. Les méthodes CRUD pour chacune de ces ressources correspondent aux appels HTTP POST, GET, PUT et DELETE. Vous aurez accès à ces dernières en fonction des droits qui vous ont été attribués lors de la création de votre compte API.

GET /$ressource vous donne accès à une liste de données
GET /$ressource/$id vous donne accès aux données d'un champ spécifique
POST /$ressource vous permet d'insérer des données supplémentaires dans votre base de données
PUT /$ressource/$id vous permet de mettre à jour certaines données d'un champ spécifique
DELETE /$ressource/$id vous permet de supprimer un champ spécifique
Certaines ressources ne vous renverront aucune donnée directement, mais un message de confirmation pour une extraction qui arrivera dans votre boîte mail une fois générée. Le lien de téléchargement pour cet export sera valide uniquement pendant 1 semaine à partir de sa date d'extraction.

Les historiques pour les contacts envoyés, ouvreurs et cliqueurs seront conservés au maximum 6 mois dans nos bases de données. Si vous voulez les conserver au delà de cette durée, il vous est conseillé de sauvegarder ces données dans votre propre espace de stockage.