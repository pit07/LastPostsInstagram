# Test Technique pour BBS

### Objectif :
Créer un système de récupération automatique des posts d'une page Instagram sur Laravel 10. 

### Consignes :

- Récupérer les derniers posts (donc quelques posts pas tous ceux de la page) et les afficher sur une page. 
- Cette récupération doit prendre en compte l'utilisation en production (ex : si un nouveau post apparaît sur la page Insta, qu'il soit pris en compte sur le système de récupération et non juste fait par rapport à une liste de posts figée à un instant T). 
- Nous nous concentrons ici essentiellement surtout sur l'aspect back-end.
- Il n'est évidemment pas nécessaire que ce soit une page Instagram personnelle.

## Lancement 
```
php artisan serve
```

## Remarques

Etudier les APIs que propose MetaforDeveloppeur pour **Instagram**.

2 APIs sont proposées : 
- Instagram Basic Display
- Instagram API Graph

L'API Graph est plus complète mais nécessite plus d'autorisations et de certifications. Pour le test, j'ai décidé de partir sur l'API Basic Display, plus adaptée à la demande.


3 différents types de contenus ont été traités :
- Image
- Carousel
- Vidéo

## Axes possibles

Pour répondre à la consigne de l'utilisation en production, plusieurs choix possibles :
#### Base de données
- création d'un model et d'une table contenant les n derniers posts instagram
- appel de l'API instagram tous les x minutes/heures pour mettre à jour la base (schedule Laravel)
- la vue blade se nourrie de la BDD

Avantages : l'API est moins sollicitée (évite les problèmes éventuels de quotas)

Inconvénients : la liste des posts reste bloquée à un instant T.

#### Localstorage
- stockage des derniers posts dans un json en localstorage
- la vue blade se nourrie du localstorage
- si le localstorage date d'il y plus de x minutes/heures, la page appelle la fonction liée à l'API Instagram pour récupérer les éventuels nouveaux posts

Avantages : l'API est moins sollicitée (évite les problèmes éventuels de quotas)

Inconvénients : la liste des posts reste bloquée à un instant T.


#### Appel en direct
- l'actualisation de la page lance l'appel API

Avantages : les posts sont à jours à l'instant T

Inconvénients : l'API peut être trop sollicitée (problèmes éventuels de quotas)

Pour le test, j'ai choisi la dernière possibilité, qui répondait à la consigne de l'utilisation en production.




## Répertoires utilisés

> resources/views/

Création des vues et des composants

> routes/web

Ajout de la route principale

> routes/api

Ajout de la route API pour tests POSTMAN

> app/Http/Controllers

Création des fonctions Controller pour Instagram

> .env

Définition des variables d'environnement
