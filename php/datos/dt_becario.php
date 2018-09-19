<?php
class dt_becario extends toba_datos_tabla
{
       function get_datos_personales($id_bec){
        $sql=" select upper(trim(apellido)||', '||trim(b.nombre)) as nombre, tipo_docum||': '||nro_docum as docum,cuil1||'-'||cuil||'-'||cuil2 as cuil,correo, calle||' '||numero||' CP: '||cod_postal||' '||p.descripcion_pcia||' '||a.nombre as domi,b.telefono,fec_nacim,correo,n.nombre as nacionalidad"
                . " from becario b"
                . " left outer join domicilio d on (b.nro_domicilio=d.nro_domicilio)"
                . " left outer join pais a on (d.cod_pais=a.codigo_pais)"
                . " left outer join provincia p on (p.codigo_pcia=d.cod_provincia and p.cod_pais=a.codigo_pais)"
                . " left outer join pais n on (b.nacionalidad=n.codigo_pais)"
                . " where b.id_becario=$id_bec ";
        $res= toba::db('becarios')->consultar($sql);
        $salida=array();
            if(count($res)>0){
                $salida= $res[0];
            }
        return $salida;
        
    }
    function get_nombre($id_bec){
        $sql="select upper(trim(apellido)||', '||trim(nombre)) as nombre  "
                . "from becario where id_becario=$id_bec";
        $res= toba::db('becarios')->consultar($sql);
        
        if(count($res)>0){
            return $res[0]['nombre'];
        }else{
            return '';
        }
    }
}
?>        