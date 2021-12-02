**Après le pull :**
**OBLIGATOIRE**
- Commencer par constituer les dossiers nécessaires (en se mettant au préalable dans app-website): 
composer update

- Configurer le projet en écrivant les données d'accès à la base de donnée dans le dossier app-website/config puis config.prod pour un site hébergé ou config.local pour un site hébergé localement (xampp, uwampp, ...)

- Changer le nom de app-website (en gardant le app) ainsi que dans le www, puis changer les chemins dans config.php et www/website/index.php

- A la racine du dossier www/website/ créer un .htaccess avec un éditeur de texte et d'y coller ce contenu:
``` 
Options -Indexes
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L] 
```


**FACULTATIF**

- Lier le captcha à un compte reCaptcha fonctionnel puis entrer la clé ligne 34 du BackOfficeController

**ATTENTION** : ne pas oublier de supprimer la ligne 29 ($validation = true);

- Pour une utilisation avec Git, ajouter à la racine un fichier .gitignore avec cette instruction dedans:
/app-website/vendor/

Le projet peut commencer !

Ajoutez vos controllers, modèles et vues en fonction de vos besoins.

Merci Monsieur Louet !
