<?php
class ci_alta_solicitud extends toba_ci
{
        protected $s__pantalla;
        protected $s__categ_beca;
    
        function get_categ_beca()
        {
            return $this->s__categ_beca;
        }
        //-----------------------------------------------------------------------------------
	//---- form cero -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	
//        function evt__form_dni__buscar($datos)
//        {           
//            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get_inscripcion($datos['nro_docum']);
//            if(count($insc)>0){//el becario ya guardo una inscripcion para este año
//                //print_r($insc);
//                //inicializo variable con la categoria
//                $this->s__categ_beca=array('categ_beca'=>$insc[0]['categ_beca']);
//                $datosb=array('id_becario'=>$insc[0]['id_becario'],'fecha_presentacion'=>$insc[0]['fecha_presentacion']);
//                $this->dep('datos')->tabla('inscripcion_beca')->cargar($datosb);
//                $datosd=array('id'=>$insc[0]['id_director']);
//                $this->dep('datos')->tabla('director_beca')->cargar($datosd);
//                if(isset($insc[0]['id_codirector'])){
//                    $datosc=array('id'=>$insc[0]['id_codirector']);
//                    $this->dep('datos')->tabla('codirector_beca')->cargar($datosc);
//                }
//                $datosb=array('id_becario'=>$insc[0]['id_becario']);
//                $this->dep('datos')->tabla('becario')->cargar($datosb);
//                $becario=$this->dep('datos')->tabla('becario')->get();
//                //domicilio del becario
//                $datosdom=array('nro_domicilio'=>$becario['nro_domicilio']);
//                $this->dep('datos')->tabla('domicilio')->cargar($datosdom);
//                $datoscar=array('id'=>$insc[0]['id_carrera']);
//                $this->dep('datos')->tabla('carrera_inscripcion_beca')->cargar($datoscar);              
//                $datosins=array('fecha'=>$insc[0]['fecha_presentacion'],'id_becario'=>$insc[0]['id_becario']);
//                $this->dep('datos')->tabla('becario_estudio')->cargar($datosins);
//                $this->dep('datos')->tabla('becario_beca')->cargar($datosins);
//                $this->dep('datos')->tabla('becario_distincion')->cargar($datosins);
//                $this->dep('datos')->tabla('becario_empleo')->cargar($datosins);
//                $this->dep('datos')->tabla('becario_trabajo')->cargar($datosins);
//                $this->dep('datos')->tabla('becario_idioma')->cargar($datosins);
//                $this->dep('datos')->tabla('participacion_inv')->cargar($datosins);
//                $this->dep('datos')->tabla('participacion_ext')->cargar($datosins);
//                //domicilio del lugar de trabajo beca
//                $datosdomilt=array('nro_domicilio'=>$insc[0]['nro_domicilio_trabajo_beca']);
//                $this->dep('datos')->tabla('domicilio_lt')->cargar($datosdomilt);
//                $datos_proy=array('id_pinv'=>$insc[0]['id_proyecto']);
//                $this->dep('datos')->tabla('proyecto_inv')->cargar($datos_proy);
//            }//el becario no tiene inscripcion guardada
//        }
        //-----------------------------------------------------------------------------------
	//---- form -------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form(toba_ei_formulario $form)
	{
           $datos=array();
           if(isset($this->s__categ_beca)){
               $datos['categ_beca']=$this->s__categ_beca['categ_beca'];
           }
           $form->set_datos($datos);
	}
        function evt__form__guardar($datos)
        {
            $band=true;
            if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'I'){
                    $band=false;
                }
            }
            if($band){
               $this->s__categ_beca =   $datos;
               $this->dep('datos')->tabla('inscripcion_beca')->set($datos);//setea en la inscripcion el tipo de categoria que acaba de elegir 
            }
//            if (isset($datos['archivo'])) {
//                //is_uploaded_file();verifica que se subio el archivo
//                $nombre_archivo = toba::proyecto()->get_www_temp($datos['archivo']['name']);
//                //print_r($nombre_archivo['path']);exit;//C:\proyectos\toba_2.6.3/proyectos/becarios/www/temp/Informe_TKD(2).pdf 
//                $destino="C:/proyectos/toba_2.6.3/proyectos/becarios/www/temp/becarios_2018/xx.pdf";
//                move_uploaded_file($datos['archivo']['tmp_name'], $destino);
//                 //mueve un archivo a una nueva direccion, retorna true cuando lo hace y falso en caso de que no
//            }
        }
	//-----------------------------------------------------------------------------------
	//---- form_dir ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

        function conf__form_dir(toba_ei_formulario $form)
	{
            $datos=$this->dep('datos')->tabla('director_beca')->get();
            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
            //hago un set de categ para ocultar o no formulario de codirector
            $datos['categ']=$insc['categ_beca'];
            $form->set_datos($datos);
            if(isset($datos['id_designacion'])){
                 $id_doc=$this->dep('datos')->tabla('director_beca')->get_docente($datos['id_designacion']);
                 $datos['id_docente']=$id_doc;
                 //$datos['cuil']=$datos['cuil1'].str_pad($datos['cuil'], 8, '0', STR_PAD_LEFT).$datos['cuil2'];
                 $form->set_datos($datos);
            }   
	}
