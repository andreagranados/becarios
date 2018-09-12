
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	'Becario', --nombre
	NULL, --nivel_acceso
	'Alta de inscripcion becarios', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'0', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3793'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3794'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3798'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3799'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3800'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'becarios', --proyecto
	'becario', --usuario_grupo_acc
	NULL, --item_id
	'3801'  --item
);
--- FIN Grupo de desarrollo 0
