<?php

namespace App\Controllers;

//************************* Inclusion des fichiers nécéssaires**********************/
//Admin obligatoire
use App\Models\Admin;

class BackOfficeController extends Controller
{

	/**
	 * Login dans l'application BackOffice.
	 */
	public function login()
	{

		$this->display(
			'backoffice/login.html.twig'
		);
	}


	/**
	 *Vérifier le login.
	 */
	public function loginCheck()
	{
		$validation = true;
		/** 
		$response = strip_tags(str_replace(" ", "", $_POST["g-recaptcha-response"]));
		$validation = false;

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
			'secret' => '', //Clé captcha necessaire
			'response' => $_POST["g-recaptcha-response"]
		);
		$options = array(
			'http' => array(
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context  = stream_context_create($options);
		$verify = file_get_contents($url, false, $context);
		$captcha_success = json_decode($verify);

		if ($captcha_success->success == false) {
			$validation = false;
		} else if ($captcha_success->success == true) {
			$validation = true;
		}
		*/
		$check = Admin::getInstance()->isAdmin(strip_tags(str_replace(" ", "", $_POST['pseudo'])), strip_tags(str_replace(" ", "", $_POST['password'])));
		if ($check && $validation) {
			// ouvrir une session en mode ADMIN
			$_SESSION['login'] = true;
			$_SESSION['role'] = $check;

			// redirection vers le backoffice
			redirect('/backoffice');
		} else {
			redirect('/login');
		}
	}

	/**
	 * Fermer la session administrateur.
	 */
	public function delog()
	{
		unset($_SESSION);
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}
		session_destroy();

		redirect('/login');
	}

	//Page d'accueil du BackOffice
	public function index()
	{
		checkLogin();
		$this->display(
			'backoffice/index.html.twig',
			[]
		);
	}
}