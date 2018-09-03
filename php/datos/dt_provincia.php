<?php
class dt_provincia extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT codigo_pcia,descripcion_pcia FROM provincia ORDER BY descripcion_pcia";
            return toba::db('becarios')->consultar($sql);
	}
        function get_provincias($id_pais=null){
            $where='';
            if(isset($id_pais)){
                $where=" WHERE cod_pais ='".$id_pais."'";
            }
            $sql="select codigo_pcia,descripcion_pcia from provincia "
                    . $where
                    ." order by descripcion_pcia";
          print_r($sql);
           return toba::db('becarios')->consultar($sql); 
        }
}

?>