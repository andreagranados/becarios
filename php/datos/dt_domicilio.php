<?php
class dt_domicilio extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT * FROM domicilio ";
            return toba::db('becarios')->consultar($sql);
	}
}
?>        