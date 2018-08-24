------------------------------------------------------------
--[4126]--  alta_solicitud - datos 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'becarios', --proyecto
	'4126', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'25', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'alta_solicitud - datos', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'becarios', --fuente_datos_proyecto
	'becarios', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2018-06-08 18:57:23', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'becarios', --proyecto
	'4126', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'25', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2990', --dep_id
	'4126', --objeto_consumidor
	'4134', --objeto_proveedor
	'becario', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3016', --dep_id
	'4126', --objeto_consumidor
	'4145', --objeto_proveedor
	'becario_beca', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'10'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3017', --dep_id
	'4126', --objeto_consumidor
	'4148', --objeto_proveedor
	'becario_distincion', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'11'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3018', --dep_id
	'4126', --objeto_consumidor
	'4151', --objeto_proveedor
	'becario_empleo', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'12'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3015', --dep_id
	'4126', --objeto_consumidor
	'4141', --objeto_proveedor
	'becario_estudio', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'9'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3020', --dep_id
	'4126', --objeto_consumidor
	'4153', --objeto_proveedor
	'becario_idioma', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'14'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3021', --dep_id
	'4126', --objeto_consumidor
	'4175', --objeto_proveedor
	'becario_referencia', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'15'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3019', --dep_id
	'4126', --objeto_consumidor
	'4157', --objeto_proveedor
	'becario_trabajo', --identificador
	'0', --parametros_a
	'100', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'13'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2996', --dep_id
	'4126', --objeto_consumidor
	'4139', --objeto_proveedor
	'carrera_inscripcion_beca', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'7'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2978', --dep_id
	'4126', --objeto_consumidor
	'4125', --objeto_proveedor
	'categoria_beca', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2993', --dep_id
	'4126', --objeto_consumidor
	'4127', --objeto_proveedor
	'codirector_beca', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'5'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2991', --dep_id
	'4126', --objeto_consumidor
	'4127', --objeto_proveedor
	'director_beca', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2995', --dep_id
	'4126', --objeto_consumidor
	'4137', --objeto_proveedor
	'domicilio', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'6'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3028', --dep_id
	'4126', --objeto_consumidor
	'4137', --objeto_proveedor
	'domicilio_lt', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'18'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3032', --dep_id
	'4126', --objeto_consumidor
	'4137', --objeto_proveedor
	'domicilio_ref', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'19'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'2992', --dep_id
	'4126', --objeto_consumidor
	'4161', --objeto_proveedor
	'inscripcion_beca', --identificador
	'1', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'4'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3026', --dep_id
	'4126', --objeto_consumidor
	'4180', --objeto_proveedor
	'participacion_ext', --identificador
	'0', --parametros_a
	'40', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'17'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3025', --dep_id
	'4126', --objeto_consumidor
	'4179', --objeto_proveedor
	'participacion_inv', --identificador
	'0', --parametros_a
	'40', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'16'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'becarios', --proyecto
	'3014', --dep_id
	'4126', --objeto_consumidor
	'4172', --objeto_proveedor
	'proyecto_inv', --identificador
	'0', --parametros_a
	'1', --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'8'  --orden
);
--- FIN Grupo de desarrollo 0
