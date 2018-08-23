<?php
class dt_participacion_inv extends toba_datos_tabla
{
     function get_datos_pi($id_becario,$fecha){
         $sql="select * from participacion_inv"
                . " where id_becario=".$id_becario." and fecha='".$fecha."'" ;
        return toba::db('becarios')->consultar($sql);
    }
}

?>