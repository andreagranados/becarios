<?php
class ci_alta_solicitud extends toba_ci
{
        protected $s__pantalla;
        protected $s__categ_beca;
        protected $s__nombre_archivo_ca;
        
    
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
            //esto era para cambiar la categoria
            //!!!ojo aca ver si esta bien que pueda modificar la categoria de la inscripcion
//            if($band){
//               $this->s__categ_beca =   $datos;
//               $this->dep('datos')->tabla('inscripcion_beca')->set($datos);//setea en la inscripcion el tipo de categoria que acaba de elegir 
//            }

        }
	//-----------------------------------------------------------------------------------
	//---- form_dir ---------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

        function conf__form_dir(toba_ei_formulario $form)
	{
            $datos=$this->dep('datos')->tabla('director_beca')->get();
            $datosc=$this->dep('datos')->tabla('codirector_beca')->get();
            $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
            //hago un set de categ para ocultar o no formulario de codirector
            $datos['categ']=$insc['categ_beca'];
            $form->set_datos($datos);
            if(isset($datos['id_designacion'])){
                 $id_doc=$this->dep('datos')->tabla('director_beca')->get_docente($datos['id_designacion']);
                
                 $datos['id_docente']=$id_doc;
                 $domi=$this->dep('datos')->tabla('domicilio_dir')->get();
                 $datos['cod_pais']=$domi['cod_pais'];
                 $datos['cod_provincia']=$domi['cod_provincia'];
                 $datos['cod_postal']=$domi['cod_postal'];
                 $datos['calle']=$domi['calle'];
                 $datos['numero']=$domi['numero'];
                 $datos['telefono']=$domi['telefono'];
                 if(isset($datosc['id_designacion'])){
                     $id_docc=$this->dep('datos')->tabla('director_beca')->get_docente($datosc['id_designacion']);
                     $datos['id_docentec']=$id_docc;
                     $datos['correoc']=$datosc['correo'];
                     $datos['id_designacionc']=$datosc['id_designacion'];
                     $datos['tituloc']=$datosc['titulo'];
                     $datos['institucionc']=$datosc['institucion'];
                     $datos['lugar_trabajoc']=$datosc['lugar_trabajo'];
                     $datos['cat_investc']=$datosc['cat_invest'];
                     $datos['cat_conicetc']=$datosc['cat_conicet'];
                     $datos['hs_dedic_invesc']=$datosc['hs_dedic_inves'];
                     $domic=$this->dep('datos')->tabla('domicilio_codir')->get();
                     $datos['cod_paisc']=$domic['cod_pais'];
                     $datos['cod_provinciac']=$domic['cod_provincia'];
                     $datos['cod_postalc']=$domic['cod_postal'];
                     $datos['callec']=$domic['calle'];
                     $datos['numeroc']=$domic['numero'];
                     $datos['telefonoc']=$domic['telefono'];
                 }
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
                //datos del domicilio
                $datosdom['cod_pais']=$datos['cod_pais'];
                $datosdom['cod_provincia']=$datos['cod_provincia'];
                $datosdom['cod_postal']=$datos['cod_postal'];
                $datosdom['numero']=$datos['numero'];
                $datosdom['calle']=$datos['calle'];
                $datosdom['telefono']=$datos['telefono'];
                $this->controlador()->dep('datos')->tabla('domicilio_dir')->set($datosdom);
                $this->controlador()->dep('datos')->tabla('domicilio_dir')->sincronizar();
                $domi=$this->controlador()->dep('datos')->tabla('domicilio_dir')->get();
                $datosd['nro_domicilio']=$domi['nro_domicilio'];
                
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
                $datosd['hs_dedic_inves']=$datos['hs_dedic_inves'];
                $this->dep('datos')->tabla('director_beca')->set($datosd);
                //----sincroniza
                $this->dep('datos')->tabla('director_beca')->sincronizar();
                if($primerad){
                    $dir=$this->dep('datos')->tabla('director_beca')->get();
                    $datos_insc['id_director']=$dir['id'];
                }
                
                //pregunto si cargo codirector beca
                if(isset($datos['id_designacionc'])){
                    //datos del domicilio
                    if(isset($datos['cod_paisc'])){
                        $datosdom['cod_pais']=$datos['cod_paisc'];
                        $datosdom['cod_provincia']=$datos['cod_provinciac'];
                        $datosdom['cod_postal']=$datos['cod_postalc'];
                        $datosdom['numero']=$datos['numeroc'];
                        $datosdom['calle']=$datos['callec'];
                        $datosdom['telefono']=$datos['telefonoc'];
                        $this->controlador()->dep('datos')->tabla('domicilio_codir')->set($datosdom);
                        $this->controlador()->dep('datos')->tabla('domicilio_codir')->sincronizar();
                        $domi=$this->controlador()->dep('datos')->tabla('domicilio_codir')->get();
                        $datosc['nro_domicilio']=$domi['nro_domicilio'];
                    }
                    
                //--datos del codirector
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
                    $datosc['hs_dedic_inves']=$datos['hs_dedic_invesc'];
                    $this->dep('datos')->tabla('codirector_beca')->set($datosc);
                    $this->dep('datos')->tabla('codirector_beca')->sincronizar();
                }  
                if($primerac){
                    $dir=$this->dep('datos')->tabla('codirector_beca')->get();
                    $datos_insc['id_codirector']=$dir['id'];
                }
                if($primerad or $primerac){
                    $this->dep('datos')->tabla('inscripcion_beca')->set($datos_insc);
                    $this->dep('datos')->tabla('inscripcion_beca')->sincronizar();
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
                $director=$this->dep('datos')->tabla('director_beca')->get();
                //domicilio del director
                $datosdom_dir=array('nro_domicilio'=>$director['nro_domicilio']);
                $this->dep('datos')->tabla('domicilio_dir')->cargar($datosdom_dir);
                if(isset($insc[0]['id_codirector'])){
                    $datosc=array('id'=>$insc[0]['id_codirector']);
                    $this->dep('datos')->tabla('codirector_beca')->cargar($datosc);
                    $codirector=$this->dep('datos')->tabla('codirector_beca')->get();
                    $datosdom_codir=array('nro_domicilio'=>$codirector['nro_domicilio']);
                    $this->dep('datos')->tabla('domicilio_codir')->cargar($datosdom_codir);
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
                $this->dep('datos')->tabla('inscripcion_adjuntos')->cargar($datosins);
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
        
       //--------formulario para adjuntos
        function conf__form_adj(toba_ei_formulario $form)
	{
            if ($this->dep('datos')->tabla('inscripcion_adjuntos')->esta_cargada()) {
                $adj=$this->dep('datos')->tabla('inscripcion_adjuntos')->get();
                if(isset($adj['cert_ant'])){
                    //$nomb_ca='http://mocovi.uncoma.edu.ar/becarios_2019/'.$adj['cert_ant'];
                    $nomb_ca='/becarios/1.0/temp/becarios_2019/'.$adj['cert_ant'];
                    $datos['cert_a']=$adj['cert_ant'];
                    $datos['imagen_vista_previa_ca'] = "<a target='_blank' href='{$nomb_ca}' >cert ant</a>";
                }
                if(isset($adj['const_titu'])){
                    //$nomb_ca='http://mocovi.uncoma.edu.ar/becarios_2019/'.$adj['cert_ant'];
                    $nomb_ti='/becarios/1.0/temp/becarios_2019/'.$adj['const_titu'];
                    $datos['const_titu']=$adj['const_titu'];
                    $datos['imagen_vista_previa_titu'] = "<a target='_blank' href='{$nomb_ti}' >const titu</a>";
                }
                if(isset($adj['rend_acad'])){
                    //$nomb_ca='http://mocovi.uncoma.edu.ar/becarios_2019/'.$adj['cert_ant'];
                    $nomb_ra='/becarios/1.0/temp/becarios_2019/'.$adj['rend_acad'];
                    $datos['rend_acad']=$adj['rend_acad'];
                    $datos['imagen_vista_previa_ra'] = "<a target='_blank' href='{$nomb_ra}' >rend acad</a>";
                }
                 if(isset($adj['cv_post'])){
                    //$nomb_ca='http://mocovi.uncoma.edu.ar/becarios_2019/'.$adj['cert_ant'];
                    $nomb_cvp='/becarios/1.0/temp/becarios_2019/'.$adj['cv_post'];
                    $datos['cv_post']=$adj['cv_post'];
                    $datos['imagen_vista_previa_cvp'] = "<a target='_blank' href='{$nomb_cvp}' >cv postul</a>";
                }
                return $datos;
                //https://despacho.uncoma.edu.ar/archivos/ord_1039_2017_47.pdf
            }
	}
        
        function evt__form_adj__guardar($datos)
        {//print_r($datos);
            $band=true;
            $datos2=array();
            if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'I'){//solo en estado I puede modificar
                    $band=false;
                }else{
                    $datos2['id_becario']=$insc['id_becario'];
                    $datos2['fecha']=$insc['fecha_presentacion'];
                }
                
            }
            //!!!!!!!!toba::proyecto()->get_path() usar
            if($band){//band es true cuando tiene que cargar la primera vez o cuando puede modificar
                $bec=$this->dep('datos')->tabla('becario')->get();
                $cuil_becario=$bec['cuil1'].$bec['cuil'].$bec['cuil2'];
                
                if (isset($datos['cert_a'])) {
                    //$nombre_archivo_ca = toba::proyecto()->get_www_temp($datos['cert_a']['name']);
                    //$this->s__nombre_archiv_ca = $datos['cert_a']['name'];
                    $nombre_ca="cert_ant".$cuil_becario.".pdf";
                    //$destino_ca="C:/proyectos/toba_2.6.3/proyectos/becarios/www/temp/becarios_2019/cert_ant".$cuil_becario.".pdf";
                    $destino_ca="/home/cristian/becarios/becarios_2019/cert_ant".$cuil_becario.".pdf";
                    move_uploaded_file($datos['cert_a']['tmp_name'], $destino_ca);//mueve un archivo a una nueva direccion, retorna true cuando lo hace y falso en caso de que no
                    $datos2['cert_ant']=strval($nombre_ca);
                }
                if(isset($datos['const_titu'])){
                    $nombre_ti="const_titu".$cuil_becario.".pdf";
                    //$destino_ti="C:/proyectos/toba_2.6.3/proyectos/becarios/www/temp/becarios_2019/const_titu".$cuil_becario.".pdf";
                    $destino_ti="/home/cristian/becarios/becarios_2019/cert_ant".$cuil_becario.".pdf";
                    move_uploaded_file($datos['const_titu']['tmp_name'], $destino_ti);//mueve un archivo a una nueva direccion, retorna true cuando lo hace y falso en caso de que no
                    $datos2['const_titu']=strval($nombre_ti);
                }
                if(isset($datos['rend_acad'])){
                    $nombre_ra="rend_acad".$cuil_becario.".pdf";
                    $destino_ra="C:/proyectos/toba_2.6.3/proyectos/becarios/www/temp/becarios_2019/rend_acad".$cuil_becario.".pdf";
                    move_uploaded_file($datos['rend_acad']['tmp_name'], $destino_ra);//mueve un archivo a una nueva direccion, retorna true cuando lo hace y falso en caso de que no
                    $datos2['rend_acad']=strval($nombre_ra);
                }
                if(isset($datos['cv_post'])){
                    $nombre_cvp="cv_post".$cuil_becario.".pdf";
                    $destino_cvp="C:/proyectos/toba_2.6.3/proyectos/becarios/www/temp/becarios_2019/rend_acad".$cuil_becario.".pdf";
                    move_uploaded_file($datos['cv_post']['tmp_name'], $destino_cvp);//mueve un archivo a una nueva direccion, retorna true cuando lo hace y falso en caso de que no
                    $datos2['cv_post']=strval($nombre_cvp);
                }
                //print_r($datos2);
                $this->dep('datos')->tabla('inscripcion_adjuntos')->set($datos2);
                $this->dep('datos')->tabla('inscripcion_adjuntos')->sincronizar();
                
            }//no modifica nada
 
        }
        //recien cuando ha sifo enviado muestra los botones para imprimir
        function conf__pant_final(toba_ei_pantalla $pantalla){
            //El evento "imprimir" no posee un VINCULO ASOCIADO.
            if ($this->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']=='E'){
                    $this->evento('enviar')->ocultar();
                    $this->evento('imprimir')->mostrar();
                    $this->evento('imprimir_ficha')->mostrar();
                    $this->evento('imprimir')->vinculo()->agregar_parametro('evento_trigger', 'imprimir1');
                    $this->evento('imprimir_ficha')->vinculo()->agregar_parametro('evento_trigger', 'imprimir2'); 
                }else{
                    $this->evento('imprimir')->ocultar();
                    $this->evento('imprimir_ficha')->ocultar();
                }
             }
            
        }
        //----
        
        function vista_pdf(toba_vista_pdf $salida){
          $bandera = toba::memoria()->get_parametro('evento_trigger');
         // print_r($bandera);exit;
          $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
          $datos_bec=$this->dep('datos')->tabla('becario')->get_datos_personales($inscripcion['id_becario']);
          $fec_nac=date("d/m/Y",strtotime($datos_bec['fec_nacim']));
          $datos_dir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_director']); 
          $datos_codir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_codirector']); 
          $proy=$this->dep('datos')->tabla('proyecto_inv')->get();
          $datos_proy=$this->dep('datos')->tabla('proyecto_inv')->get_datos_proyecto($proy['id_pinv']);
          $datos_insc=$this->dep('datos')->tabla('inscripcion_beca')->get_datos_inscripcion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);
          if($bandera=='imprimir1'){//imprimir el formulario
            $salida->set_nombre_archivo("Inscripcion_Becario.pdf");
            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait');//landscape
            $salida->inicializar();
            $pdf = $salida->get_pdf();
            $pdf->ezSetMargins(90, 50, 45, 45);
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
//            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
//            $datos_insc=$this->dep('datos')->tabla('inscripcion_beca')->get_datos_inscripcion($inscripcion['id_becario'],$inscripcion['fecha_presentacion']);
//            //print_r($inscripcion);
//            $datos_bec=$this->dep('datos')->tabla('becario')->get_datos_personales($inscripcion['id_becario']);
//            $datos_dir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_director']); 
//            $datos_codir=$this->dep('datos')->tabla('director_beca')->get_datos_director($inscripcion['id_codirector']); 
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
//            $proy=$this->dep('datos')->tabla('proyecto_inv')->get();
//            $datos_proy=$this->dep('datos')->tabla('proyecto_inv')->get_datos_proyecto($proy['id_pinv']);
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
            
           
            //-------------------------------1
            $pdf->ezText(' <b>1. SOLICITUD </b>', 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText("\n", 10);
            //-----------------------datos que antes iban en la CARATULA
            $pdf->ezText(utf8_d_seguro(' <b>BECAS DE INVESTIGACIÓN DE LA UNIVERSIDAD NACIONAL DEL COMAHUE</b>'), 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(' <b>CONVOCATORIA 2019</b>', 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText('<b>POSTULANTE: </b>'.utf8_d_seguro($datos_bec['nombre']), 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText($uacad, 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro($cat), 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText($datos_proy['codigo'], 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText('<b>DIRECTOR: </b>'.utf8_d_seguro($datos_dir['nombre']), 12,$centrado);
            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduado
                if(isset($inscripcion['id_codirector'])){
                    if(isset($datos_codir['nombre'])){
                        $pdf->ezText("\n", 10);
                        $pdf->ezText('<b>CO-DIRECTOR: </b>'.utf8_d_seguro($datos_codir['nombre']), 12,$centrado);
                    }   
                }
            }
   
            //-------------------------------2
            $pdf->ezNewPage(); 
            $pdf->ezText(' <b>2. ANTECEDENTES Y DATOS DEL POSTULANTE </b>', 12,$centrado);
            $pdf->ezText("\n", 10);
            $pdf->ezText(' <b>2.1 DATOS PERSONALES </b>', 10);
            $pdf->ezText("\n", 10);
            //$fec_nac=date("d/m/Y",strtotime($datos_bec['fec_nacim']));
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
            
            //------------------------3
            $pdf->ezNewPage(); 
            $pdf->ezText(utf8_d_seguro(' <b>3. DATOS DEL DIRECTOR DE BECA </b>'), 12,$centrado);
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
                $tabla_director[11]=array('dato'=>utf8_d_seguro('MAX TITULACIÓN ALCANZADA: '.$datos_dir['titulo']));
                $tabla_director[12]=array('dato'=>utf8_d_seguro('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'));
                $pdf->ezTable($tabla_director,array('dato'=>''),'<b>DATOS DEL DIRECTOR DE BECA: </b>',array('showHeadings'=>0,'shaded'=>0,'fontSize'=>10));
                
            }
              if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//solo graduados pide codirector
                if(isset($inscripcion['id_codirector'])){
                    $tabla_codirector[0]=array('dato'=>'APELLIDO Y NOMBRES: '.$datos_codir['nombre']);
                    $tabla_codirector[1]=array('dato'=>'DOMICILIO: '.$datos_codir['domi']);
                    $tabla_codirector[2]=array('dato'=>'E-MAIL: '.$datos_codir['correo']);
                    $tabla_codirector[3]=array('dato'=>'CUIL: '.$datos_codir['cuil']);
                    $tabla_codirector[4]=array('dato'=>utf8_d_seguro('CATEGORÍA DOCENTE: '.$datos_codir['cat_estat']));
                    $tabla_codirector[5]=array('dato'=>utf8_d_seguro('DEDICACIÓN: '.$datos_codir['dedicacion']));
                    $tabla_codirector[6]=array('dato'=>'REGULAR O INTERINO: '.$datos_codir['carac']);
                    $tabla_codirector[7]=array('dato'=>utf8_d_seguro('CATEGORÍA INVESTIGADOR: '.$datos_codir['cat_conicet']));
                    $tabla_codirector[8]=array('dato'=>utf8_d_seguro('INSTITUCIÓN: '.$datos_codir['institucion']));
                    $tabla_codirector[9]=array('dato'=>'LUGAR DE TRABAJO: '.$datos_codir['lugar_trabajo']);
                    $tabla_codirector[10]=array('dato'=>utf8_d_seguro('CATEGORÍA EQUIVALENTE DE INVESTIGACIÓN: '.$datos_codir['cat_inv']));
                    $tabla_codirector[11]=array('dato'=>utf8_d_seguro('MAX TITULACIÓN ALCANZADA: '.$datos_codir['titulo']));
                    $tabla_codirector[12]=array('dato'=>utf8_d_seguro('CANTIDAD DE POSTULANTES (en cualquier categoría) QUE PRESENTA EN ESTA CONVOCATORIA:'));
                    $pdf->ezTable($tabla_codirector,array('dato'=>''),'<b>DATOS DEL CODIRECTOR DE BECA:</b> ',array('showHeadings'=>0,'shaded'=>0));
                  }
            }
         //-------------------------4
            $pdf->ezText("\n", 10);
            $pdf->ezText(utf8_d_seguro(' <b>4. DATOS DEL PROYECTO DE INVESTIGACIÓN AL QUE SE INCORPORA (APROBADO O EN EVALUACIÓN) </b>'), 12,$centrado);
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
            $pdf->ezText(' <b>5. DATOS DEL PLAN DE TRABAJO DEL BECARIO</b>', 12,$centrado);
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
            $pdf->ezText(' <b>6. FUNDAMENTOS DE LA SOLICITUD</b>', 12,$centrado);
            $pdf->ezText("\n", 8);
            $pdf->ezText(utf8_d_seguro(' El solicitante expresará en esta hoja los motivos de su solicitud de una beca y de su elección de los temas propuestos.'), 10);
            $pdf->ezText("\n", 8);
            unset($datos);//limpio la variable
            if(isset($inscripcion['fundamentos_solicitud'])){
                $datos[0]=array('dato'=>utf8_d_seguro($inscripcion['fundamentos_solicitud']));
                $pdf->ezTable($datos,array('dato'=>''),' ',array('showHeadings'=>0,'shaded'=>0,'width'=>500));
                $pdf->ezText("\n", 8);
            }
//            //---------------------------7
//            //PIDEN ELIMINAR LAS HOJAS PARA REFERENCISTAS
////            $i=0;
////            while ($i<=$copias_ref) {
////                $pdf->ezNewPage(); 
////                $pdf->ezText(' <b>7. REFERENCISTAS</b>', 10,$centrado);
////                $pdf->ezText("\n", 8);
////                $pdf->ezText(utf8_d_seguro(' SR. REFERENCISTA: Rogamos completar el cuestionario adjunto. Agradecemos desde ya en nombre del Consejo su aprecida colaboración y le garantizamos absoluta reserva.'),10);
////                $pdf->ezText(utf8_d_seguro( 'EL PRESENTE FORMULARIO DEBE SER ENTREGADO EN SOBRE CERRADO, EN LA SUBSECRETARÍA DE INVESTIGACIÓN DE CADA UNIDAD ACADÉMICA, A LOS EFECTOS DE SER ANEXADO A LA CARPETA DE PRESENTACIÓN.'), 10);
////                $pdf->ezText("\n", 8);
////                $pdf->ezText(utf8_d_seguro( '1. Apellido y Nombres del concursante: .......................................................................'), 10);
////                $pdf->ezText("\n", 8);
////                $pdf->ezText(utf8_d_seguro( '2. Apellido y Nombres del referencista: ......................................................................'), 10);
////                $pdf->ezText("\n", 8);
////                $pdf->ezText(utf8_d_seguro( '3. CONOCIMIENTO DEL POSTULANTE'), 10);
////                $pdf->ezText(utf8_d_seguro( '3.1 ¿Cuánto tiempo hace que lo conoce?'), 10);
////                $pdf->ezText(utf8_d_seguro( '3.2 Tipo de relación (especifique la duración en cada tipo de relación si corresponde )'), 10);
////                $pdf->ezText("\n", 7);
////                $tabla=array();              
////                $tabla[0]=array( 'col1'=>'Alumno: ','col2' => 'Becario: ');
////                $tabla[1]=array( 'col1'=>'Ayudante: ','col2' => 'Integrante: ');
////                $tabla[2]=array( 'col1'=>' ','col2' => 'Colaborador: ');
////                $tabla[3]=array( 'col1'=>'Otro (especificar): ','col2' => '');
////                $pdf->ezTable($tabla,array('col1'=>'DOCENCIA','col2'=>'INVESTIGACION'),'',array('shaded'=>1,'width'=>500));
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4. SE SOLICITA OPINIÓN ACERCA DE LOS SIGUIENTES ASPECTOS (SI SON DE SU CONOCIMIENTO)'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4.1 Formación académica del postulante (carrera universitaria, seminarios).'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4.2 Antecedentes generales del postulante (ayudantías docentes y de investigación, conocimientos de idiomas, etc.)'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4.3 Trabajos realizados por el postulante (monografías, tesinas, tesis, publicaciones, presentaciones a congresos, etc.)'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4.4 Predisposición del postulante para desarrollar tareas vinculadas a la investigación científica.'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '4.5 Disciplina de trabajo y actitud frente a las indicaciones de sus directores, tutores, asesores, etc.'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '5. EVALUACIÓN FINAL DEL POSTULANTE'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText(utf8_d_seguro( '............................................................................................................................................................................'), 10);
////                $pdf->ezText("\n", 7);
////                $pdf->ezText("\n", 7);$pdf->ezText("\n", 7);
////                $tabla=array();              
////                $tabla[0]=array( 'col1'=>'','col2' => utf8_d_seguro('Unidad Académica a la que '));
////                $tabla[0]=array( 'col1'=>'','col2' => utf8_d_seguro(' pertenece: '));
////                $tabla[1]=array( 'col1'=>'............................................ ','col2' => '............................................');
////                $tabla[2]=array( 'col1'=>utf8_d_seguro('Firma y aclaración '),'col2' => '');
////                $pdf->ezTable($tabla,array( 'col1'=>'','col2' => ''),'',array('showLines'=>0,'shaded'=>0,'width'=>500));
////                $pdf->ezText("\n", 7);$pdf->ezText("\n", 7); 
////                if($inscripcion['categ_beca']==3){
////                    $pdf->ezText(utf8_d_seguro( 'Se certifica que el/la alumno/a....................................................................................'
////                        . 'DNI N° .................................. Legajo N° .................................'
////                        . ' se encuentra cursando la carrera .....................................................................'
////                        . ' con un total de  .....................................................materias aprobadas al día de la fecha.'
////                        . ' El Plan de Estudios consta de ........materias, incluyendo tesis/trabajo final si correspondiera (Ordenanzas N° .......................................)'), 10);
////                    $pdf->ezText("\n", 7);$pdf->ezText("\n", 7);
////                    $pdf->ezText(utf8_d_seguro( 'Lugar y fecha:'), 10);
////                    $pdf->ezText("\n", 7);
////                    $pdf->ezText(utf8_d_seguro( 'Firma del área académica correspondiente:'), 10);
////                }
////             $i++;   
////            }//-------fin referencista 
            foreach ($pdf->ezPages as $pageNum=>$id){ 
                   $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
                   $imagen = toba::proyecto()->get_path().'/www/img/logo_becarios.jpg';
                   $pdf->addJpegFromFile($imagen, 30, 750, 108, 69);
                   //$imagen2 = toba::proyecto()->get_path().'/www/img/sein.jpg';
                   //$pdf->addJpegFromFile($imagen2, 30, 760, 70, 60);
                   $pdf->closeObject(); 
                }   

        }else{//imprimir la ficha
          if($bandera=='imprimir2'){
            $salida->set_nombre_archivo("Ficha_Inscripcion.pdf");
            //recuperamos el objteo ezPDF para agregar la cabecera y el pie de página 
            $salida->set_papel_orientacion('portrait');//landscape
            $salida->inicializar();
            $pdf = $salida->get_pdf();
            $pdf->ezSetMargins(100, 50, 30, 30);//($top, $bottom, $left, $right)
            
            //Configuramos el pie de página. El mismo, tendra el número de página centrado en la página y la fecha ubicada a la derecha. 
            //Primero definimos la plantilla para el número de página.
            $formato = utf8_decode('Becarios-Mocovi '.date('d/m/Y h:i:s a').'     Página {PAGENUM} de {TOTALPAGENUM} ');
            $pdf->ezStartPageNumbers(400, 20, 8, 'left', $formato, 1); //utf8_d_seguro($formato)
            //Configuración de Título.
            $salida->titulo(utf8_d_seguro(''));   
            //$pdf->setLineStyle(1);
            //$pdf->setLineStyle(5);
            //$pdf->Line(1, 45, 210-20, 45);//ultimo le da la inclinacion
            //$pdf->Line(10, 45, 550, 45);//primero: eje x desde donde comienza/tercero es el largo de la linea/cuarto:ultimo le da la inclinacion
            //segundo le da orientacion sobre x
            $pdf->ezText(utf8_decode(' <b>Ficha de Inscripción </b>'), 10);
            $inscripcion=$this->dep('datos')->tabla('inscripcion_beca')->get();
            $texto=' La presente ficha deberá ser debidamente firmada y entregada en la Secretaría de Investigación de la Unidad Académica. ';
            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){//graduados
                $texto.=' correspondiente a la carrera por la que solicita la beca.';         
            }else{
                $texto.=' de pertenencia del proyecto en el que se inserta su plan de trabajo.';         
            }
           
            $pdf->ezText(utf8_decode($texto), 10);
            $pdf->ezText("\n", 7);
            $tabla_cod=array();
            $pdf->ezTable($tabla_cod,array('col1'=>utf8_d_seguro('<b>Código de proyecto:</b>'),'col2' => $datos_proy['codigo']),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));      
            $cols_dp = array('col1'=>"<b>Datos Personales</b>",'col2'=>'');
            $tabla_dp=array();
            $tabla_dp[0]=array( 'col1'=>'Postulante:','col2' => utf8_d_seguro($datos_bec['nombre']));
            $tabla_dp[1]=array( 'col1'=>'CUIL:','col2' => $datos_bec['cuil']);
            $tabla_dp[3]=array( 'col1'=>'e-mail:','col2' => $datos_bec['correo']);
            $tabla_dp[4]=array( 'col1'=>'Fecha de nacimiento:','col2' => $fec_nac);
            $tabla_dp[5]=array( 'col1'=>'Domicilio:','col2' => $datos_bec['domi']);
            $tabla_dp[6]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_bec['telefono']);
            $pdf->ezTable($tabla_dp,$cols_dp,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
            $tabla_dir=array(); 
            $tabla_dir[0]=array( 'col1'=>'Apellido y Nombre:','col2' => utf8_d_seguro($datos_dir['nombre']));
            $tabla_dir[1]=array( 'col1'=>'CUIL:','col2' => $datos_dir['cuil']);
            $tabla_dir[2]=array( 'col1'=>utf8_decode('e-mail:'),'col2' => $datos_dir['correo']);
            $tabla_dir[3]=array( 'col1'=>'Domicilio:','col2' => $datos_dir['domi']);
            $tabla_dir[4]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_dir['telefono']);
            $tabla_dir[5]=array( 'col1'=>utf8_decode('Máxima titulación alcanzada'),'col2' => $datos_dir['titulo']);
            $tabla_dir[6]=array( 'col1'=>'Cargo Docente:','col2' => $datos_dir['cat_estat']);
            $tabla_dir[7]=array( 'col1'=>utf8_decode('Dedicación en el cargo'),'col2' => $datos_dir['dedicacion']);
            $tabla_dir[8]=array( 'col1'=>utf8_decode('Categoría Equiv Investigador'),'col2' =>  $datos_dir['cat_inv']);
            $tabla_dir[9]=array( 'col1'=>utf8_decode('Categoría  Investigador'),'col2' => $datos_dir['cat_conicet']);
            $tabla_dir[10]=array( 'col1'=>'Lugar de trabajo:','col2' => $datos_dir['lugar_trabajo']);
            $tabla_dir[11]=array( 'col1'=>utf8_decode('Hs de dedicación total de investigación:'),'col2' => $datos_dir['hs_dedic_inves']);
            $cols_dir = array('col1'=>"<b>Datos del Director</b>",'col2'=>'');
            $pdf->ezTable($tabla_dir,$cols_dir,'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
            if($inscripcion['categ_beca']==1 or $inscripcion['categ_beca']==2){
                //codirector
               if(isset($inscripcion['id_codirector'])){
                    $tabla_codir=array(); 
                    $tabla_codir[0]=array( 'col1'=>'Apellido y Nombre:','col2' => $datos_codir['nombre']);
                    $tabla_codir[1]=array( 'col1'=>'CUIL:','col2' => $datos_codir['cuil']);
                    $tabla_codir[2]=array( 'col1'=>utf8_decode('e-mail:'),'col2' => $datos_codir['correo']);
                    $tabla_codir[3]=array( 'col1'=>'Domicilio:','col2' => $datos_codir['domi']);
                    $tabla_codir[4]=array( 'col1'=>utf8_decode('Teléfono:'),'col2' => $datos_codir['telefono']);
                    $tabla_codir[5]=array( 'col1'=>utf8_decode('Máxima titulación alcanzada'),'col2' => $datos_codir['titulo']);
                    $tabla_codir[6]=array( 'col1'=>'Cargo Docente:','col2' => $datos_codir['cat_estat']);
                    $tabla_codir[7]=array( 'col1'=>utf8_decode('Dedicación en el cargo'),'col2' => $datos_codir['dedicacion']);
                    $tabla_codir[8]=array( 'col1'=>utf8_decode('Categoría Investigador'),'col2' => $datos_codir['cat_conicet']);
                    $tabla_codir[9]=array( 'col1'=>'Lugar de trabajo:','col2' => $datos_codir['lugar_trabajo']);
                    $tabla_codir[10]=array( 'col1'=>utf8_decode('Hs de dedicación total de investigación:'),'col2' => $datos_codir['hs_dedic_inves']);
                    $pdf->ezTable($tabla_dir,array('col1'=>"<b>Datos del Co-director</b>",'col2'=>''),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right','width'=>200),'col2'=>array('width'=>350)) ));
               }
            }
            
            //-----------
            $tabla_texto=array();
            $tabla_texto[0]=array('dato'=>utf8_d_seguro('Declaro conocer las Bases y el Reglamento de la Convocatoria 2019 del Porgrama de Becas de Estimulo a las Vocaciones Cientificas del CIN y aceptar cada una de las obligaciones que de ellos derivan, comprometiendome a su cumplimiento en caso de que me fuera otorgada la Beca solicitada.'));
            $pdf->ezTable($tabla_texto,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
            $tabla_firma=array();
            $tabla_firma[0]=array('col1'=>'','col2'=>'');
            $tabla_firma[1]=array('col1'=>'','col2'=>'');
            $tabla_firma[2]=array('col1'=>'Firma Postulante','col2'=>'Lugar y fecha');
            $pdf->ezTable($tabla_firma,array('col1'=>'','col2'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center'),'col2'=>array('justification'=>'center'))));
            $tabla_texto2=array();
            $tabla_texto2[0]=array('col1'=>utf8_d_seguro('Por la presente presto mi conformidad para que, en caso de ser otorgada la beca solicitada, el postulante pueda realizar el trabajo propuesto en el marco del proyecto de investigación acreditado y financiado que dirijo.'),'col2'=>utf8_d_seguro('Declaro conocer y aceptar Reglamento de la Convocatoria 2019 del Programa de Becas de Estímulo a las Vocaciones Científicas del CIN en las obligaciones que de él derivan para los directores y dejo constancia que avalo el Plan de Trabajo del postulante./n En caso de ser otorgada la beca, me hago responsable de proporcionar al becario de las orientaciones para que lleve a cabo el plan propuesto faciltando las condiciones académicas necesarias para ello, como así también de contribuir a que mantenga su desempeño académico como estudiante.'));
            $pdf->ezTable($tabla_texto2,array('col1'=>'','col2'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'left','width'=>150),'col2'=>array('justification'=>'left','width'=>400))));
            $tabla_firma2=array();
            $tabla_firma2[0]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma2[1]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma2[2]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma2[3]=array('col1'=>utf8_d_seguro('Firma Director de proyecto de investigación'),'col2'=>'Firma Director de Beca','col3'=>'Firma Co-Director de Beca');
            $pdf->ezTable($tabla_firma2,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150),'col2'=>array('justification'=>'center','width'=>200),'col3'=>array('justification'=>'center','width'=>200))));
            $tabla_firma3=array();
            $tabla_firma3[0]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma3[1]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma3[2]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma3[3]=array('col1'=>'Lugar de fecha','col2'=>'Lugar y fecha','col3'=>'Lugar y fecha');
            $pdf->ezTable($tabla_firma3,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150),'col2'=>array('justification'=>'center','width'=>200),'col3'=>array('justification'=>'center','width'=>200))));
            //lugar de la beca
            $tabla_lugar=array();
            $tabla_lugar[0]=array( 'col1'=>utf8_d_seguro('Laboratorio/Área/Centro/Instituto:'),'col2' => $datos_insc['ua_trabajo_beca']);
            $tabla_lugar[1]=array( 'col1'=>utf8_d_seguro('Departamento Académico:'),'col2' => $datos_insc['dpto_trabajo_beca']);
            $tabla_lugar[3]=array( 'col1'=>'Domicilio:','col2' => $datos_insc['domi_lt']);
            $pdf->ezTable($tabla_lugar,array('col1'=>utf8_d_seguro('<b>Lugar de trabajo en donde desarrollará la beca</b>'),'col2'=>''),'',array('shaded'=>0,'showLines'=>1,'width'=>550,'cols'=>array('col1'=>array('justification'=>'right')) ));
            //
            $tabla_conf=array();
            $tabla_conf[0]=array('dato'=>utf8_d_seguro('<b>Conformidad de la Secretaría de Investigación donde se postula</b>'));
            $pdf->ezTable($tabla_conf,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
            $tabla_conf=array();
            $tabla_conf[0]=array('dato'=>utf8_d_seguro('Por la presente presto mi conformidad para que, en caso de ser otorgada la beca solicitada, el postulante puede realizar el trabajo propuesto en el lugar indicativo precedentemente.'));
            $pdf->ezTable($tabla_conf,array('dato'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550));
            $tabla_firma4=array();
            $tabla_firma4[0]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma4[1]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma4[2]=array('col1'=>'','col2'=>'','col3'=>'');
            $tabla_firma4[3]=array('col1'=>'Firma','col2'=>'Lugar y fecha','col3'=>utf8_d_seguro('Cargo e Institución'));
            $pdf->ezTable($tabla_firma4,array('col1'=>'','col2'=>'','col3'=>''),'',array('showHeadings'=>0,'shaded'=>0,'width'=>550,'cols'=>array('col1'=>array('justification'=>'center','width'=>150,'fontSize' => 8),'col2'=>array('justification'=>'center','width'=>200,'fontSize' => 8),'col3'=>array('justification'=>'center','width'=>200,'fontSize' => 8))));

            
            foreach ($pdf->ezPages as $pageNum=>$id){ 
                   $pdf->reopenObject($id); //definimos el path a la imagen de logo de la organizacion 
                   //$imagen = toba::proyecto()->get_path().'/www/img/sein.jpg';
                   //$pdf->addJpegFromFile($imagen, 30, 750, 70, 60);
                   $imagen = toba::proyecto()->get_path().'/www/img/logo_becarios.jpg';
                   $pdf->addJpegFromFile($imagen, 30, 750, 108, 69);
                   $pdf->addText(30,750,13,'<b>                                   CONVOCATORIA BECAS INVESTIGACION - 2019</b>');
                   $pdf->closeObject(); 
                }     
            }//if bandera=imprimir2
        
            }//else
        }//fin vista_pdf
        function vista_impresion( toba_impresion $salida )
	{
		$salida->titulo('Datos de Inscripcion a Beca ');
                $this->dependencia('form')->vista_impresion($salida);
                $salida->mensaje('DATOS PERSONALES:');
		$this->dependencia('ci_antecedentes')->dependencia('form_dp')->vista_impresion($salida);
                $salida->mensaje('DATOS DE LA CARRERA DE GRADO/PREGRADO POR LA QUE SE SOLICITA LA BECA:');
                $this->dependencia('ci_antecedentes')->dependencia('form_car')->vista_impresion($salida);
                $salida->mensaje('OTROS ESTUDIOS UNIVERSITARIOS:');
                $this->dependencia('ci_antecedentes')->dependencia('form_est')->vista_impresion($salida);
                $salida->mensaje('BECAS OBTENIDAS:');
                $this->dependencia('ci_antecedentes')->dependencia('form_beca')->vista_impresion($salida);
                $salida->mensaje('DISTINCIONES Y PREMIOS');
                //aqui las tablas ya tienen titulo
                $this->dependencia('ci_antecedentes')->dependencia('form_dis')->vista_impresion($salida);
                $this->dependencia('ci_antecedentes')->dependencia('form_emp')->vista_impresion($salida);
                $this->dependencia('ci_antecedentes')->dependencia('form_empa')->vista_impresion($salida);
                $this->dependencia('ci_antecedentes')->dependencia('form_pi')->vista_impresion($salida);
                $this->dependencia('ci_antecedentes')->dependencia('form_pe')->vista_impresion($salida);
                $salida->mensaje('TRABAJOS REALIZADOS:');
                $this->dependencia('ci_antecedentes')->dependencia('form_trab')->vista_impresion($salida);
                $salida->mensaje('CONOCIMIENTO DE IDIOMAS:');
                $this->dependencia('ci_antecedentes')->dependencia('form_idio')->vista_impresion($salida);
                $salida->mensaje('¿TIENE BECA EN CURSO?');
                $this->dependencia('ci_antecedentes')->dependencia('form_bc')->vista_impresion($salida);
                $salida->mensaje('PERSONAS A QUIENES EL POSTULANTE SOLICITO REFERENCIAS');
                $this->dependencia('ci_antecedentes')->dependencia('cuadro_ref')->vista_impresion($salida);
                $salida->mensaje('LUGAR DE TRABAJO EN EL QUE DESARROLLARA LA BECA');
                $this->dependencia('ci_antecedentes')->dependencia('form_lt')->vista_impresion($salida);
                $this->dependencia('form_dir')->vista_impresion($salida);
                $salida->mensaje('DATOS DEL PROYECTO DE INVESTIGACIÓN AL QUE SE INCORPORA ');
                $this->dependencia('form_pinv')->vista_impresion($salida);
                $salida->mensaje('DATOS DEL PLAN DE TRABAJO');
                $this->dependencia('form_pt')->vista_impresion($salida);
                $salida->mensaje('FUNDAMENTOS DE LA SOLICITUD');
                $this->dependencia('form_fund')->vista_impresion($salida);
		$salida->salto_pagina();
		
	}
}
?>