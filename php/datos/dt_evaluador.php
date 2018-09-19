<?php
class dt_evaluador extends toba_datos_tabla
{
    function get_evaluadores($fecha,$id_becario){
        $sql="select * from evaluador "
                . " where id_becario=$id_becario and fecha='".$fecha."'";
        return toba::db('becarios')->consultar($sql);
    }
    //listado de los evaluadores de una convocatoria y la cantidad de becarios asignados
    function get_distribucion($filtro){
        //print_r($filtro);
        $where='';
        if(isset($filtro['id_conv'])){
            $where.=' where id_convocatoria='.$filtro['id_conv']['valor'];
        }
        $sql="select u.id,u.uni_acad,u.nombre_evaluador,count(distinct e.id_becario) as cant"
                . " from ua_evaluadora u"
                . " left outer join evaluador e on (e.id_ua=u.id)"
                .  $where 
                . " group by u.id,u.uni_acad,u.nombre_evaluador";
        return toba::db('becarios')->consultar($sql);
    }
  
}
?>