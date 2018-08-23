<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class becarios_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'becarios_comando' => 'extension_toba/becarios_comando.php',
		'becarios_modelo' => 'extension_toba/becarios_modelo.php',
		'becarios_ci' => 'extension_toba/componentes/becarios_ci.php',
		'becarios_cn' => 'extension_toba/componentes/becarios_cn.php',
		'becarios_datos_relacion' => 'extension_toba/componentes/becarios_datos_relacion.php',
		'becarios_datos_tabla' => 'extension_toba/componentes/becarios_datos_tabla.php',
		'becarios_ei_arbol' => 'extension_toba/componentes/becarios_ei_arbol.php',
		'becarios_ei_archivos' => 'extension_toba/componentes/becarios_ei_archivos.php',
		'becarios_ei_calendario' => 'extension_toba/componentes/becarios_ei_calendario.php',
		'becarios_ei_codigo' => 'extension_toba/componentes/becarios_ei_codigo.php',
		'becarios_ei_cuadro' => 'extension_toba/componentes/becarios_ei_cuadro.php',
		'becarios_ei_esquema' => 'extension_toba/componentes/becarios_ei_esquema.php',
		'becarios_ei_filtro' => 'extension_toba/componentes/becarios_ei_filtro.php',
		'becarios_ei_firma' => 'extension_toba/componentes/becarios_ei_firma.php',
		'becarios_ei_formulario' => 'extension_toba/componentes/becarios_ei_formulario.php',
		'becarios_ei_formulario_ml' => 'extension_toba/componentes/becarios_ei_formulario_ml.php',
		'becarios_ei_grafico' => 'extension_toba/componentes/becarios_ei_grafico.php',
		'becarios_ei_mapa' => 'extension_toba/componentes/becarios_ei_mapa.php',
		'becarios_servicio_web' => 'extension_toba/componentes/becarios_servicio_web.php',
	);
}
?>