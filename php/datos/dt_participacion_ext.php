<?php
class dt_participacion_ext extends toba_datos_tabla
{
    function get_datos_pe($id_becario,$id_c){
         $sql="select * from participacion_ext"
                . " where id_becario=".$id_becario." and id_conv=".$id_c ;
        return toba::db('becarios')->consultar($sql);
    }
}

?>