<?php
class dt_becario_estudio extends toba_datos_tabla
{
        function eliminar_filas($fecha,$id_bec){
            $sql="delete from becario_estudio "
                    . "where id_becario=$id_bec and fecha='".$fecha."'";
            toba::db('becarios')->consultar($sql);
        }
//        function get_datos_estudio($id_becario,$fecha){
//            $sql="select * from becario_estudio"
//                    . " where id_becario=".$id_becario." and fecha='".$fecha."'" ;
//            return toba::db('becarios')->consultar($sql);
//        }
        function get_datos_estudio($id_becario,$id_c){
            $sql="select * from becario_estudio"
                    . " where id_becario=".$id_becario." and id_conv=".$id_c ;
            return toba::db('becarios')->consultar($sql);
        }
}

?>