<?php
class dt_opciones extends toba_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id, descripcion FROM opciones ORDER BY descripcion";
        return toba::db('becarios')->consultar($sql);
    }

}

?>