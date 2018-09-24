<?php
class form_dir_extension extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "
			{$this->objeto_js}.evt__tiene_codir__procesar = function(es_inicial) 
			{
				/*if (! es_inicial) {
					this.evt__categ__procesar(es_inicial);
				}*/
                              
                                switch (this.ef('tiene_codir').get_estado()) {
                                    case 'si':  
						this.ef('id_docentec').mostrar();
                                                this.ef('correoc').mostrar();
                                                this.ef('id_designacionc').mostrar();
                                                this.ef('tituloc').mostrar();
                                                this.ef('institucionc').mostrar();
                                                this.ef('lugar_trabajoc').mostrar();
                                                this.ef('cat_investc').mostrar();
                                                this.ef('cat_conicetc').mostrar();
                                                this.ef('cod_paisc').mostrar();
                                                this.ef('cod_provinciac').mostrar();
                                                this.ef('cod_postalc').mostrar();
                                                this.ef('callec').mostrar();
                                                this.ef('numeroc').mostrar();
                                                this.ef('telefonoc').mostrar();
                                                this.ef('hs_dedic_invesc').mostrar();
                                    break;
                                    case 'no':  
                                                this.ef('otro_organismoc').ocultar();
                                                this.ef('rayac').ocultar();
                                                this.ef('direccionc').ocultar();
						this.ef('id_docentec').ocultar();
                                                this.ef('correoc').ocultar();
                                                this.ef('id_designacionc').ocultar();
                                                this.ef('tituloc').ocultar();
                                                this.ef('institucionc').ocultar();
                                                this.ef('lugar_trabajoc').ocultar();
                                                this.ef('cat_investc').ocultar();
                                                this.ef('cat_conicetc').ocultar();
                                                this.ef('cod_paisc').ocultar();
                                                this.ef('cod_provinciac').ocultar();
                                                this.ef('cod_postalc').ocultar();
                                                this.ef('callec').ocultar();
                                                this.ef('numeroc').ocultar();
                                                this.ef('telefonoc').ocultar();
                                                this.ef('hs_dedic_invesc').ocultar();
                                    break;
                                }
			}
                        
                        {$this->objeto_js}.evt__categ__procesar = function(es_inicial) 
			{
                                this.ef('categ').ocultar();
				switch (this.ef('categ').get_estado()) {                                     					
					case '3':
                                                this.ef('tiene_codir').ocultar();
                                                this.ef('otro_organismoc').ocultar();
                                                this.ef('rayac').ocultar();
                                                this.ef('direccionc').ocultar();
						this.ef('id_docentec').ocultar();
                                                this.ef('correoc').ocultar();
                                                this.ef('id_designacionc').ocultar();
                                                this.ef('tituloc').ocultar();
                                                this.ef('institucionc').ocultar();
                                                this.ef('lugar_trabajoc').ocultar();
                                                this.ef('cat_investc').ocultar();
                                                this.ef('cat_conicetc').ocultar();
                                                this.ef('cod_paisc').ocultar();
                                                this.ef('cod_provinciac').ocultar();
                                                this.ef('cod_postalc').ocultar();
                                                this.ef('callec').ocultar();
                                                this.ef('numeroc').ocultar();
                                                this.ef('telefonoc').ocultar();
                                                this.ef('hs_dedic_invesc').ocultar();
                                                
						break;
                                        case '1': break;       
				}
			}
                        
			
			
			
                        ";
}
}
?>