<?php
class dt_becario_idioma extends toba_datos_tabla
{
	  function eliminar_filas($fecha,$id_bec){
            $sql="delete from becario_idioma "
                    . "where id_becario=$id_bec and fecha='".$fecha."'";
            toba::db('becarios')->consultar($sql);
        }
        function get_datos_idioma($id_becario,$fecha){
             $sql="select b.descripcion as idioma, a.descripcion as lee,e.descripcion as escribe, c.descripcion as habla, d.descripcion as entiende"
                     . " from becario_idioma b"
                     . " left outer join opciones a on (a.id=b.lee)"
                     . " left outer join opciones e on (e.id=b.escribe)"
                     . " left outer join opciones c on (c.id=b.habla)"
                     . " left outer join opciones d on (d.id=b.entiende)"
                    . " where id_becario=".$id_becario." and fecha='".$fecha."'";
                     
            return toba::db('becarios')->consultar($sql);
        }
}

?>