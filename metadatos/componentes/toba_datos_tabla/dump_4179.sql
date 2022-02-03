------------------------------------------------------------
--[4179]--  DT - participacion_inv 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'becarios', --proyecto
	'4179', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'25', --punto_montaje
	'dt_participacion_inv', --subclase
	'datos/dt_participacion_inv.php', --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'DT - participacion_inv', --nombre
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
	'2018-06-21 13:09:11', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 0

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'25', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'participacion_inv', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'0', --modificar_claves
	'becarios', --fuente_datos_proyecto
	'becarios', --fuente_datos
	'1', --permite_actualizacion_automatica
	NULL, --esquema
	'public'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2096', --col_id
	'id', --columna
	'E', --tipo
	'1', --pk
	'participacion_inv_id_seq', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2097', --col_id
	'codigo', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2098', --col_id
	'desde', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2099', --col_id
	'hasta', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2100', --col_id
	'id_becario', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2101', --col_id
	'fecha', --columna
	'F', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2108', --col_id
	'nombredirector', --columna
	'C', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'becarios', --objeto_proyecto
	'4179', --objeto
	'2470', --col_id
	'id_conv', --columna
	'E', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	'0', --externa
	'participacion_inv'  --tabla
);
--- FIN Grupo de desarrollo 0
