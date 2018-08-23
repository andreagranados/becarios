<?php
class dt_categoria_conicet extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT id_categ, descripcion FROM categoria_conicet ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}

}

?>