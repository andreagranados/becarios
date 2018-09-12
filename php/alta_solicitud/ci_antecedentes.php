<?php
class ci_antecedentes extends toba_ci
{
    protected $s__tipo_beca;
    protected $s__mostrar_sig=0;
    protected $s__mostrar_ant=0;
    protected $s__pantalla;

        function get_opciones($id_categ){
            $salida=array();
            if($id_categ==1 or $id_categ==2){
                $salida= array(
                    array('id' => 1, 'descripcion' => 'Universidad Nacional del Comahue'),  // $gente[0]
                    array('id' => 2, 'descripcion' => 'Otro') // $gente[1]
                 );
               }else{//estudiante siempre es Universidad Nacional del Comahue
                   $salida= array(
                    array('id' => 1, 'descripcion' => 'Universidad Nacional del Comahue')  // $gente[0]
                 );
               }
            return $salida;   
        }
        function get_mostrar_sig(){
          return $this->s__mostrar_sig;
        }
        function get_mostrar_ant(){
          return $this->s__mostrar_ant;
        }
	//-----------------------------------------------------------------------------------
	//---- formulario para datos personales del becario ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_dp(toba_ei_formulario $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario')->get();
            $usuario=toba::usuario()->get_id();
            //$datos['cuil']=$datos['cuil1'].str_pad($datos['cuil'], 8, '0', STR_PAD_LEFT).$datos['cuil2'];
            $datos['cuil']=$usuario;//campo cuil se autocompleta con el usuario y no puede ser modificado
            $datosd=$this->controlador()->dep('datos')->tabla('domicilio')->get();
            if(isset($datos)){
                 $form->set_datos($datos);
                 $form->set_datos($datosd);
            }
	}
        //evento implicito que se ejecuta cuando presiona siguiente
        function evt__form_dp__guardar($datos)
        {
         //presiono el boton siguiente
            $band=true;
            $primera=true;
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'I'){
                    $band=false;
                }
                if(isset($insc['id_becario'])){//sino tiene id_becario seteado
                //if(isset($insc['id_carrera'])){//si ya tiene valor entonces esta asociada a la inscripcion
                    $primera=false;
                }
            }else{//sino esta cargada la inscripcion significa que es la primera entonces pongo la fecha actual
                 $datos_inscripcion['fecha_presentacion']=date("Y-m-d");   
                 $datos_inscripcion['estado']='I';
            }
            if($band){
                $this->s__tipo_beca=$this->controlador()->get_categ_beca();
                $datos_inscripcion['categ_beca']=$this->s__tipo_beca['categ_beca'];
                
                //datos del domicilio
                $datosd['cod_pais']=$datos['cod_pais'];
                $datosd['cod_provincia']=$datos['cod_provincia'];
                $datosd['cod_postal']=$datos['cod_postal'];
                $datosd['numero']=$datos['numero'];
                $datosd['calle']=$datos['calle'];
                $this->controlador()->dep('datos')->tabla('domicilio')->set($datosd);
                $this->controlador()->dep('datos')->tabla('domicilio')->sincronizar();
                $domi=$this->controlador()->dep('datos')->tabla('domicilio')->get();
                $datosb['nro_domicilio']=$domi['nro_domicilio'];
                //datos del becario
                $datosb['apellido']=$datos['apellido'];
                $datosb['nombre']=$datos['nombre'];
                $datosb['cuil1']=substr($datos['cuil'], 0, 2);
                $datosb['cuil']=substr($datos['cuil'], 2, 8);
                $datosb['cuil2']=substr($datos['cuil'], 10, 1);
                $datosb['nacionalidad']=$datos['nacionalidad'];
//                $datosb['tipo_docum']=$datos['tipo_docum'];            
//                $datosb['nro_docum']=$datos['nro_docum'];            
                $datosb['fec_nacim']=$datos['fec_nacim'];            
                $datosb['correo']=$datos['correo'];            
                $datosb['telefono']=$datos['telefono'];            
                $this->controlador()->dep('datos')->tabla('becario')->set($datosb); 
                $this->controlador()->dep('datos')->tabla('becario')->sincronizar();    
                $bec=$this->controlador()->dep('datos')->tabla('becario')->get();
                $datosi['id_becario']=$bec['id_becario'];
                //datos de inscripcion beca
                if($primera){
                    $bec=$this->controlador()->dep('datos')->tabla('becario')->get();
                    $datos_inscripcion['id_becario']=$bec['id_becario'];     
                }
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos_inscripcion);
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();
            }
            
        }
        
        //-----------------------------------------------------------------------------------
	//---- formulario para datos de la carrera ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_car(toba_ei_formulario $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('carrera_inscripcion_beca')->get();
            if(isset($datos)){
                $datos['car']=$datos['carrera'];
            }
            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            $datos['categ']=$insc['categ_beca']; 
        
            if(isset($datos)){
                $form->set_datos($datos);
            }
	}
        function evt__form_car__guardar($datos)
        {
            $band=true;
            $primera=true;
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'I'){
                    $band=false;
                }
                if(isset($insc['id_carrera'])){//si ya tiene valor entonces esta asociada a la inscripcion
                    $primera=false;
                }
            }
            if($band){
                if($datos['categ']==1 or $datos['categ']==2 ){//graduados
                    if($datos['inst']==1){//selecciono UNCOMA
                        $datos['institucion']='Universidad Nacional del Comahue';
                        $datos['carrera']=$datos['car'];
                    }
                }else{//estudiantes
                    $datos['institucion']='Universidad Nacional del Comahue';
                    $datos['carrera']=$datos['car'];
                }
                $this->controlador()->dep('datos')->tabla('carrera_inscripcion_beca')->set($datos);
                $this->controlador()->dep('datos')->tabla('carrera_inscripcion_beca')->sincronizar();
                if($primera){
                    $car=$this->controlador()->dep('datos')->tabla('carrera_inscripcion_beca')->get();
                    $datos['id_carrera']=$car['id'];
                    $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos);
                    $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();    
                } 
            }
        }
         //-----------------------------------------------------------------------------------
	//---- formulario estudios realizados ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_est(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario_estudio')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_est__guardar($datos)
        { 
            //recupero clave de la inscripcion para asociarle los estudios
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('becario_estudio')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_estudio')->sincronizar();
            } 
        }
         //-----------------------------------------------------------------------------------
	//---- formulario becas obtenidas ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_beca(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario_beca')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_beca__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('becario_beca')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_beca')->sincronizar();
          }   
        }
         //-----------------------------------------------------------------------------------
	//---- formulario distinciones y premios ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_dis(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario_distincion')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_dis__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('becario_distincion')->procesar_filas($datos);  
                $this->controlador()->dep('datos')->tabla('becario_distincion')->sincronizar();
          }
        }
         //-----------------------------------------------------------------------------------
	//---- formulario empleos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_emp(toba_ei_formulario_ml $form)
	{
            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            $datos=$this->controlador()->dep('datos')->tabla('becario_empleo')->get_empleos(true,$insc['id_becario'],$insc['fecha_presentacion']);
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_emp__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                    $datos[$clave]['actual']=true;
                }
                $this->controlador()->dep('datos')->tabla('becario_empleo')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_empleo')->sincronizar();
          }
        }
        //empleos anteriores
        function conf__form_empa(toba_ei_formulario_ml $form)
	{
            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            $datos=$this->controlador()->dep('datos')->tabla('becario_empleo')->get_empleos(false,$insc['id_becario'],$insc['fecha_presentacion']);
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_empa__guardar($datos)
        { 
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                    $datos[$clave]['actual']=false;
                }
                $this->controlador()->dep('datos')->tabla('becario_empleo')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_empleo')->sincronizar();
          }
        }
         //-----------------------------------------------------------------------------------
	//---- formulario proyectos de investigacion  ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_pi(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('participacion_inv')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_pi__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('participacion_inv')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('participacion_inv')->sincronizar();
            }
        }
         //-----------------------------------------------------------------------------------
	//---- formulario proyectos de extension  ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_pe(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('participacion_ext')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_pe__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('participacion_ext')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('participacion_ext')->sincronizar();
            }
        }
        //-----------------------------------------------------------------------------------
        //---- formulario trabajos realizados ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_trab(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario_trabajo')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_trab__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                }
                $this->controlador()->dep('datos')->tabla('becario_trabajo')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_trabajo')->sincronizar();
            }
        }
         //-----------------------------------------------------------------------------------
        //---- formulario idiomas ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_idio(toba_ei_formulario_ml $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('becario_idioma')->get_filas();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_idio__guardar($datos)
        {
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($inscripcion['estado']=='I'){
                foreach ($datos as $clave => $elem) {
                    $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
                    $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
                   }
                $this->controlador()->dep('datos')->tabla('becario_idioma')->procesar_filas($datos);
                $this->controlador()->dep('datos')->tabla('becario_idioma')->sincronizar();
            }
         }
         //-----------------------------------------------------------------------------------
        //---- CUADRO referencias ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
