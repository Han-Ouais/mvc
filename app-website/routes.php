<?php

//== Page pour internautes ========================================
$route->addRoute('GET', '/', 'FrontController@index');

//== Authentification ========================================
$route->addRoute('GET', '/login', 'BackofficeController@login');
$route->addRoute('POST', '/login', 'BackofficeController@loginCheck');
$route->addRoute('GET', '/delog', 'BackofficeController@delog');

//==Backoffice==================================
$route->addRoute('GET', '/backoffice', 'BackofficeController@index');