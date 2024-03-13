<?php
class dt_estado extends toba_datos_tabla
{
    function get_descripciones()
    {
        $sql = "SELECT id_estado, descripcion FROM estado ";
        return toba::db('becarios')->consultar($sql);
    }

}

?>