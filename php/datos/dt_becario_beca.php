<?php
class dt_becario_beca extends toba_datos_tabla
{
	function eliminar_filas($fecha,$id_bec){
            $sql="delete from becario_beca "
                    . "where id_becario=$id_bec and fecha='".$fecha."'";
            toba::db('becarios')->consultar($sql);
        }
        function get_datos_beca($id_becario,$fecha){
            $sql="select * from becario_beca"
                    . " where id_becario=".$id_becario." and fecha='".$fecha."'" ;
            return toba::db('becarios')->consultar($sql);
        }
}

?>