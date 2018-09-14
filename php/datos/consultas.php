<?php
class consultas
{
     //este metodo permite mostrar la descripcion del estado del campo titulog
    //este metodo permite mostrar la descripcion del estado del campo codc_titul de form_curric docente_solapas.php
    static function get_proyecto($id=null){
         if (! isset($id)) {
            return array();
         }else{
		$id = quote($id);
		$sql = "SELECT 
					id_pinv, denominacion
				FROM 
					pinvestigacion
				WHERE
					id_pinv = $id";
		$result = toba::db('designa')->consultar($sql);
		if (! empty($result)) {
			return $result[0]['denominacion'];
		}
            }
	
        }
                
    static function get_proyectos_todos($filtro=null, $locale=null){
                if (! isset($filtro) || ($filtro == null) || trim($filtro) == '') {
			return array();
		}
		$where = '';
		if (isset($locale)) {
			$locale = quote($locale);
			$where = "AND locale=$locale";
		}
		$filtro = quote("{$filtro}%");
                $sql = "SELECT id_pinv, denominacion "
                        . " FROM pinvestigacion "
//                        . " WHERE  denominacion ILIKE $filtro"
//                        . " $where"
                        . " ORDER BY codigo";
			
		return toba::db('designa')->consultar($sql);
	}
}
?>