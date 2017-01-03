<?php

//Convierto la fecha al formato que usa el MySql con la hora al final
function convfecha($hora)
{
	$date = date('m/d/Y', time());
	$date = $date." ".$hora;
	$date = strtotime($date);
	return $date;
}

function reser($reg,$aula,$horario,$area,$unidad)
{
	echo "Reserva: ".$reg['name']." - Aula: ".$aula." - Hora: ".$horario." - Area: ".$area." - Unidad: ".$unidad."<br>";
}


require_once "../defaultincludes.inc";

$hora="0:00";
//Convierto la fecha de hoy al formato fecha (*/*/* 0:00)
$fecha_inicio=convfecha($hora);
$hora="23:59";
//Convierto la fecha de hoy al formato fecha (*/*/* 23:59)
$fecha_final=convfecha($hora);

$conexion=mysql_connect($db_host,$db_login,$db_password) or die("Problemas en la conexion");
mysql_select_db($db_database,$conexion) or die("Problemas en la selección de la base de datos");

//Obtengo las reservas del dia de la fecha.
$registros=mysql_query("SELECT * FROM plan_entry WHERE start_time >='$fecha_inicio' AND start_time <='$fecha_final'",$conexion) or die("Problemas en el select:".mysql_error());

$json = '{ "schedules": [';

while ($reg=mysql_fetch_array($registros))
{
	//obtengo solo la hora de la reserva.
	$horario=date("H:i", $reg['start_time']);
	$horario_fin=date("H:i", $reg['end_time']);
	$aula=$reg['room_id'];
	//Paso el id de la sala a Nombre
	$regaula=mysql_query("SELECT * FROM plan_room WHERE id ='$aula'",$conexion) or die("Problemas en el select:".mysql_error());
	if ($rega=mysql_fetch_array($regaula))
	{
		$aula=$rega['room_name'];
		$area=$rega['area_id'];
	}
	//paso la letra de unidad a nombre
	$unidad=$typel[$reg['type']];
	//solo las muestro si pertenecen a las areas PILAR - Modulo A, PILAR - Modulo B y Plaza de transferencia.
	if ($area==11 or $area==20 or $area==12)
	{
		switch ($area) {
			case 11:
				$edificio = 'Módulo A';
				break;
			case 20:
				$edificio = 'Módulo B';
				break;
			case 12:
				$edificio = 'Plaza de Transferencia';
				break;
		}
		$json = $json .'{"subject": "'.$reg['name'].'", "classroom": "'.$aula.'", "startTime": "'.$horario.'", "endTime": "'.$horario_fin.'", "academicUnit": "'.$unidad.'", "building": "' .$edificio.'"},';
	}
}

$json = substr($json, 0, -1);
$json = $json .']}';
echo $json;

mysql_close($conexion);

?>