<?php
session_start();
// intégrer COMPOSER
require 'vendor/autoload.php';
require 'Config/config.php';
require 'Libs/functions.php';

// 1. Gestion/Affichage des erreurs
$whoops = new \Whoops\Run;
if (APP_MODE === 'dev') {
  $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
} else {
  // enregistrement des erreurs dans le fichier
  //   app\Storage\error.log
  $whoops->pushHandler(function ($exception, $inspector, $run) {
    $errorFile = APP_STORAGE_DIRECTORY . 'error.log';
    $output = date('Y-m-d H:i:s') . ' L' . $exception->getLine() . ' ' .
    $exception->getFile() . ':: ' . $exception->getMessage() . "\n" .
    file_get_contents($errorFile);
    file_put_contents($errorFile, $output);
  });
}
$whoops->register();

// 2. composant TWIG
$twig = new \Twig\Environment(
  // spécifier le dossier des templates twig
  new \Twig\Loader\FilesystemLoader(APP_SRC_DIRECTORY . 'Views'),
  [
    // le dossier du cache
    'cache' => false,
    // si true, les variables qui n'existent pas déclenchent une erreur
    'strict_variables ' => true,
    // debug activé
    'debug' => true,
  ]
);
// composant additionnel pour le debug TWIG
$twig->addExtension(new \Twig\Extension\DebugExtension());
// ajouter une fonction url (obligatoire)
$twig->addFunction(
  new \Twig\TwigFunction('url', function ($sz) {
    return APP_ROOT_URL_COMPLETE . $sz;
  })
);
// ajouter une fonction asset (obligatoire)
$twig->addFunction(
  new \Twig\TwigFunction('asset', function ($ressource) {
    return APP_ROOT_URL_COMPLETE . '/assets' . $ressource;
  })
);
// ajouter un filtre nommé  firstWords (pas obligatoire si cette méthode n'est pas utilisée)
$twig->addFilter(
  new \Twig\TwigFilter('firstWords', function ($string, $nWords = 10) {
    $sz = explode(' ', $string);
    $sz = array_slice($sz, $nWords);
    return implode(' ', $sz) . ' …';
  })
);

//Vérification de la présence d'une table à chaque endroit du tableau
$twig->addFunction(
 new \Twig\TwigFunction('getTable', function ($tables, $row, $col) {
  foreach ($tables as $table) 
  {    
    if ($table['row'] == $row && $table['col']== $col) 
    {
      return $table;   
    } 
  }
 })
);

// 3. Le ROUTAGE
require 'router.php';