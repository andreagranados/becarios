<?php
class dt_convocatoria extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT id_conv,anio,descripcion FROM convocatoria ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}
        function get_descripciones_filtro($filtro)
	{
            $where='';
            if(isset($filtro)){
                $where=" where id_conv=".$filtro['id_conv'];
            }
            
            $sql = "SELECT * FROM convocatoria $where"
                    . "ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}
        //recibe el año de la inscripcion a beca y en funcion a la convocatoria a la que corresponda se fija si puede o no modificar
        function puedo_modificar($anio){
            $band=false;
            $sql="select fec_inicio_ua,fec_fin_ua from convocatoria "
                    . "where anio=$anio";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
               // print_r($fecha_actual);
                if($fecha_actual>=$res[0]['fec_inicio_ua'] && $fecha_actual<=$res[0]['fec_fin_ua']){
                    $band=true;
                }
            }
            return $band;
        }
        function puede_ver_asignados($anio){
            $band=false;
            $sql="select fec_ver_asignadas from convocatoria "
                    . " where anio=$anio";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
                if($fecha_actual>=$res[0]['fec_ver_asignadas']){
                    $band=true;
                }
            }
            return $band;
        }

}
?>