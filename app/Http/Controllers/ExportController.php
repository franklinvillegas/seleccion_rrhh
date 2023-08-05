<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HelperServices;


use App\Exports\GeneralExport;


class ExportController extends Controller
{
    
    public function exportUsuarios(Request $request){
        $query = "
        select 
        u.nombres,
        u.apellidos,
        u.email,
        o.nombre as ocupacion,
        u.puesto_actual,
        u.ult_visita,
        case u.tipo_usuario when 1 then 'Administrador' when 2 then 'Gestor' else 'Usuario' end as activo,
        case u.activo when true then 'Activo' else 'Inactivo' end as activo,
        u.created_at as f_creacion
        from users u
        left join t_ocupaciones o on o.id = u.ocupacion_id 
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "u.activo = ". request('activo'));
        if($request->tipo){
            if($request->tipo == 9)
                array_push($whereAnd, "u.es_admin = false");
            else
                array_push($whereAnd, "u.tipo_usuario = ". $request->tipo);
        }
        if($request->ocupacion)
            array_push($whereAnd, "u.ocupacion_id = ". $request->ocupacion);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "u.created_at between '".$request->fechaIni."' and '".$request->fechaFin);
        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);

        $valores = array("titulo"=>"Usuarios", "nombre_hoja"=>"usuarios", "nom_archivo"=>"Usuarios_".date('Y_m_d'));
        $cabecera = ['Nombres','Apellidos','Email','Ocupacion','Puesto actual','Última visita','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportEtiquetas(Request $request){
        $query = "
        select 
        t1.nombre,
        t1.url,
        case t1.nivel when 1 then 'Rubro' when 2 then 'Tema' when 3 then'Subtema' end,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_etiquetas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->nivel)
            array_push($whereAnd, "t1.nivel = ". $request->nivel);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);

        $valores = array("titulo"=>"Etiquetas", "nombre_hoja"=>"etiqueta", "nom_archivo"=>"Etiquetas_".date('Y_m_d'));
        $cabecera = ['Nombre','Clave','Nivel','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportContenidos(Request $request){
        $query = "
        select
        concat(u.nombres,' ',u.apellidos) as usuario,
        t1.titulo,
        case t1.tipo when 1 then 'Pregunta' when 2 then 'Publicación' when 3 then 'Respuesta' when 4 then 'Comentario' end as tipo,
        t1.me_gusta,
        t1.no_gusta,
        t1.denunciado,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_preguntas t1
        left join users u on u.id = t1.user_id 
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->tipo)
            array_push($whereAnd, "t1.tipo = ". $request->tipo);
        if($request->moderar)
            array_push($whereAnd, "t1.denunciado = ". $request->moderar);
        if($request->es_peligroso)
            array_push($whereAnd, "t1.es_peligroso = ". $request->es_peligroso);
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Contenido", "nombre_hoja"=>"contenido", "nom_archivo"=>"Contenido_".date('Y_m_d'));
        $cabecera = ['Usuario','Título','Tipo','Me gustas','No me gustas','Moderado','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportPalabrasVetadas(Request $request){
        $query = "
        select
        t1.palabra,
        t1.descripcion,
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_palabras_betadas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Palabras Vetadas", "nombre_hoja"=>"palabras", "nom_archivo"=>"PalabrasVetadas_".date('Y_m_d'));
        $cabecera = ['Palabra','Descripción','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }

    public function exportAyudas(Request $request){
        $query = "
        select
        case t1.tipo when 1 then 'Inicio' when 2 then 'Pregunta' when 3 then 'Publicación' end as tipo,
        t1.titulo,
        t1.subtitulo,
        t1.descripcion,
        t1.orden,

        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_ayudas t1
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if(request()->has('tipo'))
            array_push($whereAnd, "t1.tipo = ". request('tipo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $query .=" order by t1.tipo, t1.orden;";
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Ayuda", "nombre_hoja"=>"ayuda", "nom_archivo"=>"Ayuda_".date('Y_m_d'));
        $cabecera = ['Tipo','Título','Subtitulo','Descripción','Orden','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }
    public function exportMensajes(Request $request){
        $query = "
        select
        concat(u1.nombres,' ',u1.apellidos) as emisor,
        concat(u2.nombres,' ',u2.apellidos) as receptor,
        t1.mensaje,
        
        case t1.activo when true then 'Activo' else 'Inactivo' end as activo,
        t1.created_at as f_creacion
        from t_bandejas t1
        left join users u1 on u1.id = t1.usuario_1
        left join users u2 on u2.id = t1.usuario_2
        ";
        $whereAnd = [];
        if(request()->has('activo'))
            array_push($whereAnd, "t1.activo = ". request('activo'));
        if($request->fechaIni && $request->fechaFin)
            array_push($whereAnd, "t1.created_at between '".$request->fechaIni."' and '".$request->fechaFin."'");

        if (count($whereAnd)){
            $whereAnd = implode(' and ', $whereAnd);
            $query .= " where " . $whereAnd;
        }
        $query .=" order by t1.id desc;";
        $resultado = DB::select($query);
        $valores = array("titulo"=>"Mensajes", "nombre_hoja"=>"mesnaje", "nom_archivo"=>"Mensajes_".date('Y_m_d'));
        $cabecera = ['Emisor','Receptor','Mensaje','Estado','F.Registro',];
        return new GeneralExport($resultado, $valores, $cabecera);
    }
    public function reporteCV(Request $request){
        $convocatoria = $request->cargo;
        switch ($convocatoria) {
            case 1:
                $query = "select
                @row_number := @row_number + 1 AS `index`,
                provincia AS sede_provincial,
                region AS sede_regional,
                documento AS dni,
                apellidos_y_nombres,
                fecha_nac,
                edad,
                profesion,
                persona_grado,
                num_registro AS registro_de_cv,
                rnp,
                eva_profesion AS formacion_academica_minima,
                office,
                criterio_cv_1 AS experiencia_minima,
                CUMPLE_PERFIL_SOLICITADO,
                grado AS formacion_academica,
                criterio_cv_2 AS experiencia_laboral_1,
                criterio_cv_3 AS experiencia_laboral_2,
                certificado_lengua AS manejo_lenguas_originarias,
                CASE
                    WHEN (edad < 30 OR edad > 55) THEN 'Observado'
                    ELSE ''
                END AS rango_edad,
                CASE
                    WHEN (rnp = 'SI' AND eva_profesion = 'SI' AND office = 'SI' AND criterio_cv_1 = 'SI') THEN 'APROBADO'
                    ELSE 'DESAPROBADO'
                END AS estado,
                CASE
                    WHEN estado = ESTADO2 THEN 'OK'
                    ELSE 'ERROR'
                END AS VALIDACION_DE_ESTADO,
                CASE
                    WHEN estado = 'APROBADO' THEN (grado * 5 * 0.35) + (criterio_cv_2 * 4 * 0.4) + (criterio_cv_3 * 4 * 0.25)
                    ELSE NULL
                END AS puntaje_ponderado,
                fecha_evaluacion
            FROM (
                SELECT
                    e.id AS id,
                    pc.id AS id_persona_convocatoria,
                    p.documento,
                    CONCAT(p.apellido_pat, ' ', p.apellido_mat, ' ', p.nombres) AS apellidos_y_nombres,
                    p.fecha_nac,
                    p.profesion,
                    p.grado AS persona_grado,
                    e.grado,
                    e.profesion AS eva_profesion,
                    e.num_registro,
                    e.rnp,
                    e.office,
                    e.criterio_cv_1,
                    e.certificado_lengua,
                    e.criterio_cv_2,
                    e.criterio_cv_3,
                    e.criterio_cv_4,
                    e.criterio_cv_5,
                    e.criterio_cv_6,
                    e.estado_cv,
                    e.created_at,
                    sp.nombre_sede AS provincia,
                    sr.nombre_sede AS region,
                    e.updated_at AS fecha_evaluacion,
                    TIMESTAMPDIFF(YEAR, p.fecha_nac, CURDATE()) AS edad,
                    CASE
                        WHEN e.rnp = 'SI' AND e.profesion = 'SI' AND e.office = 'SI' AND e.criterio_cv_1 = 'SI' THEN 'SI'
                        ELSE 'NO'
                    END AS CUMPLE_PERFIL_SOLICITADO,
                    CASE
                        WHEN (e.rnp = 'SI' AND e.profesion = 'SI' AND e.office = 'SI' AND e.criterio_cv_1 = 'SI') THEN 'APROBADO'
                        ELSE 'DESAPROBADO'
                    END AS estado,
                    CASE
                        WHEN (e.grado >= 1 AND (e.criterio_cv_2 >= 2 OR e.criterio_cv_3 >= 2)) THEN 'APROBADO'
                        ELSE 'DESAPROBADO'
                    END AS ESTADO2
                FROM
                    evaluacion e
                INNER JOIN
                    persona_convocatoria pc ON e.id_persona_convocatoria = pc.id
                INNER JOIN
                    sede_provincial sp ON pc.id_sede_provincial = sp.id
                INNER JOIN
                    sede_regional sr ON sp.id_sede_regional = sr.id
                INNER JOIN
                    persona p ON pc.id_persona = p.id
                WHERE
                    pc.id_sede_provincial = 1 AND id_convocatoria = 1
            ) AS subquery, (SELECT @row_number := 0) AS t;";
                $resultado = DB::select($query);
                $valores = array("titulo"=>"REPORTE ED EVALUACION DE CV", "nombre_hoja"=>"Ev- CV", "nom_archivo"=>"Reporte_CV_Evaluados_SN_ENLA2023".date('Y_m_d'));
                $cabecera = ['N°','SEDE REGIONAL','SEDE PROVINCIAL','DNI','APELLIDOS Y NOMBRES','FECHA DE NACIMIENTO','EDAD','PROFESIÓN','GRADO','REGISTRO CV','TIENE RNP',
                'FORMACIÓN ACADÉMICA MÍNIMA','MANEJO DE OFFICE','EXPERIENCIA MÍNIMA','CUMPLE CON EL PERFIL SOLICITACO','FORMACIÓN ACADEMICA','EXPERIENCIA LABORAL 1','EXPERIENCIA LABORAL 2',
                'MANEJO DE LENGUAS ORIGINARIAS','RANGO DE EDAD','ESTADO','VALIDACIÓN DE ESTADO','PUNTAJE PONDERADO','FECHA Y HORA EVALUACION',];
                return new GeneralExport($resultado, $valores, $cabecera);
                break;
            case 2:
                $query = "select
                @row_number := @row_number + 1 AS `index`,
                provincia AS sede_provincial,
                region AS sede_regional,
                documento AS dni,
                apellidos_y_nombres,
                fecha_nac,
                edad,
                profesion,
                persona_grado,
                num_registro AS registro_de_cv,
                rnp,
                eva_profesion AS formacion_academica_minima,
                office,
                criterio_cv_1 AS experiencia_minima,
                CUMPLE_PERFIL_SOLICITADO,
                grado AS formacion_academica,
                criterio_cv_2 AS experiencia_laboral_1,
                criterio_cv_3 AS experiencia_laboral_2,
                CASE
                    WHEN NOT (fecha_nac >= '2003-08-03' AND fecha_nac <= '1957-08-04') THEN 'Observado'
                    ELSE ''
                END AS rango_edad,
                CASE
                    WHEN (rnp = 'SI' AND profesion = 'SI' AND office = 'SI' AND criterio_cv_1 = 'SI') THEN 'APROBADO'
                    ELSE 'DESAPROBADO'
                END AS estado,
                CASE
                    WHEN estado = ESTADO2 THEN 'OK'
                    ELSE 'ERROR'
                END AS VALIDACION_DE_ESTADO,
                CASE
                    WHEN estado = 'APROBADO' THEN (grado * 5 * 0.35) + (criterio_cv_2 * 5 * 0.4) + (criterio_cv_3 * 4 * 0.25)
                    ELSE NULL
                END AS puntaje_ponderado,
                fecha_evaluacion
            
            FROM (
                SELECT
                    e.id AS id,
                    pc.id AS id_persona_convocatoria,
                    p.documento,
                    CONCAT(p.apellido_pat, ' ', p.apellido_mat, ' ', p.nombres) AS apellidos_y_nombres,
                    p.fecha_nac,
                    p.profesion,
                    p.grado AS persona_grado,
                    e.grado,
                    e.profesion AS eva_profesion,
                    e.num_registro,
                    e.rnp,
                    e.office,
                    e.criterio_cv_1,
                    e.certificado_lengua,
                    e.criterio_cv_2,
                    e.criterio_cv_3,
                    e.criterio_cv_4,
                    e.criterio_cv_5,
                    e.criterio_cv_6,
                    e.estado_cv,
                    e.created_at,
                    sp.nombre_sede AS provincia,
                    sr.nombre_sede AS region,
                    e.updated_at AS fecha_evaluacion,
                    TIMESTAMPDIFF(YEAR, p.fecha_nac, CURDATE()) AS edad,
                    CASE
                        WHEN e.rnp = 'SI' AND e.profesion = 'SI' AND e.office = 'SI' AND e.criterio_cv_1 = 'SI' THEN 'SI'
                        ELSE 'NO'
                    END AS CUMPLE_PERFIL_SOLICITADO,
                    CASE
                        WHEN (e.rnp = 'SI' AND e.profesion = 'SI' AND e.office = 'SI' AND e.criterio_cv_1 = 'SI') THEN 'APROBADO'
                        ELSE 'DESAPROBADO'
                    END AS estado,
                    CASE
                        WHEN (e.grado >= 1 AND (e.criterio_cv_2 >= 2 OR e.criterio_cv_3 >= 2)) THEN 'APROBADO'
                        ELSE 'DESAPROBADO'
                    END AS ESTADO2
                FROM
                    evaluacion e
                INNER JOIN
                    persona_convocatoria pc ON e.id_persona_convocatoria = pc.id
                INNER JOIN
                    sede_provincial sp ON pc.id_sede_provincial = sp.id
                INNER JOIN
                    sede_regional sr ON sp.id_sede_regional = sr.id
                INNER JOIN
                    persona p ON pc.id_persona = p.id
                WHERE
                    pc.id_sede_provincial = 1 AND id_convocatoria = 2
            ) AS subquery, (SELECT @row_number := 0) AS t;";
                $resultado = DB::select($query);
                $valores = array("titulo"=>"REPORTE ED EVALUACION DE CV", "nombre_hoja"=>"Ev- CV", "nom_archivo"=>"Reporte_CV_Evaluados_mN_ENLA2023".date('Y_m_d'));
                $cabecera = ['N°','SEDE REGIONAL','SEDE PROVINCIAL','DNI','APELLIDOS Y NOMBRES','FECHA DE NACIMIENTO','EDAD','PROFESIÓN','GRADO','REGISTRO CV','TIENE RNP',
                'FORMACIÓN ACADÉMICA MÍNIMA','MANEJO DE OFFICE','EXPERIENCIA MÍNIMA','CUMPLE CON EL PERFIL SOLICITACO','FORMACIÓN ACADEMICA','EXPERIENCIA LABORAL 1','EXPERIENCIA LABORAL 2',
                'RANGO DE EDAD','ESTADO','VALIDACIÓN DE ESTADO','PUNTAJE PONDERADO','FECHA Y HORA EVALUACION',];
                return new GeneralExport($resultado, $valores, $cabecera);
                break;
            default:
                # code...
                break;
        }
        
    }
    public function examen(Request $request){
        $convocatoria = $request->cargo;

                $query = "select
                        ROW_NUMBER() OVER (ORDER BY e.id) AS `index`,
                        sp.nombre_sede AS nombre_sede_provincial,
                        sr.nombre_sede AS nombre_sede_regional,
                        p.documento,
                        CONCAT(p.apellido_pat, ' ', p.apellido_mat, ' ', p.nombres) AS apellidos_y_nombres,
                        e.total_fase1,
                        e.nota_examen,
                        e.ponderado1,
                        ROUND((e.nota_examen * 0.4) + (e.total_fase1 * 0.55) + (e.ponderado1 * 0.05), 2) AS fase2_ponderado,
                        CASE
                            WHEN ROUND((e.nota_examen * 0.4) + (e.total_fase1 * 0.55) + (e.ponderado1 * 0.05), 2) >= 9 THEN 1
                            ELSE 0
                        END AS estado,
                        CASE
                            WHEN ROUND((e.nota_examen * 0.4) + (e.total_fase1 * 0.55) + (e.ponderado1 * 0.05), 2) >= 9 THEN 'APROBADO'
                            ELSE 'DESAPROBADO'
                        END AS estado_letras
                    FROM
                        examen e
                    INNER JOIN
                        persona_convocatoria pc ON e.id_persona_convocatoria = pc.id
                    INNER JOIN
                        persona p ON pc.id_persona = p.id
                    INNER JOIN
                        sede_provincial sp ON pc.id_sede_provincial = sp.id
                    INNER JOIN
                        sede_regional sr ON sp.id_sede_regional = sr.id;";
                $resultado = DB::select($query);
                $valores = array("titulo"=>"REPORTE ED EVALUACION DE CV", "nombre_hoja"=>"Ev- CV", "nom_archivo"=>"Reporte_CV_Evaluados_SN_ENLA2023".date('Y_m_d'));
                $cabecera = ['N°','SEDE REGIONAL','SEDE PROVINCIAL','DNI','APELLIDOS Y NOMBRES','FECHA DE NACIMIENTO','EDAD','PROFESIÓN','GRADO','REGISTRO CV','TIENE RNP',
                'FORMACIÓN ACADÉMICA MÍNIMA','MANEJO DE OFFICE','EXPERIENCIA MÍNIMA','CUMPLE CON EL PERFIL SOLICITACO','FORMACIÓN ACADEMICA','EXPERIENCIA LABORAL 1','EXPERIENCIA LABORAL 2',
                'MANEJO DE LENGUAS ORIGINARIAS','RANGO DE EDAD','ESTADO','VALIDACIÓN DE ESTADO','PUNTAJE PONDERADO','FECHA Y HORA EVALUACION',];
                return new GeneralExport($resultado, $valores, $cabecera);    
    }


    public function prueba(){
        try {
            DB::beginTransaction();
            $rankings = \App\Models\Ranking::where('activo', true)->get();
            foreach($rankings as $row){
                HelperServices::obtenerPuntajeFinalUsuario($row);
            }
            $rankingOrdenado = \App\Models\Ranking::select('id','user_id','total','decil')->where('activo', true)->orderBy('total', 'asc')->get();
            $total = count($rankingOrdenado);
            $posicion = 0;
            foreach($rankingOrdenado as $row){
                $decil = floor((($posicion +1) * 10) / $total);
                $row->decil = $decil;
                $row->save();
                $posicion++;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }
        return true;

    }


}
