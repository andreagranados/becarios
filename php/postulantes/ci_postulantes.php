<?php
//class ci_postulantes extends toba_ci
class ci_postulantes extends becarios_abm_ci
{
    protected $s__datos_filtro;
    protected $s__where;
    protected $s__leyenda='No generado por el postulante';
    
        
        function get_ua_evaluadoras(){
            $res=array();
            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
            if(isset($inscripcion)){
                $res=$this->dep('datos')->tabla('ua_evaluadora')->get_ua_evaluadoras($inscripcion['id_conv'],$inscripcion['uni_acad']);
            }
            
            return $res;    
        }
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
            $estado=$this->dep('datos')->tabla('inscripcion_beca')->get_estado($datos);
            if($estado<>'I'){
                $this->dep('datos')->tabla('inscripcion_beca')->cargar($datos);
                $datos2['id_becario']=$datos['id_becario'];
                //$datos2['fecha']=$datos['fecha_presentacion'];
                $datos2['id_conv']=$datos['id_conv'];
                $this->dep('datos')->tabla('inscripcion_adjuntos')->cargar($datos2);
                $this->set_pantalla('pant_editar');
            }else{
                toba::notificacion()->agregar(utf8_decode('No puede editar una inscripción que no ha sido enviada por el becario.'), 'info');   
            } 
        }
        
        function evt__cuadro__asignarp($datos){
            $estado=$this->dep('datos')->tabla('inscripcion_beca')->get_estado($datos);
            if($estado=='A'){
                $this->dep('datos')->tabla('inscripcion_beca')->cargar($datos);
                //cargo los evaluadores del becario seleccionado y luego uso el get_filas
                $datos2['id_becario']=$datos['id_becario'];
                $datos2['id_conv']=$datos['id_conv'];
                $this->dep('datos')->tabla('evaluador')->cargar($datos2);
                $this->set_pantalla('pant_asigna');
            }else{
                toba::notificacion()->agregar(utf8_decode('La inscripción debe estar Admitida(A) para poder asignarle evaluadores.'), 'info');   
            }
            
        }
        
        function conf__formulario(toba_ei_formulario $form)
	{
            $form->evento('imprimir1')->vinculo()->agregar_parametro('evento_trigger', 'imprimir1');
            $form->evento('imprimir2')->vinculo()->agregar_parametro('evento_trigger', 'imprimir2'); 
            if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                    $datos=$this->dep('datos')->tabla('inscripcion_beca')->get();
                    $anio=$this->dep('datos')->tabla('convocatoria')->get_anio($datos['id_conv']);
                    if($datos['categ_beca']==3){//estudiantes desactivo 
                         $form->desactivar_efs(array('imagen_vista_previa_titu','imagen_vista_previa_cvc')); 
                    }
                    $agente=$this->dep('datos')->tabla('becario')->get_datos_personales($datos['id_becario']);
                    $datos['agente']=$agente['nombre'];
                    if ($this->dep('datos')->tabla('inscripcion_adjuntos')->esta_cargada()) {
                        $user=getenv('DB_USER_SL');
                        $password=getenv('DB_PASS_SL');
                        $adj=$this->dep('datos')->tabla('inscripcion_adjuntos')->get();
                        $carpeta='becarios_'.$anio.'_'.$datos['id_conv'];
                        if(isset($adj['cert_ant'])){
                            $nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                            //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                            $datos['imagen_vista_previa_ca'] = "<a target='_blank' href='{$nomb_ca}' >cert ant</a>";
                        }
                        if(isset($adj['const_titu'])){
                            $nomb_titu='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['const_titu'];
                            //$nomb_titu='/becarios/1.0/becarios_'.$anio.'/'.$adj['const_titu'];
                            $datos['imagen_vista_previa_titu'] = "<a target='_blank' href='{$nomb_titu}' >titulo</a>";
                        }
                        if(isset($adj['rend_acad'])){
                            $nomb_ra='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['rend_acad'];
                            //$nomb_ra='/becarios/1.0/becarios_'.$anio.'/'.$adj['rend_acad'];
                            $datos['imagen_vista_previa_ra'] = "<a target='_blank' href='{$nomb_ra}' >rend acad</a>";
                        }
                        if(isset($adj['cv_post'])){
                            $nomb_cvp='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_post'];
                            //$nomb_cvp='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_post'];
                            $datos['imagen_vista_previa_cvp'] = "<a target='_blank' href='{$nomb_cvp}' >cv postulante</a>";
                        }
                        if(isset($adj['cv_dir'])){
                            $nomb_cvdir='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_dir'];
                            //$nomb_cvdir='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_dir'];
                            $datos['imagen_vista_previa_cvd'] = "<a target='_blank' href='{$nomb_cvdir}' >cv director</a>";
                        }
                        if(isset($adj['cv_codir'])){
                            $nomb_cdir='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_codir'];
                            //$nomb_cdir='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_codir'];
                            $datos['imagen_vista_previa_cvc'] = "<a target='_blank' href='{$nomb_cdir}' >cv codirector</a>";
                        }
                        if(isset($adj['cuil'])){
                            $nomb_cuil='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cuil'];
                            //$nomb_cuil='/becarios/1.0/becarios_'.$anio.'/'.$adj['cuil'];
                            $datos['imagen_vista_previa_cuil'] = "<a target='_blank' href='{$nomb_cuil}' >cuil</a>";
                        }
                        if(isset($adj['docum'])){
                            $nomb_doc='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['docum'];
                            //$nomb_doc='/becarios/1.0/becarios_'.$anio.'/'.$adj['docum'];
                            $datos['imagen_vista_previa_docum'] = "<a target='_blank' href='{$nomb_doc}' >documento</a>";
                        }
                        if(isset($adj['comprob'])){
                            $nomb_comp='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['comprob'];
                            //$nomb_comp='/becarios/1.0/becarios_'.$anio.'/'.$adj['comprob'];
                            $datos['imagen_vista_previa_comp'] = "<a target='_blank' href='{$nomb_comp}' >comprobante</a>";
                        }
                        if(isset($adj['desarrollo_pt'])){
                            $nomb_des_pt='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['desarrollo_pt'];
                            //$nomb_des_pt='/becarios/1.0/becarios_'.$anio.'/'.$adj['desarrollo_pt'];
                            $datos['imagen_vista_previa_dp'] = "<a target='_blank' href='{$nomb_des_pt}' >desarrollo plan trabajo</a>";
                        }
                        if(isset($adj['informe_final'])){
                            $nomb_informe_final='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['informe_final'];
                            //$nomb_informe_final='/becarios/1.0/becarios_'.$anio.'/'.$adj['informe_final'];
                            $datos['imagen_vista_previa_if'] = "<a target='_blank' href='{$nomb_informe_final}' >informe final</a>";
                        }
                    }
                    $form->set_datos($datos);    
                }
        }
        function evt__formulario__modificacion($datos)
        {//solo estado, puntaje y observaciones
            //print_r($datos);exit;
            $mensaje='';
            $band=true;
            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
           // $anio=date("Y",strtotime($inscripcion['fecha_presentacion']));
            if($inscripcion['estado']=='I'){//cuando la inscripcion esta en I nadie puede cambiar nada
                toba::notificacion()->agregar('No puede modificar una inscripción que no ha sido enviada por el becario.', 'error');   
            }else{
                //esto es para todos porque nadie puede pasar a E
                if($inscripcion['estado']<>'E' && $datos['estado']=='E' ){//la inscripcion no esta en estado E y se la quiere pasar
                    toba::notificacion()->agregar('La inscripcion no puede ser pasada a E por la UA. Es el becario es quien debe hacerlo.', 'error');   
                }else{//puedo cambiar estado
                    
                    $perfil = toba::usuario()->get_perfil_datos();
                    if ($perfil == null) {//es usuario de SCyT
                    //usuario de SCyT puede modificar siempre salvo por no pasar a E que ya se chequeo antes
                       // $datos2['estado']=$datos['estado'];
                        //$datos2['observaciones']=$datos['observaciones'];
                        if(isset($datos['puntaje'])){//si han cargado puntaje en el formulario
                            if($inscripcion['estado']=='A'){//solo si esta aceptado puede cambiar puntaje
                                $datos2['puntaje']=$datos['puntaje'];
                            }else{
                                $band=false;
                                toba::notificacion()->agregar(utf8_decode('La inscripción debe estar Admitida (A) para poder ingresarle el puntaje'), 'info');   
                            }
                        }
                    }else{//usuario de la UA solo puede modificar durante el periodo indicado en la convocatoria
                    //solo estado y observaciones
                        //$band=$this->dep('datos')->tabla('convocatoria')->puedo_modificar($anio+1);
                        $band=$this->dep('datos')->tabla('convocatoria')->puedo_modificar($inscripcion['id_conv']);
                        if(!$band){
                            $mensaje=utf8_decode('No puede modificar porque ha pasado el período para hacer cambios');}
                    }
                    if($band){
                        $datos2['estado']=$datos['estado'];
                        $datos2['observaciones']=$datos['observaciones'];
                        if($datos['estado']=='I'){//si reabre la inscripcion se pierde la fecha de envio
                            $datos2['fecha_envio']=null;$mensaje='. Inscripcion reabierta, se ha perdido la fecha de envio.';
                            $usuario=$this->dep('datos')->tabla('inscripcion_beca')->get_usuario($inscripcion['id_becario']);
                            $this->dep('datos')->tabla('inscripcion_beca')->desbloquear($usuario);
                        }
                        $this->dep('datos')->tabla('inscripcion_beca')->set($datos2);
                        $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
                        toba::notificacion()->agregar('Los datos se han guardado correctamente'.$mensaje, 'info');   
                    }else{
                      toba::notificacion()->agregar($mensaje, 'info');   
                    }
             
                }
            }
        }
        
        function evt__formulario__cancelar($datos)
        {
            $this->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->dep('datos')->tabla('becario')->resetear();    
            $this->set_pantalla('pant_inicial');
        }
        function evt__volver(){
            $this->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->dep('datos')->tabla('inscripcion_adjuntos')->resetear();
            $this->dep('datos')->tabla('becario')->resetear();    
            $this->dep('datos')->tabla('evaluador')->resetear();    
            $this->set_pantalla('pant_inicial');
        }
