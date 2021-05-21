<?php
// fichier app/Config/config.local.php

// Nom de la base de données
define('APP_DB_NAME', 'db_name');

// Utilisateur de la base de données MySQL.
// reprendre les informations à partir d'alwaysdata.net
//   https://admin.alwaysdata.com/database/user/?type=mysql
define('APP_DB_USER', 'db_user');
// Mot de passe de la base de données MySQL.
define('APP_DB_PASSWORD', 'db_pwd');
// Adresse de l'hébergement MySQL.
// compléter ici les ??? par votre compte alwaysdata
define('APP_DB_HOST', 'db_host');

// préfixe des tables
// pas utile maintenant donc on laisse vide
define('APP_TABLE_PREFIX', '');