<?php
class dt_inscripcion_adjuntos extends toba_datos_tabla
{
    function get_datos_adjuntos($id_becario,$fecha){
        $sql="select * from inscripcion_adjuntos "
                . " where id_becario=$id_becario and fecha='".$fecha."'";
        $res= toba::db('becarios')->consultar($sql);
        return $res[0];
    }
}
?>