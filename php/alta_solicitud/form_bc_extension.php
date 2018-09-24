<?php
class form_bc_extension extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "
                        {$this->objeto_js}.evt__beca_en_curso__procesar = function(es_inicial) 
			{
                        /*if (! es_inicial) {*/
				if (this.ef('beca_en_curso').chequeado()) {
				    this.ef('institucion_beca_en_curso').mostrar();
			        } else {
				    this.ef('institucion_beca_en_curso').ocultar();
				}
			 /* }*/
                        }
                        ";
}
}
?>