//este metodo lo copie tal cual de alta solicitud //sale con leyenda separada  No generado por becario 

//        function vista_pdf(toba_vista_pdf $salida){
//          $bandera = toba::memoria()->get_parametro('evento_trigger');
//          //print_r($bandera);exit;
//          $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
//          $anio=date("Y",strtotime($inscripcion['fecha_presentacion']))+1;
//          $cat=$this->dep('datos')->tabla('categoria_beca')->get_descripcion_categoria($inscripcion['categ_beca']);
//          $datos_bec=$this->dep('datos')->tabla('becario')->get_datos_personales($inscripcion['id_becario']);
//          $fec_nac=date("d/m/Y",strtotime($datos_bec['fec_nacim']));
//          $datos_dir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_director']); 
//          $datos_codir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_codirector']); 
//          $datos_adj=$this->dep('datos')->tabla('inscripcion_adjuntos')->get_datos_adjuntos($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);          
//          //print_r($bandera);exit;
//          $datos_proy=$this->dep('datos')->tabla('proyecto_inv')->get_datos_proyecto($inscripcion['id_proyecto']);
//          $datos_insc=$this->dep('datos')->tabla('inscripcion_beca')->get_datos_inscripcion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);
//          $datos_carrera=$this->dep('datos')->tabla('carrera_inscripcion_beca')->get_datos_carrera($inscripcion['id_carrera']); 
//          
//          if(isset($inscripcion['uni_acad'])){
//                $uacad=$this->dep('datos')->tabla('inscripcion_beca')->get_unidad($inscripcion['uni_acad']);
//            }else{
//                $uacad='';
//           }
//          if($bandera=='imprimir1'){//imprimir el formulario
//            $salida->set_nombre_archivo("Inscripcion_Becario.pdf");
//            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
//            $salida->set_papel_orientacion('portrait');//landscape
//            $salida->inicializar();
//            $pdf = $salida->get_pdf();
//            $pdf->ezSetMargins(100, 50, 45, 45);
//            //Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
//            //Primero definimos la plantilla para el número de página.
//            $formato = utf8_decode('Convocatoria Becas de Investigación (Mocovi) - No generado por el postulante   '.date('d/m/Y h:i:s a').'     Página {PAGENUM} de {TOTALPAGENUM} ');
//            $pdf->ezStartPageNumbers(500, 20, 8, 'left', $formato, 1); //utf8_d_seguro($formato)
//            
//            //Configuración de Título.
//            $salida->titulo(utf8_d_seguro(''));    
//            $titulo="   ";
//            $opciones = array(
//                'showLines'=>0,
//                'rowGap' => 1,
//                'showHeadings' => true,
//                'titleFontSize' => 9,
//                'fontSize' => 10,
//                'shadeCol' => array(0,0,0),
//                'outerLineThickness' => 0,//grosor de las lineas exteriores
//                'innerLineThickness' => 0,
//                'xOrientation' => 'center',
//                'width' => 1000,
//                'cols'=>array('col1'=>array('width'=>180,'justification'=>'center'),'col2'=>array('width'=>180,'justification'=>'center'),'col3'=>array('width'=>180,'justification'=>'center'))
//            );
//           
//            //INICIALIZACION VARIABLE CAT
//            $centrado = array('justification'=>'center');
////            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
////            $datos_insc=$this->dep('datos')->tabla('inscripcion_beca')->get_datos_inscripcion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);
////            //print_r($inscripcion);
////            $datos_bec=$this->dep('datos')->tabla('becario')->get_datos_personales($inscripcion['id_becario']);
////            $datos_dir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_director']); 
////            $datos_codir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_codirector']); 
//            
//            $datos_estudio=$this->dep('datos')->tabla('becario_estudio')->get_datos_estudio($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_beca=$this->dep('datos')->tabla('becario_beca')->get_datos_beca($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_empleo_actual=$this->dep('datos')->tabla('becario_empleo')->get_empleos(true,$inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_empleo_anterior=$this->dep('datos')->tabla('becario_empleo')->get_empleos(false,$inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_pi=$this->dep('datos')->tabla('participacion_inv')->get_datos_pi($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            //print_r($datos_pi);exit;
//            $datos_pe=$this->dep('datos')->tabla('participacion_ext')->get_datos_pe($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_disti=$this->dep('datos')->tabla('becario_distincion')->get_datos_distincion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_trab=$this->dep('datos')->tabla('becario_trabajo')->get_datos_trabajo($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            $datos_idioma=$this->dep('datos')->tabla('becario_idioma')->get_datos_idioma($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
//            //$carrera=$this->dep('datos')->tabla('carrera_inscripcion_beca')->get();//no se usa
//            //por si llega hasta el final sin guardar y presiona el botón imprimir ver!! pero como va a ser obligatorio entonces esta
//         
//           
//            //-------------------------------1
//            $pdf->ezText(' <b>1. SOLICITUD </b>', 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText("\n", 10);
//            //-----------------------datos que antes iban en la CARATULA
//            $pdf->ezText(utf8_d_seguro(' <b>BECAS DE INVESTIGACIÓN DE LA UNIVERSIDAD NACIONAL DEL COMAHUE</b>'), 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(' <b>CONVOCATORIA '.$anio.'</b>', 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText('<b>POSTULANTE: </b>'.utf8_d_seguro($datos_bec['nombre']), 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText($uacad, 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(utf8_d_seguro($cat), 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText($datos_proy['codigo'], 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText('<b>DIRECTOR: </b>'.utf8_d_seguro($datos_dir['nombre']), 12,$centrado);
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduado
//                if(isset($inscripcion['id_codirector'])){
//                    if(isset($datos_codir['nombre'])){
//                        $pdf->ezText("\n", 10);
//                        $pdf->ezText('<b>CO-DIRECTOR: </b>'.utf8_d_seguro($datos_codir['nombre']), 12,$centrado);
//                    }   
//                }
//            }
//   
//            //-------------------------------2
//            $pdf->ezNewPage(); 
//            $pdf->ezText(' <b>2. ANTECEDENTES Y DATOS DEL POSTULANTE </b>', 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(' <b>2.1 DATOS PERSONALES </b>', 10);
//            $pdf->ezText("\n", 10);
//            //$fec_nac=date("d/m/Y",strtotime($datos_bec['fec_nacim']));
//            $tabla_becario=array();
//            $tabla_becario[0]=array('dato'=>utf8_d_seguro('APELLIDO Y NOMBRES: '.$datos_bec['nombre']));
//            $tabla_becario[1]=array('dato'=>'NACIONALIDAD: '.$datos_bec['nacionalidad']);
//            $tabla_becario[3]=array('dato'=>'FECHA DE NACIMIENTO: '.$fec_nac);
//            $tabla_becario[4]=array('dato'=>utf8_d_seguro('CUIL: '.$datos_bec['cuil']));
//            $tabla_becario[5]=array('dato'=>'DOMICILIO REAL COMPLETO: '.$datos_bec['domi']);
//            $tabla_becario[6]=array('dato'=>utf8_d_seguro('TELÉFONO: '.$datos_bec['telefono']));    
//            $tabla_becario[7]=array('dato'=>'E-MAIL: '.$datos_bec['correo']);
//            $pdf->ezTable($tabla_becario,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0));
//            $pdf->ezText("\n", 10);
//            
//            
//            $tabla_carrera=array();
//            $pdf->ezText(' <b>2.2 DATOS DE LA CARRERA DE GRADO/PREGRADO POR LA QUE SOLICITA LA BECA </b>', 10);
//            $pdf->ezText("\n", 10);
//                
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduado
//                $copias_ref=3;
//                $tabla_carrera[0]=array('dato'=>utf8_decode('INSTITUCIÓN: ').$datos_carrera['institucion']);
//                $tabla_carrera[1]=array('dato'=>'CARRERA: '.$datos_carrera['carrera']);
//                $tabla_carrera[2]=array('dato'=>utf8_decode('DURACIÓN PLAN DE ESTUDIOS: ').$datos_carrera['duracion_plan_estudio']);
//                $tabla_carrera[3]=array('dato'=>utf8_decode('AÑOS DE ESTUDIO - FECHA DE INGRESO: '.date("d/m/Y",strtotime($datos_carrera['fecha_inicio'])).' FECHA DE EGRESO: '.date("d/m/Y",strtotime($datos_carrera['fecha_finalizacion']))));
//                $tabla_carrera[4]=array('dato'=>'CANTIDAD DE MATERIAS DEL PLAN DE ESTUDIOS: '.$datos_carrera['cant_mat_plan']);
//                $tabla_carrera[5]=array('dato'=>'CANTIDAD DE MATERIAS ADEUDADAS: '.$datos_carrera['cant_materias_adeuda']);
//                $tabla_carrera[6]=array('dato'=>'PROMEDIO SIN APLAZOS: '.$datos_carrera['promedio']);
//                $tabla_carrera[7]=array('dato'=>'PROMEDIO CON APLAZOS: '.$datos_carrera['promedio_ca']);
//                $tabla_carrera[8]=array('dato'=>utf8_decode('TÍTULO OBTENIDO: ').$datos_carrera['titulo']);
//                
//            }else{//estudiante
//                $copias_ref=2;
//                $tabla_carrera[0]=array('dato'=>utf8_decode('UNIDAD ACADÉMICA: ').$datos_carrera['uni_acad']);
//                $tabla_carrera[1]=array('dato'=>utf8_decode('CARRERA: ').$datos_carrera['carrera']);
//                $tabla_carrera[2]=array('dato'=>utf8_decode('DURACIÓN PLAN DE ESTUDIOS: ').$datos_carrera['duracion_plan_estudio']);
//                $tabla_carrera[3]=array('dato'=>utf8_decode('FECHA INGRESO A LA CARRERA: '.$datos_carrera['fecha_inicio']));
//                $tabla_carrera[4]=array('dato'=>'CANTIDAD DE MATERIAS DEL PLAN DE ESTUDIOS: '.$datos_carrera['cant_mat_plan']);
//                $tabla_carrera[5]=array('dato'=>'CANTIDAD DE MATERIAS APROBADAS: '.$datos_carrera['cant_materias_aprobadas']);
//                $tabla_carrera[6]=array('dato'=>'PORCENTAJE DE MATERIAS APROBADAS: '.$datos_carrera['porc_mat_aprob']);
//                $tabla_carrera[7]=array('dato'=>'PROMEDIO SIN APLAZOS: '.$datos_carrera['promedio']);
//                $tabla_carrera[8]=array('dato'=>'PROMEDIO CON APLAZOS: '.$datos_carrera['promedio_ca']);
//                
//            }
//            $pdf->ezTable($tabla_carrera,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0));
//            $pdf->ezText("\n", 10);
//            if(count($datos_estudio)>0){//si tiene estudios
//                $pdf->ezText(' <b>2.3 OTROS ESTUDIOS</b>', 10);
//                $pdf->ezText("\n", 10);
//                $i=0;
//                $tabla_estudio=array();              
//                foreach ($datos_estudio as $des) {
//                    $fec_desde=date("d/m/Y",strtotime($des['desde']));
//                    if(!isset($des['hasta'])){
//                        $fec_hasta='';
//                    }else{
//                        $fec_hasta=date("d/m/Y",strtotime($des['hasta']));
//                    }
//                    $tabla_estudio[$i]=array( 'col1'=>trim($des['institucion']),'col2' => $fec_desde,'col3' => $fec_hasta,'col4' => trim($des['titulo']));
//                    $i++;
//                }   
//                
//                $pdf->ezTable($tabla_estudio,array('col1'=>utf8_decode('<b>INSTITUCIÓN</b>'),'col2'=>'<b>DESDE</b>','col3'=>'<b>HASTA</b>','col4'=>utf8_decode('<b>TÍTULO OBTENIDO</b>')),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                $pdf->ezText("\n", 10);
//            }
//           
//            //------------------BECAS
//            if(count($datos_beca)>0){
//                $pdf->ezText('<b> 2.4 BECAS OBTENIDAS </b>', 10);
//                $pdf->ezText("\n", 10);
//                $i=0;
//                $tabla_beca=array();              
//                foreach ($datos_beca as $des) {
//                    $fec_desde=date("d/m/Y",strtotime($des['desde']));
//                    $fec_hasta=date("d/m/Y",strtotime($des['hasta']));
//                    $tabla_beca[$i]=array( 'col1'=>trim($des['institucion']),'col2' => trim($des['objeto']),'col3' => $fec_desde,'col4' => $fec_hasta);
//                    $i++;
//                }
//                //'shaded'=>0,'showLines'=>0
//                //'num'=>array('justification'=>'right')
//                $pdf->ezTable($tabla_beca,array('col1'=>utf8_decode('<b>INSTITUCIÓN</b>'),'col2'=>'<b>OBJETO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                $pdf->ezText("\n", 10);
//            }
//            //------------------DISTINCIONES
//            if(count($datos_disti)>0){
//                $pdf->ezText(' <b>2.5 DISTINCIONES Y PREMIOS</b>', 10);
//                $pdf->ezText("\n", 10);
//                $i=0;
//                $tabla_disti=array();              
//                foreach ($datos_disti as $des) {
//                    $fecha=date("d/m/Y",strtotime($des['fecha_dis']));
//                    $tabla_disti[$i]=array( 'col1'=>trim($des['distincion']),'col2' => $fecha);
//                    $i++;
//                }   
//                $pdf->ezTable($tabla_disti,array('col1'=>utf8_decode('<b>DISTINCIÓN</b>'),'col2'=>'<b>FECHA</b>'),'',array('shaded'=>0,'showLines'=>1));
//                $pdf->ezText("\n", 10);
//             }
//            if(count($datos_empleo_actual)>0 or count($datos_empleo_anterior)>0 or count($datos_pi)>0 or count($datos_pe)>0){
//                 $pdf->ezText(utf8_d_seguro(' <b>2.6 EMPLEOS: Indicar en cada caso si se trata de instituciones nacionales, provinciales, municipales y privadas. Incluir antecedentes docentes, pasantías, ayudantías de investigación, etc.</b>'), 10);
//                 $pdf->ezText("\n", 10);
//                  if(count($datos_empleo_actual)>0){
//                     $pdf->ezText(' <b>EMPLEOS ACTUALES </b>', 10);
//                     $pdf->ezText("\n", 10);
//                     $i=0;
//                     $tabla_empleo_actual=array();              
//                     foreach ($datos_empleo_actual as $des) {
//                        $tabla_empleo_actual[$i]=array( 'col1'=>trim($des['institucion'].'/'.trim($des['direccion'])),'col2' => $des['cargo'],'col3'=>$des['anio_ingreso']);
//                        $i++;
//                     }   
//                     $pdf->ezTable($tabla_empleo_actual,array('col1'=>  utf8_decode('<b>INSTITUCIÓN: NOMBRE/DIRECCIÓN</b>'),'col2'=>'<b>CARGO</b>','col3'=>utf8_decode('<b>AÑO DE INGRESO</b>')),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                     $pdf->ezText("\n", 10);
//                  }
//                  if(count($datos_empleo_anterior)>0){
//                      $pdf->ezText(' <b> EMPLEOS ANTERIORES </b>', 10);
//                      $pdf->ezText("\n", 10);
//                      $i=0;
//                      $tabla_empleo_ant=array();              
//                      foreach ($datos_empleo_anterior as $des) {
//                        $tabla_empleo_ant[$i]=array( 'col1'=>trim($des['institucion']).'/'.trim($des['direccion']),'col2' => trim($des['cargo']),'col3'=>$des['anio_ingreso']);
//                        $i++;
//                      }  
//                      $pdf->ezTable($tabla_empleo_ant,array('col1'=>utf8_decode('<b>INSTITUCIÓN: NOMBRE/DIRECCIÓN</b>'),'col2'=>'<b>CARGO</b>','col3'=>utf8_d_seguro('<b>AÑO DE INGRESO</b>')),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                      $pdf->ezText("\n", 10);
//                  }
//                  if(count($datos_pi)>0){
//                      $pdf->ezText(utf8_decode('<b>PARTICIPACIÓN EN PROYECTOS DE INVESTIGACIÓN </b>'), 10);
//                      $pdf->ezText("\n", 10);
//                      $i=0;
//                      $tabla_pi=array();              
//                      foreach ($datos_pi as $des) {
//                        $fecha_desde=date("d/m/Y",strtotime($des['desde']));  
//                        $fecha_hasta=date("d/m/Y",strtotime($des['hasta'])); 
//                        $tabla_pi[$i]=array( 'col1'=>$des['codigo'],'col2' => $des['nombredirector'],'col3'=>$fecha_desde,'col4'=>$fecha_hasta);
//                        $i++;
//                      }   
//                      $pdf->ezTable($tabla_pi,array('col1'=>utf8_decode('<b>CÓDIGO DEL PROYECTO</b>'),'col2'=>'<b>DIRECTOR DEL PROYECTO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                      $pdf->ezText("\n", 10); 
//                  }
//                if(count($datos_pe)>0){
//                      $pdf->ezText(utf8_d_seguro('<b>PARTICIPACIÓN EN PROYECTOS DE EXTENSIÓN </b>'), 10);
//                      $pdf->ezText("\n", 10);
//                      $i=0;
//                      $tabla_pe=array();  
//                      foreach ($datos_pe as $des) {
//                        $fecha_desde=date("d/m/Y",strtotime($des['desde']));  
//                        $fecha_hasta=date("d/m/Y",strtotime($des['hasta'])); 
//                        $tabla_pe[$i]=array( 'col1'=>$des['codigo'],'col2' => $des['nombredirector'],'col3'=>$fecha_desde,'col4'=>$fecha_hasta);
//                        $i++;
//                      }   
//                      $pdf->ezTable($tabla_pe,array('col1'=>utf8_d_seguro('<b>CÓDIGO DEL PROYECTO</b>'),'col2'=>'<b>DIRECTOR DEL PROYECTO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
//                      $pdf->ezText("\n", 10); 
//                  }
//            }
//            if(count($datos_trab)>0){
//               $pdf->ezText(utf8_d_seguro(' <b>2.7 TRABAJOS/CURSOS REALIZADOS: MONOGRAFÍAS, TRABAJOS DE SEMINARIOS, TESIS, CONGRESOS, PUBLICACIONES, CURSOS </b>'), 10); 
//               $pdf->ezText("\n", 10);
//               $i=0;
//               $tabla_trab=array();              
//               foreach ($datos_trab as $des) {
//                    $fecha=date("d/m/Y",strtotime($des['fecha_trab']));
//                    $tabla_trab[$i]=array( 'col1'=>trim($des['titulo']),'col2' => trim($des['presentado_en']),'col3' => $fecha);
//                    $i++;
//                }   
//               $pdf->ezTable($tabla_trab,array('col1'=>utf8_d_seguro('<b>TÍTULO DEL TRABAJO</b>'),'col2'=>'<b>PRESENTADO O PUBLICADO EN</b>','col3'=>'<b>FECHA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500,'cols' =>array('col1' => array('width'=>330),'col2' => array('width'=>100),'col3' => array('width'=>70))    ));
//               $pdf->ezText("\n", 10);
//            }
//            if(count($datos_idioma)>0){
//                $pdf->ezText(utf8_d_seguro(' <b>2.8 CONOCIMIENTO DE IDIOMAS: INDICAR SI ES MUY BUENO, BUENO, ACEPTABLE Y ADJUNTAR CERTIFICADOS O DIPLOMAS </b>'), 10);
//                $pdf->ezText("\n", 10);
//                $i=0;
//                $tabla_idiom=array();
//                foreach ($datos_idioma as $des) {
//                    $tabla_idiom[$i]=array( 'col1'=>trim($des['idioma']),'col2' => $des['lee'],'col3' => $des['escribe'],'col4' => $des['habla'],'col5' => $des['entiende']);
//                    $i++;
//                }   
//                
//               $pdf->ezTable($tabla_idiom,array('col1'=>utf8_d_seguro('<b>IDIOMA</b>'),'col2'=>'<b>LEE</b>','col3'=>'<b>ESCRIBE</b>','col4'=>'<b>HABLA</b>','col5'=>'<b>ENTIENDE</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500,'cols'=>array('col1'=>array('width'=>200,'justification'=>'center'),'col2'=>array('width'=>75,'justification'=>'center'),'col3'=>array('width'=>75,'justification'=>'center'),'col4'=>array('width'=>75,'justification'=>'center'))));
//               $pdf->ezText("\n", 10);
//            }
//
//            $pdf->ezText(' <b>2.9 TIENE OTRA BECA EN CURSO? </b>', 10);
//            if($inscripcion['beca_en_curso']){
//                $pdf->ezText(' <b>SI </b>', 10);
//                $pdf->ezText('INSTITUCION: '.$inscripcion['institucion_beca_en_curso'], 10);
//            }else{
//                $pdf->ezText(' <b>NO </b>', 10);
//            }
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(utf8_decode(' <b>2.10 LUGAR DE TRABAJO EN EL QUE DESARROLLARÁ LA BECA</b>'), 10);
//            $pdf->ezText("\n", 10);
//            //utf8_decode($tabla_empleo_ant)
//            $pdf->ezText(utf8_decode(' <b>UNIDAD ACADÉMICA: </b>').$datos_insc['ua_trabajo_beca'], 10);
//            $pdf->ezText(utf8_decode(' <b>DEPARTAMENTO ACADÉMICO: </b>').$datos_insc['dpto_trabajo_beca'], 10);
//            $pdf->ezText(utf8_decode(' <b>LABORATORIO, ÁREA, CENTRO, INSTITUTO: </b>').trim($datos_insc['desc_trabajo_beca']), 10);
//            $pdf->ezText(' <b>DOMICILIO COMPLETO: </b>'.$datos_insc['domi_lt'], 10);
//            
//            //------------------------3
//            $pdf->ezNewPage(); 
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
//                $pdf->ezText(utf8_decode(' <b>3. DATOS DEL DIRECTOR/CODIRECTOR (si corresponde) </b>'), 12,$centrado);
//            }else{
//                $pdf->ezText(utf8_decode(' <b>3. DATOS DEL DIRECTOR DE BECA </b>'), 12,$centrado);
//            }
//            
//            $pdf->ezText("\n", 10);
//                     
//            $tabla_director=array();
//            $tabla_codirector=array();
//            if(isset($inscripcion['id_director'])){
//                $tabla_director[0]=array('dato'=>utf8_decode('APELLIDO Y NOMBRES: ').$datos_dir['nombre']);
//                $tabla_director[1]=array('dato'=>'DOMICILIO: '.$datos_dir['domi']);
//                $tabla_director[2]=array('dato'=>'E-MAIL: '.$datos_dir['correo']);
//                $tabla_director[3]=array('dato'=>'CUIL: '.$datos_dir['cuil']);
//                $tabla_director[4]=array('dato'=>utf8_decode('CATEGORÍA DOCENTE: ').$datos_dir['cat_estat']);
//                $tabla_director[5]=array('dato'=>utf8_decode('DEDICACIÓN: ').$datos_dir['dedicacion']);
//                $tabla_director[6]=array('dato'=>'REGULAR O INTERINO: '.$datos_dir['carac']);
//                $tabla_director[7]=array('dato'=>utf8_decode('CATEGORÍA OTRO ORGANISMO: ').$datos_dir['cat_conicet']);
//                $tabla_director[8]=array('dato'=>utf8_decode('INSTITUCIÓN: ').$datos_dir['institucion']);
//                $tabla_director[9]=array('dato'=>'LUGAR DE TRABAJO: '.trim($datos_dir['lugar_trabajo']));
//                $tabla_director[10]=array('dato'=>utf8_decode('CATEGORÍA EQUIVALENTE DE INVESTIGACIÓN: ').$datos_dir['cat_inv']);
//                $tabla_director[11]=array('dato'=>utf8_decode('MAX TITULACIÓN ALCANZADA: ').$datos_dir['titulo']);
//                //$tabla_director[12]=array('dato'=>utf8_decode('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'.$datos_dir_cantpost));
//                $pdf->ezTable($tabla_director,array('dato'=>''),'<b>DATOS DEL DIRECTOR DE BECA: </b>',array('showHeadings'=>0,'shaded'=>0,'fontSize'=>10,'width'=>500));
//                                                                                        
//            }
//              if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//solo graduados pide codirector
//                if(isset($inscripcion['id_codirector'])){
//                    $tabla_codirector[0]=array('dato'=>'APELLIDO Y NOMBRES: '.$datos_codir['nombre']);
//                    $tabla_codirector[1]=array('dato'=>'DOMICILIO: '.$datos_codir['domi']);
//                    $tabla_codirector[2]=array('dato'=>'E-MAIL: '.$datos_codir['correo']);
//                    $tabla_codirector[3]=array('dato'=>'CUIL: '.$datos_codir['cuil']);
//                    $tabla_codirector[4]=array('dato'=>utf8_decode('CATEGORÍA DOCENTE: ').$datos_codir['cat_estat']);
//                    $tabla_codirector[5]=array('dato'=>utf8_decode('DEDICACIÓN: ').$datos_codir['dedicacion']);
//                    $tabla_codirector[6]=array('dato'=>'REGULAR O INTERINO: '.$datos_codir['carac']);
//                    $tabla_codirector[7]=array('dato'=>utf8_decode('CATEGORÍA OTRO ORGANISMO: ').$datos_codir['cat_conicet']);
//                    $tabla_codirector[8]=array('dato'=>utf8_decode('INSTITUCIÓN: ').$datos_codir['institucion']);
//                    $tabla_codirector[9]=array('dato'=>'LUGAR DE TRABAJO: '.trim($datos_codir['lugar_trabajo']));
//                    $tabla_codirector[10]=array('dato'=>utf8_decode('CATEGORÍA EQUIVALENTE DE INVESTIGACIÓN: ').$datos_codir['cat_inv']);
//                    $tabla_codirector[11]=array('dato'=>utf8_decode('MAX TITULACIÓN ALCANZADA: ').$datos_codir['titulo']);
//                    //$tabla_codirector[12]=array('dato'=>utf8_decode('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'.$datos_codir_cantpost));
//                    $pdf->ezTable($tabla_codirector,array('dato'=>''),'<b>DATOS DEL CODIRECTOR DE BECA:</b> ',array('showHeadings'=>0,'shaded'=>0,'fontSize'=>10,'width'=>500));
//                  }
//            }
//         //-------------------------4
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(utf8_d_seguro(' <b>4. DATOS DEL PROYECTO DE INVESTIGACIÓN AL QUE SE INCORPORA (APROBADO O EN EVALUACIÓN) </b>'), 12,$centrado);
//            if(isset($datos_proy)>0){
//                $datos[0]=array('dato'=>utf8_decode('CÓDIGO DEL PROYECTO: ').$datos_proy['codigo']);
//                $datos[1]=array('dato'=>utf8_decode('TÍTULO: ').$datos_proy['denominacion']);//no va decodificado el nombre del titulo
//                $fecha_desde=date("d/m/Y",strtotime($datos_proy['fec_desde']));
//                $fecha_hasta=date("d/m/Y",strtotime($datos_proy['fec_hasta']));
//                $datos[2]=array('dato'=>'FECHA DE INICIO: '.$fecha_desde);
//                $datos[3]=array('dato'=>utf8_decode('FECHA DE FINALIZACIÓN: ').$fecha_hasta);
//                $datos[4]=array('dato'=>utf8_decode('ORDENANZA DE APROBACIÓN N° : ').$datos_proy['nro_ord_cs']);
//                $datos[5]=array('dato'=>'DIRECTOR: '.$datos_proy['apnom_director']);
//                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
//                $pdf->ezText("\n", 10);
//            }
//            $pdf->ezNewPage(); 
//            //-------------------------5
//            $pdf->ezText(' <b>5. DATOS DEL PLAN DE TRABAJO DEL BECARIO</b>', 12,$centrado);
//            $pdf->ezText("\n", 10);
//            $pdf->ezText(utf8_decode(' Título del Plan de Trabajo (tema de la beca)'), 12);
//            unset($datos);//limpio la variable
//            if(isset($inscripcion['titulo_plan_trabajo'])){
//                $datos[0]=array('dato'=>$inscripcion['titulo_plan_trabajo']);
//                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
//                $pdf->ezText("\n", 8);
//            }
//            
////            $pdf->ezText(utf8_d_seguro(' <b> DESARROLLO DEL PLAN DE TRABAJO </b>'), 10,$centrado);
////            $pdf->ezText("\n", 10);
////            $pdf->ezText(utf8_d_seguro(' Se deberá incluir una descripción de la investigación a realizar durante el primer año de beca. Además deberá  especificarse el plan de formació del becario, mediante la enumeración de la realización de cursos, participación a congresos, seminarios, pasantías (especificando en cada caso lugar y tiempo estimado) '), 10);
////            $pdf->ezText("\n", 10);
////            unset($datos);//limpio la variable
////            if(isset($inscripcion['desarrollo_plan_trab'])){
////                $datos[0]=array('dato'=>utf8_d_seguro($inscripcion['desarrollo_plan_trab']));
////                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
////                $pdf->ezText("\n", 10);
////            }
//             //-------------------------6
//            $pdf->ezText("\n", 10);$pdf->ezText("\n", 10);
//            $pdf->ezText(' <b>6. FUNDAMENTOS DE LA SOLICITUD</b>', 12,$centrado);
//            $pdf->ezText("\n", 8);
//            $pdf->ezText(utf8_decode(' El solicitante expresará en esta hoja los motivos de su solicitud de una beca y de su elección de los temas propuestos.'), 10);
//            $pdf->ezText("\n", 8);
//            unset($datos);//limpio la variable
//            if(isset($inscripcion['fundamentos_solicitud'])){
//                $datos[0]=array('dato'=>$inscripcion['fundamentos_solicitud']);
//                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
//                $pdf->ezText("\n", 8);
//            }
//
//            foreach ($pdf->ezPages as $pageNum=>$id){ 
//                   $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
//                   $imagen = toba::proyecto()->get_path().'/www/img/logo_becarios.jpg';
//                   $pdf->addJpegFromFile($imagen, 30, 770, 108, 69);
//                   //$imagen2 = toba::proyecto()->get_path().'/www/img/sein.jpg';
//                   //$pdf->addJpegFromFile($imagen2, 30, 760, 70, 60);
//                   $pdf->closeObject(); 
//                }   
//
//        }else{//imprimir la ficha
//          if($bandera=='imprimir2'){
//            $salida->set_nombre_archivo("Ficha_Inscripcion.pdf");
//            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
//            $salida->set_papel_orientacion('portrait');//landscape
//            $salida->inicializar();
//            $pdf = $salida->get_pdf();
//            $pdf->ezSetMargins(100, 50, 30, 30);//($top, $bottom, $left, $right)
//            
//            //Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
//            //Primero definimos la plantilla para el número de página.
//            $formato = utf8_decode('Convocatoria Becas de Investigación (Mocovi) - No generado por el postulante   '.date('d/m/Y h:i:s a').'     Página {PAGENUM} de {TOTALPAGENUM} ');
//            $pdf->ezStartPageNumbers(500, 20, 8, 'left', $formato, 1); //utf8_d_seguro($formato)
//            //Configuración de Título.
//            $salida->titulo(utf8_decode(''));   
//            //$pdf->setLineStyle(1);
//            //$pdf->setLineStyle(5);
//            //$pdf->Line(1, 45, 210-20, 45);//ultimo le da la inclinacion
//            //$pdf->Line(10, 45, 550, 45);//primero: eje x desde donde comienza/tercero es el largo de la linea/cuarto:ultimo le da la inclinacion
//            //segundo le da orientacion sobre x
//            $pdf->ezText(utf8_decode(' <b>Ficha de Inscripción </b>'), 10);
//            $texto=' La presente ficha deberá ser debidamente firmada y entregada en la Secretaría de Investigación de la Unidad Académica';
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduados
//                $texto.=' de pertenencia del proyecto en el que se inserta su plan de trabajo.';
//            }else{         
//                $texto.=' correspondiente a la carrera por la que solicita la beca.';         
//            }
//           
//            $pdf->ezText(utf8_decode($texto), 10);
//            $pdf->ezText("\n", 7);
//            $tabla_cod=array();
//            $pdf->ezTable($tabla_cod,array('col1'=>utf8_decode('<b>Categoría de Beca:</b>'),'col2' => utf8_d_seguro($cat)),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));      
//            $pdf->ezTable($tabla_cod,array('col1'=>utf8_decode('<b>Unidad Académica:</b>'),'col2' => $uacad),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));      
//            $cols_p = array('col1'=>"<b>Datos del Proyecto al que se incorpora:</b>",'col2'=>'');
//            $tabla_p=array();
//            $tabla_p[0]=array( 'col1'=>utf8_decode('Código:'),'col2' => $datos_proy['codigo']);
//            $tabla_p[1]=array( 'col1'=>utf8_decode('Título:'),'col2' => $datos_proy['denominacion']);
//            $tabla_p[2]=array( 'col1'=>'Director:','col2' => $datos_proy['apnom_director']);
//            $pdf->ezTable($tabla_p,$cols_p,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//            //---
//             if(isset($inscripcion['titulo_plan_trabajo'])){
//                 $pdf->ezTable($tabla_cod,array('col1'=>utf8_decode('<b>Plan de Trabajo:</b>'),'col2' => trim($inscripcion['titulo_plan_trabajo'])),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));      
//             }
//            
//            //---
//            $cols_dp = array('col1'=>"<b>Datos Personales</b>",'col2'=>'');
//            $tabla_dp=array();
//            $tabla_dp[0]=array( 'col1'=>'Postulante:','col2' => utf8_decode($datos_bec['nombre']));
//            $tabla_dp[1]=array( 'col1'=>'CUIL:','col2' => $datos_bec['cuil']);
//            $tabla_dp[2]=array( 'col1'=>'e-mail:','col2' => $datos_bec['correo']);
//            $tabla_dp[3]=array( 'col1'=>'Fecha de nacimiento:','col2' => $fec_nac);
//            $tabla_dp[5]=array( 'col1'=>'Domicilio:','col2' => $datos_bec['domi']);
//            $tabla_dp[5]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_bec['telefono']);
//            $pdf->ezTable($tabla_dp,$cols_dp,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//            //--
//            $cols_c = array('col1'=>"<b>Datos de la Carrera</b>",'col2'=>'');
//            $tabla_c=array();
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduado
//                    $tabla_c[0]=array( 'col1'=>utf8_decode('Institución:'),'col2' => trim($datos_carrera['institucion']));
//            }else{
//                    $tabla_c[0]=array( 'col1'=>utf8_decode('Unidad Académica:'),'col2' => $datos_carrera['uni_acad']);
//            }
//            $tabla_c[1]=array( 'col1'=>'Carrera:','col2' => trim($datos_carrera['carrera']));
//            $tabla_c[2]=array( 'col1'=>'Promedio sin aplazos:','col2' => $datos_carrera['promedio']);
//            $tabla_c[3]=array( 'col1'=>'Promedio con aplazos:','col2' => $datos_carrera['promedio_ca']);
//            $pdf->ezTable($tabla_c,$cols_c,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//            //--
//            $tabla_dir=array(); 
//            $tabla_dir[0]=array( 'col1'=>'Apellido y Nombre:','col2' => utf8_decode($datos_dir['nombre']));
//            $tabla_dir[1]=array( 'col1'=>'CUIL:','col2' => $datos_dir['cuil']);
//            $tabla_dir[2]=array( 'col1'=>utf8_decode('e-mail:'),'col2' => $datos_dir['correo']);
//            $tabla_dir[3]=array( 'col1'=>'Domicilio:','col2' => $datos_dir['domi']);//no va decodificado, lo toma bien
//            $tabla_dir[4]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_dir['telefono']);
//            $tabla_dir[5]=array( 'col1'=>utf8_decode('Máxima titulación alcanzada'),'col2' => $datos_dir['titulo']);
//            $tabla_dir[6]=array( 'col1'=>'Cargo Docente:','col2' => $datos_dir['cat_estat']);
//            $tabla_dir[7]=array( 'col1'=>utf8_decode('Dedicación en el cargo:'),'col2' => $datos_dir['dedicacion']);
//            $tabla_dir[8]=array( 'col1'=>utf8_decode('Categoría Equiv Investigador:'),'col2' =>  $datos_dir['cat_inv']);
//            $tabla_dir[9]=array( 'col1'=>utf8_decode('Categoría Otro Organismo:'),'col2' => $datos_dir['cat_conicet']);
//            $tabla_dir[10]=array( 'col1'=>utf8_decode('Institución Otro Organismo:'),'col2' => trim($datos_dir['institucion']));
//            $tabla_dir[11]=array( 'col1'=>'Lugar de trabajo:','col2' => trim($datos_dir['lugar_trabajo']));
//            $tabla_dir[12]=array( 'col1'=>utf8_decode('Hs de dedicación total de investigación:'),'col2' => $datos_dir['hs_dedic_inves']);
//            $cols_dir = array('col1'=>"<b>Datos del Director</b>",'col2'=>'');
//            $pdf->ezTable($tabla_dir,$cols_dir,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
//                //codirector
//               if(isset($inscripcion['id_codirector'])){
//                    $tabla_codir=array(); 
//                    $tabla_codir[0]=array( 'col1'=>'Apellido y Nombre:','col2' => $datos_codir['nombre']);
//                    $tabla_codir[1]=array( 'col1'=>'CUIL:','col2' => $datos_codir['cuil']);
//                    $tabla_codir[2]=array( 'col1'=>'e-mail:','col2' => $datos_codir['correo']);
//                    $tabla_codir[3]=array( 'col1'=>'Domicilio:','col2' => $datos_codir['domi']);
//                    $tabla_codir[4]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_codir['telefono']);
//                    $tabla_codir[5]=array( 'col1'=>utf8_decode('Máxima titulación alcanzada:'),'col2' => $datos_codir['titulo']);
//                    $tabla_codir[6]=array( 'col1'=>'Cargo Docente:','col2' => $datos_codir['cat_estat']);
//                    $tabla_codir[7]=array( 'col1'=>utf8_decode('Dedicación en el cargo:'),'col2' => $datos_codir['dedicacion']);
//                    $tabla_codir[8]=array( 'col1'=>utf8_decode('Categoría Equiv Investigador:'),'col2' => $datos_codir['cat_inv']);
//                    $tabla_codir[9]=array( 'col1'=>utf8_decode('Categoría Otro Organismo:'),'col2' => $datos_codir['cat_conicet']);
//                    $tabla_codir[10]=array( 'col1'=>utf8_decode('Institución Otro Organismo:'),'col2' => utf8_decode(trim($datos_codir['institucion'])));
//                    $tabla_codir[11]=array( 'col1'=>'Lugar de trabajo:','col2' => trim(utf8_decode($datos_codir['lugar_trabajo'])));
//                    $tabla_codir[12]=array( 'col1'=>utf8_decode('Hs de dedicación total de investigación:'),'col2' => $datos_codir['hs_dedic_inves']);
//                    $pdf->ezTable($tabla_codir,array('col1'=>"<b>Datos del Co-director</b>",'col2'=>''),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//               }
//            }
//            //adjuntos
//            $pdf->ezText("\n", 10);
//            $tabla_adj=array();
//            $cols_adj = array('col1'=>"<b>ARCHIVO</b>",'col2'=>'<b>NOMBRE INTERNO</b>');
//            $tabla_adj[0]=array('col1'=>'CERTIFICADO ANTECEDENTES','col2'=>$datos_adj['cert_ant']); 
//            $tabla_adj[1]=array('col1'=>'CONSTANCIA DE FIN DE ESTUDIOS','col2'=>$datos_adj['const_titu']); 
//            $tabla_adj[2]=array('col1'=>utf8_decode('RENDIMIENTO ACADÉMICO'),'col2'=>$datos_adj['rend_acad']); 
//            $tabla_adj[3]=array('col1'=>'CV POSTULANTE','col2'=>$datos_adj['cv_post']); 
//            $tabla_adj[4]=array('col1'=>'CV DIRECTOR','col2'=>$datos_adj['cv_dir']); 
//            $tabla_adj[5]=array('col1'=>'CV CODIRECTOR','col2'=>$datos_adj['cv_codir']);
//            $tabla_adj[6]=array('col1'=>'CUIL','col2'=>$datos_adj['cuil']);
//            $tabla_adj[7]=array('col1'=>'DOCUMENTO','col2'=>$datos_adj['docum']);
//            $tabla_adj[8]=array('col1'=>'COMPROBANTES','col2'=>$datos_adj['comprob']);
//            $tabla_adj[9]=array('col1'=>'PLAN DE TRABAJO','col2'=>$datos_adj['desarrollo_pt']);
//            $tabla_adj[10]=array('col1'=>'INFORME FINAL','col2'=>$datos_adj['informe_final']);         
//            $pdf->ezTable($tabla_adj,$cols_adj,'<b>DATOS ADJUNTOS</b>',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
//            //-----------
//            $pdf->ezNewPage(); 
//            $tabla_texto=array();
//            $tabla_texto[0]=array('dato'=>utf8_decode('Declaro conocer el Reglamento de Becas de Investigación de la Universidad Nacional del Comahue, y aceptar cada una de las obligaciones que de él derivan, comprometiéndome a su cumplimiento en caso de que me fuera otorgada la Beca.'));
//            $pdf->ezTable($tabla_texto,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
//            $tabla_firma=array();
//            $tabla_firma[0]=array('col1'=>'','col2'=>'');
//            $tabla_firma[1]=array('col1'=>'','col2'=>'');
//            $tabla_firma[2]=array('col1'=>'','col2'=>'');
//            $tabla_firma[3]=array('col1'=>'','col2'=>'');
//            $tabla_firma[4]=array('col1'=>'Firma Postulante','col2'=>'Lugar y fecha');
//            $pdf->ezTable($tabla_firma,array('col1'=>'','col2'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center'),'col2'=>array('justification'=>'center'))));
//            $tabla_texto2=array();
//            $tabla_texto2[0]=array('col1'=>utf8_decode('Por la presente presto mi conformidad para que, en caso de ser otorgada la beca solicitada, el postulante pueda realizar el trabajo propuesto en el marco del proyecto de investigación acreditado y financiado que dirijo.'),'col2'=>utf8_d_seguro('Declaro conocer y aceptar el Reglamento de Becas de Investigación de la Universidad Nacional del Comahue, y aceptar cada una de las obligaciones que de él derivan. Avalo el plan de trabajo del postulante, y en caso de ser otorgada la beca me hago responsable de proporcionar al becario todas las condiciones necesarias para su desarrollo.'));
//            $pdf->ezTable($tabla_texto2,array('col1'=>'','col2'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'left','width'=>150),'col2'=>array('justification'=>'left','width'=>400))));
//            $tabla_firma2=array();
//            $tabla_firma2[0]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma2[1]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma2[2]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma2[3]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma2[4]=array('col1'=>utf8_decode('Firma Director de proyecto de investigación'),'col2'=>'Firma Director de Beca','col3'=>'Firma Co-Director de Beca');
//            $pdf->ezTable($tabla_firma2,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150),'col2'=>array('justification'=>'center','width'=>200),'col3'=>array('justification'=>'center','width'=>200))));
//            $tabla_firma3=array();
//            $tabla_firma3[0]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma3[1]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma3[2]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma3[3]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma3[4]=array('col1'=>'Lugar y fecha','col2'=>'Lugar y fecha','col3'=>'Lugar y fecha');
//            $pdf->ezTable($tabla_firma3,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150),'col2'=>array('justification'=>'center','width'=>200),'col3'=>array('justification'=>'center','width'=>200))));
//            //lugar de la beca
//            $tabla_lugar=array();
//            $tabla_lugar[0]=array( 'col1'=>utf8_decode('Unidad Académica:'),'col2' => $datos_insc['ua_trabajo_beca']);
//            $tabla_lugar[1]=array( 'col1'=>utf8_decode('Laboratorio/Área/Centro/Instituto:'),'col2' => trim($datos_insc['desc_trabajo_beca']));
//            $tabla_lugar[2]=array( 'col1'=>utf8_decode('Departamento Académico:'),'col2' => $datos_insc['dpto_trabajo_beca']);
//            $tabla_lugar[3]=array( 'col1'=>'Domicilio:','col2' => $datos_insc['domi_lt']);
//            $pdf->ezTable($tabla_lugar,array('col1'=>utf8_decode('<b>Lugar de trabajo en donde desarrollará la beca</b>'),'col2'=>''),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right')) ));
//            //conformidad del decano
//            $tabla_conf=array();
//            $tabla_conf[0]=array('dato'=>utf8_decode('<b>Conformidad del Decano del lugar de trabajo</b>'));
//            $pdf->ezTable($tabla_conf,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
//            $tabla_conf=array();
//            $tabla_conf[0]=array('dato'=>utf8_decode('Por la presente presto mi conformidad para que, en caso de ser otorgada la beca solicitada, el postulante pueda realizar el trabajo propuesto en el lugar indicado precedentemente.'));
//            $pdf->ezTable($tabla_conf,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
//            $tabla_firma4=array();
//            $tabla_firma4[0]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[1]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[2]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[3]=array('col1'=>'Firma','col2'=>'Lugar y fecha','col3'=>utf8_decode('Cargo e Institución'));
//            $pdf->ezTable($tabla_firma4,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150,'fontSize' => 8),'col2'=>array('justification'=>'center','width'=>200,'fontSize' => 8),'col3'=>array('justification'=>'center','width'=>200,'fontSize' => 8))));
//            //conformidad de la secretaria
//            $tabla_conf=array();
//            $tabla_conf[0]=array('dato'=>utf8_decode('<b>Conformidad de la Secretaría de Investigación donde se postula</b>'));
//            $pdf->ezTable($tabla_conf,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
//            $tabla_firma4=array();
//            $tabla_firma4[0]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[1]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[2]=array('col1'=>'','col2'=>'','col3'=>'');
//            $tabla_firma4[3]=array('col1'=>'Firma','col2'=>'Lugar y fecha','col3'=>utf8_decode('Cargo e Institución'));
//            $pdf->ezTable($tabla_firma4,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150,'fontSize' => 8),'col2'=>array('justification'=>'center','width'=>200,'fontSize' => 8),'col3'=>array('justification'=>'center','width'=>200,'fontSize' => 8))));
//
//            
//            foreach ($pdf->ezPages as $pageNum=>$id){ 
//                   $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
//                   //$imagen = toba::proyecto()->get_path().'/www/img/sein.jpg';
//                   //$pdf->addJpegFromFile($imagen, 30, 750, 70, 60);
//                   $imagen = toba::proyecto()->get_path().'/www/img/logo_becarios.jpg';
//                   $pdf->addJpegFromFile($imagen, 30, 750, 108, 69);
//                   $pdf->addText(30,750,13,utf8_decode('<b>                                   CONVOCATORIA BECAS INVESTIGACIÓN - '.$anio.'</b>'));
//                   $pdf->closeObject(); 
//                }     
//            }//if bandera=imprimir2
//                       
//            }//else
//        }//fin vista_pdf	
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
//imprime el numero de cada fila 
	function conf_evt__cuadro__seleccion(toba_evento_usuario $evento, $fila)
	{
           // print_r($fila);
	}
	

	//-----------------------------------------------------------------------------------
	//---- form_asignar -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------


        function conf__form_asignar (toba_ei_formulario_ml $form_ml) {
              $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
              $texto=$this->dep('datos')->tabla('becario')->get_nombre($inscripcion['id_becario']);
              $datos= $this->dep('datos')->tabla('evaluador')->get_filas();
              $form_ml->set_datos($datos);
              $form_ml->set_titulo('Lista de evaluadores de: '.$texto);
        }
        
	function evt__form_asignar__guardar($datos)
	{
            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
            foreach ($datos as $clave => $elem) {
                $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                $datos[$clave]['id_conv']=$inscripcion['id_conv']; 
            }
            $this->dep('datos')->tabla('evaluador')->procesar_filas($datos);
            $this->dep('datos')->tabla('evaluador')->sincronizar();
             
	}

}
?>