<?php
require_once 'consultas_designa.php';
class dt_carrera_inscripcion_beca extends toba_datos_tabla
{
    function get_datos_carrera($id_car){
        $sql = "SELECT * FROM  carrera_inscripcion_beca "
                    . " where id=$id_car";
        $res = toba::db('becarios')->consultar($sql);
        return $res[0];
    }
    function get_carreras($uni_acad){
        $salida = consultas_designa::get_carreras($uni_acad);
        return $salida;
    }
}
?>