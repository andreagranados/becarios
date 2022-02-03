<?php
class dt_participacion_inv extends toba_datos_tabla
{
     function get_datos_pi($id_becario,$id_c){
         $sql="select * from participacion_inv"
                . " where id_becario=".$id_becario." and id_conv=".$id_c ;
        return toba::db('becarios')->consultar($sql);
    }
}

?>