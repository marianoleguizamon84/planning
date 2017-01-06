<?php

require_once "defaultincludes.inc";

$db = new PDO('mysql:host=' . $db_host . ';dbname='. $db_database .';charset=utf8mb4;port:3306', $db_login, $dp_password);

$query = $db->query('SELECT * FROM plan_room');

$result = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $key => $value) {
  echo 'ID: ' . $value['id'] . ' - SALA: '. $value['room_name'] . ' - CAPACIDAD: ' . $value['capacity'] . '<br>';
}

// print_r($result);

// echo 'hola';

// $dbsys = "mysql";
// $db_host = "localhost";
// $db_database = "planningdb";
// $db_login = "root";
// $db_password = '';

 ?>
