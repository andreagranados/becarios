<?php
class dt_becario_distincion extends toba_datos_tabla
{
	function eliminar_filas($fecha,$id_bec){
            $sql="delete from becario_distincion "
                    . "where id_becario=$id_bec and fecha='".$fecha."'";
            toba::db('becarios')->consultar($sql);
        }
        function get_datos_distincion($id_becario,$id_c){
             $sql="select * from becario_distincion"
                    . " where id_becario=".$id_becario." and id_conv=".$id_c ." order by fecha_dis";
            return toba::db('becarios')->consultar($sql);
        }
}

?>