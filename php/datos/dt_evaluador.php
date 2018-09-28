<?php
class dt_evaluador extends toba_datos_tabla
{
    function get_evaluadores($fecha,$id_becario){
        $sql="select * from evaluador "
                . " where id_becario=$id_becario and fecha='".$fecha."'";
        return toba::db('becarios')->consultar($sql);
    }
    //listado de los evaluadores de una convocatoria y la cantidad de becarios asignados
    //y cantidad de inscripciones de la ua
    function get_distribucion($filtro){
        //print_r($filtro);
        $where='';
        if(isset($filtro['id_conv'])){
            $where.=" where id_convocatoria=".$filtro['id_conv']['valor'];
                    
        }
        $sql="select sub.id,sub.uni_acad,sub.nombre_evaluador,sub.cant,sub.cant2,sub.cant+sub.cant2 as total from(select u.id,u.uni_acad,u.nombre_evaluador,count(distinct e.id_becario) as cant,count(distinct i.id_becario) as cant2"
                . " from ua_evaluadora u"
                . " inner join convocatoria a on (a.id_conv=u.id_convocatoria)"
                . " left outer join evaluador e on (e.id_ua=u.id)"
                . " left outer join inscripcion_beca i on (extract (year from i.fecha_presentacion)=(a.anio-1) and u.uni_acad=i.uni_acad and i.estado='A')"
                .  $where 
                . " group by u.id,u.uni_acad,u.nombre_evaluador) sub";
        return toba::db('becarios')->consultar($sql);
    }
    function get_evaluados_x($id){
        $sql=" select b.apellido||', '||b.nombre as nombre, i.uni_acad "
                . " from evaluador e"
                . " inner join inscripcion_beca i on (e.id_becario=i.id_becario and e.fecha=i.fecha_presentacion)"
                . " inner join becario b on (b.id_becario=i.id_becario)"
                . " where id_ua=$id";
        return toba::db('becarios')->consultar($sql);
    }
  
}
?>