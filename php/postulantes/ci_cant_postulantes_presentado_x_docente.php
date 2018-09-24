<?php
class ci_cant_postulantes_presentado_x_docente extends toba_ci
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
    
//---- cuadro_reserva -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if (isset($this->s__datos_filtro)) {
                $datos=$this->dep('datos')->tabla('director_beca')->get_cant_postulantes($this->s__datos_filtro); 
                $cuadro->set_datos($datos);    
            }
	}
}
?>