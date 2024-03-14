<?php
class consultas_designa
{
    function get_carreras($uni_acad){
        if(isset ($uni_acad)){
            $where=" where activo and uni_acad='".$uni_acad."'";
        }else{
            $where="";
        }
        $sql="select distinct desc_carrera "
                . " from plan_estudio "
                . $where;
        return toba::db('designa')->consultar($sql);
    }
    function get_categ_docente($id_doc){//trae las categ de investigador del docente seleccionado
        $where=" WHERE 1=1 ";
            if(isset($id_doc)){
                $where.=" AND id_docente=".$id_doc;
            }	
            $query = "CREATE TEMPORARY TABLE pg_temp.auxi(
                    cod_cati integer,
                    descripcion character(12)
            )"; # Consulta Final
        
            toba::db('designa')->consultar($query);
            //si el docente no tiene ninguna categ entonces retorna S/C
            //INSERT INTO auxi 
            $sql = "SELECT i.cod_cati, i.descripcion FROM"
                    . "(SELECT id_docente,max(anio_categ) as anio "
                    . " FROM categorizacion c "
                    . $where
                    ." AND fecha_fin_validez is null"
                    . " group by id_docente "
                    . ")sub"//no tiene fecha de fin de validez
                    . " LEFT OUTER JOIN categorizacion cc  ON (sub.id_docente=cc.id_docente and sub.anio=anio_categ)"
                    . " LEFT OUTER JOIN categoria_invest i ON (cc.id_cat=i.cod_cati)"
                    . "ORDER BY cod_cati";
            
