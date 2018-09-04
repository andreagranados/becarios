<?php
class form_descargar extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "
			
                        {$this->objeto_js}.evt__categ_beca__procesar = function(es_inicial) 
			{
                        if (! es_inicial) {//En el inicial no se afecta para que se perciba el ocultamiento desde el server
                       /* Muestra el botón descargar solo si se ha seleccionado una opcion del combo*/
				switch (this.ef('categ_beca').get_estado()) {                                     					
					case '3':
                                            this.mostrar_boton('descargar');
                                            break;	
                                        case '2':
                                            this.mostrar_boton('descargar');
                                            break;	
                                        case '1':
                                            this.mostrar_boton('descargar');
                                            break;
                                         default:this.ocultar_boton('descargar');break;        
				}
			}
                        }

                        ";
  }
}
?>