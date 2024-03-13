<?php
class dt_convocatoria extends toba_datos_tabla
{
	function get_descripciones()
	{
            $sql = "SELECT id_conv,anio,descripcion FROM convocatoria ORDER BY descripcion";
            return toba::db('becarios')->consultar($sql);
	}
        function get_descripciones_filtro($filtro)
        {  
            $where='';
            if(isset($filtro['id_conv'])){
                $where=" where id_conv=".$filtro['id_conv'];
            }
            
            $sql = "SELECT * FROM convocatoria $where"
                    . "ORDER BY anio desc";
            return toba::db('becarios')->consultar($sql);
	}
        function puedo_modificar_inf_avan($id_conv){//puedo modificar Informes de Avance
            $band=false;
            $sql="select fec_inicio_ia,	fec_fin_ia from convocatoria "
                    . "where id_conv=$id_conv";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
               // print_r($fecha_actual);
                if($fecha_actual>=$res[0]['fec_inicio_ia'] && $fecha_actual<=$res[0]['fec_fin_ia']){
                    $band=true;
                }
            }
            return $band;
        }
        function puedo_modificar_inf_fin($id_conv){//puedo modificar Informes Finales
            $band=false;
            $sql="select fec_inicio_if,	fec_fin_if from convocatoria "
                    . "where id_conv=$id_conv";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
               // print_r($fecha_actual);
                if($fecha_actual>=$res[0]['fec_inicio_if'] && $fecha_actual<=$res[0]['fec_fin_if']){
                    $band=true;
                }
            }
            return $band;
        }
        //recibe el id de la convocatoria corresp a la inscripcion a beca y  se fija si puede o no modificar
         function puedo_modificar($id_conv){
            $band=false;
            $sql="select fec_inicio_ua,fec_fin_ua from convocatoria "
                    . "where id_conv=$id_conv";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
               // print_r($fecha_actual);
                if($fecha_actual>=$res[0]['fec_inicio_ua'] && $fecha_actual<=$res[0]['fec_fin_ua']){
                    $band=true;
                }
            }
            return $band;
        }
//        function puede_ver_asignados($anio){
//            $band=false;
//            $sql="select fec_ver_asignadas from convocatoria "
//                    . " where anio=$anio";
//            $res = toba::db('becarios')->consultar($sql);
//            if(isset($res)){
//                $fecha_actual=date('Y-m-d');
//                if($fecha_actual>=$res[0]['fec_ver_asignadas']){
//                    $band=true;
//                }
//            }
//            return $band;
//        }
        function puede_ver_asignados($id_conv){
            $band=false;
            $sql="select fec_ver_asignadas from convocatoria "
                    . " where id_conv=$id_conv";
            $res = toba::db('becarios')->consultar($sql);
            if(isset($res)){
                $fecha_actual=date('Y-m-d');
                if($fecha_actual>=$res[0]['fec_ver_asignadas']){
                    $band=true;
                }
            }
            return $band;
        }
        function convocatoria_actual(){//retorna el id de la convocatoria si existe conv actual, sino retorna nulo
            $fec_actual=date('Y-m-d');
            $sql="select * from convocatoria where inicio<='".$fec_actual."' and  fec_fin_ua>='".$fec_actual."'";
            $resul=toba::db('becarios')->consultar($sql);
            if(count($resul)>0){
                return $resul[0]['id_conv'];
            }else 
                return null;
        }
        function get_anio($id_conv){
            $sql="select * from convocatoria where id_conv=".$id_conv;
            $resul=toba::db('becarios')->consultar($sql);
            if(count($resul)>0){
                return $resul[0]['anio'];
            }else 
                return ' ';
        }
        function puedo_borrar($id_conv){
            $sql="select * from inscripcion_beca where id_conv=".$id_conv;
            $resul=toba::db('becarios')->consultar($sql);
            if(count($resul)>0){
                return false;
            }else{
                return true;
            }
        }

}
?>