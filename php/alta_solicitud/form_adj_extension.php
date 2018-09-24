<?php
class form_adj_extension extends toba_ei_formulario
{
     function extender_objeto_js()
    {
     echo "
                        {$this->objeto_js}.evt__categ__procesar = function(es_inicial) 
			{
                                this.ef('categ').ocultar();
				switch (this.ef('categ').get_estado()) {                                     					
					case '3':
                                                this.ef('const_titu').ocultar();
                                                this.ef('cv_codir').ocultar();
						break;
                                             
				}
			}

                        ";
}
}
?>