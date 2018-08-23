<?php
class form_extension extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "
			{$this->objeto_js}.evt__efecto__procesar = function(es_inicial) 
			{
				if (! es_inicial) {
					this.evt__categ__procesar(es_inicial);
				}
			}
                        {$this->objeto_js}.evt__categ__procesar = function(es_inicial) 
			{
                                this.ef('categ').ocultar();
				switch (this.ef('categ').get_estado()) {                                     					
					case '3':
						this.ef('id_docentec').ocultar();
                                                this.ef('correoc').ocultar();
                                                this.ef('id_designacionc').ocultar();
                                                this.ef('tituloc').ocultar();
                                                this.ef('institucionc').ocultar();
                                                this.ef('lugar_trabajoc').ocultar();
                                                this.ef('cat_investc').ocultar();
                                                this.ef('cat_conicetc').ocultar();
						break;				
				}
			}
                        
			
			
			
                        ";
}
}
?>