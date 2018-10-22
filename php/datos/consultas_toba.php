<?php

/* consultar la base toba */

class consultas_toba {
     function desbloquear($usuario){
        $sql=" update produccion.apex_usuario set bloqueado=0 where usuario='".$usuario."'";
        toba::db('toba')->consultar($sql);
    }
}
?>