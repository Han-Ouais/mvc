Après le pull :

-Commencer par constituer les dossiers nécessaires : 
composer update

-Configurer le projet en écrivant les données d'accès à la base de donnée dans le dossier app-website/config puis config.prod pour un site hébergé ou config.local pour un site hébergé localement (xampp, uwampp, ...)

-Lier le captcha à un compte reCaptcha fonctionnel puis entrer la clé ligne 34 du BackOfficeController
ATTENTION : ne pas oublier de supprimer la ligne 29 ($validation = true);

Le projet peut commencer !
Ajoutez vos controllers, modèles et vues en fonction de vos besoins.

Merci Monsieur Louet !
