<?php
class formulario_extension extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "             
                        {$this->objeto_js}.evt__estado__procesar = function(es_inicial) 
			{
				switch (this.ef('estado').get_estado()) {                                     					
					case 'R':
                                                this.ef('fecha_renuncia').mostrar();break;
                                                
                                        default: this.ef('fecha_renuncia').ocultar();break; 
				}
                                
			}
                        ";
}
}?>