<?php

class Capacidad {
  public $host;
  public $database;
  public $user;
  public $pass;

  public function __construct($db_host, $db_database, $db_login, $db_password){
    $this->host = $db_host;
    $this->database = $db_database;
    $this->user = $db_login;
    $this->pass = $db_password;
  }

  function cargarArray() {

    $db = new PDO('mysql:host=' . $this->host . ';dbname='. $this->database .';charset=utf8mb4;port:3306', $this->user, $this->pass);

    $query = $db->query('SELECT * FROM plan_room');

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
  }

  function getCapacidad($room, $miVector){
    foreach ($miVector as $value) {
      if ($room == $value['id'])
        {
          return $value['capacity'];
        }
      }
      return -1;
    }
}

 ?>
