<?php
class dt_categoria_beca extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT id_categ, descripcion FROM categoria_beca "
                    . " ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}
        function get_descripcion_categoria($id)
	{
            $salida='';
            $sql = "SELECT id_categ FROM categoria_beca "
                    . " where id_categ=$id";
            $res = toba::db('becarios')->consultar($sql);
            switch ($res[0]['id_categ']) {
                case 1:     $salida='BECA GRADUADO DE PERFECCIONAMIENTO';               break;
                case 2:     $salida='BECA GRADUADO DE INICIACIÓN';             break;
                case 3:     $salida='BECA DE INICIACIÓN EN LA INVESTIGACIÓN PARA ESTUDIANTES DE LA UNIVERSIDAD NACIONAL DEL COMAHUE';             break;
                default:
                    break;
            }
            return $salida;
            
	}
       

}

?>