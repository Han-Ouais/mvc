<?php
namespace App\Controllers;

//************************* Inclusion des fichiers nécéssaires**********************/

class FrontController extends Controller {
 /**
 * Affiche tous les articles.
 */
 public function index() {
 $this->display(
      'front/index.html.twig',
      [
      ]
    );
 }
}