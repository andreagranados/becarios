<?php
require_once 'consultas_designa.php';
class dt_director_beca extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT cod_cati, descripcion FROM categoria_invest ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}
        function get_docentes()
	{
            $datos_docentes = consultas_designa::get_docentes();
            return $datos_docentes;
	}
        function get_categ_docente($id_doc)
	{
            $datos = consultas_designa::get_categ_docente($id_doc);
            return $datos;
	}
        //dado un docente trae las designaciones
        function get_designaciones($id_doc)
	{
            $datos_desig = consultas_designa::get_designaciones($id_doc);
            return $datos_desig;
        }
        function get_categoria($id_designacion)
	{
            $datos_desig = consultas_designa::get_categoria($id_designacion);
            return $datos_desig;
        }
        function get_dedicacion($id_designacion)
	{
            $datos_desig = consultas_designa::get_dedicacion($id_designacion);
            return $datos_desig;
        } 
        function get_cargo($id_designacion)
	{
            $datos_desig = consultas_designa::get_cargo($id_designacion);
            return $datos_desig;
        }
        function get_ua($id_designacion)
	{
            $datos_desig = consultas_designa::get_ua($id_designacion);
            return $datos_desig;
        }
        function get_caracter($id_designacion)
	{
            $datos_desig = consultas_designa::get_caracter($id_designacion);
            return $datos_desig;
        }
       
        //retorna el id del docente
        function get_docente($id_designacion)
	{
            $datos_desig = consultas_designa::get_docente($id_designacion);
            return $datos_desig;
        }
         
        function get_legajo($id_docente)
	{
            $dato = consultas_designa::get_legajo($id_docente);
            return $dato;
        }
        function get_apellido($id_doc)
	{
            $dato = consultas_designa::get_apellido($id_doc);
            return $dato;
        }
        function get_nombre($id_doc)
	{
            $dato = consultas_designa::get_nombre($id_doc);
            return $dato;
        }
        function get_cuil($id_doc)
	{
            $dato = consultas_designa::get_cuil($id_doc);
            return $dato;
        }
        function get_cant_postulantes($filtro){
            if(isset($filtro)){
                $where=" where id_conv=".$filtro['id_conv'];
            }
            $sql="select legajo,trim(apellido)||', '||trim(nombre) as docente,sum(cant) as cant from (select 1,d.legajo,d.apellido,d.nombre,count(distinct i.id_becario)as cant 
                    from director_beca d
                    inner join inscripcion_beca i on (i.id_director=d.id)
                    $where
                    group by d.legajo,d.apellido,d.nombre
                    
                    union
                    
                    select 2,d.legajo,d.apellido,d.nombre,count(distinct i.id_becario)as cant from director_beca d
                    inner join inscripcion_beca i on (i.id_codirector=d.id)
                    $where                 
                    group by d.legajo,d.apellido,d.nombre)sub
                    group by legajo,apellido,nombre";
            
            return toba::db('becarios')->consultar($sql); 
        }
        function get_datos_director($id_dir){//lo llama para director y codirector
            $salida=array();
            if(isset($id_dir)){
               $sql="select upper(trim(d.apellido)||', '||trim(d.nombre)) as nombre,legajo,cuil1||'-'||cuil||'-'||cuil2 as cuil,correo,cat_estat,case when dedic=1 then 'Exclusiva' else case when dedic=2 then 'Parcial' else case when dedic=3 then 'Simple' else 'Ah-Honorem' end end  end as dedicacion,case when carac='I' then 'Interino' else case when carac='R' then 'Regular' else case when carac='S' then 'Suplente' else 'Otro' end end end as carac,c.descripcion as cat_conicet, i.descripcion as cat_inv, lugar_trabajo, institucion, titulo,
                    calle||' '||numero||' CP: '||cod_postal||' '||p.descripcion_pcia||' '||a.nombre as domi,hs_dedic_inves, dom.telefono
                     from director_beca d
                     left outer join categoria_conicet c on (d.cat_conicet=c.id_categ)
                     left outer join categoria_invest i on (d.cat_invest=i.cod_cati)
                     left outer join domicilio dom on (d.nro_domicilio=dom.nro_domicilio)
                     left outer join pais a on (dom.cod_pais=a.codigo_pais)
                     left outer join provincia p on (p.codigo_pcia=dom.cod_provincia and p.cod_pais=a.codigo_pais)
                     where id=$id_dir";
            $res=toba::db('becarios')->consultar($sql); 
            if(count($res)>0){
                $salida= $res[0];
                }
            }
            return $salida; 
        }
}

?>