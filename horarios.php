<?php

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    if ($_SERVER["HTTP_HOST"] == 'localhost') {
        //base de datos pruebas
        $server = 'localhost';
        $username = 'root';
        $password = '';
        $db = 'planning';
        $table_prefix = 'mbrs_';
    } else {
        //base de datos produccion
        $server = '10.70.200.55';
        $username = 'Planning_User';
        $password = 'UAplanning.125';
        $db = 'planningdb';
        $table_prefix = 'plan_';
    }


    $conn = mysql_connect($server, $username, $password) or die('No pudo conectar con la base de datos');
    mysql_select_db($db, $conn) or die('No se pudo seleccionar la base de datos');

    $areas = array();
    if (isset($_GET['area'])) {
        $areas = explode(',', $_GET['area']);
        $areas = array_filter($areas);
    }

    $tipos = array('B', 'L', 'N');

    foreach ($areas as $k => $area) {

        $area = abs(intval($area));
        if (!is_int($area)) {
            unset($areas[$k]);
            continue;
        }
        $resultado = mysql_query("select * from ".$table_prefix."area where id = '" . $area . "' limit 1", $conn) or die(mysql_error() . __LINE__);
        if (mysql_num_rows($resultado) != 1) {
            unset($areas[$k]);
            continue;
        }

        $areas[$k] = $area;
    }

    $inicio = (!isset($_GET['time']) || !is_numeric($_GET['time'])) ? mktime(0,0,0) : $_GET['time'];
    $fin = $inicio + 3600 * 24 * 5; //buscar todos los registros para los proximos 5 dias


    if (count($areas)) {
        $materias = mysql_query("select * "
            . "         from ".$table_prefix."room r "
            . "         join ".$table_prefix."entry e "
            . "             on r.id = e.room_id "
            . "         where r.area_id in (" . implode(',', $areas) . ") "
            . "             and e.type in ('".implode("','", $tipos)."') "
            . "             and e.start_time >= " . $inicio . " "
            . "             and e.start_time <= " . $fin) or die(mysql_error() . __LINE__);
    } else {
        $materias = mysql_query("select * "
        . "         from ".$table_prefix."room r "
        . "         join ".$table_prefix."entry e "
        . "             on r.id = e.room_id "
        . "         where "
        . "             e.type in ('".implode("','", $tipos)."') "
        . "             and e.start_time >= " . $inicio . " "
        . "             and e.start_time <= " . $fin) or die(mysql_error() . __LINE__);
    }

    header('Content-Type: application/xml; charset=utf-8');
    echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<registros>';
    while ($row = mysql_fetch_assoc($materias)) {
		//Agregue el IF para que no muestre las salas Aula A y D que pertenecen al collegio La Salle
		if ($row['room_name'] != "Aula A" && $row['room_name'] != "Aula D") {
        echo '<registro
                materia= "' . htmlentities($row['name']) . '"
                aula= "' . substr(htmlentities($row['room_name']),-3) . '"
                comienzo="' . date('H:i', $row['start_time']) . '"
                comienzo_dia="' . date('d', $row['start_time']) . '"
                fin= "' . date('H:i', $row['end_time']) . '"
                />';
		}
    }
    echo '</registros>';
