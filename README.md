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
        
5. **Conteneur de dépendance**:

    * Ajout d'un container de dépendances
    * Refactoring des classes pour permettre de mieux gérer les dépendances
    * Création des deux fichiers de config pour gérer le container de dépendance
    * Séparation entre BlogAction et BlogModule pour que le Module ne gère plus les appels
    * Création d'un TwigRendererFactory pour gérer la création du TwigRenderer
    * Utilisation de nouveaux outils :
        * [php-di/php-di](https://packagist.org/packages/php-di/php-di)
        
6. **Les migrations**:

    * Création d'un module de migration avec PHINX, permet de :
         * Gérer la création, modification et suppression des tables avec des classes PHP
         * Utilise un fichier de configuration PHP pour gérer les tables et le contenu
         * Lors du passage de la BDD en local, vers la BDD en ligne, les BDD seront identiques grâce aux classes PHP
    * Utilisation de nouveaux outils :
        * [robmorgan/phinx](https://packagist.org/packages/robmorgan/phinx) qui permet la gestion des migrations
        * [fzaninotto/faker](https://packagist.org/packages/fzaninotto/faker) pour remplir une BDD de fausses données
        
7. **Récupération des articles**:

    * Création d'une connexion à la base de données
    * Création d'objets "Table" qui seront les modèles de l'application
    * Séparation du code avec les objets "Actions" qui sont les controlleurs de l'application
    * Modification des vues pour qu'elles arrivent à lire les données reçues maintenant

8. **Pagination**:

    * Création d'un module pour gérer la pagination des posts
    * Installation de pagerfanta qui va automatiquement :
        * récupérer le nombre d'article nécessaire
        * créer la barre de navigation pour passer d'une page à l'autre
    * Création d'une Entity pour stocker les posts
    * Gestion des DateTime grâce à timeago.js pour afficher différement les dates 
    * Utilisation de nouveaux outils :
         * [pagerfanta/pagerfanta](https://packagist.org/packages/pagerfanta/pagerfanta) créé une pagination automatique avec gestion des pages
         * [timeago.js](https://cdnjs.com/libraries/timeago.js) pour modifier l'affichage des dates en "il y a X temps"
         
9. **Tester la base de données**:

    * Mise en place de test sur la base de données avec SQLite
    * Création d'instances unique pour chaques tests :
        * SQLite utilisant la memoire, rien est enregistré
        * Chaque tests se fait avec une nouvelle instanciation
    * Test PostTable effectué
    * Centralisation de la configuration de la BDD (SQLite) dans un DatabaseTestCase
    * ######Correction du twig renderer (ne necessite pas le chargement du loader)
    
10. **Administration du blog**:

    * Creation des routes pour l'administration
    * Creation des vues pour l'administration :
        * Vues d'affichage de la liste d'articles, d'edition et de creation
        * Mise en place de la vue formulaire séparé pour etre inclue ou besoin est
    * Mise en place de tests sur les fonctions du CRUD
    * Changements sur le fonctionnement du router pour les CRUD
    
11. **Messages flash**:
    
    * Creation des classes pour les messages flash
    * Creation des tests pour verifier la suppressions de ceux-ci aprés leurs affichage :
        * Creation d'une fausse $_SESSION dans ArraySession
        * Simulation d'un success et de son affichage
    * Modification du layout Admin pour y ajouter le message flash
    
12. **Validation des données**:
    
    * Creation des classes pour la validation des formulaires 
    * Creation des tests pour verifier les données soumises :
        * Verification sur "Required", "Empty", "Format", "Taille", "Slug" et "Date"
        * Vérification du type d'erreur et des messages renvoyés
    * Mise en place d'un systeme permettant la traduction future des messages d'erreurs
    
13. **Simplifier les formulaires**:
    
    * Ajout d'une extension Twig pour gerer les formulaires 
    * Creation des tests pour verifier la création des champs et leurs retours :
        * Verification des attributs passés en parametres
        * Vérification des ajouts de classes pour les erreurs
    * ######Fix sur la gestion des slugs ou la teminaison ne peu pas être "-" (Test OK)
    
14. **Les catégories**:
    
    * Refactorisation du code afin de la rendre plus générique
        * Les classes des modules extendent à présent des classes générique du Framework.
    * Creation de la table Catégories ne contenant qu'un nom et un slug
    * Creation de la relation entre les posts et les categories
    * Creation des tests pour verifier la création des categories :
        * Verification du CRUD catégories
        * Vérification des attributs du CRUD
    * Creation des tests pour verifier la liaison posts->catégories :
        * Modification des tests CRUD posts
        * Vérification des attributs passés en paramètre
    * Changement sur les vues pour le choix de catégories
    
14. **Front catégories**:
    
    * Refactorisation du code afin de la rendre plus générique
        * methode fetchOrFail pour les enregistrement dans la BDD
    * Changements des seeds pour y inclure les catégories
    * Ajout d'un bloc lateral pour afficher les catégories
    * Création de la navigation par catégorie :
        * Creation d'un slug pour naviguer par catégorie
        * Mise en place d'une contrainte d'unicitée sur le slug
    * Creation des tests pour verifier les methodes des catégories :
        * Lors de l'edition pour verifier le slug
        * Lors de la recuperation de la liste des catégories
    * Modifications mineures sur les titres des pages pour inclure la catégorie et la page si elle existe