<?php
class form_ocultar_mostrar extends toba_ei_formulario
{
    function extender_objeto_js()
    {
     echo "
			{$this->objeto_js}.evt__efecto__procesar = function(es_inicial) 
			{
				if (! es_inicial) {
					this.evt__categ__procesar(es_inicial);
                                        this.evt__inst__procesar(es_inicial);
				}
			}
                        {$this->objeto_js}.evt__categ__procesar = function(es_inicial) 
			{
                                this.ef('categ').ocultar();
				/*switch (this.ef('categ').get_estado()) {
					case '1':
                                                this.ef('cant_materias_aprobadas').ocultar();
                                                this.ef('porc_mat_aprob').ocultar();
						break;
					case '2':
                                                this.ef('cant_materias_aprobadas').ocultar();
                                                this.ef('porc_mat_aprob').ocultar();
						break;
                                       					
					case '3':
						this.ef('institucion').ocultar();
                                                this.ef('cant_materias_adeuda').ocultar();
                                                this.ef('titulo').ocultar();
                                                this.ef('fecha_finalizacion').ocultar();
						break;				
				}
                                */
                                
			}
                        {$this->objeto_js}.evt__inst__procesar = function(es_inicial) 
			{
                            switch (this.ef('inst').get_estado()) {
                                    case '1': this.ef('uni_acad').mostrar();/*selecciono Otro entonces tiene que completar la institucion*/
                                              this.ef('car').mostrar();
                                              this.ef('carrera').ocultar();
                                              this.ef('institucion').ocultar();
                                              break;
                                    case '2': this.ef('uni_acad').ocultar();/*seleccion UNCO*/
                                              this.ef('car').ocultar();
                                              this.ef('carrera').mostrar();
                                              this.ef('institucion').mostrar();
                                              break;
                                    default:this.ef('institucion').ocultar();/*por defecto unidad acad e institucion no aparecen*/
                                            this.ef('uni_acad').ocultar();
                                            this.ef('car').ocultar();
                                            this.ef('carrera').ocultar();
                                            break;          
                                    
                                }
                        }
                        
			
			
			
                        ";
}
}
?>