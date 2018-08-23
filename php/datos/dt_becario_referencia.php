<?php
class dt_becario_referencia extends toba_datos_tabla
{
        function get_listado($id_becario,$fecha){
            $sql="select b.id,b.apellido,b.nombre,b.profesion,b.cargo,p.nombre as cod_pais,a.descripcion_pcia as cod_provincia,d.calle,d.numero,d.cod_postal,d.telefono "
                    . " from becario_referencia b"
                    . " left outer join domicilio d on (b.id_domicilio=d.nro_domicilio)"
                    . " left outer join pais p on (p.codigo_pais=d.cod_pais)"
                    . " left outer join provincia a on (a.codigo_pcia=d.cod_provincia and a.cod_pais=d.cod_pais)"
                    . " where b.fecha='".$fecha."' and b.id_becario=$id_becario";
            return toba::db('becarios')->consultar($sql);
        }
        function get_datos_referencias($id_becario,$fecha){
            $sql="select b.apellido||', '||b.nombre as agente,profesion,cargo,institucion,uni_acad,d.calle||' '||d.numero||' CP: '||d.cod_postal||' '||p.descripcion_pcia||' '||a.nombre as domi"
                    . " from becario_referencia b"
                    . " left outer join domicilio d on (b.id_domicilio=d.nro_domicilio)"
                    . " left outer join pais a on (d.cod_pais=a.codigo_pais)"
                    . " left outer join provincia p on (p.codigo_pcia=d.cod_provincia and p.cod_pais=a.codigo_pais)"
                    . " where id_becario=$id_becario and "
                    . " fecha='".$fecha."'";
            $res = toba::db('becarios')->consultar($sql);
            return $res;
        }
}

?>