<?php
class ci_convocatoria extends toba_ci
{
        protected $s__datos_filtro;
        //---- Filtro -----------------------------------------------------------------------

	function conf__filtro(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}
        //-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            $cuadro->set_datos($this->dep('datos')->tabla('convocatoria')->get_descripciones_filtro($this->s__datos_filtro));
	}
        function evt__cuadro__seleccion($datos){
            $this->dep('datos')->tabla('convocatoria')->cargar($datos);
            $this->set_pantalla('pant_edicion');
        }
        //-----------------------------------------------------------------------------------
	//---- formulario -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__formulario(toba_ei_formulario $form)
        {
           if ($this->dep('datos')->tabla('convocatoria')->esta_cargada()) {
                $datos=$this->dep('datos')->tabla('convocatoria')->get();
                $form->set_datos($datos);    
           }
        }
	//-----------------------------------------------------------------------------------
	//---- formulario -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__formulario__alta($datos)
	{
            $this->dep('datos')->tabla('convocatoria')->set($datos);
            $this->dep('datos')->tabla('convocatoria')->sincronizar();
            toba::notificacion()->agregar('La convocatoria ha sido dada de alta exitosamente', 'info');
            $this->set_pantalla('pant_inicial');
	}

	function evt__formulario__baja()
	{
            $datos=$this->dep('datos')->tabla('convocatoria')->get();
            $band=$this->dep('datos')->tabla('convocatoria')->puedo_borrar($datos['id_conv']);
            if($band){
                $this->dep('datos')->tabla('convocatoria')->eliminar_todo();
                toba::notificacion()->agregar('La convocatoria se ha eliminado correctamente', 'info');
            }else{
                toba::notificacion()->agregar('Esta convocatoria no puede ser eliminada. Existen inscripciones asociadas.', 'info');
            }
            $this->dep('datos')->tabla('convocatoria')->resetear();
            $this->set_pantalla('pant_inicial');  
	}

	function evt__formulario__modificacion($datos)
	{
            $this->dep('datos')->tabla('convocatoria')->set($datos);
            $this->dep('datos')->tabla('convocatoria')->sincronizar();
	}

	function evt__formulario__cancelar()
	{
            $this->dep('datos')->tabla('convocatoria')->resetear();
            $this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

}
?>