//        function conf__cuadro_ref(toba_ei_cuadro $cuadro)
//	{
//            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
//                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
//                $datos=$this->controlador()->dep('datos')->tabla('becario_referencia')->get_listado($insc['id_becario'],$insc['fecha_presentacion']);
//                $cuadro->set_datos($datos);
//            }
//	}
//        function evt__cuadro_ref__seleccion($datos)
//	{//carga el referencista y su domicilio
//          $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
//          if($insc['estado']<>'I'){
//              toba::notificacion()->agregar('La inscripcion ya ha sido enviada', "info");
//          }else{
//            if($insc['categ_beca']==3){//estudiante entonces muestra formulario para docente
//                $this->s__mostrar_e=1;  
//            }else{
//                $this->s__mostrar=1;
//            }
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->cargar($datos);  
//            $br=$this->controlador()->dep('datos')->tabla('becario_referencia')->get();  
//            if(isset($br['id_domicilio'])){
//                $datosd['nro_domicilio']=$br['id_domicilio'];
//                $this->controlador()->dep('datos')->tabla('domicilio_ref')->cargar($datosd);  
//            }
//          }
//	}
        //---formulario para referencias que son docentes
//        function conf__form_refer_e(toba_ei_formulario $form)
//        {
//            if($this->s__mostrar_e==1){
//                $this->dep('form_refer_e')->descolapsar();
//            }else{
//                $this->dep('form_refer_e')->colapsar();
//            }
//            if ($this->controlador()->dep('datos')->tabla('becario_referencia')->esta_cargada()) {
//                $datos=$this->controlador()->dep('datos')->tabla('becario_referencia')->get();
//                if(isset($datos['id_designacion'])){
//                    $doc=$this->controlador()->dep('datos')->tabla('director_beca')->get_docente($datos['id_designacion']);
//                    $datos['id_docente']=$doc;
//                }
//                if ($this->controlador()->dep('datos')->tabla('domicilio_ref')->esta_cargada()) {
//                    $datosd=$this->controlador()->dep('datos')->tabla('domicilio_ref')->get();
//                    $datos['cod_pais']=$datosd['cod_pais'];
//                    $datos['cod_provincia']=$datosd['cod_provincia'];
//                    $datos['cod_postal']=$datosd['cod_postal'];
//                    $datos['calle']=$datosd['calle'];
//                    $datos['numero']=$datosd['numero'];
//                    $datos['telefono']=$datosd['telefono'];
//                }
//                $form->set_datos($datos);
//            }
//        }
//        function evt__form_refer_e__alta($datos)//da de alta un referenciasta docente
//        {
//            $ap=$this->controlador()->dep('datos')->tabla('director_beca')->get_apellido($datos['id_docente']);
//            $nom=$this->controlador()->dep('datos')->tabla('director_beca')->get_nombre($datos['id_docente']);
//            $cargo=$this->controlador()->dep('datos')->tabla('director_beca')->get_cargo($datos['id_designacion']);
//            $unia=$this->controlador()->dep('datos')->tabla('director_beca')->get_ua($datos['id_designacion']);
//            $datos['apellido']=$ap;
//            $datos['nombre']=$nom;
//            $datos['cargo']=$cargo;
//            $datos['uni_acad']=$unia;
//              //datos del domicilio del referencista
//            $datosd['cod_pais']=$datos['cod_pais'];
//            $datosd['cod_provincia']=$datos['cod_provincia'];
//            $datosd['cod_postal']=$datos['cod_postal'];
//            $datosd['calle']=$datos['calle'];
//            $datosd['numero']=$datos['numero'];
//            $datosd['telefono']=$datos['telefono'];
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->set($datosd);
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->sincronizar();
//            $domi=$this->controlador()->dep('datos')->tabla('domicilio_ref')->get();  
//            $datos['id_domicilio']=$domi['nro_domicilio'];
//            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
//            $datos['id_becario']=$insc['id_becario'];
//            $datos['fecha']=$insc['fecha_presentacion'];
//            //da de alta el referencista docente
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->set($datos);
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();  
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear();  
//            $this->s__mostrar_e=0;
//        }
//        function evt__form_refer_e__modificacion($datos)
//        {
//            $datosd['cod_pais']=$datos['cod_pais'];
//            $datosd['cod_provincia']=$datos['cod_provincia'];
//            $datosd['cod_postal']=$datos['cod_postal'];
//            $datosd['calle']=$datos['calle'];
//            $datosd['numero']=$datos['numero'];
//            $datosd['telefono']=$datos['telefono'];
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->set($datosd);
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear(); 
//            //referencista
//            $ap=$this->controlador()->dep('datos')->tabla('director_beca')->get_apellido($datos['id_docente']);
//            $nom=$this->controlador()->dep('datos')->tabla('director_beca')->get_nombre($datos['id_docente']);
//            $cargo=$this->controlador()->dep('datos')->tabla('director_beca')->get_cargo($datos['id_designacion']);
//            $ua=$this->controlador()->dep('datos')->tabla('director_beca')->get_ua($datos['id_designacion']);
//            $datos['apellido']=$ap;
//            $datos['nombre']=$nom;
//            $datos['cargo']=$cargo;
//            $datos['uni_acad']=$ua;
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->set($datos);
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
//            $this->s__mostrar_e=0;
//            toba::notificacion()->agregar('Los datos se han guardado correctamente', 'info');  
//        }
//        function evt__form_refer_e__cancelar($datos)
//        {
//            $this->s__mostrar_e=0;
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear();
//        }
//        function evt__form_refer_e__baja($datos)
//        {
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->eliminar_todo();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->eliminar_todo();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear();
//            $this->s__mostrar_e=0;
//        }
//        //--formulario para referencias que postulantes graduados
//        function conf__form_refer(toba_ei_formulario $form)
//	{
//            if($this->s__mostrar==1){
//                $this->dep('form_refer')->descolapsar();
//            }else{
//                $this->dep('form_refer')->colapsar();
//            }
//            if ($this->controlador()->dep('datos')->tabla('becario_referencia')->esta_cargada()) {
//                $datos=$this->controlador()->dep('datos')->tabla('becario_referencia')->get();
//                if ($this->controlador()->dep('datos')->tabla('domicilio_ref')->esta_cargada()) {
//                    $datosd=$this->controlador()->dep('datos')->tabla('domicilio_ref')->get();
//                    $datos['cod_pais']=$datosd['cod_pais'];
//                    $datos['cod_provincia']=$datosd['cod_provincia'];
//                    $datos['cod_postal']=$datosd['cod_postal'];
//                    $datos['calle']=$datosd['calle'];
//                    $datos['numero']=$datosd['numero'];
//                    $datos['telefono']=$datosd['telefono'];
//                }
//                $form->set_datos($datos);
//            }
//
//	}
//        function evt__form_refer__alta($datos)
//        {
//            //da de alta el domicilio
//            $datosd['cod_pais']=$datos['cod_pais'];
//            $datosd['cod_provincia']=$datos['cod_provincia'];
//            $datosd['cod_postal']=$datos['cod_postal'];
//            $datosd['calle']=$datos['calle'];
//            $datosd['numero']=$datos['numero'];
//            $datosd['telefono']=$datos['telefono'];
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->set($datosd);
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->sincronizar();
//            $domi=$this->controlador()->dep('datos')->tabla('domicilio_ref')->get();  
//            $datos['id_domicilio']=$domi['nro_domicilio'];
//            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
//            $datos['id_becario']=$insc['id_becario'];
//            $datos['fecha']=$insc['fecha_presentacion'];
//            //da de alta el becario
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->set($datos);
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();  
//            $this->s__mostrar=0;
//        }
//        function evt__form_refer__modificacion($datos)
//        {
//            $datosd['cod_pais']=$datos['cod_pais'];
//            $datosd['cod_provincia']=$datos['cod_provincia'];
//            $datosd['cod_postal']=$datos['cod_postal'];
//            $datosd['calle']=$datos['calle'];
//            $datosd['numero']=$datos['numero'];
//            $datosd['telefono']=$datos['telefono'];
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->set($datosd);
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear(); 
//            //referencista
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->set($datos);
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->sincronizar();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear(); 
//            $this->s__mostrar=0;
//            toba::notificacion()->agregar('Los datos se han guardado correctamente', 'info');  
//        }
//        function evt__form_refer__cancelar($datos)
//        {
//            $this->s__mostrar=0;
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear();
//        }
//        function evt__form_refer__baja($datos)
//        {
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->eliminar_todo();
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->eliminar_todo();
//            $this->controlador()->dep('datos')->tabla('domicilio_ref')->resetear();
//            $this->s__mostrar=0;
//        }
         //-----------------------------------------------------------------------------------
        //---- formulario referencias ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

