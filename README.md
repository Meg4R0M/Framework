# Description

Création d'un Framework modulaire en PHP

# Contenu

1. **Structure du projet**:

    * Présentation de l'architecture du projet
    * Mise en place des outils nécessaire au projet  
        * Composer : Outils pour créer un autoload et gérer les dépendances
        * Git : Outils pour le versionning
        * [PHPUnit](https://packagist.org/packages/phpunit/phpunit): Outils pour faire des tests unitaires
        * [guzzlehttp/psr7](https://packagist.org/packages/guzzlehttp/psr7): Classes qui implémente le PSR-7 pour gérer les $requests et les $responses
        * [http-interop/response-sender](https://packagist.org/packages/http-interop/response-sender): Classes qui gère les $responses de type PSR-7 pour les envoyer au serveur
        * [squizlabs/php_codesniffer](https://packagist.org/packages/squizlabs/php_codesniffer): Outils de test pour vérifier si le code respecte le PSR-2

2. **Le router**:

    * Création d'un Router pour gérer la lecture des URL et la création des Routes
    * Création des Routes pour gérer le lien entre l'URL et la Response
    * Utilisation des regex pour trouver les routes (test :[regex](https://regex101.com/))
    * Utilisation de nouveaux outils :
        * [zendframework/zend-expressive-fastroute](https://packagist.org/packages/zendframework/zend-expressive-fastroute): Router qui implémente [nikic/fast-route](https://packagist.org/packages/nikic/fast-route)
      
        
3. **Le renderer**:

    * Intégration des vues grâce au Renderer et au Router.
    * Création d'un système qui récupère le "slug" de l'URI pour le passer à la vue
    * Création d'un pseudo système de templates
    
4. **Twig**:

    * Modification des vues et du template pour qu'ils s'affichent à partir du moteur de template Twig
    * Utilisation de nouveaux outils :
        * [twig/twig](https://packagist.org/packages/twig/twig)