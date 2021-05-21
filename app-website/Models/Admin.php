<?php

namespace App\Models;

class Admin extends Base
{
    protected $tableName = APP_TABLE_PREFIX . 'admin';

    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

	    /**
	 * Indique si les données d'authentification sont correctes.
	 * @param string $pseudo
	 * @param string $password
	 * @return boolean false ou bien le tableau des données de l'admin.
	 */
	 function isAdmin(string $pseudo, string $password) {

	 $sql = "SELECT * FROM admin WHERE pseudo=:pseudo AND password=:password";
	 $sth = self::$dbh->prepare($sql);
	 $sth->execute([':pseudo' => $pseudo, ':password' => sha1($password)]);
	 return $sth->fetch();	 
	 }

}
