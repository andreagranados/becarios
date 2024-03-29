<?php
require_once 'consultas_designa.php';
require_once 'consultas_toba.php';
require_once 'dt_convocatoria.php';

class dt_inscripcion_beca extends toba_datos_tabla
{
    function get_usuario($id_becario){
        $sql="select cast (cuil1 as text)||cast(cuil as text)||cast(cuil2 as text) as usuario from becario where id_becario=".$id_becario;
        $res= toba::db('becarios')->consultar($sql);
        return $res[0]['usuario'];
    }
    function desbloquear($usuario){
         
        consultas_toba::desbloquear($usuario);
    }
   
    function get_estado($datos){
        //print_r($datos);
        $sql="select estado from inscripcion_beca"
                . " where id_becario=".$datos['id_becario']
                . " and id_conv=".$datos['id_conv'];
        $res= toba::db('becarios')->consultar($sql);
        return $res[0]['estado'];
    }
    
    function get_postulantes($filtro){
       
        $where=' WHERE 1=1';
        if(isset($filtro['id_conv'])){//esta siempre es obligatoria
            $where.=' and id_conv='.$filtro['id_conv']['valor'];
        }
        if(isset ($filtro['uni_acad'])){
            switch ($filtro['uni_acad']['condicion']) {
                case 'es_igual_a':$where.=" and uni_acad='".$filtro['uni_acad']['valor']."'";
                    break;
                case 'es_distinto_de':$where.=" and uni_acad<>'".$filtro['uni_acad']['valor']."'";
                    break;
                default: $where.=" and uni_acad='".$filtro['uni_acad']['valor']."'";
                    break;
            }
            
        }
        if(isset ($filtro['estado'])){
            switch ($filtro['estado']['condicion']) {
                case 'es_igual_a':$where.=" and estado='".$filtro['estado']['valor']."'";
                    break;
                case 'es_distinto_de':$where.=" and estado<>'".$filtro['estado']['valor']."'";
                    break;
            }
        }
        
        if(isset ($filtro['categ_beca'])){
            switch ($filtro['categ_beca']['condicion']) {
                case 'es_igual_a':$where.=" and categ_beca=".$filtro['categ_beca']['valor'];
                    break;
                case 'es_distinto_de':$where.=" and categ_beca<>".$filtro['categ_beca']['valor'];
                    break;
            }
        }
        if(isset ($filtro['tiene_av'])){
            switch ($filtro['tiene_av']['valor']) {
                case 1:$where.=" and informe_avance is not null ";
                    break;
                case 0:$where.=" and informe_avance is null ";
                    break;
            }
        }
        if(isset ($filtro['tiene_if'])){
            switch ($filtro['tiene_if']['valor']) {
                case 1:$where.=" and informe_fin is not null ";
                    break;
                case 0:$where.=" and informe_fin is null ";
                    break;
            }
        }
        
        $perfil = toba::usuario()->get_perfil_datos();
        if ($perfil != null) {//usuario de la UA
              //inscripcion correspond a la UA
              $sql1=" select i.* from inscripcion_beca i"
                      . " inner join unidad_acad u on (i.uni_acad=u.sigla) ";
              //asignados a la UA por scyt
              $sql2=" select i.* from inscripcion_beca i "
                      . " inner join evaluador e on (i.id_becario=e.id_becario and i.id_conv=e.id_conv)"
                      . " inner join ua_evaluadora u on (u.id=e.id_ua) "
                      . " inner join unidad_acad n on (u.uni_acad=n.sigla)";
              $con1 = toba::perfil_de_datos()->filtrar($sql1);
              $con2 = toba::perfil_de_datos()->filtrar($sql2);
              $con="  (select * from (".$con1.")sub )";
              //verifico si la fecha actual es >= fecha a partir de la cual puede ver los 
              $bandera = dt_convocatoria::puede_ver_asignados($filtro['id_conv']['valor']);//anio es obligatorio por tanto siempre tiene valor        
              if($bandera){
                  $con="(".$con." UNION "
                      . " select * from (".$con2.")sub2"
                      . ")";
              }
          }else{//usuario de SCyT
              $con=' inscripcion_beca ';
          }
       
        //////  ------------------------
         //obtengo los perfiles funcionales del usuario
        $perf_funcion = toba::usuario()->get_perfiles_funcionales();
        //obtengo el id del usuario
        $usuario = toba::usuario()->get_id();
        //si es becario entonces aplico filtro por cuil
        if(in_array("becario", $perf_funcion)){
            $where.=" and usuario='".$usuario."'";
        }
        //////  ------------------------
        $sql="select * from 
               (select i.uni_acad,i.id_conv,i.fecha_envio,i.estado,i.categ_beca,i.fecha_presentacion,i.id_becario,i.puntaje,i.titulo_plan_trabajo as tema,b.cuil1||'-'||b.cuil||'-'||b.cuil2 as cuil,b.apellido||', '||b.nombre as agente, b.correo,b.fec_nacim,c.descripcion as categoria, c_ib.carrera,c_ib.promedio,c_ib.promedio_ca,case when c_ib.uni_acad is null then c_ib.institucion else c_ib.uni_acad end as ua_institucion,
                p.codigo,p.fec_desde,p.fec_hasta,p.nro_ord_cs,di.apellido||', '||di.nombre as director,di.titulo,di.cat_estat||di.dedic||'-'||di.carac as cat_dir,ci.descripcion as cei_dir,coalesce(t.descripcion)||'('||coalesce(di.institucion)||')' as cat_oo,co.apellido||', '||co.nombre as codirector,co.cat_estat||co.dedic||'-'||co.carac as cat_co,cico.descripcion as cei_co,co.titulo as tituloc,coalesce(tco.descripcion)||'('||coalesce(co.institucion)||')' as catco_oo,bb.usuario,a.informe_avance,a.informe_fin
                from ".$con." i
                INNER JOIN becario b ON (i.id_becario=b.id_becario)
                INNER JOIN (select id_becario,cast (cuil1 as text)||cast(cuil as text)||cast(cuil2 as text) as usuario
			    from becario) bb ON (i.id_becario=bb.id_becario)
                LEFT OUTER JOIN categoria_beca c ON (c.id_categ=i.categ_beca)
                LEFT OUTER JOIN proyecto_inv p ON (p.id_pinv=i.id_proyecto)
                LEFT OUTER JOIN director_beca di ON (di.id=i.id_director)
                LEFT OUTER JOIN categoria_invest ci ON (ci.cod_cati=di.cat_invest)
                LEFT OUTER JOIN categoria_conicet t ON (t.id_categ=di.cat_conicet)
                LEFT OUTER JOIN director_beca co ON (co.id=i.id_codirector)
                LEFT OUTER JOIN categoria_conicet tco ON (tco.id_categ=co.cat_conicet)
                LEFT OUTER JOIN categoria_invest cico ON (cico.cod_cati=co.cat_invest)
                LEFT OUTER JOIN carrera_inscripcion_beca c_ib ON (c_ib.id=i.id_carrera)
                LEFT OUTER JOIN inscripcion_adjuntos a ON (i.id_becario=a.id_becario and i.id_conv=a.id_conv)
                )sub
                $where "
                  . " order by uni_acad,agente";
        //  print_r($sql);   
        return toba::db('becarios')->consultar($sql);
        
    }
    function get_unidades(){
        $uni_acad = consultas_designa::get_unidades();
        return $uni_acad;
    }
    function get_unidades_perfil(){
        $sql="select * from unidad_acad";
        $sql2=toba::perfil_de_datos()->filtrar($sql);
        $res= toba::db('becarios')->consultar($sql2);
        return $res;
    }
    function get_departamentos($uni_acad){
        $dep =consultas_designa::get_departamentos($uni_acad);
        return $dep;
    }
//    function get_inscripcion($nro_doc){//busca si el becario ya se anoto en este año
//        $sql=" select i.* from becario b, inscripcion_beca i"
//                . " where b.id_becario=i.id_becario"
//                . " and b.nro_docum=$nro_doc "
//                . " and extract (year from i.fecha_presentacion)=extract(year from now())";
//        $res= toba::db('becarios')->consultar($sql);
//        return $res;
//    }
    //--ver!!
    //recibe el nro de cuil sin guiones ni espacios
//    function get_inscripcion($cuil){//busca si el becario ya se anoto en este año
//        $sql=" select i.* from becario b, inscripcion_beca i"
//                . " where b.id_becario=i.id_becario"
//                . " and b.cuil1 = cast(substring('".$cuil."',1,2) as numeric)"
//                . " and b.cuil = cast(substring('".$cuil."',3,length('".$cuil."')-3) as numeric)"
//                . " and b.cuil2 = cast(substring('".$cuil."',length('".$cuil."'),1) as numeric)"
//                . " and extract (year from i.fecha_presentacion)=extract(year from now())";
//        $res= toba::db('becarios')->consultar($sql);
//        return $res;
//    }
    function get_inscripcion($cuil,$id){//busca si el becario ya se anoto en esa convocatoria
        $sql=" select i.* from becario b, inscripcion_beca i"
                . " where b.id_becario=i.id_becario"
                . " and b.cuil1 = cast(substring('".$cuil."',1,2) as numeric)"
                . " and b.cuil = cast(substring('".$cuil."',3,length('".$cuil."')-3) as numeric)"
                . " and b.cuil2 = cast(substring('".$cuil."',length('".$cuil."'),1) as numeric)"
                ." and i.id_conv=".$id;
        $res= toba::db('becarios')->consultar($sql);
        return $res;
    }
    function get_datos_inscripcion($id_becario,$id_c){
        $sql="select i.ua_trabajo_beca,i.titulo_plan_trabajo,i.dpto_trabajo_beca,i.desc_trabajo_beca,d.calle||' '||d.numero||' CP: '||d.cod_postal||' '||p.descripcion_pcia||' '||a.nombre as domi_lt "
                . " from inscripcion_beca i"
                . " left outer join domicilio d on (i.nro_domicilio_trabajo_beca=d.nro_domicilio)"
                . " left outer join pais a on (d.cod_pais=a.codigo_pais)"
                . " left outer join provincia p on (p.codigo_pcia=d.cod_provincia and p.cod_pais=a.codigo_pais)"
                . " where i.id_becario=$id_becario and i.id_conv=".$id_c;
        $res= toba::db('becarios')->consultar($sql);
        $salida=array();
        if(count($res)>0){
                $salida= $res[0];
            }
        return $salida;
    
    }
    function get_unidad($uni_acad){
        $salida = consultas_designa::get_unidad($uni_acad);
        return $salida;
        }
}
?>  