//boton implicito que se ejecuta cuando presiona siguiente
       function evt__form_dir__guardar($datos)
        {//si presiona el boton guardar tambien se ejecuta
           $band=true;
           $primerad=true;
           $primerac=true;
           if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
             $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
             if($insc['estado']<>'I'){
                 $band=false;
             }
             if(isset($insc['id_director'])){
                 $primerad=false;
             }
             if(isset($insc['id_codirector'])){
                 $primerac=false;
             }
           }
           if($band){
                $datosd['cat_invest']=$datos['cat_invest'];
                $datosd['institucion']=$datos['institucion'];
                $datosd['lugar_trabajo']=$datos['lugar_trabajo'];
                $datosd['cat_conicet']=$datos['cat_conicet'];
                $datosd['correo']=$datos['correo'];
                $datosd['titulo']=$datos['titulo'];
                //a partir del id_designacion obtengo todos los datos y hago una copia
                $apd=$this->dep('datos')->tabla('director_beca')->get_apellido($datos['id_docente']);
                $nomd=$this->dep('datos')->tabla('director_beca')->get_nombre($datos['id_docente']);
                $catd=$this->dep('datos')->tabla('director_beca')->get_categoria($datos['id_designacion']);
                $dedicd=$this->dep('datos')->tabla('director_beca')->get_dedicacion($datos['id_designacion']);
                $caracd=$this->dep('datos')->tabla('director_beca')->get_caracter($datos['id_designacion']);
                $cuild=$this->dep('datos')->tabla('director_beca')->get_cuil($datos['id_docente']);
                $legajod=$this->dep('datos')->tabla('director_beca')->get_legajo($datos['id_docente']);
                $datosd['apellido']=$apd;
                $datosd['nombre']=$nomd;
                $datosd['cuil1']=$cuild[0];
                $datosd['cuil']=$cuild[1];
                $datosd['cuil2']=$cuild[2];
                $datosd['cat_estat']=$catd;
                $datosd['dedic']=$dedicd;
                $datosd['carac']=$caracd;
                $datosd['legajo']=$legajod;
                $datosd['id_designacion']=$datos['id_designacion'];
                $this->dep('datos')->tabla('director_beca')->set($datosd);
                //----sincroniza
                $this->dep('datos')->tabla('director_beca')->sincronizar();
                if($primerad){
                    $dir=$this->dep('datos')->tabla('director_beca')->get();
                    $datos['id_director']=$dir['id'];
                }
                if($primerac){
                    $dir=$this->dep('datos')->tabla('codirector_beca')->get();
                    $datos['id_codirector']=$dir['id'];
                }
                $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
                $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
                //pregunto si cargo codirector beca
                if(isset($datos['id_designacionc'])){
                    $datosc['cat_invest']=$datos['cat_investc'];
                    $datosc['institucion']=$datos['institucionc'];
                    $datosc['lugar_trabajo']=$datos['lugar_trabajoc'];
                    $datosc['cat_conicet']=$datos['cat_conicetc'];
                    $datosc['correo']=$datos['correoc'];
                    $datosc['titulo']=$datos['tituloc'];
                    //a partir del id_designacion obtengo todos los datos y hago una copia
                    $apc=$this->dep('datos')->tabla('director_beca')->get_apellido($datos['id_docentec']);
                    $nomc=$this->dep('datos')->tabla('director_beca')->get_nombre($datos['id_docentec']);
                    $catc=$this->dep('datos')->tabla('director_beca')->get_categoria($datos['id_designacionc']);
                    $dedicc=$this->dep('datos')->tabla('director_beca')->get_dedicacion($datos['id_designacionc']);
                    $caracc=$this->dep('datos')->tabla('director_beca')->get_caracter($datos['id_designacionc']);
                    $cuilc=$this->dep('datos')->tabla('director_beca')->get_cuil($datos['id_docentec']);
                    $legajoc=$this->dep('datos')->tabla('director_beca')->get_legajo($datos['id_docentec']);
                    $datosc['apellido']=$apc;
                    $datosc['nombre']=$nomc;
                    $datosc['cuil1']=$cuilc[0];
                    $datosc['cuil']=$cuilc[1];
                    $datosc['cuil2']=$cuilc[2];
                    $datosc['cat_estat']=$catc;
                    $datosc['dedic']=$dedicc;
                    $datosc['carac']=$caracc;
                    $datosc['legajo']=$legajoc;
                    $datosc['id_designacion']=$datos['id_designacionc'];
                    $this->dep('datos')->tabla('codirector_beca')->set($datosc);
                    $this->dep('datos')->tabla('codirector_beca')->sincronizar();
                }  
           } 
        }
        //-----------------------------------------------------------------------------------
	//---- formulario plan de trabajo ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_pt(toba_ei_formulario $form)
	{
           $datos=$this->dep('datos')->tabla('inscripcion_beca')->get();
           if(isset($datos['titulo_plan_trabajo'])){
                 $form->set_datos($datos);
            }  
	}
        function evt__form_pt__guardar($datos)
        {
           $band=true;
           if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
             $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
             if($insc['estado']<>'I'){
                 $band=false;
             }
           }
           if($band){//solo puede modificar cuando el estado es I o cuando no esta cargada
             $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
             $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
           }
           
        }
        //------formulario de fundamentos de la solicitud
        function conf__form_fund(toba_ei_formulario $form)
	{
           $datos=$this->dep('datos')->tabla('inscripcion_beca')->get();
           if(isset($datos['fundamentos_solicitud'])){
                 $form->set_datos($datos);
            }  
	}
         function evt__form_fund__guardar($datos)
        {
           $band=true;
           if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
             $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
             if($insc['estado']<>'I'){
                 $band=false;
             }
           }
           if($band){//solo puede modificar cuando el estado es I o cuando no esta cargada
             $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
             $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
           }
           
        }
        //-----------------------------------------------------------------------------------
	//---- formulario proyecto de investigacion ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_pinv(toba_ei_formulario $form)
	{
            $datos=$this->dep('datos')->tabla('proyecto_inv')->get();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_pinv__guardar($datos)
        {
           $band=true;
           $primera=true;
           if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
             $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
             if($insc['estado']<>'I'){
                 $band=false;
             }
             if(isset($insc['id_proyecto'])){
                 $primera=false;
             }
           }
           if($band){
               $this->dep('datos')->tabla('proyecto_inv')->set($datos);
               $this->dep('datos')->tabla('proyecto_inv')->sincronizar();
               if($primera){
                    $proy=$this->dep('datos')->tabla('proyecto_inv')->get();
                    $datos['id_proyecto']=$proy['id_pinv'];
                    $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
                    $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
               }
           }
        }
        //EL BOTON ENVIAR RECIEN APARECE AL FINAL
        function evt__enviar(){
            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
            if($insc['estado']=='E'){
                toba::notificacion()->agregar(utf8_decode('La inscripción ya ha sido enviada'), "info");
            }else{
                $datos['estado']='E';
                if($insc['categ_beca']==1 or $insc['categ_beca']==2){
                    $proy=$this->dep('datos')->tabla('proyecto_inv')->get();
                    $datos['uni_acad']=$proy['uni_acad'];
                }else{//estudiante
                    $car=$this->dep('datos')->tabla('carrera_inscripcion_beca')->get();
                    $datos['uni_acad']=$car['uni_acad'];
                }
                
                $this->dep('datos')->tabla('inscripcion_beca')->set($datos);
                $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
                toba::notificacion()->agregar(utf8_decode('La inscripción ha sido enviada, ya no podrá modificar datos'), "info");
            }
        }
        
        function evt__guardar(){//sincronizacion con la base de datos cuando el usuario presiona guardar
            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
            if($insc['estado']=='E'){
                toba::notificacion()->agregar(utf8_decode('La inscripción ya ha sido enviada, no puede modificar los datos'), "info");
            }else{
                toba::notificacion()->agregar(utf8_decode('Los datos han sido guardados correctamente'), "info");
            } 
        }

        function evt__cambiar_tab__siguiente(){
//             switch ($this->s__pantalla) {
//               
//             }
           
        }
        function evt__cambiar_tab__anterior(){
             switch ($this->s__pantalla) {
               case '':break;
             }
        }

        function conf()
        {
            $usuario=toba::usuario()->get_id();
            //EL USUARIO ES EL NUMERO DE CUIL SIN ESPACIOS NI GUIONES
            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get_inscripcion($usuario);
            if(count($insc)>0){//el becario ya guardo una inscripcion para este año
                //print_r($insc);
                //inicializo variable con la categoria
                $this->s__categ_beca=array('categ_beca'=>$insc[0]['categ_beca']);
                $datosb=array('id_becario'=>$insc[0]['id_becario'],'fecha_presentacion'=>$insc[0]['fecha_presentacion']);
                $this->dep('datos')->tabla('inscripcion_beca')->cargar($datosb);
                $datosd=array('id'=>$insc[0]['id_director']);
                $this->dep('datos')->tabla('director_beca')->cargar($datosd);
                if(isset($insc[0]['id_codirector'])){
                    $datosc=array('id'=>$insc[0]['id_codirector']);
                    $this->dep('datos')->tabla('codirector_beca')->cargar($datosc);
                }
                $datosb=array('id_becario'=>$insc[0]['id_becario']);
                $this->dep('datos')->tabla('becario')->cargar($datosb);
                $becario=$this->dep('datos')->tabla('becario')->get();
                //domicilio del becario
                $datosdom=array('nro_domicilio'=>$becario['nro_domicilio']);
                $this->dep('datos')->tabla('domicilio')->cargar($datosdom);
                $datoscar=array('id'=>$insc[0]['id_carrera']);
                $this->dep('datos')->tabla('carrera_inscripcion_beca')->cargar($datoscar);              
                $datosins=array('fecha'=>$insc[0]['fecha_presentacion'],'id_becario'=>$insc[0]['id_becario']);
                $this->dep('datos')->tabla('becario_estudio')->cargar($datosins);
                $this->dep('datos')->tabla('becario_beca')->cargar($datosins);
                $this->dep('datos')->tabla('becario_distincion')->cargar($datosins);
                $this->dep('datos')->tabla('becario_empleo')->cargar($datosins);
                $this->dep('datos')->tabla('becario_trabajo')->cargar($datosins);
                $this->dep('datos')->tabla('becario_idioma')->cargar($datosins);
                $this->dep('datos')->tabla('participacion_inv')->cargar($datosins);
                $this->dep('datos')->tabla('participacion_ext')->cargar($datosins);
                //domicilio del lugar de trabajo beca
                $datosdomilt=array('nro_domicilio'=>$insc[0]['nro_domicilio_trabajo_beca']);
                $this->dep('datos')->tabla('domicilio_lt')->cargar($datosdomilt);
                $datos_proy=array('id_pinv'=>$insc[0]['id_proyecto']);
                $this->dep('datos')->tabla('proyecto_inv')->cargar($datos_proy);
            }//el becario no tiene inscripcion guardada
           
            //print_r($this->get_id_pantalla());
            switch ($this->get_id_pantalla()) {
			//--- Una vez instalado los archivos nos es posible volver atr�s
			case 'pant_director':break;
			case 'pant_antec':
                                $mostrarsig=$this->dep('ci_antecedentes')->get_mostrar_sig();
                                $mostrarant=$this->dep('ci_antecedentes')->get_mostrar_ant();
                                if($mostrarsig==0){//hasta que no llega al 2.11 no muestra siguiente
                                    $this->pantalla()->eliminar_evento('cambiar_tab__siguiente');
                                }
                                if($mostrarant==0){//hasta que no llega al 2.11 no muestra siguiente
                                    $this->pantalla()->eliminar_evento('cambiar_tab__anterior');
                                }
				break;
		}
        }
        function conf__pant_inicial(toba_ei_pantalla $pantalla)
        {
            $this->s__pantalla='pant_inicial';
        }
        function conf__pant_director(toba_ei_pantalla $pantalla)
        {
            $this->s__pantalla='pant_director';
        } 
        function conf__pant_antec(toba_ei_pantalla $pantalla)
        {
            $this->s__pantalla='pant_antec';
        }
        function conf__pant_pinv(toba_ei_pantalla $pantalla)
        {
            $this->s__pantalla='pant_pinv';
        }
        function vista_toba_impr_html(toba_vista_html $salida){
            $salida = new toba_impr_html();
            $salida->generar_salida();
        }
        function vista_pdf(toba_vista_pdf $salida){
            $salida->set_nombre_archivo("Inscripcion_Becario.pdf");
            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait');//landscape
            $salida->inicializar();
            $pdf = $salida->get_pdf();
            $pdf->ezSetMargins(80, 50, 45, 45);
            //Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
            //Primero definimos la plantilla para el número de página.
            $formato = utf8_decode('Becarios-Mocovi '.date('d/m/Y h:i:s a').'     Página {PAGENUM} de {TOTALPAGENUM} ');
            $pdf->ezStartPageNumbers(400, 20, 8, 'left', $formato, 1); //utf8_d_seguro($formato)
            
            //Configuración de Título.
            $salida->titulo(utf8_d_seguro(''));    
            $titulo="   ";
            $opciones = array(
                'showLines'=>0,
                'rowGap' => 1,
                'showHeadings' => true,
                'titleFontSize' => 9,
                'fontSize' => 10,
                'shadeCol' => array(0,0,0),
                'outerLineThickness' => 0,//grosor de las lineas exteriores
                'innerLineThickness' => 0,
                'xOrientation' => 'center',
                'width' => 1000,
                'cols'=>array('col1'=>array('width'=>180,'justification'=>'center'),'col2'=>array('width'=>180,'justification'=>'center'),'col3'=>array('width'=>180,'justification'=>'center'))
            );
            //INICIALIZACION VARIABLE CAT
            $cat=$this->dep('datos')->tabla('categoria_beca')->get_descripcion_categoria($this->s__categ_beca['categ_beca']);
            $centrado = array('justification'=>'center');
            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
            $datos_insc=$this->dep('datos')->tabla('inscripcion_beca')->get_datos_inscripcion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);
            //print_r($inscripcion);
            $datos_bec=$this->dep('datos')->tabla('becario')->get_datos_personales($inscripcion['id_becario']);
            $datos_dir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_director']); 
            $datos_codir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_codirector']); 
            $datos_carrera=$this->dep('datos')->tabla('carrera_inscripcion_beca')->get_datos_carrera($inscripcion['id_carrera']); 
            $datos_estudio=$this->dep('datos')->tabla('becario_estudio')->get_datos_estudio($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_beca=$this->dep('datos')->tabla('becario_beca')->get_datos_beca($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_empleo_actual=$this->dep('datos')->tabla('becario_empleo')->get_empleos(true,$inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_empleo_anterior=$this->dep('datos')->tabla('becario_empleo')->get_empleos(false,$inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_pi=$this->dep('datos')->tabla('participacion_inv')->get_datos_pi($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            //print_r($datos_pi);exit;
            $datos_pe=$this->dep('datos')->tabla('participacion_ext')->get_datos_pe($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_disti=$this->dep('datos')->tabla('becario_distincion')->get_datos_distincion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_trab=$this->dep('datos')->tabla('becario_trabajo')->get_datos_trabajo($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_idioma=$this->dep('datos')->tabla('becario_idioma')->get_datos_idioma($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $datos_referencias=$this->dep('datos')->tabla('becario_referencia')->get_datos_referencias($inscripcion['id_becario'],$inscripcion['fecha_presentacion']); 
            $proy=$this->dep('datos')->tabla('proyecto_inv')->get();
            $datos_proy=$this->dep('datos')->tabla('proyecto_inv')->get_datos_proyecto($proy['id_pinv']);
           // print_r($datos_proy);exit;
            $carrera=$this->dep('datos')->tabla('carrera_inscripcion_beca')->get();
            //por si llega hasta el final sin guardar y presiona el botón imprimir ver!! pero como va a ser obligatorio entonces esta
         
            if(isset($inscripcion['uni_acad'])){
                $uacad=$this->dep('datos')->tabla('inscripcion_beca')->get_unidad($inscripcion['uni_acad']);
            }else{
                $uacad='';
            }
            
            //$pinv=$this->dep('datos')->tabla('proyecto_inv')->get();
            //$codigo=$this->dep('datos')->tabla('proyecto_inv')->get_codigo($pinv['id_pinv']);
            //-----------------------CARATULA
            $pdf->ezText(utf8_d_seguro(' <b>BECAS DE INVESTIGACIÓN DE LA UNIVERSIDAD NACIONAL DEL COMAHUE</b>'), 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(' <b>CONVOCATORIA 2019</b>', 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText('<b>POSTULANTE: </b>'.utf8_d_seguro($datos_bec['nombre']), 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText($uacad, 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro($cat), 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText($datos_proy['codigo'], 20,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText('<b>DIRECTOR: </b>'.utf8_d_seguro($datos_dir['nombre']), 20,$centrado);
//            if(isset($inscripcion['id_codirector'])){
//                if(isset($datos_codir['nombre'])){
//                    $pdf->ezText( utf8_d_seguro($datos_codir['nombre']), 20,$centrado);
//                }   
//            }
//            

            $pdf->ezNewPage(); 
            $pdf->ezText(' <b>1. SOLICITUD </b>', 10,$centrado);
            $pdf->ezText("\n\n", 10);
            $pdf->ezText(utf8_d_seguro(' Al Señor/a'), 10);
            $pdf->ezText(' Rector/a de la ', 10);
            $pdf->ezText(' Universidad Nacional del Comahue ', 10);
            $pdf->ezText(' Buenos Aires 1400 ', 10);
            $pdf->ezText(utf8_d_seguro(' (8300) Neuquén '), 10);
            $pdf->ezText("\n\n", 10);
            $pdf->ezText(utf8_d_seguro("            Me dirijo al Sr/a. Rector/a, con el objeto de solititar la inscripción en el CONCURSO DE BECAS DE INVESTIGACIÓN de la Universidad Nacional del Comahue del año 2019 en la categoría ".$cat), 10);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro('            A tal efecto, hago constar en el formulario adjunto los datos correspondientes y acompaño la documentación requerida.'),10);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro('            Declaro conocer el Reglamento de Becas de Investigación de la Universidad Nacional del Comahue, y aceptar cada una de las obligaciones que de él derivan, comprometiéndome desde ya formalmente a su cumplimiento en caso de que me fuera otorgada la beca.'),10);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro('            Saludo al Sr/a. Rector/a con atenta consideración.'), 10);
            $pdf->ezText("\n\n", 10);
            $pdf->ezText('         ................................................', 10,$centrado);
            $pdf->ezText(utf8_d_seguro('         FIRMA Y ACLARACIÓN DEL POSTULANTE'), 10,$centrado);
                     
            //-------------------------------2
            $pdf->ezNewPage(); 
            $pdf->ezText(' <b>2. ANTECEDENTES Y DATOS DEL POSTULANTE </b>', 10,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(' <b>2.1 DATOS PERSONALES </b>', 10);
            $pdf->ezText("\n", 10);
            $fec_nac=date("d/m/Y",strtotime($datos_bec['fec_nacim']));
            $tabla_becario=array();
            $tabla_becario[0]=array('dato'=>utf8_d_seguro('APELLIDO Y NOMBRES: '.$datos_bec['nombre']));
            $tabla_becario[1]=array('dato'=>'NACIONALIDAD: '.$datos_bec['nacionalidad']);
            $tabla_becario[3]=array('dato'=>'FECHA DE NACIMIENTO: '.$fec_nac);
            $tabla_becario[4]=array('dato'=>utf8_d_seguro('CUIL: '.$datos_bec['cuil']));
            $tabla_becario[5]=array('dato'=>'DOMICILIO REAL COMPLETO: '.$datos_bec['domi']);
            $tabla_becario[6]=array('dato'=>utf8_d_seguro('TELÉFONO: '.$datos_bec['telefono']));    
            $tabla_becario[7]=array('dato'=>'E-MAIL: '.$datos_bec['correo']);
            $pdf->ezTable($tabla_becario,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0));
            $pdf->ezText("\n", 10);
            
            
            $tabla_carrera=array();
            $pdf->ezText(' <b>2.2 DATOS DE LA CARRERA DE GRADO/PREGRADO POR LA QUE SOLICITA LA BECA </b>', 10);
            $pdf->ezText("\n", 10);
                
            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduado
                $copias_ref=3;
                $tabla_carrera[0]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$datos_carrera['institucion']));
                $tabla_carrera[2]=array('dato'=>utf8_d_seguro('CARRERA: '.$datos_carrera['carrera']));
                $tabla_carrera[3]=array('dato'=>utf8_d_seguro('CANTIDAD DE MATERIAS DEL PLAN DE ESTUDIOS: '.$datos_carrera['cant_mat_plan']));
                $tabla_carrera[4]=array('dato'=>utf8_d_seguro('CANTIDAD DE MATERIAS ADEUDADAS: '.$datos_carrera['cant_materias_adeuda']));
                $tabla_carrera[5]=array('dato'=>'PROMEDIO: '.$datos_carrera['promedio']);
                $tabla_carrera[6]=array('dato'=>utf8_d_seguro('TÍTULO OBTENIDO: '.$datos_carrera['titulo']));
                $tabla_carrera[7]=array('dato'=>utf8_d_seguro('AÑOS DE ESTUDIO - DESDE: '.date("d/m/Y",strtotime($datos_carrera['fecha_inicio'])).' HASTA: '.date("d/m/Y",strtotime($datos_carrera['fecha_finalizacion']))));
            }else{//estudiante
                $copias_ref=2;
                $tabla_carrera[0]=array('dato'=>utf8_d_seguro('UNIDAD ACADÉMICA: '.$datos_carrera['uni_acad']));
                $tabla_carrera[2]=array('dato'=>'CARRERA: '.$datos_carrera['carrera']);
                $tabla_carrera[3]=array('dato'=>'CANTIDAD DE MATERIAS DEL PLAN DE ESTUDIOS: '.$datos_carrera['cant_mat_plan']);
                $tabla_carrera[4]=array('dato'=>'CANTIDAD DE MATERIAS APROBADAS: '.$datos_carrera['cant_materias_aprobadas']);
                $tabla_carrera[5]=array('dato'=>'PROMEDIO: '.$datos_carrera['promedio']);
                $tabla_carrera[6]=array('dato'=>utf8_d_seguro('AÑOS DE ESTUDIO - DESDE: '.$datos_carrera['fecha_inicio'].' HASTA: '.$datos_carrera['fecha_finalizacion']));
            }
            $pdf->ezTable($tabla_carrera,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0));
            $pdf->ezText("\n", 10);
            if(count($datos_estudio)>0){//si tiene estudios
                $pdf->ezText(' <b>2.3 OTROS ESTUDIOS</b>', 10);
                $pdf->ezText("\n", 10);
                $i=0;
                $tabla_estudio=array();              
                foreach ($datos_estudio as $des) {
                    $fec_desde=date("d/m/Y",strtotime($des['desde']));
                    $fec_hasta=date("d/m/Y",strtotime($des['hasta']));
                    $tabla_estudio[$i]=array( 'col1'=>trim($des['institucion']),'col2' => $fec_desde,'col3' => $fec_hasta,'col4' => trim($des['titulo']));
                    $i++;
                }   
                
                $pdf->ezTable($tabla_estudio,array('col1'=>utf8_d_seguro('<b>INSTITUCIÓN</b>'),'col2'=>'<b>DESDE</b>','col3'=>'<b>HASTA</b>','col4'=>utf8_d_seguro('<b>TÍTULO OBTENIDO</b>')),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
                $pdf->ezText("\n", 10);
            }
           
            //------------------BECAS
            if(count($datos_beca)>0){
                $pdf->ezText('<b> 2.4 BECAS OBTENIDAS </b>', 10);
                $pdf->ezText("\n", 10);
                $i=0;
                $tabla_beca=array();              
                foreach ($datos_beca as $des) {
                    $fec_desde=date("d/m/Y",strtotime($des['desde']));
                    $fec_hasta=date("d/m/Y",strtotime($des['hasta']));
                    $tabla_beca[$i]=array( 'col1'=>trim($des['institucion']),'col2' => trim($des['objeto']),'col3' => $fec_desde,'col4' => $fec_hasta);
                    $i++;
                }
                //'shaded'=>0,'showLines'=>0
                //'num'=>array('justification'=>'right')
                $pdf->ezTable($tabla_beca,array('col1'=>utf8_d_seguro('<b>INSTITUCIÓN</b>'),'col2'=>'<b>OBJETO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
                $pdf->ezText("\n", 10);
            }
            //------------------DISTINCIONES
            if(count($datos_disti)>0){
                $pdf->ezText(' <b>2.5 DISTINCIONES Y PREMIOS</b>', 10);
                $pdf->ezText("\n", 10);
                $i=0;
                $tabla_disti=array();              
                foreach ($datos_disti as $des) {
                    $fecha=date("d/m/Y",strtotime($des['fecha_dis']));
                    $tabla_disti[$i]=array( 'col1'=>$des['distincion'],'col2' => $fecha);
                    $i++;
                }   
                $pdf->ezTable($tabla_disti,array('col1'=>utf8_d_seguro('<b>DISTINCIÓN</b>'),'col2'=>'<b>FECHA</b>'),'',array('shaded'=>0,'showLines'=>1));
                $pdf->ezText("\n", 10);
             }
            if(count($datos_empleo_actual)>0 or count($datos_empleo_anterior)>0 or count($datos_pi)>0 or count($datos_pe)>0){
                 $pdf->ezText(utf8_d_seguro(' <b>2.6 EMPLEOS: Indicar en cada caso si se trata de instituciones nacionales, provinciales, minicipales y privadas. Incluir antecedentes docentes, pasantías, ayudantías de investigación, etc.</b>'), 10);
                 $pdf->ezText("\n", 10);
                  if(count($datos_empleo_actual)>0){
                     $pdf->ezText(' <b>EMPLEOS ACTUALES </b>', 10);
                     $i=0;
                     $tabla_empleo_actual=array();              
                     foreach ($datos_empleo_actual as $des) {
                        $tabla_empleo_actual[$i]=array( 'col1'=>$des['institucion'].'/'.$des['direccion'],'col2' => $des['cargo'],'col3'=>$des['anio_ingreso']);
                        $i++;
                     }   
                     $pdf->ezTable($tabla_empleo_actual,array('col1'=>'INSTITUCION: NOMBRE/DIRECCION','col2'=>'CARGO','col3'=>'AÑO DE INGRESO'),'',array('shaded'=>1));
                     $pdf->ezText("\n", 10);
                  }
                  if(count($datos_empleo_anterior)>0){
                      $pdf->ezText(' <b> EMPLEOS ANTERIORES </b>', 10);
                      $pdf->ezText("\n", 10);
                      $i=0;
                      $tabla_empleo_ant=array();              
                      foreach ($datos_empleo_anterior as $des) {
                        $tabla_empleo_ant[$i]=array( 'col1'=>trim($des['institucion']).'/'.trim($des['direccion']),'col2' => trim($des['cargo']),'col3'=>$des['anio_ingreso']);
                        $i++;
                      }  
                      $pdf->ezTable($tabla_empleo_ant,array('col1'=>utf8_d_seguro('<b>INSTITUCIÓN: NOMBRE/DIRECCIÓN</b>'),'col2'=>'<b>CARGO</b>','col3'=>utf8_d_seguro('<b>AÑO DE INGRESO</b>')),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
                      $pdf->ezText("\n", 10);
                  }
                  if(count($datos_pi)>0){
                      $pdf->ezText(utf8_d_seguro('<b>PARTICIPACIÓN EN PROYECTOS DE INVESTIGACIÓN </b>'), 10);
                      $pdf->ezText("\n", 10);
                      $i=0;
                      $tabla_pi=array();              
                      foreach ($datos_pi as $des) {
                        $fecha_desde=date("d/m/Y",strtotime($des['desde']));  
                        $fecha_hasta=date("d/m/Y",strtotime($des['hasta'])); 
                        $tabla_pi[$i]=array( 'col1'=>$des['codigo'],'col2' => $des['nombredirector'],'col3'=>$fecha_desde,'col4'=>$fecha_hasta);
                        $i++;
                      }   
                      $pdf->ezTable($tabla_pi,array('col1'=>utf8_d_seguro('<b>CÓDIGO DEL PROYECTO</b>'),'col2'=>'<b>DIRECTOR DEL PROYECTO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
                      $pdf->ezText("\n", 10); 
                  }
                if(count($datos_pe)>0){
                      $pdf->ezText(utf8_d_seguro('<b>PARTICIPACIÓN EN PROYECTOS DE EXTENSIÓN </b>'), 10);
                      $pdf->ezText("\n", 10);
                      $i=0;
                      $tabla_pe=array();  
                      foreach ($datos_pe as $des) {
                        $fecha_desde=date("d/m/Y",strtotime($des['desde']));  
                        $fecha_hasta=date("d/m/Y",strtotime($des['hasta'])); 
                        $tabla_pe[$i]=array( 'col1'=>$des['codigo'],'col2' => $des['nombredirector'],'col3'=>$fecha_desde,'col4'=>$fecha_hasta);
                        $i++;
                      }   
                      $pdf->ezTable($tabla_pe,array('col1'=>utf8_d_seguro('<b>CÓDIGO DEL PROYECTO</b>'),'col2'=>'<b>DIRECTOR DEL PROYECTO</b>','col3'=>'<b>DESDE</b>','col4'=>'<b>HASTA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
                      $pdf->ezText("\n", 10); 
                  }
            }
           if(count($datos_trab)>0){
               $pdf->ezText(utf8_d_seguro(' <b>2.7 TRABAJOS REALIZADOS: MONOGRAFÍAS, TRABAJOS DE SEMINARIOS, TESIS, CONGRESOS, PUBLICACIONES </b>'), 10); 
               $pdf->ezText("\n", 10);
               $i=0;
               $tabla_trab=array();              
               foreach ($datos_trab as $des) {
                    $fecha=date("d/m/Y",strtotime($des['fecha_trab']));
                    $tabla_trab[$i]=array( 'col1'=>trim($des['titulo']),'col2' => trim($des['presentado_en']),'col3' => $fecha);
                    $i++;
                }   
               $pdf->ezTable($tabla_trab,array('col1'=>utf8_d_seguro('<b>TÍTULO DEL TRABAJO</b>'),'col2'=>'<b>PRESENTADO O PUBLICADO EN</b>','col3'=>'<b>FECHA</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500));
               $pdf->ezText("\n", 10);
           }
           if(count($datos_idioma)>0){
                $pdf->ezText(utf8_d_seguro(' <b>2.8 CONOCIMIENTO DE IDIOMAS: INDICAR SI ES MUY BUENO, BUENO, ACEPTABLE Y ADJUNTAR CERTIFICADOS O DIPLOMAS </b>'), 10);
                $pdf->ezText("\n", 10);
                $i=0;
                $tabla_idiom=array();
                foreach ($datos_idioma as $des) {
                    $tabla_idiom[$i]=array( 'col1'=>trim($des['idioma']),'col2' => $des['lee'],'col3' => $des['escribe'],'col4' => $des['habla'],'col5' => $des['entiende']);
                    $i++;
                }   
                
               $pdf->ezTable($tabla_idiom,array('col1'=>utf8_d_seguro('<b>IDIOMA</b>'),'col2'=>'<b>LEE</b>','col3'=>'<b>ESCRIBE</b>','col4'=>'<b>HABLA</b>','col5'=>'<b>ENTIENDE</b>'),'',array('shaded'=>0,'showLines'=>1,'width'=>500,'cols'=>array('col1'=>array('width'=>200,'justification'=>'center'),'col2'=>array('width'=>75,'justification'=>'center'),'col3'=>array('width'=>75,'justification'=>'center'),'col4'=>array('width'=>75,'justification'=>'center'))));
               $pdf->ezText("\n", 10);
           }

           $pdf->ezText(' <b>2.9 TIENE OTRA BECA EN CURSO? </b>', 10);
           if($inscripcion['beca_en_curso']){
                $pdf->ezText(' <b>SI </b>', 10);
                $pdf->ezText('INSTITUCION: '.$inscripcion['institucion_beca_en_curso'], 10);
           }else{
                $pdf->ezText(' <b>NO </b>', 10);
           }
            $pdf->ezText("\n", 10);
            
            $pdf->ezText(utf8_d_seguro(' <b>2.10 PERSONAS A QUIENES EL POSTULANTE SOLICITÓ REFERENCIAS </b>'), 10);
            $pdf->ezText("\n", 10);
            foreach ($datos_referencias as $des) {
              $tabla_ref=array();
              $tabla_ref[0]=array('dato'=>utf8_d_seguro('APELLIDO Y NOMBRES: '.$des['agente'])); 
              if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
                   $tabla_ref[1]=array('dato'=>utf8_d_seguro('PROFESIÓN: '.$des['profesion'])); 
                   $tabla_ref[2]=array('dato'=>utf8_d_seguro('CARGO: '.$des['cargo'])); 
                   $tabla_ref[3]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$des['institucion'])); 
                   $tabla_ref[4]=array('dato'=>utf8_d_seguro('DOMICILIO: '.$des['domi'])); 
              }else{
                   $tabla_ref[1]=array('dato'=>utf8_d_seguro('UNIDAD ACADÉMICA: '.$des['uni_acad'])); 
                   $tabla_ref[2]=array('dato'=>utf8_d_seguro('DOMICILIO: '.$des['domi'])); 
              }
              
              $pdf->ezTable($tabla_ref,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
              $pdf->ezText("\n", 10);
            }
//            $tabla_ref[0]=array('dato'=>utf8_d_seguro('APELLIDO Y NOMBRES: '.$datos_referencias['agente']));
//            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
//               $tabla_ref[1]=array('dato'=>utf8_d_seguro('PROFESIÓN: '.$datos_referencias['profesion'])); 
//               $tabla_ref[2]=array('dato'=>utf8_d_seguro('CARGO: '.$datos_referencias['cargo'])); 
//               $tabla_ref[3]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$datos_referencias['institucion'])); 
//               $tabla_ref[4]=array('dato'=>utf8_d_seguro('DOMICILIO: '.$datos_referencias['domi'])); 
//            }else{
//                $tabla_ref[1]=array('dato'=>utf8_d_seguro('UNIDAD ACADÉMICA: '.$datos_referencias['uni_acad'])); 
//                $tabla_ref[2]=array('dato'=>utf8_d_seguro('DOMICILIO: '.$datos_referencias['domi'])); 
//            }
//            
//            $pdf->ezTable($tabla_ref,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
//            $pdf->ezText("\n", 10);
          
            $pdf->ezText(utf8_d_seguro(' <b>2.11 LUGAR DE TRABAJO EN EL QUE DESARROLLARÁ LA BECA</b>'), 10);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro(' <b>UNIDAD ACADÉMICA: </b>'.$datos_insc['ua_trabajo_beca']), 10);
            $pdf->ezText(utf8_d_seguro(' <b>DEPARTAMENTO ACADÉMICO: </b>'.$datos_insc['dpto_trabajo_beca']), 10);
            $pdf->ezText(utf8_d_seguro(' <b>LABORATORIO, ÁREA, CENTRO, INSTITUTO: </b>'.$datos_insc['desc_trabajo_beca']), 10);
            $pdf->ezText(utf8_d_seguro(' <b>DOMICILIO COMPLETO: </b>'.$datos_insc['domi_lt']), 10);
            $pdf->ezText("\n", 10);
            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
                $pdf->ezText(utf8_d_seguro(' <b>2.12 CONFORMIDAD DEL DECANO Y DEL DIRECTOR DEL DEPARTAMENTO DEL LUGAR DE TRABAJO </b>'), 10);
                $pdf->ezText("\n", 10);
                $datos[0]=array('dato'=>'APELLIDO Y NOMBRE DEL DECANO: ....................................................................quien ocupa el cargo de.............................................................PRESTA SU acuerdo para que en caso de ser aprobada la beca, EL CONCURSANTE PUEDA REALIZAR EL TRABAJO PROPUESTO EN EL PUNTO 3.11');
                $datos[1]=array('dato'=>'TIPO Y N DE DOCUMENTO: ........................');
                $datos[2]=array('dato'=>'FIRMA: .................................................................');
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 10);
                $datos=array();
                $datos[0]=array('dato'=>'APELLIDO Y NOMBRE DEL DIRECTOR DEL DEPARTAMENTO: ...............................................................quien ocupa el cargo de.............................................................PRESTA SU acuerdo para que en caso de ser aprobada la beca, EL CONCURSANTE PUEDA REALIZAR EL TRABAJO PROPUESTO EN EL PUNTO 3.11');
                $datos[1]=array('dato'=>'TIPO Y N DE DOCUMENTO: ........................');
                $datos[2]=array('dato'=>'FIRMA: .................................................................');
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 10);
            }
            //------------------------3
            $pdf->ezNewPage(); 
            $pdf->ezText(utf8_d_seguro(' <b>3. CERTIFICACIÓN DEL DIRECTOR DE BECA </b>'), 10,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro('            Declaro conocer y aceptar el Reglamento de Becas de Investigación de la Universidad Nacional del Comahue, y las obligaciones que de él derivan para los directores de beca, y dejo constancia de que he aconsejado en la formación del plan de trabajo del solicitante y estimado el cronograma de ejecución.'), 10);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro('            Asimismo, me hago responsable ante la Universidad Nacional del Comahue de que en caso de serle concedida la beca, se le proporcionará al solicitante, en el lugar de trabajo propuesto, los elementos necesarios para llevar a cabo su tarea.'), 10);
            $pdf->ezText("\n", 10);
           
            $tabla_director=array();
            $tabla_codirector=array();
            if(isset($inscripcion['id_director'])){
                $tabla_director[0]=array('dato'=>utf8_d_seguro('APELLIDO Y NOMBRES: '.$datos_dir['nombre']));
                $tabla_director[1]=array('dato'=>'DOMICILIO: '.$datos_dir['domi']);
                $tabla_director[2]=array('dato'=>'E-MAIL: '.$datos_dir['correo']);
                $tabla_director[3]=array('dato'=>'CUIL: '.$datos_dir['cuil']);
                $tabla_director[4]=array('dato'=>utf8_d_seguro('CATEGORÍA DOCENTE: '.$datos_dir['cat_estat']));
                $tabla_director[5]=array('dato'=>utf8_d_seguro('DEDICACIÓN: '.$datos_dir['dedicacion']));
                $tabla_director[6]=array('dato'=>'REGULAR O INTERINO: '.$datos_dir['carac']);
                $tabla_director[7]=array('dato'=>utf8_d_seguro('CATEGORÍA INVESTIGADOR: '.$datos_dir['cat_conicet']));
                $tabla_director[8]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$datos_dir['institucion']));
                $tabla_director[9]=array('dato'=>'LUGAR DE TRABAJO: '.$datos_dir['lugar_trabajo']);
                $tabla_director[10]=array('dato'=>utf8_d_seguro('CATEGORÍA EQUIVALENTE DE INVESTIGACIÓN: '.$datos_dir['cat_inv']));
                $tabla_director[11]=array('dato'=>utf8_d_seguro('TÍTULO DE POSGRADO: '.$datos_dir['titulo']));
                $tabla_director[12]=array('dato'=>utf8_d_seguro('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'));
                $pdf->ezTable($tabla_director,array('dato'=>''),'<b>DATOS DEL DIRECTOR DE BECA: </b>',array('showHeadings'=>0,'shaded'=>0,'fontSize'=>10));
                $pdf->ezText("\n\n\n\n\n", 10);
                $pdf->ezText('         ..........................................', 10,$centrado);
                $pdf->ezText('         ..........................................', 10,$centrado);
                $pdf->ezText('         FIRMA DEL DIRECTOR', 10,$centrado);
                $pdf->ezText('         LUGAR Y FECHA', 10,$centrado);
            }
              if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//solo graduados pide codirector
//            if(isset($inscripcion['id_codirector'])){
//                $tabla_codirector[0]=array('dato'=>'APELLIDO Y NOMBRES: '.$datos_codir['nombre']);
//                $tabla_codirector[1]=array('dato'=>'DOMICILIO: '.$datos_codir['domi']);
//                $tabla_codirector[2]=array('dato'=>'E-MAIL: '.$datos_codir['correo']);
//                $tabla_codirector[3]=array('dato'=>'CUIL: '.$datos_codir['cuil']);
//                $tabla_codirector[4]=array('dato'=>utf8_d_seguro('CATEGORÍA DOCENTE: '.$datos_codir['cat_estat']));
//                $tabla_codirector[5]=array('dato'=>utf8_d_seguro('DEDICACIÓN: '.$datos_codir['dedicacion']));
//                $tabla_codirector[6]=array('dato'=>'REGULAR O INTERINO: '.$datos_codir['carac']);
//                $tabla_codirector[7]=array('dato'=>utf8_d_seguro('CATEGORÍA INVESTIGADOR: '.$datos_codir['cat_conicet']));
//                $tabla_codirector[8]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$datos_codir['institucion']));
//                $tabla_codirector[9]=array('dato'=>'LUGAR DE TRABAJO: '.$datos_codir['lugar_trabajo']);
//                $tabla_codirector[10]=array('dato'=>utf8_d_seguro('CATEGORÍA EQUIVALENTE DE INVESTIGACIÓN: '.$datos_codir['cat_inv']));
//                $tabla_codirector[11]=array('dato'=>utf8_d_seguro('TÍTULO DE POSGRADO: '.$datos_codir['titulo']));
//                $tabla_codirector[12]=array('dato'=>utf8_d_seguro('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'));
//                $pdf->ezTable($tabla_codirector,array('dato'=>''),'<b>DATOS DEL CODIRECTOR DE BECA: ',array('showHeadings'=>0,'shaded'=>0));
//                $pdf->ezText("\n\n\n\n\n", 10);
//                $pdf->ezText('         ..........................................', 10,$centrado);
//                $pdf->ezText('         ..........................................', 10,$centrado);
//                $pdf->ezText('         FIRMA DEL CODIRECTOR', 10,$centrado);
//                $pdf->ezText('         LUGAR Y FECHA', 10,$centrado);
//                $pdf->ezTable(array(),array('dato'=>''),utf8_d_seguro('<b>FUNDAMENTOS DE LA PARTICIPACIÓN DEL CODIRECTOR: </b>'),array('showHeadings'=>0,'shaded'=>0));
//                $pdf->ezText('         ..........................................', 10,$centrado);
//                $pdf->ezText('         FIRMA DEL DIRECTOR', 10,$centrado);
//            }
              }
         //-------------------------4
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro(' <b>4. DATOS DEL PROYECTO DE INVESTIGACIÓN AL QUE SE INCORPORA (APROBADO O EN EVALUACIÓN) </b>'), 10,$centrado);
            if(isset($datos_proy)>0){
                $datos[0]=array('dato'=>utf8_d_seguro('CÓDIGO DEL PROYECTO: '.$datos_proy['codigo']));
                $datos[1]=array('dato'=>utf8_d_seguro('TÍTULO: '.$datos_proy['denominacion']));
                $fecha_desde=date("d/m/Y",strtotime($datos_proy['fec_desde']));
                $fecha_hasta=date("d/m/Y",strtotime($datos_proy['fec_hasta']));
                $datos[2]=array('dato'=>'FECHA DE INICIO: '.$fecha_desde);
                $datos[3]=array('dato'=>utf8_d_seguro('FECHA DE FINALIZACIÓN: ').$fecha_hasta);
                $datos[4]=array('dato'=>utf8_d_seguro('ORDENANZA DE APROBACIÓN N° : ').$datos_proy['nro_ord_cs']);
                $datos[5]=array('dato'=>utf8_d_seguro('DIRECTOR: '.$datos_proy['apnom_director']));
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 10);
            }
            $pdf->ezNewPage(); 
            //-------------------------5
            $pdf->ezText(' <b>5. DATOS DEL PLAN DE TRABAJO DEL BECARIO</b>', 10,$centrado);
            $pdf->ezText("\n", 10);
            if(isset($inscripcion['titulo_plan_trabajo'])){
                $pdf->ezText(utf8_d_seguro($inscripcion['titulo_plan_trabajo']), 10,$centrado);
            }
            
            $pdf->ezText(utf8_d_seguro(' <b> DESARROLLO DEL PLAN DE TRABAJO </b>'), 10,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro(' Se deberá incluir una descripción de la investigación a realizar durante el primer año de beca. Además deberá  especificarse el plan de formació del becario, mediante la enumeración de la realización de cursos, participación a congresos, seminarios, pasantías (especificando en cada caso lugar y tiempo estimado) '), 10);
            $pdf->ezText("\n", 10);
            unset($datos);//limpio la variable
            if(isset($inscripcion['desarrollo_plan_trab'])){
                $datos[0]=array('dato'=>utf8_d_seguro($inscripcion['desarrollo_plan_trab']));
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 10);
            }
             //-------------------------6
            $pdf->ezNewPage(); 
            $pdf->ezText(' <b>6. FUNDAMENTOS DE LA SOLICITUD</b>', 10,$centrado);
            $pdf->ezText("\n", 8);
            $pdf->ezText(utf8_d_seguro(' El solicitante expresará en esta hoja los motivos de su solicitud de una beca y de su elección de los temas propuestos.'), 10);
            $pdf->ezText("\n", 8);
            unset($datos);//limpio la variable
            if(isset($inscripcion['fundamentos_solicitud'])){
                $datos[0]=array('dato'=>utf8_d_seguro($inscripcion['fundamentos_solicitud']));
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 8);
            }
            //---------------------------7
            $i=0;
            while ($i<=$copias_ref) {
                $pdf->ezNewPage(); 
                $pdf->ezText(' <b>7. REFERENCISTAS</b>', 10,$centrado);
                $pdf->ezText("\n", 8);
                $pdf->ezText(utf8_d_seguro(' SR. REFERENCISTA: Rogamos completar el cuestionario adjunto. Agradecemos desde ya en nombre del Consejo su aprecida colaboración y le garantizamos absoluta reserva.'),10);
                $pdf->ezText(utf8_d_seguro( 'EL PRESENTE FORMULARIO DEBE SER ENTREGADO EN SOBRE CERRADO, EN LA SUBSECRETARÍA DE INVESTIGACIÓN DE CADA UNIDAD ACADÉMICA, A LOS EFECTOS DE SER ANEXADO A LA CARPETA DE PRESENTACIÓN.'), 10);
                $pdf->ezText("\n", 8);
                $pdf->ezText(utf8_d_seguro( '1. Apellido y Nombres del concursante: .......................................................................'), 10);
                $pdf->ezText("\n", 8);
                $pdf->ezText(utf8_d_seguro( '2. Apellido y Nombres del referencista: ......................................................................'), 10);
                $pdf->ezText("\n", 8);
                $pdf->ezText(utf8_d_seguro( '3. CONOCIMIENTO DEL POSTULANTE'), 10);
                $pdf->ezText(utf8_d_seguro( '3.1 ¿Cuánto tiempo hace que lo conoce?'), 10);
                $pdf->ezText(utf8_d_seguro( '3.2 Tipo de relación (especifique la duración en cada tipo de relación si corresponde )'), 10);
                $pdf->ezText("\n", 7);
                $tabla=array();              
                $tabla[0]=array( 'col1'=>'Alumno: ','col2' => 'Becario: ');
                $tabla[1]=array( 'col1'=>'Ayudante: ','col2' => 'Integrante: ');
                $tabla[2]=array( 'col1'=>' ','col2' => 'Colaborador: ');
                $tabla[3]=array( 'col1'=>'Otro (especificar): ','col2' => '');
                $pdf->ezTable($tabla,array('col1'=>'DOCENCIA','col2'=>'INVESTIGACION'),'',array('shaded'=>1,'width'=>500));
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4. SE SOLICITA OPINIÓN ACERCA DE LOS SIGUIENTES ASPECTOS (SI SON DE SU CONOCIMIENTO)'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4.1 Formación académica del postulante (carrera universitaria, seminarios).'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4.2 Antecedentes generales del postulante (ayudantías docentes y de investigación, conocimientos de idiomas, etc.)'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4.3 Trabajos realizados por el postulante (monografías, tesinas, tesis, publicaciones, presentaciones a congresos, etc.)'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4.4 Predisposición del postulante para desarrollar tareas vinculadas a la investigación científica.'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '4.5 Disciplina de trabajo y actitud frente a las indicaciones de sus directores, tutores, asesores, etc.'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '5. EVALUACIÓN FINAL DEL POSTULANTE'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
                $pdf->ezText("\n", 7);
                $pdf->ezText("\n", 7);$pdf->ezText("\n", 7);
                $tabla=array();              
                $tabla[0]=array( 'col1'=>'','col2' => utf8_d_seguro('Unidad Académica a la que '));
                $tabla[0]=array( 'col1'=>'','col2' => utf8_d_seguro(' pertenece: '));
                $tabla[1]=array( 'col1'=>'............................................ ','col2' => '............................................');
                $tabla[2]=array( 'col1'=>utf8_d_seguro('Firma y aclaración '),'col2' => '');
                $pdf->ezTable($tabla,array( 'col1'=>'','col2' => ''),'',array('showLines'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 7);$pdf->ezText("\n", 7); 
                if($inscripcion['categ_beca']==3){
                    $pdf->ezText(utf8_d_seguro( 'Se certifica que el/la alumno/a....................................................................................'
                        . 'DNI N° .................................. Legajo N° .................................'
                        . ' se encuentra cursando la carrera .....................................................................'
                        . ' con un total de  .....................................................materias aprobadas al día de la fecha.'
                        . ' El Plan de Estudios consta de ........materias, incluyendo tesis/trabajo final si correspondiera (Ordenanzas N° .......................................)'), 10);
                    $pdf->ezText("\n", 7);$pdf->ezText("\n", 7);
                    $pdf->ezText(utf8_d_seguro( 'Lugar y fecha:'), 10);
                    $pdf->ezText("\n", 7);
                    $pdf->ezText(utf8_d_seguro( 'Firma del área académica correspondiente:'), 10);
                }
             $i++;   
            }
            
            
          //-------fin referencista  
            
        }
}
?>