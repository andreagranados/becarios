<?php
//class ci_formularios extends toba_ci
class ci_formularios extends ci_postulantes
{
    function conf()
    {
        if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
           $datos = $this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
           if($datos['estado']<>'D' and $datos['estado']<>'R' ){
               $this->pantalla()->tab("pant_informes")->desactivar();
           } 
        }else{
            $this->pantalla()->tab("pant_informes")->desactivar();
        }
    }
    function conf__formulario(toba_ei_formulario $form)
	{
            $form->evento('imprimir1')->vinculo()->agregar_parametro('evento_trigger', 'imprimir1');
            $form->evento('imprimir2')->vinculo()->agregar_parametro('evento_trigger', 'imprimir2'); 
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                    $datos=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                    //nuevo
                    $estado=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get_estado($datos);
                     if($estado=='I'){
                        $form->eliminar_evento('modificacion');
                        $form->eliminar_evento('cancelar');
                        $form->eliminar_evento('imprimir1');
                        $form->eliminar_evento('imprimir2');
                    }   
                    //
                    $anio=$this->controlador()->dep('datos')->tabla('convocatoria')->get_anio($datos['id_conv']);
                    if($datos['categ_beca']==3){//estudiantes desactivo 
                         $form->desactivar_efs(array('imagen_vista_previa_titu','imagen_vista_previa_cvc')); 
                    }
                    $agente=$this->controlador()->dep('datos')->tabla('becario')->get_datos_personales($datos['id_becario']);
                    $datos['agente']=$agente['nombre'];
                    if ($this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->esta_cargada()) {
                        //$user=getenv('DB_USER_SL');
                        //$password=getenv('DB_PASS_SL');
                        $adj=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->get();
                        $carpeta='becarios_'.$anio.'_'.$datos['id_conv'];
                        if(isset($adj['cert_ant'])){
                            $nomb_ca=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['cert_ant']);
                            //$nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                            //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                            $datos['imagen_vista_previa_ca'] = "<a target='_blank' href='{$nomb_ca}' >cert ant</a>";
                        }
                        if(isset($adj['const_titu'])){
                            $nomb_titu=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['const_titu']);
                            //$nomb_titu='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['const_titu'];
                            //$nomb_titu='/becarios/1.0/becarios_'.$anio.'/'.$adj['const_titu'];
                            $datos['imagen_vista_previa_titu'] = "<a target='_blank' href='{$nomb_titu}' >titulo</a>";
                        }
                        if(isset($adj['rend_acad'])){
                            $nomb_ra=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['rend_acad']);
                            //$nomb_ra='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['rend_acad'];
                            //$nomb_ra='/becarios/1.0/becarios_'.$anio.'/'.$adj['rend_acad'];
                            $datos['imagen_vista_previa_ra'] = "<a target='_blank' href='{$nomb_ra}' >rend acad</a>";
                        }
                        if(isset($adj['cv_post'])){
                            $nomb_cvp=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['cv_post']);
                            //$nomb_cvp='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_post'];
                            //$nomb_cvp='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_post'];
                            $datos['imagen_vista_previa_cvp'] = "<a target='_blank' href='{$nomb_cvp}' >cv postulante</a>";
                        }
                        if(isset($adj['cv_dir'])){
                            $nomb_cvdir=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['cv_dir']);
                            //$nomb_cvdir='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_dir'];
                            //$nomb_cvdir='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_dir'];
                            $datos['imagen_vista_previa_cvd'] = "<a target='_blank' href='{$nomb_cvdir}' >cv director</a>";
                        }
                        if(isset($adj['cv_codir'])){
                            $nomb_cdir=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['cv_codir']);
                            //$nomb_cdir='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cv_codir'];
                            //$nomb_cdir='/becarios/1.0/becarios_'.$anio.'/'.$adj['cv_codir'];
                            $datos['imagen_vista_previa_cvc'] = "<a target='_blank' href='{$nomb_cdir}' >cv codirector</a>";
                        }
                        if(isset($adj['cuil'])){
                            $nomb_cuil=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['cuil']);
                            //$nomb_cuil='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cuil'];
                            //$nomb_cuil='/becarios/1.0/becarios_'.$anio.'/'.$adj['cuil'];
                            $datos['imagen_vista_previa_cuil'] = "<a target='_blank' href='{$nomb_cuil}' >cuil</a>";
                        }
                        if(isset($adj['docum'])){
                            $nomb_doc=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['docum']);
                            //$nomb_doc='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['docum'];
                            //$nomb_doc='/becarios/1.0/becarios_'.$anio.'/'.$adj['docum'];
                            $datos['imagen_vista_previa_docum'] = "<a target='_blank' href='{$nomb_doc}' >documento</a>";
                        }
                        if(isset($adj['comprob'])){
                            $nomb_comp=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['comprob']);
                            //$nomb_comp='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['comprob'];
                            //$nomb_comp='/becarios/1.0/becarios_'.$anio.'/'.$adj['comprob'];
                            $datos['imagen_vista_previa_comp'] = "<a target='_blank' href='{$nomb_comp}' >comprobante</a>";
                        }
                        if(isset($adj['desarrollo_pt'])){
                            $nomb_des_pt=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['desarrollo_pt']);
                            //$nomb_des_pt='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['desarrollo_pt'];
                            //$nomb_des_pt='/becarios/1.0/becarios_'.$anio.'/'.$adj['desarrollo_pt'];
                            $datos['imagen_vista_previa_dp'] = "<a target='_blank' href='{$nomb_des_pt}' >desarrollo plan trabajo</a>";
                        }
                        if(isset($adj['informe_final'])){
                            $nomb_informe_final=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['informe_final']);
                            //$nomb_informe_final='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['informe_final'];
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
            $inscripcion=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
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
                            if($inscripcion['puntaje']<>$datos['puntaje']){
                                if($inscripcion['estado']=='A' and $datos['estado']=='A'){//solo si esta aceptado puede cambiar puntaje
                                    $datos2['puntaje']=$datos['puntaje'];
                                }else{
                                    $mensaje.=utf8_decode(' La inscripción debe estar Admitida (A) para poder ingresarle/modificarle el puntaje');
                                }
                            }
                            
                        }
                        if(isset($datos['fecha_renuncia'])){//se ha cargado fecha de renuncia
                            $datos2['fecha_renuncia']=$datos['fecha_renuncia'];
                        }
                        //print_r($datos2);exit;
                    }else{//usuario de la UA solo puede modificar durante el periodo indicado en la convocatoria
                    //solo estado y observaciones
                        //$band=$this->controlador()->dep('datos')->tabla('convocatoria')->puedo_modificar($anio+1);
                        $band=$this->controlador()->dep('datos')->tabla('convocatoria')->puedo_modificar($inscripcion['id_conv']);
                        if(!$band){
                            $mensaje=utf8_decode('No puede modificar porque ha pasado el período para hacer cambios');}
                        else{
                            if($datos['estado']=='D' or $datos['estado']=='O' or $datos['estado']=='R'){
                              $mensaje=utf8_decode('No puede pasar a estado Designado, nO Designado o Renuncia. Seleccione el estado que corresponda.');
                              $band=false;
                            }
                        }    
                         
                    }
                    if($band){
                        if(isset($datos['estado'])){//esta cambiando el estado
                            if($datos['estado']<>'R'){
                                $datos2['fecha_renuncia']=null;
                            }
                        }
                        $datos2['estado']=$datos['estado'];
                        $datos2['observaciones']=$datos['observaciones'];
                        if($datos['estado']=='I'){//si reabre la inscripcion se pierde la fecha de envio
                            $datos2['fecha_envio']=null;$mensaje='. Inscripcion reabierta, se ha perdido la fecha de envio.';
                            $usuario=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get_usuario($inscripcion['id_becario']);
                            $this->controlador()->dep('datos')->tabla('inscripcion_beca')->desbloquear($usuario);
                        }
                        $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos2);
                        $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();
                        toba::notificacion()->agregar('Los datos se han guardado correctamente'.$mensaje, 'info');   
                    }else{
                      toba::notificacion()->agregar($mensaje, 'info');   
                    }
                }
            }
        }
        
        function evt__formulario__cancelar($datos)
        {
            $this->controlador()->dep('datos')->tabla('inscripcion_beca')->resetear();
            $this->controlador()->dep('datos')->tabla('becario')->resetear();    
            $this->controlador()->set_pantalla('pant_inicial');
        }
       
        //-----form_informes
        function conf__form_informes(toba_ei_formulario $form)
        {
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $datos=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                $anio=$this->controlador()->dep('datos')->tabla('convocatoria')->get_anio($datos['id_conv']);
                $carpeta='becarios_'.$anio.'_'.$datos['id_conv'];
                if ($this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->esta_cargada()) {
                
                    //$user=getenv('DB_USER_SL');
                    //$password=getenv('DB_PASS_SL');
                    $adj=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->get();
                    
                    if(isset($adj['informe_avance'])){
                        $nomb_ca=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['informe_avance']);
                        //$nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                        //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                        $datos['imagen_vista_previa_ia'] = "<a target='_blank' href='{$nomb_ca}' >informe avance</a>";
                    }   
                    if(isset($adj['evaluacion_ia'])){
                        $nomb_ca=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['evaluacion_ia']);
                        //$nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                        //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                        $datos['imagen_vista_previa_eia'] = "<a target='_blank' href='{$nomb_ca}' >eval inf avance</a>";
                    }   
                    if(isset($adj['informe_fin'])){
                        $nomb_ca=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['informe_fin']);
                        //$nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                        //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                        $datos['imagen_vista_previa_if'] = "<a target='_blank' href='{$nomb_ca}' >inf final</a>";
                    }  
                    if(isset($adj['evaluacion_if'])){
                        $nomb_ca=$this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->link_al_archivo($datos['id_conv'],$adj['evaluacion_if']);
                        //$nomb_ca='http://'.$user.':'.$password.'@copia.uncoma.edu.ar/becarios/'.$carpeta.'/'.$adj['cert_ant'];
                        //$nomb_ca='/becarios/1.0/becarios_'.$anio.'/'.$adj['cert_ant'];
                        $datos['imagen_vista_previa_eif'] = "<a target='_blank' href='{$nomb_ca}' >eval inf final</a>";
                    }       
                }
                return $datos;
            }
      
        }
        //solo lo ve la UA, puede modificar Informe de Avance e Informe Final
        function evt__form_informes__modificacion_ua($datos)
        {
            $band=true;
            $bandia=false;
            $bandif=false;
            $mensaje="";
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                if($insc['estado']<>'D'){//solo en estado D puede modificar
                    $band=false;
                    $mensaje.="De estar en estado Designado para poder modificar. ";
                }else{
                    //verifico que la UA de la postulacion corresponda al usuario logueado
                    //obtengo el perfil de datos del usuario logueado
                    $con="select sigla,descripcion from unidad_acad ";
                    $con = toba::perfil_de_datos()->filtrar($con);
                    $resul=toba::db('designa')->consultar($con);
                    if($insc['uni_acad']<>$resul[0]['sigla']){
                        $band=false;
                        $mensaje.="La postulacion no corresponde a su UA. No puede modificar informes.";
                    }else{//corresponde a la misma UUA de la postulacion
                        if(isset($datos['informe_avance'])){
                            //si las fechas no estan seteadas devuelve falso
                            $bandia=$this->controlador()->dep('datos')->tabla('convocatoria')->puedo_modificar_inf_avan($insc['id_conv']);
                            if(!$bandia){
                                $mensaje.="NO SUBIO IA. Verifique el periodo de fechas para subir Informes de Avance.";
                              }
                        }
                        if(isset($datos['informe_fin'])){
                            $bandif=$this->controlador()->dep('datos')->tabla('convocatoria')->puedo_modificar_inf_fin($insc['id_conv']);
                             if(!$bandif){
                                $mensaje.="NO SUBIO IF. Verifique el periodo de fechas para subir Informes Finales";
                            }
                        }
                        $datos2['id_becario']=$insc['id_becario'];
                        $datos2['id_conv']=$insc['id_conv'];
                        $id=$insc['id_conv'];
                        $anio=$this->controlador()->dep('datos')->tabla('convocatoria')->get_anio($id);
                    }
                } 
            }else{
                $band=false;
            }
            //print_r($mensaje);exit;
            if($band){//band es true cuando tiene que cargar la primera vez o cuando puede modificar
                $guardar=true;
                $user=getenv('DB_USER');
                $host=getenv('DB_HOST');
                $port=getenv('DB_PORT');
                $password=getenv('DB_PASS');
                $ruta="/becarios/becarios_".$anio."_".$id;
                   
                //realizamos la conexion
                $conn_id=ftp_connect($host,$port);
                if($conn_id){
                    $cuil_becario=$this->controlador()->dep('datos')->tabla('becario')->get_cuil($insc['id_becario']);
                    
                    # Realizamos el login con nuestro usuario y contrasena
                    if(ftp_login($conn_id,$user,$password)){
                        ftp_pasv($conn_id, true);//activa modo pasivo. la conexion es iniciada por el cliente
                        # Cambiamos al directorio especificado
                        if(ftp_chdir($conn_id,$ruta)){
                            if(isset($datos['informe_fin']) && $bandif) {
                                $remote_file = $datos['informe_fin']['tmp_name'];
                                $nombre_ca="ifin".$cuil_becario.".pdf";//nombre con el que se guarda el archivo
                                # Subimos el fichero
                                if(ftp_put($conn_id,$nombre_ca,$remote_file, FTP_BINARY)){
                                        $datos2['informe_fin']=strval($nombre_ca);   
                                        echo "Fichero subido correctamente";
                                }else
                                        echo "No ha sido posible subir el fichero";  
                            }
                            if(isset($datos['informe_avance']) && $bandia) {
                                $remote_file = $datos['informe_avance']['tmp_name'];
                                $nombre_ca="iav".$cuil_becario.".pdf";//nombre con el que se guarda el archivo
                                # Subimos el fichero
                                if(ftp_put($conn_id,$nombre_ca,$remote_file, FTP_BINARY)){
                                        $datos2['informe_avance']=strval($nombre_ca);   
                                        echo "Fichero subido correctamente";
                                }else
                                        echo "No ha sido posible subir el fichero";  
                            }
                        }
                    } else{
                        $guardar=false;
                        echo "El usuario o la contraseÃ±a son incorrectos";
                    }
                    ftp_close($conn_id);
                }else{
                    $guardar=false;
                    echo "No ha sido posible conectar con el servidor";
                    }
                if($guardar){
                    $this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->set($datos2);
                    $this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->sincronizar();
                }
                toba::notificacion()->agregar(utf8_decode($mensaje), 'info');   
            }
        }
        function evt__form_informes__modificacion($datos)//solo para SCYT central. Modifica evaluaciones y observaciones
        {
            $band=true;
            if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                
                $datos2['id_becario']=$insc['id_becario'];
                $datos2['id_conv']=$insc['id_conv'];
                $id=$insc['id_conv'];
                $anio=$this->controlador()->dep('datos')->tabla('convocatoria')->get_anio($id);

                if(isset ($datos['observaciones_informes'])){
                    $datos3['observaciones_informes']=$datos['observaciones_informes'];
                    $this->controlador()->dep('datos')->tabla('inscripcion_beca')->set($datos3);
                    $this->controlador()->dep('datos')->tabla('inscripcion_beca')->sincronizar();
                }    
            }else{
                $band=false;
            }
            
            if($band){//band es true cuando tiene que cargar la primera vez o cuando puede modificar
                $guardar=true;
                $user=getenv('DB_USER');
                $host=getenv('DB_HOST');
                $port=getenv('DB_PORT');
                $password=getenv('DB_PASS');
                $ruta="/becarios/becarios_".$anio."_".$id;
                   
                //realizamos la conexion
                $conn_id=ftp_connect($host,$port);
                if($conn_id){
                    $cuil_becario=$this->controlador()->dep('datos')->tabla('becario')->get_cuil($insc['id_becario']);
                    
                    # Realizamos el login con nuestro usuario y contrasena
                    if(ftp_login($conn_id,$user,$password)){
                        ftp_pasv($conn_id, true);//activa modo pasivo. la conexion es iniciada por el cliente
                        # Cambiamos al directorio especificado
                        if(ftp_chdir($conn_id,$ruta)){
                            if(isset($datos['evaluacion_ia'])) {
                                $remote_file = $datos['evaluacion_ia']['tmp_name'];
                                $nombre_ca="eval_ia".$cuil_becario.".pdf";//nombre con el que se guarda el archivo
                                # Subimos el fichero
                                if(ftp_put($conn_id,$nombre_ca,$remote_file, FTP_BINARY)){
                                        $datos2['evaluacion_ia']=strval($nombre_ca);   
                                        echo "Fichero subido correctamente";
                                }else
                                        echo "No ha sido posible subir el fichero";  
                            }
                            if(isset($datos['evaluacion_if'])) {
                                $remote_file = $datos['evaluacion_if']['tmp_name'];
                                $nombre_ca="eval_if".$cuil_becario.".pdf";//nombre con el que se guarda el archivo
                                # Subimos el fichero
                                if(ftp_put($conn_id,$nombre_ca,$remote_file, FTP_BINARY)){
                                        $datos2['evaluacion_if']=strval($nombre_ca);   
                                        echo "Fichero subido correctamente";
                                }else
                                        echo "No ha sido posible subir el fichero";  
                            }
                        }
                    } else{
                        $guardar=false;
                        echo "El usuario o la contraseÃ±a son incorrectos";
                    }
                    ftp_close($conn_id);
                }else{
                    $guardar=false;
                    echo "No ha sido posible conectar con el servidor";
                    }
                if($guardar){
                    $this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->set($datos2);
                    $this->controlador()->dep('datos')->tabla('inscripcion_adjuntos')->sincronizar();
                } 
            }
                
        }
        //-----------------------------------------------------------------------------------
	//---- form_encabezado --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__form_encabezado(toba_ei_formulario $form)
	{
             if ($this->controlador()->dep('datos')->tabla('inscripcion_beca')->esta_cargada()) {
                $insc=$this->controlador()->dep('datos')->tabla('inscripcion_beca')->get();
                $agente=$this->controlador()->dep('datos')->tabla('becario')->get_nombre($insc['id_becario']);
                $a=array('id_conv'=>$insc['id_conv']);
                $fi=$this->controlador()->dep('datos')->tabla('convocatoria')->get_descripciones_filtro($a);
                //print_r($fi);exit;
                
                if(isset($fi[0]['fec_inicio_ia']) and isset($fi[0]['fec_fin_ia']) ){
                    $fechas_ia=date("d/m/Y",strtotime($fi[0]['fec_inicio_ia'])).' - '.date("d/m/Y",strtotime($fi[0]['fec_fin_ia']));
                }else{
                    $fechas_ia="";
                }
                 if(isset($fi[0]['fec_inicio_if']) and isset($fi[0]['fec_fin_if']) ){
                    $fechas_if=date("d/m/Y",strtotime($fi[0]['fec_inicio_if'])).' - '.date("d/m/Y",strtotime($fi[0]['fec_fin_if']));
                }else{
                    $fechas_if="";
                }
                //$fechas_ia=date("d/m/Y",strtotime($fi[0]['fec_inicio_ia'])).' - '.date("d/m/Y",strtotime($fi[0]['fec_fin_ia']));
                //print_r($fechas_ia);exit;
                $texto="Becario: ".$agente."<br>"."<br>".utf8_decode(" Presentación de Informes Avance: ").$fechas_ia."<br>".utf8_decode(" Presentación de Informes Finales: ").$fechas_if;//."Fechas Carga Informes Avance: "
                $form->set_titulo($texto);
            }
	}
}
?>