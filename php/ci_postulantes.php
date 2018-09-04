<?php
class ci_postulantes extends toba_ci
{
    protected $s__datos_filtro;
    protected $s__where;
    
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
            if (isset($this->s__datos_filtro)) {
                $cuadro->set_datos($this->dep('datos')->tabla('inscripcion_beca')->get_postulantes($this->s__datos_filtro));
            }
	}
        
        function evt__cuadro__seleccion($datos){
            $this->dep('datos')->tabla('inscripcion_beca')->cargar($datos);
            $datos2['id_becario']=$datos['id_becario'];
            $datos2['fecha']=$datos['fecha_presentacion'];
            $this->dep('datos')->tabla('inscripcion_adjuntos')->cargar($datos2);
            $this->set_pantalla('pant_editar');
        }
        
        function conf__formulario(toba_ei_formulario $form)
	{
                if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                    $datos=$this->dep('datos')->tabla('inscripcion_beca')->get();
                    $agente=$this->dep('datos')->tabla('becario')->get_datos_personales($datos['id_becario']);
                    $datos['agente']=$agente['nombre'];
                    if ($this->dep('datos')->tabla('inscripcion_adjuntos')->esta_cargada()) {
                        $adj=$this->dep('datos')->tabla('inscripcion_adjuntos')->get();
                        if(isset($adj['cert_ant'])){
                            //$nomb_ca='http://mocovi.uncoma.edu.ar/becarios_2019/'.$adj['cert_ant'];
                            $nomb_ca='/becarios/1.0/becarios_2019/'.$adj['cert_ant'];
                            $datos['imagen_vista_previa_ca'] = "<a target='_blank' href='{$nomb_ca}' >cert ant</a>";
                        }
                        if(isset($adj['const_titu'])){
                            $nomb_titu='/becarios/1.0/becarios_2019/'.$adj['const_titu'];
                            $datos['imagen_vista_previa_titu'] = "<a target='_blank' href='{$nomb_titu}' >titulo</a>";
                        }
                        if(isset($adj['rend_acad'])){
                            $nomb_ra='/becarios/1.0/becarios_2019/'.$adj['rend_acad'];
                            $datos['imagen_vista_previa_ra'] = "<a target='_blank' href='{$nomb_ra}' >rend acad</a>";
                        }
                        if(isset($adj['cv_post'])){
                            $nomb_cvp='/becarios/1.0/becarios_2019/'.$adj['cv_post'];
                            $datos['imagen_vista_previa_cvp'] = "<a target='_blank' href='{$nomb_cvp}' >cv postulante</a>";
                        }
                        if(isset($adj['cv_dir'])){
                            $nomb_cvdir='/becarios/1.0/becarios_2019/'.$adj['cv_dir'];
                            $datos['imagen_vista_previa_cvd'] = "<a target='_blank' href='{$nomb_cvdir}' >cv director</a>";
                        }
                        if(isset($adj['cv_codir'])){
                            $nomb_cdir='/becarios/1.0/becarios_2019/'.$adj['cv_codir'];
                            $datos['imagen_vista_previa_cvc'] = "<a target='_blank' href='{$nomb_cdir}' >cv codirector</a>";
                        }
                        if(isset($adj['cuil'])){
                            $nomb_cuil='/becarios/1.0/becarios_2019/'.$adj['cuil'];
                            $datos['imagen_vista_previa_cuil'] = "<a target='_blank' href='{$nomb_cuil}' >cuil</a>";
                        }
                        if(isset($adj['docum'])){
                            $nomb_doc='/becarios/1.0/becarios_2019/'.$adj['docum'];
                            $datos['imagen_vista_previa_docum'] = "<a target='_blank' href='{$nomb_doc}' >documento</a>";
                        }
                        if(isset($adj['comprob'])){
                            $nomb_comp='/becarios/1.0/becarios_2019/'.$adj['comprob'];
                            $datos['imagen_vista_previa_comp'] = "<a target='_blank' href='{$nomb_comp}' >comprobante</a>";
                        }
                    }
                    $form->set_datos($datos);    
                }
        }
         function evt__formulario__modificacion($datos)
        {
            $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
            $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
            toba::notificacion()->agregar('Los datos se han guardado correctamente', 'info');   
        }
        function evt__formulario__cancelar($datos)
        {
            $this->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->dep('datos')->tabla('becario')->resetear();    
            $this->set_pantalla('pant_inicial');
        }
        function evt__volver(){
            $this->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->dep('datos')->tabla('becario')->resetear();    
            $this->set_pantalla('pant_inicial');
        }
}
?>