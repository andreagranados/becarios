<?php
class cuadro_descargar extends toba_ei_cuadro
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		
		
		{$this->objeto_js}.invocar_vinculo = function(vista, id_vinculo)
		{
                    if(vista=='pdf_acta'){
                            this.controlador.ajax('cargar_fila',id_vinculo,this,this.retorno);
                        }
                    
                    
                    return false;
		}
		 {$this->objeto_js}.retorno = function(datos)
		{
                 if(datos==-1){alert('No tiene un acta adjunto');
                   }else{vinculador.invocar(datos);}
		}
		
		";
	}

}

?>