<?php
class dt_ua_evaluadora extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT id, uni_acad FROM ua_evaluadora ORDER BY uni_acad";
            return toba::db('becarios')->consultar($sql);
	}
        //listado de las UA evaluadoras correspondientes al anio que ingresa como argumento y cuya UA sea distinta a la del becario
        function get_ua_evaluadoras($id_conv,$ua)
	{
            $where='';
            if(isset($id_conv)){
                $where.=' and id_convocatoria='.$id_conv;
            }
            if(isset($ua)){
                $where.=" and  uni_acad<>'".$ua."'";
            }
            $sql = "SELECT u.id, u.uni_acad||'('||u.nombre_evaluador||')' as descripcion"
                    . " FROM ua_evaluadora u, convocatoria c "
                    . " where u.id_convocatoria=c.id_conv"
                    . $where
                    . " ORDER BY uni_acad";
            return toba::db('becarios')->consultar($sql);
	}

}
?>