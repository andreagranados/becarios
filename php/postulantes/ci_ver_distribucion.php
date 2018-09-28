<?php
class ci_ver_distribucion extends toba_ci
{
    protected $s__datos_filtro;
    protected $s__where;
        //-----------------------------------------------------------------------------------
	//---- filtros -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtros(toba_ei_filtro $filtro)
	{
            if (isset($this->s__datos_filtro)) {
                    $filtro->set_datos($this->s__datos_filtro);
		}
	}
        function evt__filtros__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
                $this->s__where = $this->dep('filtros')->get_sql_where();
	}

	function evt__filtros__cancelar()
	{
		unset($this->s__datos_filtro);
                unset($this->s__where);
	}
        //-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
            if (isset($this->s__datos_filtro)) {
                $cuadro->set_datos($this->dep('datos')->tabla('evaluador')->get_distribucion($this->s__datos_filtro));
            }
	}
        function evt__cuadro__seleccion($datos){
            $this->dep('datos')->tabla('ua_evaluadora')->cargar($datos);
            $this->set_pantalla('pant_ver');
        }
        
        function conf__cuadro_post(toba_ei_cuadro $cuadro)
	{
            if ($this->dep('datos')->tabla('ua_evaluadora')->esta_cargada()) {
                $datos=$this->dep('datos')->tabla('ua_evaluadora')->get();
                $cuadro->set_datos($this->dep('datos')->tabla('evaluador')->get_evaluados_x($datos['id']));
            }
	}
        function evt__cuadro_post__cancelar(){
             $this->dep('datos')->tabla('ua_evaluadora')->resetear();   
             $this->set_pantalla('pant_inicial');
        }
}
?>