            $resul=toba::db('designa')->consultar($sql);
            if(count($resul)<1){//sino tiene entonces devuelvo S/C
                $salida=array();
                $elem['cod_cati']=6;
                $elem['descripcion']='S/C';
                array_push($salida, $elem);
                return $salida;
            }else{
               return $resul;
            }
    }
    function get_docentes(){//docentes con cargo vigente en periodo actual
  	$sql="select e.id_docente, e.apellido||', '||e.nombre as descripcion 
              from docente e
              where legajo<>0 and exists (select * from designacion d 
                                          left outer join mocovi_periodo_presupuestario m on (d.desde <= m.fecha_fin and (d.hasta >= m.fecha_inicio or d.hasta is null))
                            		  where m.actual and not (d.hasta is not null and d.hasta<=d.desde)
                                          and d.id_docente=e.id_docente 
                                           )
                         order by apellido,nombre   ";
	
	$res= toba::db('designa')->consultar($sql);
	return $res;
	
    }
    function get_unidad($ua){//recibe la sigla y retorna la descripcion completa
        $salida='';
        switch ($ua) {
            case 'ASMA':
                    $salida="FACULTAD DE CIENCIAS AGRARIAS - ASENTAMIENTO UNIVERSITARIO SAN MARTIN DE LOS ANDES ";
                break;
            case 'AUZA':
                    $salida="FACULTAD DE INGENIERIA - ASENTAMIENTO UNIVERSITARIO ZAPALA ";
                break;
            default:
                $sql="select trim(descripcion) as descripcion from unidad_acad "
                . " where sigla='".$ua."'";
                $res= toba::db('designa')->consultar($sql);
                if(count($res)>0){
                    $salida=$res[0]['descripcion'];
                }
                break;
        }
	return $salida;
    }
    function get_proyectos($anio){//Se podrá seleccionar sólo un proyecto de investigación que se encuentre vigente durante el año al que corresponde la convocatoria
        //p.codigo||'-'||SUBSTRING (p.denominacion,0,50) as denominacion
        $pdia=date('Y-m-d', strtotime($anio.'-01-01'));
        $udia=date('Y-m-d', strtotime($anio.'-12-31'));
        $sql="select p.id_pinv,coalesce(codigo,'')||' '||SUBSTRING(p.denominacion,1,60)||'....' as descripcion
              from pinvestigacion p "
              //." where extract (year from p.fec_desde) in (2015,2016,2017,2018,2019)
              //." where extract (year from p.fec_hasta) >= $anio
                ." where p.fec_desde<='".$udia."' and p.fec_hasta>='".$pdia
              ."' and (p.estado='A' or p.estado='N')
              and not exists (select * from subproyecto s
                              where s.id_proyecto=p.id_pinv)
              order by descripcion";
        
	$res= toba::db('designa')->consultar($sql);
	return $res;
    }
    function get_codigo_proyecto($id){
        $sql="select  codigo
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
        if(isset($res[0]['codigo'])){
            return $res[0]['codigo'];
        }else{
            return 'S/C';
        }
    }
    function get_ua_proyecto($id){
        $sql="select  uni_acad
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
	return $res[0]['uni_acad'];
    }
    function get_denominacion_proyecto($id){
        $sql="select denominacion
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
	return $res[0]['denominacion'];
    }
    function get_inicio_proyecto($id){
        $sql="select fec_desde
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
        $salida=date("d-m-Y",strtotime($res[0]['fec_desde'])); 
	return $salida;
    }
    function get_fin_proyecto($id){
        $sql="select fec_hasta
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
        $salida=date("d-m-Y",strtotime($res[0]['fec_hasta'])); 
	return $salida;
    }
    function get_ordenanza_proyecto($id){
        $sql="select case when nro_ord_cs is null then 'S/D' else nro_ord_cs end as ordenanza
              from pinvestigacion
              where id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
	return $res[0]['ordenanza'];
    }
    function get_director_proyecto($id){
        $sql="select case when t_do2.apellido is not null then trim(t_do2.apellido)||', '||trim(t_do2.nombre) else case when t_d3.apellido is not null then 'DE: '||trim(t_d3.apellido)||', '||trim(t_d3.nombre)  else '' end end as director
        from pinvestigacion t_p
        left outer join integrante_interno_pi id2 on (id2.pinvest=t_p.id_pinv and (id2.funcion_p='DP' or id2.funcion_p='DE'  or id2.funcion_p='D' or id2.funcion_p='DpP') and t_p.fec_hasta=id2.hasta)
        left outer join designacion t_d2 on (t_d2.id_designacion=id2.id_designacion)    
        left outer join docente t_do2 on (t_do2.id_docente=t_d2.id_docente) 
    
        left outer join integrante_externo_pi id3 on (id3.pinvest=t_p.id_pinv and (id3.funcion_p='DE' or id3.funcion_p='DEpP' ) and t_p.fec_hasta=id3.hasta)
        left outer join persona t_d3 on (t_d3.tipo_docum=id3.tipo_docum and t_d3.nro_docum=id3.nro_docum) 

        where t_p.id_pinv=$id";
	$res= toba::db('designa')->consultar($sql);
	return $res[0]['director'];
    }
    function get_unidades(){
        $sql="select sigla,descripcion
              from unidad_acad";
        $res= toba::db('designa')->consultar($sql);
	return $res;
    }
    function get_departamentos($uni_acad){
        $where=" where vigente and descripcion<>'SIN DEPARTAMENTO'";
        if(isset($uni_acad)){
          $where.=" and  idunidad_academica='".$uni_acad."'";  
        }
        $sql="select iddepto,descripcion
              from departamento
              $where
              order by descripcion";
	$res= toba::db('designa')->consultar($sql);
	return $res;
    }
    function get_designaciones($id_doc){
       // print_r($id_doc);
	$sql="select id_designacion, cat_estat||dedic||'-'||carac as descripcion
              from designacion d
              left outer join mocovi_periodo_presupuestario m on (d.desde <= m.fecha_fin and (d.hasta >= m.fecha_inicio or d.hasta is null))
              where m.actual
                  and d.id_docente=$id_doc
                  and not (d.hasta is not null and d.hasta<=d.desde)";//no esta anulada la designacion
	$res= toba::db('designa')->consultar($sql);
	return $res;
    }
     function get_legajo($id_doc){
  	$sql="select legajo
              from docente 
              where id_docente=$id_doc
             ";
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['legajo'];
    }
    function get_apellido($id_doc){
  	$sql="select apellido
              from docente 
              where id_docente=$id_doc
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['apellido'];
    }
    function get_nombre($id_doc){
  	$sql="select nombre
              from docente 
              where id_docente=$id_doc
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['nombre'];
    }
    function get_cuil($id_doc){
  	$sql="select nro_cuil1,nro_cuil,nro_cuil2 
              from docente 
              where id_docente=$id_doc
             ";
	
	$res= toba::db('designa')->consultar($sql);
        $salida=array();
        $salida[0]=$res[0]['nro_cuil1'];
        $salida[1]=$res[0]['nro_cuil'];
        $salida[2]=$res[0]['nro_cuil2'];
        return $salida;
	
    }
    function get_categoria($id_designacion){
  	$sql="select cat_estat
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['cat_estat'];
    }
    function get_dedicacion($id_designacion){
  	$sql="select dedic
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['dedic'];
    }
    function get_cargo($id_designacion){
  	$sql="select cat_estat||dedic as cargo
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['cargo'];
    }
    function get_ua($id_designacion){
  	$sql="select uni_acad
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['uni_acad'];
    }
    function get_caracter($id_designacion){
  	$sql="select carac
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['carac'];
	
    }
    function get_docente($id_designacion){
  	$sql="select id_docente
              from designacion d
              where d.id_designacion=$id_designacion
             ";
	
	$res= toba::db('designa')->consultar($sql);
        return $res[0]['id_docente'];
	
    }

}
?>