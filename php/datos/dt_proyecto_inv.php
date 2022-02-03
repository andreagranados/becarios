<?php
require_once 'consultas_designa.php';
class dt_proyecto_inv extends toba_datos_tabla
{
    
	function get_descripciones()
	{
            $sql = "SELECT id_pinv, codigo FROM proyecto_inv ORDER BY codigo";
            return toba::db('becarios')->consultar($sql);
	}
        function get_proyectos($anio){
            $pro = consultas_designa::get_proyectos($anio);
            return $pro;
        }
        function get_codigo_proyecto($id){
           $res = consultas_designa::get_codigo_proyecto($id);
           return $res;
        }
        function get_ua_proyecto($id){
           $res = consultas_designa::get_ua_proyecto($id);
           return $res;
        }
        function get_denominacion_proyecto($id){
           $res = consultas_designa::get_denominacion_proyecto($id);
           return $res;
        }
        function get_inicio_proyecto($id){
           $res = consultas_designa::get_inicio_proyecto($id);
           return $res;
        }
        function get_fin_proyecto($id){
           $res = consultas_designa::get_fin_proyecto($id);
           return $res;
        }
        function get_director_proyecto($id){
           $res = consultas_designa::get_director_proyecto($id);
           return $res;
        }
        function get_ordenanza_proyecto($id){
           $res = consultas_designa::get_ordenanza_proyecto($id);
           return $res;
        }
        function get_codigo($id_p){
            $sql="select codigo from proyecto_inv where id_pinv=$id_p";
            $res = toba::db('becarios')->consultar($sql);
            return $res[0]['codigo'];
        }
        function get_datos_proyecto($id){
            $sql="select * from proyecto_inv "
                    . " where id_pinv=".$id;
            $res= toba::db('becarios')->consultar($sql);
            return $res[0];
        }
}
?>