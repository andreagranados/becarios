<?php
class dt_becario_trabajo extends toba_datos_tabla
{
//	function eliminar_filas($fecha,$id_bec){
//            $sql="delete from becario_trabajo "
//                    . "where id_becario=$id_bec and fecha='".$fecha."'";
//            toba::db('becarios')->consultar($sql);
//        }
        function get_datos_trabajo($id_becario,$id_c){
             $sql="select * from becario_trabajo"
                    . " where id_becario=".$id_becario." and id_conv=".$id_c. " order by titulo";
                     
            return toba::db('becarios')->consultar($sql);
        }
}

?>