//	function conf__form_ref(toba_ei_formulario_ml $form)
//	{
//            $datos=$this->controlador()->dep('datos')->tabla('becario_referencia')->get_filas();
//            if(isset($datos)){
//                 $form->set_datos($datos);
//            }
//	}
//        function evt__form_ref__guardar($datos)
//        {
//            print_r($datos);
//            $this->guardar_pant_inicial();//para asegurarnos de que exista id_becario, por si no guardo hasta este momento
//            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
//            foreach ($datos as $clave => $elem) {
//                $datos[$clave]['id_becario']=$inscripcion['id_becario']; 
//                $datos[$clave]['fecha']=$inscripcion['fecha_presentacion']; 
//            }
//            //domicilio del referencista
////            $datosd['cod_pais']=$datos['cod_paisr'];
////            $datosd['cod_provincia']=$datos['cod_provinciar'];
////            $datosd['cod_postal']=$datos['cod_postalr'];
////            $datosd['calle']=$datos['caller'];
////            $datosd['numero']=$datos['numeror'];
////            $datosd['telefono']=$datos['telefonor'];
////            $this->controlador()->dep('datos')->tabla('domicilio_ref')->set($datosd);
////            $this->controlador()->dep('datos')->tabla('domicilio_ref')->sincronizar();
////            $domi=$this->controlador()->dep('datos')->tabla('domicilio_ref')->get();
////            $datos['id_domicilio']=$domi['nro_domicilio'];
//            $this->controlador()->dep('datos')->tabla('becario_referencia')->procesar_filas($datos);
//        }
        //-----------------------------------------------------------------------------------
        //---- formulario lugar trabajo desarrollo beca ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_lt(toba_ei_formulario $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            $datosd=$this->controlador()->dep('datos')->tabla('domicilio_lt')->get();
            $datos['cod_pais']=$datosd['cod_pais'];
            $datos['cod_provincia']=$datosd['cod_provincia'];
            $datos['cod_postal']=$datosd['cod_postal'];
            $datos['calle']=$datosd['calle'];
            $datos['numero']=$datosd['numero'];
            $datos['telefono']=$datosd['telefono'];
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_lt__guardar($datos)
        {//se guarda en tabla inscripcion beca
            //tiene que setear el domicilio del lugar del trabajo
            $band=true;
            $primera=true;
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'I'){
                    $band=false;
                }
                if(isset($insc['nro_domicilio_trabajo_beca'])){//si ya tiene valor entonces esta asociada a la inscripcion
                    $primera=false;
                }
            }
            if($band){
                $datosd['cod_pais']=$datos['cod_pais'];
                $datosd['cod_provincia']=$datos['cod_provincia'];
                $datosd['cod_postal']=$datos['cod_postal'];
                $datosd['calle']=$datos['calle'];
                $datosd['numero']=$datos['numero'];
                $datosd['telefono']=$datos['telefono'];
                $this->controlador()->dep('datos')->tabla('domicilio_lt')->set($datosd);
                $this->controlador()->dep('datos')->tabla('domicilio_lt')->sincronizar();
                if($primera){
                    $domi=$this->controlador()->dep('datos')->tabla('domicilio_lt')->get();
                    $datos_lt['nro_domicilio_trabajo_beca']=$domi['nro_domicilio'];
                }
                $datos_lt['ua_trabajo_beca']=$datos['ua_trabajo_beca'];
                $datos_lt['dpto_trabajo_beca']=$datos['dpto_trabajo_beca'];
                $datos_lt['desc_trabajo_beca']=$datos['desc_trabajo_beca'];
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos_lt);  
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();//sincroniza aqui para guardar estos datos
            }
           
        }
         //-----------------------------------------------------------------------------------
        //---- formulario tiene beca en curso ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
        function conf__form_bc(toba_ei_formulario $form)
	{
            $datos=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if(isset($datos)){
                 $form->set_datos($datos);
            }
	}
        function evt__form_bc__guardar($datos)
        {//se guarda en tabla inscripcion beca
            $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
            if($insc['estado']=='I'){
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos);
                $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();
            }
        }
	

        function conf__pant_inicial(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=1;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_inicial';
        }
        //tuve que ponerlo porque en inicializar de la variable no funciona
        function conf__pant_car(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_car';
        }
        function conf__pant_est(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_est';
        }
        function conf__pant_becas(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_becas';
        }
        function conf__pant_disti(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_disti';
        }
        function conf__pant_emp(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_emp';
        }
        function conf__pant_trab(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_trab';
        }
        function conf__pant_idio(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_idio';
        }
        function conf__pant_bc(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_bc';
        }
        function conf__pant_ref(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_ant=0;
            $this->s__mostrar_sig=0;
            $this->s__pantalla='pant_ref';
        }
        function conf__pant_lt(toba_ei_pantalla $pantalla)
        {
            $this->s__mostrar_sig=1;
            $this->s__pantalla='pant_lt';
        }
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Eventos ---------------------------------------------
		
		{$this->objeto_js}.evt__guardar = function()
		{
		}
		";
	}
        //ver
        function evt__cambiar_tab__siguiente(){
             switch ($this->s__pantalla) {
               case 'pant_lt': break;
             }
           
        }
       	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
//sincroniza con la base de datos
	function evt__guardar()
	{
         $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
         if($insc['estado']=='I'){
           //sincroniza con la base de datos
              toba::notificacion()->agregar('Se ha guardado correctamente', "info");
         } else{
             toba::notificacion()->agregar('La inscripcion ya ha sido enviada, no puede ser modificada', "info");
         }
	}

        function evt__cambiar_tab__anterior(){
            $this->controlador()->dep('datos')->tabla('becario_referencia')->resetear();
           
        }
}
?>