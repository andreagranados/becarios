<?php
class dt_becario_empleo extends toba_datos_tabla
{
	function eliminar_filas($fecha,$id_bec){
            $sql="delete from becario_empleo "
                    . "where id_becario=$id_bec and fecha='".$fecha."'";
            toba::db('becarios')->consultar($sql);
        }
        function get_datos_empleo_actual($id_becario,$fecha){
             $sql="select * from becario_empleo"
                    . " where id_becario=".$id_becario." and fecha='".$fecha."'"
                     . " and actual" ;
            return toba::db('becarios')->consultar($sql);
        }
        function get_datos_empleo_anterior($id_becario,$fecha){
             $sql="select * from becario_empleo"
                    . " where id_becario=".$id_becario." and fecha='".$fecha."'"
                     . " and not actual" ;
            return toba::db('becarios')->consultar($sql);
        }
        function get_empleos($band,$bec,$fec){
           if($band){
               $where=" and actual";
           } else{
               $where=" and not actual";
           }
           $sql="select * from becario_empleo"
                   . " where id_becario=".$bec
                   . " and fecha='".$fec."'"
                   . $where; 
           return toba::db('becarios')->consultar($sql);
        }
        function get_empleos_becario($bec,$fec){
            $sql="select * from becario_empleo"
                   . " where id_becario=".$bec
                   . " and fecha='".$fec."'";
                   
           return toba::db('becarios')->consultar($sql);
        }
}

?>