<?php
class ci_postulantes extends toba_ci
{
    protected $s__datos_filtro;
    protected $s__where;
    protected $s__mostrar;
	 //-----------------------------------------------------------------------------------
	//---- filtros ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtros(toba_ei_filtro $filtro)
	{
            if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}
        function evt__filtros__filtrar($datos)
	{
            //print_r($datos);
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
            if (isset($this->s__where)) {
                $cuadro->set_datos($this->dep('datos')->tabla('inscripcion_beca')->get_postulantes($this->s__where));
            }
	}
        
        function evt__cuadro__seleccion($datos){
            $this->dep('datos')->tabla('inscripcion_beca')->cargar($datos);
            $this->s__mostrar=1;
        }
        
        function conf__formulario(toba_ei_formulario $form)
	{
            if($this->s__mostrar==1){
                $this->dep('formulario')->descolapsar();
                if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                    $datos=$this->dep('datos')->tabla('inscripcion_beca')->get();
                    $agente=$this->dep('datos')->tabla('becario')->get_datos_personales($datos['id_becario']);
                    $datos['agente']=$agente['nombre'];
                    $form->set_datos($datos);    
                }
            }else{
                $this->dep('formulario')->colapsar();
            }
        }
         function evt__formulario__modificacion($datos)
        {
            $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
            $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
            $this->dep('datos')->tabla('inscripcion_beca')->resetear(); 
            $this->s__mostrar=0;
            toba::notificacion()->agregar('Los datos se han guardado correctamente', 'info');   
        }
        function evt__formulario__cancelar($datos)
        {
            $this->s__mostrar=0;
            $this->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->dep('datos')->tabla('becario')->resetear();    
        }
}
?>