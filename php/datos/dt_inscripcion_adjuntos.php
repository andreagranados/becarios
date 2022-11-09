<?php
class dt_inscripcion_adjuntos extends toba_datos_tabla
{
    function get_datos_adjuntos($id_becario,$id_c){
        $sql="select * from inscripcion_adjuntos "
                . " where id_becario=$id_becario and id_conv=".$id_c;
        $res= toba::db('becarios')->consultar($sql);
        return $res[0];
    }
    function link_al_archivo($id_conv,$nombre_archivo){
        $sql="select link_archivo(".$id_conv.",'".$nombre_archivo."')";
        $res= toba::db('becarios')->consultar($sql);
        return $res[0]['link_archivo'];
    }
}
?>