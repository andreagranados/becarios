<?php
class dt_convocatoria extends toba_datos_tabla
{
	function get_descripciones()
	{
		$sql = "SELECT id_conv, anio,descripcion FROM convocatoria ORDER BY descripcion";
		return toba::db('becarios')->consultar($sql);
	}

}
?>