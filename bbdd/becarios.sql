--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.15
-- Dumped by pg_dump version 9.2.2
-- Started on 2018-08-24 08:53:32

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 198 (class 3079 OID 11639)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2130 (class 0 OID 0)
-- Dependencies: 198
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 560 (class 1247 OID 496202)
-- Name: dblink_pkey_results; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE dblink_pkey_results AS (
	"position" integer,
	colname text
);


ALTER TYPE public.dblink_pkey_results OWNER TO postgres;

--
-- TOC entry 228 (class 1255 OID 496194)
-- Name: dblink(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink(text) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_record';


ALTER FUNCTION public.dblink(text) OWNER TO postgres;

--
-- TOC entry 226 (class 1255 OID 496192)
-- Name: dblink(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink(text, text) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_record';


ALTER FUNCTION public.dblink(text, text) OWNER TO postgres;

--
-- TOC entry 229 (class 1255 OID 496195)
-- Name: dblink(text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink(text, boolean) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_record';


ALTER FUNCTION public.dblink(text, boolean) OWNER TO postgres;

--
-- TOC entry 227 (class 1255 OID 496193)
-- Name: dblink(text, text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink(text, text, boolean) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_record';


ALTER FUNCTION public.dblink(text, text, boolean) OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 496205)
-- Name: dblink_build_sql_delete(text, int2vector, integer, text[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_build_sql_delete(text, int2vector, integer, text[]) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_build_sql_delete';


ALTER FUNCTION public.dblink_build_sql_delete(text, int2vector, integer, text[]) OWNER TO postgres;

--
-- TOC entry 235 (class 1255 OID 496204)
-- Name: dblink_build_sql_insert(text, int2vector, integer, text[], text[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_build_sql_insert(text, int2vector, integer, text[], text[]) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_build_sql_insert';


ALTER FUNCTION public.dblink_build_sql_insert(text, int2vector, integer, text[], text[]) OWNER TO postgres;

--
-- TOC entry 237 (class 1255 OID 496206)
-- Name: dblink_build_sql_update(text, int2vector, integer, text[], text[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_build_sql_update(text, int2vector, integer, text[], text[]) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_build_sql_update';


ALTER FUNCTION public.dblink_build_sql_update(text, int2vector, integer, text[], text[]) OWNER TO postgres;

--
-- TOC entry 244 (class 1255 OID 496213)
-- Name: dblink_cancel_query(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_cancel_query(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_cancel_query';


ALTER FUNCTION public.dblink_cancel_query(text) OWNER TO postgres;

--
-- TOC entry 222 (class 1255 OID 496188)
-- Name: dblink_close(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_close(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_close';


ALTER FUNCTION public.dblink_close(text) OWNER TO postgres;

--
-- TOC entry 223 (class 1255 OID 496189)
-- Name: dblink_close(text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_close(text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_close';


ALTER FUNCTION public.dblink_close(text, boolean) OWNER TO postgres;

--
-- TOC entry 224 (class 1255 OID 496190)
-- Name: dblink_close(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_close(text, text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_close';


ALTER FUNCTION public.dblink_close(text, text) OWNER TO postgres;

--
-- TOC entry 225 (class 1255 OID 496191)
-- Name: dblink_close(text, text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_close(text, text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_close';


ALTER FUNCTION public.dblink_close(text, text, boolean) OWNER TO postgres;

--
-- TOC entry 199 (class 1255 OID 496176)
-- Name: dblink_connect(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_connect(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_connect';


ALTER FUNCTION public.dblink_connect(text) OWNER TO postgres;

--
-- TOC entry 203 (class 1255 OID 496177)
-- Name: dblink_connect(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_connect(text, text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_connect';


ALTER FUNCTION public.dblink_connect(text, text) OWNER TO postgres;

--
-- TOC entry 238 (class 1255 OID 496207)
-- Name: dblink_current_query(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_current_query() RETURNS text
    LANGUAGE c
    AS '$libdir/dblink', 'dblink_current_query';


ALTER FUNCTION public.dblink_current_query() OWNER TO postgres;

--
-- TOC entry 212 (class 1255 OID 496178)
-- Name: dblink_disconnect(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_disconnect() RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_disconnect';


ALTER FUNCTION public.dblink_disconnect() OWNER TO postgres;

--
-- TOC entry 213 (class 1255 OID 496179)
-- Name: dblink_disconnect(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_disconnect(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_disconnect';


ALTER FUNCTION public.dblink_disconnect(text) OWNER TO postgres;

--
-- TOC entry 245 (class 1255 OID 496214)
-- Name: dblink_error_message(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_error_message(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_error_message';


ALTER FUNCTION public.dblink_error_message(text) OWNER TO postgres;

--
-- TOC entry 232 (class 1255 OID 496198)
-- Name: dblink_exec(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_exec(text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_exec';


ALTER FUNCTION public.dblink_exec(text) OWNER TO postgres;

--
-- TOC entry 230 (class 1255 OID 496196)
-- Name: dblink_exec(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_exec(text, text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_exec';


ALTER FUNCTION public.dblink_exec(text, text) OWNER TO postgres;

--
-- TOC entry 233 (class 1255 OID 496199)
-- Name: dblink_exec(text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_exec(text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_exec';


ALTER FUNCTION public.dblink_exec(text, boolean) OWNER TO postgres;

--
-- TOC entry 231 (class 1255 OID 496197)
-- Name: dblink_exec(text, text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_exec(text, text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_exec';


ALTER FUNCTION public.dblink_exec(text, text, boolean) OWNER TO postgres;

--
-- TOC entry 218 (class 1255 OID 496184)
-- Name: dblink_fetch(text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_fetch(text, integer) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_fetch';


ALTER FUNCTION public.dblink_fetch(text, integer) OWNER TO postgres;

--
-- TOC entry 219 (class 1255 OID 496185)
-- Name: dblink_fetch(text, integer, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_fetch(text, integer, boolean) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_fetch';


ALTER FUNCTION public.dblink_fetch(text, integer, boolean) OWNER TO postgres;

--
-- TOC entry 220 (class 1255 OID 496186)
-- Name: dblink_fetch(text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_fetch(text, text, integer) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_fetch';


ALTER FUNCTION public.dblink_fetch(text, text, integer) OWNER TO postgres;

--
-- TOC entry 221 (class 1255 OID 496187)
-- Name: dblink_fetch(text, text, integer, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_fetch(text, text, integer, boolean) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_fetch';


ALTER FUNCTION public.dblink_fetch(text, text, integer, boolean) OWNER TO postgres;

--
-- TOC entry 243 (class 1255 OID 496212)
-- Name: dblink_get_connections(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_get_connections() RETURNS text[]
    LANGUAGE c
    AS '$libdir/dblink', 'dblink_get_connections';


ALTER FUNCTION public.dblink_get_connections() OWNER TO postgres;

--
-- TOC entry 234 (class 1255 OID 496203)
-- Name: dblink_get_pkey(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_get_pkey(text) RETURNS SETOF dblink_pkey_results
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_get_pkey';


ALTER FUNCTION public.dblink_get_pkey(text) OWNER TO postgres;

--
-- TOC entry 241 (class 1255 OID 496210)
-- Name: dblink_get_result(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_get_result(text) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_get_result';


ALTER FUNCTION public.dblink_get_result(text) OWNER TO postgres;

--
-- TOC entry 242 (class 1255 OID 496211)
-- Name: dblink_get_result(text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_get_result(text, boolean) RETURNS SETOF record
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_get_result';


ALTER FUNCTION public.dblink_get_result(text, boolean) OWNER TO postgres;

--
-- TOC entry 240 (class 1255 OID 496209)
-- Name: dblink_is_busy(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_is_busy(text) RETURNS integer
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_is_busy';


ALTER FUNCTION public.dblink_is_busy(text) OWNER TO postgres;

--
-- TOC entry 214 (class 1255 OID 496180)
-- Name: dblink_open(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_open(text, text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_open';


ALTER FUNCTION public.dblink_open(text, text) OWNER TO postgres;

--
-- TOC entry 215 (class 1255 OID 496181)
-- Name: dblink_open(text, text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_open(text, text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_open';


ALTER FUNCTION public.dblink_open(text, text, boolean) OWNER TO postgres;

--
-- TOC entry 216 (class 1255 OID 496182)
-- Name: dblink_open(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_open(text, text, text) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_open';


ALTER FUNCTION public.dblink_open(text, text, text) OWNER TO postgres;

--
-- TOC entry 217 (class 1255 OID 496183)
-- Name: dblink_open(text, text, text, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_open(text, text, text, boolean) RETURNS text
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_open';


ALTER FUNCTION public.dblink_open(text, text, text, boolean) OWNER TO postgres;

--
-- TOC entry 239 (class 1255 OID 496208)
-- Name: dblink_send_query(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dblink_send_query(text, text) RETURNS integer
    LANGUAGE c STRICT
    AS '$libdir/dblink', 'dblink_send_query';


ALTER FUNCTION public.dblink_send_query(text, text) OWNER TO postgres;

--
-- TOC entry 246 (class 1255 OID 512968)
-- Name: palabras_claves(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION palabras_claves(text) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
  	pc		text;
  	salida		text;
  	long 		integer;
  	primero         character(1);
  	ultimo        	character(1);
  
BEGIN
--ya viene sin blancos al inicio y al final
pc=trim($1);
long=LENGTH(pc) ;
primero=substring(pc from 1 for 1);--
ultimo=substring(pc from long for 1);--from for desde la posicion 
salida=pc;

if (primero='*') then
	if (ultimo='*') then
          salida=substring(pc from 2 for long-2);
          
        else  
          salida=substring(pc from 2 for long);
    	end if;	
else
    if (ultimo='*') then
        salida=substring(pc from 1 for long-1);
    end if;	
end if;

return salida;
END; 
$_$;


ALTER FUNCTION public.palabras_claves(text) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 167 (class 1259 OID 496266)
-- Name: becario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario (
    id_becario integer NOT NULL,
    apellido character(60),
    nombre character(60),
    nacionalidad character(2),
    tipo_docum character(4),
    nro_docum integer,
    cuil1 integer,
    cuil integer,
    cuil2 integer,
    fec_nacim date,
    correo character(60),
    telefono character(30),
    nro_domicilio integer
);


ALTER TABLE public.becario OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 497197)
-- Name: becario_beca; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_beca (
    id_beca integer NOT NULL,
    institucion character(120),
    objeto character(120),
    desde date,
    hasta date,
    id_becario integer,
    fecha date
);


ALTER TABLE public.becario_beca OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 497195)
-- Name: becario_beca_id_beca_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_beca_id_beca_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_beca_id_beca_seq OWNER TO postgres;

--
-- TOC entry 2131 (class 0 OID 0)
-- Dependencies: 176
-- Name: becario_beca_id_beca_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_beca_id_beca_seq OWNED BY becario_beca.id_beca;


--
-- TOC entry 179 (class 1259 OID 497210)
-- Name: becario_distincion; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_distincion (
    id_distincion integer NOT NULL,
    fecha_dis date,
    distincion character(100),
    id_becario integer,
    fecha date
);


ALTER TABLE public.becario_distincion OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 497208)
-- Name: becario_distincion_id_distincion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_distincion_id_distincion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_distincion_id_distincion_seq OWNER TO postgres;

--
-- TOC entry 2132 (class 0 OID 0)
-- Dependencies: 178
-- Name: becario_distincion_id_distincion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_distincion_id_distincion_seq OWNED BY becario_distincion.id_distincion;


--
-- TOC entry 181 (class 1259 OID 497223)
-- Name: becario_empleo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_empleo (
    id integer NOT NULL,
    institucion character(100),
    direccion character(200),
    cargo character(20),
    anio_ingreso integer,
    actual boolean,
    id_becario integer,
    fecha date
);


ALTER TABLE public.becario_empleo OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 497221)
-- Name: becario_empleo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_empleo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_empleo_id_seq OWNER TO postgres;

--
-- TOC entry 2133 (class 0 OID 0)
-- Dependencies: 180
-- Name: becario_empleo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_empleo_id_seq OWNED BY becario_empleo.id;


--
-- TOC entry 175 (class 1259 OID 497184)
-- Name: becario_estudio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_estudio (
    id integer NOT NULL,
    institucion character(100),
    desde date,
    hasta date,
    titulo character(120),
    id_becario integer,
    fecha date
);


ALTER TABLE public.becario_estudio OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 497182)
-- Name: becario_estudio_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_estudio_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_estudio_id_seq OWNER TO postgres;

--
-- TOC entry 2134 (class 0 OID 0)
-- Dependencies: 174
-- Name: becario_estudio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_estudio_id_seq OWNED BY becario_estudio.id;


--
-- TOC entry 166 (class 1259 OID 496264)
-- Name: becario_id_becario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_id_becario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_id_becario_seq OWNER TO postgres;

--
-- TOC entry 2135 (class 0 OID 0)
-- Dependencies: 166
-- Name: becario_id_becario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_id_becario_seq OWNED BY becario.id_becario;


--
-- TOC entry 183 (class 1259 OID 497236)
-- Name: becario_idioma; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_idioma (
    id integer NOT NULL,
    descripcion character(60),
    id_becario integer,
    fecha date,
    lee integer,
    escribe integer,
    habla integer,
    entiende integer
);


ALTER TABLE public.becario_idioma OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 497234)
-- Name: becario_idioma_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_idioma_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_idioma_id_seq OWNER TO postgres;

--
-- TOC entry 2136 (class 0 OID 0)
-- Dependencies: 182
-- Name: becario_idioma_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_idioma_id_seq OWNED BY becario_idioma.id;


--
-- TOC entry 187 (class 1259 OID 497262)
-- Name: becario_referencia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_referencia (
    id integer NOT NULL,
    apellido character(60),
    nombre character(60),
    profesion character(100),
    cargo character(100),
    id_domicilio integer,
    id_becario integer,
    fecha date,
    institucion character(100),
    uni_acad character(5),
    id_designacion integer
);


ALTER TABLE public.becario_referencia OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 497260)
-- Name: becario_referencia_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_referencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_referencia_id_seq OWNER TO postgres;

--
-- TOC entry 2137 (class 0 OID 0)
-- Dependencies: 186
-- Name: becario_referencia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_referencia_id_seq OWNED BY becario_referencia.id;


--
-- TOC entry 185 (class 1259 OID 497249)
-- Name: becario_trabajo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE becario_trabajo (
    id integer NOT NULL,
    titulo character(200),
    presentado_en character(200),
    fecha_trab date,
    id_becario integer,
    fecha date
);


ALTER TABLE public.becario_trabajo OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 497247)
-- Name: becario_trabajo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE becario_trabajo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.becario_trabajo_id_seq OWNER TO postgres;

--
-- TOC entry 2138 (class 0 OID 0)
-- Dependencies: 184
-- Name: becario_trabajo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE becario_trabajo_id_seq OWNED BY becario_trabajo.id;


--
-- TOC entry 162 (class 1259 OID 496167)
-- Name: carrera_inscripcion_beca; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE carrera_inscripcion_beca (
    id integer NOT NULL,
    uni_acad character(5),
    carrera character(120),
    cant_mat_plan integer,
    cant_materias_adeuda integer,
    cant_materias_aprobadas integer,
    promedio numeric,
    fecha_inicio date,
    fecha_finalizacion date,
    titulo character(120),
    institucion character varying,
    inst integer
);


ALTER TABLE public.carrera_inscripcion_beca OWNER TO postgres;

--
-- TOC entry 2139 (class 0 OID 0)
-- Dependencies: 162
-- Name: COLUMN carrera_inscripcion_beca.inst; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN carrera_inscripcion_beca.inst IS 'Tipo de Institucion:
1- Universidad Nacional del Comahue
2- Otra';


--
-- TOC entry 161 (class 1259 OID 496165)
-- Name: carrera_inscripcion_beca_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE carrera_inscripcion_beca_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carrera_inscripcion_beca_id_seq OWNER TO postgres;

--
-- TOC entry 2140 (class 0 OID 0)
-- Dependencies: 161
-- Name: carrera_inscripcion_beca_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE carrera_inscripcion_beca_id_seq OWNED BY carrera_inscripcion_beca.id;


--
-- TOC entry 165 (class 1259 OID 496259)
-- Name: categoria_beca; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categoria_beca (
    id_categ integer NOT NULL,
    descripcion character(35)
);


ALTER TABLE public.categoria_beca OWNER TO postgres;

--
-- TOC entry 164 (class 1259 OID 496254)
-- Name: categoria_conicet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categoria_conicet (
    id_categ character(4) NOT NULL,
    descripcion character(35)
);


ALTER TABLE public.categoria_conicet OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 496772)
-- Name: categoria_invest; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE categoria_invest (
    cod_cati integer NOT NULL,
    descripcion character(10)
);


ALTER TABLE public.categoria_invest OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 497300)
-- Name: director_beca; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE director_beca (
    id integer NOT NULL,
    nombre character varying,
    apellido character varying,
    legajo integer,
    cuil1 integer,
    cuil integer,
    cuil2 integer,
    correo character varying,
    nro_domicilio integer,
    cat_estat character(6),
    dedic integer,
    carac character(1),
    cat_invest integer,
    cat_conicet character(4),
    titulo character(100),
    institucion character(100),
    lugar_trabajo character(100),
    id_designacion integer
);


ALTER TABLE public.director_beca OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 497298)
-- Name: director_beca_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE director_beca_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.director_beca_id_seq OWNER TO postgres;

--
-- TOC entry 2141 (class 0 OID 0)
-- Dependencies: 188
-- Name: director_beca_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE director_beca_id_seq OWNED BY director_beca.id;


--
-- TOC entry 172 (class 1259 OID 496612)
-- Name: domicilio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE domicilio (
    nro_domicilio integer NOT NULL,
    cod_postal integer,
    calle character(50),
    numero integer,
    cod_pais character(2),
    cod_provincia integer,
    telefono character(30)
);


ALTER TABLE public.domicilio OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 496610)
-- Name: domicilio_nro_domicilio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE domicilio_nro_domicilio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.domicilio_nro_domicilio_seq OWNER TO postgres;

--
-- TOC entry 2142 (class 0 OID 0)
-- Dependencies: 171
-- Name: domicilio_nro_domicilio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE domicilio_nro_domicilio_seq OWNED BY domicilio.nro_domicilio;


--
-- TOC entry 168 (class 1259 OID 496285)
-- Name: inscripcion_beca; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE inscripcion_beca (
    id_becario integer NOT NULL,
    fecha_presentacion date NOT NULL,
    categ_beca integer,
    estado character(1),
    uni_acad character(4),
    id_director integer,
    id_codirector integer,
    id_proyecto integer,
    id_carrera integer,
    beca_en_curso boolean,
    institucion_beca_en_curso character(100),
    ua_trabajo_beca character(5),
    desc_trabajo_beca character(100),
    nro_domicilio_trabajo_beca integer,
    titulo_plan_trabajo character(250),
    dpto_trabajo_beca character varying,
    observaciones character varying,
    desarrollo_plan_trab character varying,
    fundamentos_solicitud character varying
);


ALTER TABLE public.inscripcion_beca OWNER TO postgres;

--
-- TOC entry 195 (class 1259 OID 502882)
-- Name: opciones; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE opciones (
    id integer NOT NULL,
    descripcion character(60)
);


ALTER TABLE public.opciones OWNER TO postgres;

--
-- TOC entry 194 (class 1259 OID 502880)
-- Name: opciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE opciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.opciones_id_seq OWNER TO postgres;

--
-- TOC entry 2143 (class 0 OID 0)
-- Dependencies: 194
-- Name: opciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE opciones_id_seq OWNED BY opciones.id;


--
-- TOC entry 169 (class 1259 OID 496548)
-- Name: pais; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pais (
    codigo_pais character(2) NOT NULL,
    nombre character varying(40)
);


ALTER TABLE public.pais OWNER TO postgres;

--
-- TOC entry 193 (class 1259 OID 497357)
-- Name: participacion_ext; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE participacion_ext (
    id integer NOT NULL,
    codigo character varying,
    desde date,
    hasta date,
    id_becario integer,
    fecha date,
    nombredirector character varying
);


ALTER TABLE public.participacion_ext OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 497355)
-- Name: participacion_ext_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE participacion_ext_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.participacion_ext_id_seq OWNER TO postgres;

--
-- TOC entry 2144 (class 0 OID 0)
-- Dependencies: 192
-- Name: participacion_ext_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE participacion_ext_id_seq OWNED BY participacion_ext.id;


--
-- TOC entry 191 (class 1259 OID 497341)
-- Name: participacion_inv; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE participacion_inv (
    id integer NOT NULL,
    codigo character varying,
    desde date,
    hasta date,
    id_becario integer,
    fecha date,
    nombredirector character varying
);


ALTER TABLE public.participacion_inv OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 497339)
-- Name: participacion_inv_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE participacion_inv_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.participacion_inv_id_seq OWNER TO postgres;

--
-- TOC entry 2145 (class 0 OID 0)
-- Dependencies: 190
-- Name: participacion_inv_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE participacion_inv_id_seq OWNED BY participacion_inv.id;


--
-- TOC entry 170 (class 1259 OID 496571)
-- Name: provincia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE provincia (
    descripcion_pcia character(40),
    cod_pais character(2),
    codigo_pcia integer NOT NULL
);


ALTER TABLE public.provincia OWNER TO postgres;

--
-- TOC entry 197 (class 1259 OID 512908)
-- Name: proyecto_inv; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE proyecto_inv (
    id_pinv integer NOT NULL,
    codigo character varying,
    denominacion character varying,
    fec_desde date,
    fec_hasta date,
    nro_ord_cs character(10),
    apnom_director character(140),
    id integer,
    uni_acad character(5)
);


ALTER TABLE public.proyecto_inv OWNER TO postgres;

--
-- TOC entry 2146 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN proyecto_inv.id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN proyecto_inv.id IS 'id del proyecto de investigacion en designa';


--
-- TOC entry 196 (class 1259 OID 512906)
-- Name: proyecto_inv_id_pinv_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE proyecto_inv_id_pinv_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.proyecto_inv_id_pinv_seq OWNER TO postgres;

--
-- TOC entry 2147 (class 0 OID 0)
-- Dependencies: 196
-- Name: proyecto_inv_id_pinv_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE proyecto_inv_id_pinv_seq OWNED BY proyecto_inv.id_pinv;


--
-- TOC entry 2004 (class 2604 OID 496269)
-- Name: id_becario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario ALTER COLUMN id_becario SET DEFAULT nextval('becario_id_becario_seq'::regclass);


--
-- TOC entry 2007 (class 2604 OID 497200)
-- Name: id_beca; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_beca ALTER COLUMN id_beca SET DEFAULT nextval('becario_beca_id_beca_seq'::regclass);


--
-- TOC entry 2008 (class 2604 OID 497213)
-- Name: id_distincion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_distincion ALTER COLUMN id_distincion SET DEFAULT nextval('becario_distincion_id_distincion_seq'::regclass);


--
-- TOC entry 2009 (class 2604 OID 497226)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_empleo ALTER COLUMN id SET DEFAULT nextval('becario_empleo_id_seq'::regclass);


--
-- TOC entry 2006 (class 2604 OID 497187)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_estudio ALTER COLUMN id SET DEFAULT nextval('becario_estudio_id_seq'::regclass);


--
-- TOC entry 2010 (class 2604 OID 497239)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma ALTER COLUMN id SET DEFAULT nextval('becario_idioma_id_seq'::regclass);


--
-- TOC entry 2012 (class 2604 OID 497265)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_referencia ALTER COLUMN id SET DEFAULT nextval('becario_referencia_id_seq'::regclass);


--
-- TOC entry 2011 (class 2604 OID 497252)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_trabajo ALTER COLUMN id SET DEFAULT nextval('becario_trabajo_id_seq'::regclass);


--
-- TOC entry 2003 (class 2604 OID 496170)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY carrera_inscripcion_beca ALTER COLUMN id SET DEFAULT nextval('carrera_inscripcion_beca_id_seq'::regclass);


--
-- TOC entry 2013 (class 2604 OID 497303)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY director_beca ALTER COLUMN id SET DEFAULT nextval('director_beca_id_seq'::regclass);


--
-- TOC entry 2005 (class 2604 OID 496615)
-- Name: nro_domicilio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY domicilio ALTER COLUMN nro_domicilio SET DEFAULT nextval('domicilio_nro_domicilio_seq'::regclass);


--
-- TOC entry 2016 (class 2604 OID 502885)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY opciones ALTER COLUMN id SET DEFAULT nextval('opciones_id_seq'::regclass);


--
-- TOC entry 2015 (class 2604 OID 497360)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY participacion_ext ALTER COLUMN id SET DEFAULT nextval('participacion_ext_id_seq'::regclass);


--
-- TOC entry 2014 (class 2604 OID 497344)
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY participacion_inv ALTER COLUMN id SET DEFAULT nextval('participacion_inv_id_seq'::regclass);


--
-- TOC entry 2017 (class 2604 OID 512911)
-- Name: id_pinv; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY proyecto_inv ALTER COLUMN id_pinv SET DEFAULT nextval('proyecto_inv_id_pinv_seq'::regclass);


--
-- TOC entry 2092 (class 0 OID 496266)
-- Dependencies: 167
-- Data for Name: becario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario (id_becario, apellido, nombre, nacionalidad, tipo_docum, nro_docum, cuil1, cuil, cuil2, fec_nacim, correo, telefono, nro_domicilio) FROM stdin;
42	granados                                                    	andrea                                                      	AR	\N	\N	27	28399996	9	1980-09-16	ag@gmail.com                                                	112                           	42
54	Serventi                                                    	Mauro Norberto                                              	AR	DNI 	27666640	20	27666640	2	1979-12-10	ms@gmail.com                                                	112                           	70
\.


--
-- TOC entry 2102 (class 0 OID 497197)
-- Dependencies: 177
-- Data for Name: becario_beca; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_beca (id_beca, institucion, objeto, desde, hasta, id_becario, fecha) FROM stdin;
3	instituto1                                                                                                              	beca1                                                                                                                   	2018-01-01	2018-02-02	42	2018-06-12
\.


--
-- TOC entry 2148 (class 0 OID 0)
-- Dependencies: 176
-- Name: becario_beca_id_beca_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_beca_id_beca_seq', 4, true);


--
-- TOC entry 2104 (class 0 OID 497210)
-- Dependencies: 179
-- Data for Name: becario_distincion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_distincion (id_distincion, fecha_dis, distincion, id_becario, fecha) FROM stdin;
3	2018-01-01	premiado en buen comportamiento                                                                     	42	2018-06-12
\.


--
-- TOC entry 2149 (class 0 OID 0)
-- Dependencies: 178
-- Name: becario_distincion_id_distincion_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_distincion_id_distincion_seq', 3, true);


--
-- TOC entry 2106 (class 0 OID 497223)
-- Dependencies: 181
-- Data for Name: becario_empleo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_empleo (id, institucion, direccion, cargo, anio_ingreso, actual, id_becario, fecha) FROM stdin;
1	escuela 92                                                                                          	avenida plottier                                                                                                                                                                                        	director            	1980	f	42	2018-06-12
\.


--
-- TOC entry 2150 (class 0 OID 0)
-- Dependencies: 180
-- Name: becario_empleo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_empleo_id_seq', 3, true);


--
-- TOC entry 2100 (class 0 OID 497184)
-- Dependencies: 175
-- Data for Name: becario_estudio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_estudio (id, institucion, desde, hasta, titulo, id_becario, fecha) FROM stdin;
13	universidad de madrid                                                                               	2018-01-01	2018-01-01	analista en sistemas                                                                                                    	42	2018-06-12
14	universidad de la plata                                                                             	2019-01-01	2018-02-01	medico                                                                                                                  	42	2018-06-12
17	ins estudio1                                                                                        	2015-02-01	2018-01-31	analista en computacion                                                                                                 	54	2018-07-30
\.


--
-- TOC entry 2151 (class 0 OID 0)
-- Dependencies: 174
-- Name: becario_estudio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_estudio_id_seq', 18, true);


--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 166
-- Name: becario_id_becario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_id_becario_seq', 54, true);


--
-- TOC entry 2108 (class 0 OID 497236)
-- Dependencies: 183
-- Data for Name: becario_idioma; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_idioma (id, descripcion, id_becario, fecha, lee, escribe, habla, entiende) FROM stdin;
1	ingles                                                      	42	2018-06-12	3	3	3	3
\.


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 182
-- Name: becario_idioma_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_idioma_id_seq', 1, true);


--
-- TOC entry 2112 (class 0 OID 497262)
-- Dependencies: 187
-- Data for Name: becario_referencia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_referencia (id, apellido, nombre, profesion, cargo, id_domicilio, id_becario, fecha, institucion, uni_acad, id_designacion) FROM stdin;
10	ABADI                                                       	SARA LAURA                                                  	\N	AYP3                                                                                                	71	54	2018-07-30	\N	FAME 	13086
11	ABRIGO                                                      	SERGIO ALBERTO                                              	\N	PAD1                                                                                                	72	54	2018-07-30	\N	FAIN 	12111
1	perez de vidal                                              	jorgelina                                                   	contador                                                                                            	jefe de personal                                                                                    	44	42	2018-06-12	escuela 32                                                                                          	\N	\N
12	pepe                                                        	pepe                                                        	contador                                                                                            	contador                                                                                            	74	42	2018-06-12	escuela 8                                                                                           	\N	\N
\.


--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 186
-- Name: becario_referencia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_referencia_id_seq', 12, true);


--
-- TOC entry 2110 (class 0 OID 497249)
-- Dependencies: 185
-- Data for Name: becario_trabajo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY becario_trabajo (id, titulo, presentado_en, fecha_trab, id_becario, fecha) FROM stdin;
1	mitrabajo                                                                                                                                                                                               	universidad de toronto                                                                                                                                                                                  	2018-06-20	42	2018-06-12
2	otro                                                                                                                                                                                                    	unco                                                                                                                                                                                                    	2018-01-01	42	2018-06-12
3	titulo1                                                                                                                                                                                                 	unco                                                                                                                                                                                                    	2018-06-20	54	2018-07-30
\.


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 184
-- Name: becario_trabajo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('becario_trabajo_id_seq', 3, true);


--
-- TOC entry 2088 (class 0 OID 496167)
-- Dependencies: 162
-- Data for Name: carrera_inscripcion_beca; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY carrera_inscripcion_beca (id, uni_acad, carrera, cant_mat_plan, cant_materias_adeuda, cant_materias_aprobadas, promedio, fecha_inicio, fecha_finalizacion, titulo, institucion, inst) FROM stdin;
42	FATU 	agronomia                                                                                                               	1	\N	6	\N	2008-12-12	2018-12-12	\N	\N	\N
32	FALE 	PROFESORADO EN INGLES                                                                                                   	1	1	1	5.6	2000-01-01	2010-01-31	analista en sistemas                                                                                                    	Universidad Nacional del Comahue	1
\.


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 161
-- Name: carrera_inscripcion_beca_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('carrera_inscripcion_beca_id_seq', 42, true);


--
-- TOC entry 2090 (class 0 OID 496259)
-- Dependencies: 165
-- Data for Name: categoria_beca; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY categoria_beca (id_categ, descripcion) FROM stdin;
3	Estudiante                         
1	Graduado de Perfeccionamiento      
2	Graduado de Iniciación             
\.


--
-- TOC entry 2089 (class 0 OID 496254)
-- Dependencies: 164
-- Data for Name: categoria_conicet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY categoria_conicet (id_categ, descripcion) FROM stdin;
IP  	Investigador Principal             
IAd 	Investigador Adjunto               
II  	Investigador Independiente         
IAs 	Investigador Asistente             
IS  	Investigador Superior              
\.


--
-- TOC entry 2098 (class 0 OID 496772)
-- Dependencies: 173
-- Data for Name: categoria_invest; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY categoria_invest (cod_cati, descripcion) FROM stdin;
1	I         
2	II        
3	III       
4	IV        
5	V         
6	S/C       
\.


--
-- TOC entry 2114 (class 0 OID 497300)
-- Dependencies: 189
-- Data for Name: director_beca; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY director_beca (id, nombre, apellido, legajo, cuil1, cuil, cuil2, correo, nro_domicilio, cat_estat, dedic, carac, cat_invest, cat_conicet, titulo, institucion, lugar_trabajo, id_designacion) FROM stdin;
3	MARIA CLAUDIA	ALLAN	55880	27	21385349	5	adra@gmail.com	\N	ASD   	1	R	3	IAs 	xxxx                                                                                                	asas                                                                                                	mi casa                                                                                             	\N
9	ALIDA MARINA	ABAD	53761	27	11543480	8	abad@gmail.com	\N	PAS   	3	I	4	II  	titulo de posgrado                                                                                  	inst                                                                                                	neuquen                                                                                             	693
1	ANA CAROLINA	ALONSO DE ARMIÑO	55880	27	24712589	8	ag@gmail.com	\N	AYP   	3	R	3	IAs 	MEDICO                                                                                              	uncom                                                                                               	mi casa de campo                                                                                    	1
\.


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 188
-- Name: director_beca_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('director_beca_id_seq', 9, true);


--
-- TOC entry 2097 (class 0 OID 496612)
-- Dependencies: 172
-- Data for Name: domicilio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY domicilio (nro_domicilio, cod_postal, calle, numero, cod_pais, cod_provincia, telefono) FROM stdin;
71	8300	avd argentina                                     	112	AR	16	155777654                     
72	8300	Mendoza                                           	222	AR	16	11111                         
73	8300	mendoza                                           	839	AR	16	112-99882                     
70	8300	Cosquin                                           	2288	AR	16	\N
44	777	san juan                                          	1212	AR	16	121212                        
74	8316	mendoza                                           	111	AR	16	111                           
42	8316	mendoza                                           	123	AR	16	\N
43	8316	mendoza                                           	839	AR	1	112-99882                     
\.


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 171
-- Name: domicilio_nro_domicilio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('domicilio_nro_domicilio_seq', 74, true);


--
-- TOC entry 2093 (class 0 OID 496285)
-- Dependencies: 168
-- Data for Name: inscripcion_beca; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY inscripcion_beca (id_becario, fecha_presentacion, categ_beca, estado, uni_acad, id_director, id_codirector, id_proyecto, id_carrera, beca_en_curso, institucion_beca_en_curso, ua_trabajo_beca, desc_trabajo_beca, nro_domicilio_trabajo_beca, titulo_plan_trabajo, dpto_trabajo_beca, observaciones, desarrollo_plan_trab, fundamentos_solicitud) FROM stdin;
54	2018-07-30	3	I	FATU	9	\N	3	42	f	\N	FATU 	LABORATORIO NUMERO 1                                                                                	73	este es el titulo de mi plan de trabajo                                                                                                                                                                                                                   	ZOOLOGÃA	\N	\N	\N
42	2018-06-12	1	I	FAME	1	\N	4	32	t	uncoma                                                                                              	FADE 	LABORATORIO NUMERO 1                                                                                	43	este es mi plan de trabajo                                                                                                                                                                                                                                	SERVICIO SOCIAL	\N	desarrollo	estos son los fundamentos
\.


--
-- TOC entry 2120 (class 0 OID 502882)
-- Dependencies: 195
-- Data for Name: opciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY opciones (id, descripcion) FROM stdin;
1	Muy Bueno                                                   
2	Bueno                                                       
3	Aceptable                                                   
\.


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 194
-- Name: opciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('opciones_id_seq', 1, false);


--
-- TOC entry 2094 (class 0 OID 496548)
-- Dependencies: 169
-- Data for Name: pais; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pais (codigo_pais, nombre) FROM stdin;
AD	Andorra
AE	Emiratos Arabes Unidos
AF	Afghanistan
AG	Antigua y Barbuda
AI	Anguilla
AL	Albania
AM	Armenia
AN	Antillas Holandesas
AO	Angola
AQ	Antartida
AR	Argentina
AS	Samoa Americana
AT	Austria
AU	Australia
AW	Aruba
AZ	Azerbaijan
BA	Bosnia y Herzegovina
BB	Barbados
BD	Bangladesh
BE	Belgica
BF	Burkina Faso
BG	Bulgaria
BH	Bahrein
BI	Burundi
BJ	Benin
BM	Bermuda
BN	Brunei Darussalam
BO	Bolivia
BR	Brasil
BS	Bahamas
BT	Bhutan
BV	Bouvet Island
BW	Botswana
BY	Bielorrusia
BZ	Belize
CA	Canada
CC	Cocos (Keeling Islands)
CF	Republica del Africa Central
CG	Congo
CH	Confederacion Helvetica (Suiza)
CI	Costa de Marfil
CK	Cook Islands
CL	Chile
CM	Camerun
CN	China (Excluido Taiwan)
CO	Colombia
CR	Costa Rica
CU	Cuba
CV	Cabo Verde
CX	Christmas Island
CY	Chipre
CZ	Republica Checa
DE	Alemania
DJ	Djibouti
DK	Dinamarca
DM	Dominica
DO	Republica Dominicana
DZ	Argelia
EC	Ecuador
EE	Estonia
EG	Egipto
EH	Sahara Occidental
ER	Eritrea
ES	España
ET	Etiopia
FI	Finlandia
FJ	Fidji
FK	Islas Malvinas
FM	Micronesia
FO	Faroe Islands
FR	Francia
FX	Francia, (Metropolitana)
GA	Gabon
GD	Grenada
GE	Georgia
GF	Guyana Frances
GH	Ghana
GI	Gibraltar
GL	Groenlandia
GM	Gambia
GN	Guinea
GP	Guadalupe
GQ	Guinea Ecuatorial
GR	Grecia
GT	Guatemala
GU	Guam
GW	Guinea-Bissau
GY	Guyana
HK	Hong Kong
HM	Heard and McDonald Islands
HN	Honduras
HR	Croacia
HT	Haiti
HU	Hungria
ID	Indonesia
IE	Irlanda
IL	Israel
IN	India
IO	Territorios britanicos del Oceano Indico
IQ	Iraq
IR	Iran
IS	Islandia
IT	Italia
JM	Jamaica
JO	Jordan
JP	Japon
KE	Kenya
KG	Kyrgyzstan
KH	Camboya
KI	Kiribati
KM	Comoros
KN	Saint Kitts y Nevis
KP	Korea del Norte
KR	Korea del Sur
KW	Kuwait
KY	Cayman Islands
KZ	Kazakhstan
LA	Laos
LB	Libano
LC	Santa Lucia
LI	Liechtenstein
LK	Sri Lanka
LR	Liberia
LS	Lesotho
LT	Lituania
LU	Luxemburgo
LV	Latavia
LY	Libia
MA	Marruecos
MC	Monaco
MD	Moldova
MG	Madagascar
MH	Marshall Islands
MK	Macedonia
ML	Mali
MM	Myanmar
MN	Mongolia
MO	Macao
MP	Islas Marianas del Norte
MQ	Martinica
MR	Mauritania
MS	Montserrat
MT	Malta
MU	Mauricio
MV	Maldivias
MW	Malawi
MX	Mexico
MY	Malasia
MZ	Mozambique
NA	Namibia
NC	Nueva Caledonia
NE	Niger
NF	Norfolk Island
NG	Nigeria
NI	Nicaragua
NL	Paises Bajos (Holanda o Netherlands)
NO	Noruega
NP	Nepal
NR	Nauru
NZ	Nueva Zelandia
OM	Oman
PA	Panama
PE	Peru
PF	Polinesia Francesa
PG	Papua /Nueva Guinea
PH	Filipinas
PK	Pakistan
PL	Polonia
PM	St. Pierre y Miquelon
PN	Pitcairn
PR	Puerto Rico
PT	Portugal
PW	Palau
PY	Paraguay
QA	Qatar
RE	Reunion
RO	Rumania
RU	Rusia
RW	Rwanda
SA	Arabia Saudita
SB	Solomon Islands
SC	Seychelles
SD	Sudan
SE	Suecia
SG	Singapur
SH	St. Helena
SI	Eslovenia
SJ	Svalbard y Jan Mayen
SK	Republica Eslovaca
SL	Sierra Leona
SM	San Marino
SN	Senegal
SO	Somalia
SR	Surinam
ST	Santo Tome y Principe
SV	El Salvador
SY	Siria
SZ	Swazilandia
TC	Turks and Caicos Islands
TD	Chad
TF	Territorios Franceses del Sur
TG	Togo
TH	Tailandia
TJ	Tajikistan
TK	Tokelau
TM	Turkmenistan
TN	Tunez
TO	Tonga
TP	Timor
TR	Turquia
TT	Trinidad y Tobago
TV	Tuvalu
TW	Taiwan
TZ	Tanzania
UA	Ucrania
UG	Uganda
UK	Reino Unido (Inglaterra,Gales y Escocia)
UM	US Minor Outlying Islands
UN	Niue
US	Estados Unidos de America
UY	Uruguay
UZ	Uzbekistan
VC	San Vincente y Las Grenadinas
VE	Venezuela
VG	Virgin Islands Britanicas
VI	Virgin Islands (USA)
VN	Vietnam
VU	Vanuatu
WF	Wallis y Futuna
WS	Samoa
YE	Yemen
YT	Mayotte
YU	Yugoslavia
ZA	Sudafrica
ZM	Zambia
ZR	Zaire
ZW	Zimbabwe
\.


--
-- TOC entry 2118 (class 0 OID 497357)
-- Dependencies: 193
-- Data for Name: participacion_ext; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY participacion_ext (id, codigo, desde, hasta, id_becario, fecha, nombredirector) FROM stdin;
1	extens1	2015-01-01	2016-02-01	42	2018-06-12	\N
\.


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 192
-- Name: participacion_ext_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('participacion_ext_id_seq', 1, true);


--
-- TOC entry 2116 (class 0 OID 497341)
-- Dependencies: 191
-- Data for Name: participacion_inv; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY participacion_inv (id, codigo, desde, hasta, id_becario, fecha, nombredirector) FROM stdin;
2	efgh	2016-02-01	2017-01-31	42	2018-06-12	luis
3	o88/kjkj	2015-02-01	2016-01-31	54	2018-07-30	JOSE
1	cambie	2015-02-01	2016-01-31	42	2018-06-12	esteban jose
\.


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 190
-- Name: participacion_inv_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('participacion_inv_id_seq', 3, true);


--
-- TOC entry 2095 (class 0 OID 496571)
-- Dependencies: 170
-- Data for Name: provincia; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY provincia (descripcion_pcia, cod_pais, codigo_pcia) FROM stdin;
Buenos Aires                            	AR	1
Buenos Aires-GBA                        	AR	2
Capital Federal                         	AR	3
Catamarca                               	AR	4
Chaco                                   	AR	5
Chubut                                  	AR	6
Córdoba                                 	AR	7
Corrientes                              	AR	8
Entre Ríos                              	AR	9
Formosa                                 	AR	10
Jujuy                                   	AR	11
La Pampa                                	AR	12
La Rioja                                	AR	13
Mendoza                                 	AR	14
Misiones                                	AR	15
Neuquén                                 	AR	16
Río Negro                               	AR	17
Salta                                   	AR	18
San Juan                                	AR	19
San Luis                                	AR	20
Santa Cruz                              	AR	21
Santa Fe                                	AR	22
Santiago del Estero                     	AR	23
Tierra del Fuego                        	AR	24
Tucumán                                 	AR	25
\.


--
-- TOC entry 2122 (class 0 OID 512908)
-- Dependencies: 197
-- Data for Name: proyecto_inv; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY proyecto_inv (id_pinv, codigo, denominacion, fec_desde, fec_hasta, nro_ord_cs, apnom_director, id, uni_acad) FROM stdin;
3	04/L003 Sub 2	Alternativas de industrializaciÃ³n para frutas de pepita en fresco y sus bagazos	2014-01-01	2017-12-31	\N	VULLIOUD, MABEL BEATRIZ                                                                                                                     	44	\N
4	04/N026	AsociaciÃ³n entre la enfermedad periodontal y los eventos vasculares mayores con el polimorfismo de la metilentetrahidrofolato reductasa (MTHFR)	2016-01-01	2019-12-31	0589/16   	PEPE                                                                                                                                        	134	FAME 
\.


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 196
-- Name: proyecto_inv_id_pinv_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('proyecto_inv_id_pinv_seq', 4, true);


--
-- TOC entry 2025 (class 2606 OID 496271)
-- Name: pk_becario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario
    ADD CONSTRAINT pk_becario PRIMARY KEY (id_becario);


--
-- TOC entry 2039 (class 2606 OID 497202)
-- Name: pk_becario_beca; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_beca
    ADD CONSTRAINT pk_becario_beca PRIMARY KEY (id_beca);


--
-- TOC entry 2043 (class 2606 OID 497228)
-- Name: pk_becario_empleo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_empleo
    ADD CONSTRAINT pk_becario_empleo PRIMARY KEY (id);


--
-- TOC entry 2037 (class 2606 OID 497189)
-- Name: pk_becario_estudio; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_estudio
    ADD CONSTRAINT pk_becario_estudio PRIMARY KEY (id);


--
-- TOC entry 2045 (class 2606 OID 497241)
-- Name: pk_becario_idioma; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT pk_becario_idioma PRIMARY KEY (id);


--
-- TOC entry 2041 (class 2606 OID 497215)
-- Name: pk_becario_istincion; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_distincion
    ADD CONSTRAINT pk_becario_istincion PRIMARY KEY (id_distincion);


--
-- TOC entry 2049 (class 2606 OID 497267)
-- Name: pk_becario_referencia; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_referencia
    ADD CONSTRAINT pk_becario_referencia PRIMARY KEY (id);


--
-- TOC entry 2047 (class 2606 OID 497254)
-- Name: pk_becario_trabajo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY becario_trabajo
    ADD CONSTRAINT pk_becario_trabajo PRIMARY KEY (id);


--
-- TOC entry 2019 (class 2606 OID 496175)
-- Name: pk_carrera_inscripcion_beca; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY carrera_inscripcion_beca
    ADD CONSTRAINT pk_carrera_inscripcion_beca PRIMARY KEY (id);


--
-- TOC entry 2023 (class 2606 OID 496263)
-- Name: pk_categoria_beca; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categoria_beca
    ADD CONSTRAINT pk_categoria_beca PRIMARY KEY (id_categ);


--
-- TOC entry 2021 (class 2606 OID 496258)
-- Name: pk_categoria_conicet; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categoria_conicet
    ADD CONSTRAINT pk_categoria_conicet PRIMARY KEY (id_categ);


--
-- TOC entry 2035 (class 2606 OID 496776)
-- Name: pk_categoria_invest; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY categoria_invest
    ADD CONSTRAINT pk_categoria_invest PRIMARY KEY (cod_cati);


--
-- TOC entry 2051 (class 2606 OID 497308)
-- Name: pk_director_beca; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY director_beca
    ADD CONSTRAINT pk_director_beca PRIMARY KEY (id);


--
-- TOC entry 2033 (class 2606 OID 496617)
-- Name: pk_domicilio; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY domicilio
    ADD CONSTRAINT pk_domicilio PRIMARY KEY (nro_domicilio);


--
-- TOC entry 2027 (class 2606 OID 496292)
-- Name: pk_inscripcion_beca; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT pk_inscripcion_beca PRIMARY KEY (id_becario, fecha_presentacion);


--
-- TOC entry 2057 (class 2606 OID 502887)
-- Name: pk_opciones; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY opciones
    ADD CONSTRAINT pk_opciones PRIMARY KEY (id);


--
-- TOC entry 2029 (class 2606 OID 496552)
-- Name: pk_pais; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pais
    ADD CONSTRAINT pk_pais PRIMARY KEY (codigo_pais);


--
-- TOC entry 2055 (class 2606 OID 497365)
-- Name: pk_participacion_ext; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY participacion_ext
    ADD CONSTRAINT pk_participacion_ext PRIMARY KEY (id);


--
-- TOC entry 2053 (class 2606 OID 497349)
-- Name: pk_participacion_inv; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY participacion_inv
    ADD CONSTRAINT pk_participacion_inv PRIMARY KEY (id);


--
-- TOC entry 2031 (class 2606 OID 496575)
-- Name: pk_provincia; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY provincia
    ADD CONSTRAINT pk_provincia PRIMARY KEY (codigo_pcia);


--
-- TOC entry 2059 (class 2606 OID 512916)
-- Name: pk_proyecto_inv; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY proyecto_inv
    ADD CONSTRAINT pk_proyecto_inv PRIMARY KEY (id_pinv);


--
-- TOC entry 2072 (class 2606 OID 497203)
-- Name: fk_becario_beca_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_beca
    ADD CONSTRAINT fk_becario_beca_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2073 (class 2606 OID 497216)
-- Name: fk_becario_distincion_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_distincion
    ADD CONSTRAINT fk_becario_distincion_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2060 (class 2606 OID 497002)
-- Name: fk_becario_domicilio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario
    ADD CONSTRAINT fk_becario_domicilio FOREIGN KEY (nro_domicilio) REFERENCES domicilio(nro_domicilio) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2074 (class 2606 OID 497229)
-- Name: fk_becario_empleo_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_empleo
    ADD CONSTRAINT fk_becario_empleo_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2071 (class 2606 OID 497190)
-- Name: fk_becario_estudio_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_estudio
    ADD CONSTRAINT fk_becario_estudio_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2075 (class 2606 OID 512777)
-- Name: fk_becario_idioma_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT fk_becario_idioma_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2076 (class 2606 OID 512782)
-- Name: fk_becario_idioma_opciones_e; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT fk_becario_idioma_opciones_e FOREIGN KEY (escribe) REFERENCES opciones(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2077 (class 2606 OID 512787)
-- Name: fk_becario_idioma_opciones_h; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT fk_becario_idioma_opciones_h FOREIGN KEY (habla) REFERENCES opciones(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2078 (class 2606 OID 512792)
-- Name: fk_becario_idioma_opciones_l; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT fk_becario_idioma_opciones_l FOREIGN KEY (lee) REFERENCES opciones(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2079 (class 2606 OID 512797)
-- Name: fk_becario_idioma_opciones_t; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_idioma
    ADD CONSTRAINT fk_becario_idioma_opciones_t FOREIGN KEY (entiende) REFERENCES opciones(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2081 (class 2606 OID 512821)
-- Name: fk_becario_referencia_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_referencia
    ADD CONSTRAINT fk_becario_referencia_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2080 (class 2606 OID 497255)
-- Name: fk_becario_trabajo_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY becario_trabajo
    ADD CONSTRAINT fk_becario_trabajo_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2082 (class 2606 OID 512826)
-- Name: fk_director_beca_categ_invest; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY director_beca
    ADD CONSTRAINT fk_director_beca_categ_invest FOREIGN KEY (cat_invest) REFERENCES categoria_invest(cod_cati);


--
-- TOC entry 2083 (class 2606 OID 512831)
-- Name: fk_director_beca_conicet; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY director_beca
    ADD CONSTRAINT fk_director_beca_conicet FOREIGN KEY (cat_conicet) REFERENCES categoria_conicet(id_categ);


--
-- TOC entry 2084 (class 2606 OID 512836)
-- Name: fk_director_beca_domicilio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY director_beca
    ADD CONSTRAINT fk_director_beca_domicilio FOREIGN KEY (nro_domicilio) REFERENCES domicilio(nro_domicilio);


--
-- TOC entry 2069 (class 2606 OID 497391)
-- Name: fk_domicilio_pais; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY domicilio
    ADD CONSTRAINT fk_domicilio_pais FOREIGN KEY (cod_pais) REFERENCES pais(codigo_pais);


--
-- TOC entry 2070 (class 2606 OID 497396)
-- Name: fk_domicilio_provincia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY domicilio
    ADD CONSTRAINT fk_domicilio_provincia FOREIGN KEY (cod_provincia) REFERENCES provincia(codigo_pcia);


--
-- TOC entry 2061 (class 2606 OID 513513)
-- Name: fk_inscripcion_beca; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_beca FOREIGN KEY (id_becario) REFERENCES becario(id_becario);


--
-- TOC entry 2062 (class 2606 OID 513518)
-- Name: fk_inscripcion_carrera; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_carrera FOREIGN KEY (id_carrera) REFERENCES carrera_inscripcion_beca(id);


--
-- TOC entry 2063 (class 2606 OID 513523)
-- Name: fk_inscripcion_categ; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_categ FOREIGN KEY (categ_beca) REFERENCES categoria_beca(id_categ);


--
-- TOC entry 2064 (class 2606 OID 513528)
-- Name: fk_inscripcion_codirector; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_codirector FOREIGN KEY (id_codirector) REFERENCES director_beca(id);


--
-- TOC entry 2065 (class 2606 OID 513533)
-- Name: fk_inscripcion_director; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_director FOREIGN KEY (id_director) REFERENCES director_beca(id);


--
-- TOC entry 2066 (class 2606 OID 513538)
-- Name: fk_inscripcion_domicilio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_domicilio FOREIGN KEY (nro_domicilio_trabajo_beca) REFERENCES domicilio(nro_domicilio);


--
-- TOC entry 2067 (class 2606 OID 513543)
-- Name: fk_inscripcion_proyecto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY inscripcion_beca
    ADD CONSTRAINT fk_inscripcion_proyecto FOREIGN KEY (id_proyecto) REFERENCES proyecto_inv(id_pinv);


--
-- TOC entry 2086 (class 2606 OID 497383)
-- Name: fk_participacion_ext_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY participacion_ext
    ADD CONSTRAINT fk_participacion_ext_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2085 (class 2606 OID 497378)
-- Name: fk_participacion_inv_inscripcion; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY participacion_inv
    ADD CONSTRAINT fk_participacion_inv_inscripcion FOREIGN KEY (id_becario, fecha) REFERENCES inscripcion_beca(id_becario, fecha_presentacion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2068 (class 2606 OID 496576)
-- Name: fk_provincia_pais; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY provincia
    ADD CONSTRAINT fk_provincia_pais FOREIGN KEY (cod_pais) REFERENCES pais(codigo_pais);


--
-- TOC entry 2129 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2018-08-24 08:53:33

--
-- PostgreSQL database dump complete
--

