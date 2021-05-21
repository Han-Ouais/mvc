<?php
//
// Fichier: app\Models\Base.php
//

namespace App\Models;

/**
 * Classe de base pour le CRUD sur les données.
 * Contient les 6 méthodes :
 *   - exists( $id )
 *   - add( $datas )
 *   - get( $id )
 *   - getAll()
 *   - update( $id, $datas )
 *   - delete( $id )
 */
class Base {
  protected $tableName;
  // instance de la classe
  protected static $dbh;

  public function __construct() {
    if (!self::$dbh) {
      try {
        self::$dbh = new \PDO(
          'mysql:host=' . APP_DB_HOST . ';dbname=' . APP_DB_NAME . ';charset=UTF8',
          APP_DB_USER,
          APP_DB_PASSWORD,
          [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
          ]
        );
      } catch (Exception $e) {
        trigger_error('Impossible de se connecter à la base', E_USER_ERROR);
      }
    }
  }

  /**
   * Indique si l'identifiant existe déjà dans la base.
   *
   * @param  integer  $id identifiant à tester.
   * @return boolean
   */
  public function exists($id) {
    try {
      $sql = "SELECT COUNT(*) AS c FROM `{$this->tableName}` WHERE id = :id";
      $sth = self::$dbh->prepare($sql);
      if ($sth) {
        $sth->bindValue(':id', $id);
        $sth->execute();
        return ($sth->fetch()['c'] > 0);
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode exists: ' . $sql);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@exists', E_USER_ERROR);
    }
  }

  /**
   * Ajoute les nouvelles informations.
   *
   * @param  array  $datas  données à ajouter organisées sous forme de tableau associatif.
   * @return integer
   */
  public function add($datas) {
    try {
      $sql = 'INSERT INTO `' . $this->tableName . '` ( ';
      foreach (array_keys($datas) as $k) {
        $sql .= " {$k} ,";
      }
      $sql = substr($sql, 0, strlen($sql) - 1) . ' ) VALUE (';
      foreach (array_keys($datas) as $k) {
        $sql .= " :{$k} ,";
      }
      $sql = substr($sql, 0, strlen($sql) - 1) . ' )';
      $sth = self::$dbh->prepare($sql);
      if ($sth) {
        foreach (array_keys($datas) as $k) {
          $sth->bindValue(':' . $k, $datas[$k]);
        }
        $sth->execute();
        return self::$dbh->lastInsertId();
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode add: ' . $sql);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@add', E_USER_ERROR);
    }
  }

  /**
   * Édite les  informations d'un identifiant.
   *
   * @param  integer  $id     identifiant à modifier.
   * @param  integer  $datas  tableau associatif des données à modifier.
   * @return integer
   */
  public function update($id, $datas) {
    try {
      $sql = 'UPDATE `' . $this->tableName . '` SET ';
      foreach (array_keys($datas) as $k) {
        $sql .= " {$k} = :{$k} ,";
      }
      $sql = substr($sql, 0, strlen($sql) - 1);
      $sql .= ' WHERE id =:id';
      $sth = self::$dbh->prepare($sql);
      if ($sth) {
        foreach (array_keys($datas) as $k) {
          $sth->bindValue(':' . $k, $datas[$k]);
        }
        $sth->bindValue(':id', $id);
        return $sth->execute();
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode get: ' . $sql);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@update', E_USER_ERROR);
    }
  }

  /**
   * Retourne les informations d'un identifiant.
   *
   * @param  integer  $id identifiant
   * @return array
   */
  public function get($id) {
    try {
      $sql = "SELECT * FROM `{$this->tableName}` WHERE id = :id";
      $sth = self::$dbh->prepare($sql);
      if ($sth) {
        $sth->bindValue(':id', $id);
        $sth->execute();
        return $sth->fetch();
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode get : ' . $sql);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@get', E_USER_ERROR);
    }
  }

  /**
   * Retourne toutes les informations.
   *
   * @return array
   */
  public function getAll() {
    try {
      $sql = "SELECT * FROM `{$this->tableName}`";
      $sth = self::$dbh->query($sql);
      if ($sth) {
        return $sth->fetchAll();
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode getAll: ' . $sql, E_USER_ERROR);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@getAll', E_USER_ERROR);
    }
  }

  /**
   * Efface l'identifiant.
   *
   * @param  integer  $id identifiant
   * @return int|boolean
   */
  public function delete($id) {
    try {
      $sql = "DELETE FROM `{$this->tableName}` WHERE id = :id";
      $sth = self::$dbh->prepare($sql);
      if ($sth) {
        $sth->bindValue(':id', $id);
        return $sth->execute();
      } else {
        trigger_error('ERREUR dans la requête SQL de la méthode delete: ' . $sql, E_USER_ERROR);
      }
    } catch (Exception $e) {
      trigger_error('ERREUR dans la méthode Base@delete', E_USER_ERROR);
    }
  }
}
