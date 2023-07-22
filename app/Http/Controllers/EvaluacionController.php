<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Evaluacion;
use App\Models\PersonaConvocatoria;
use Illuminate\Support\Facades\DB;


class EvaluacionController extends Controller
{
    //
     //funciones generales de mantenimiento
     public function ver($dni,$convocatoria){

        $persona = Persona::select('id','nombres','apellido_pat','apellido_mat','documento' )->where('documento',$dni)->get();
        $proceso = PersonaConvocatoria::select('id','id_persona','id_convocatoria','id_sede_provincial')
        ->where('id_persona',$persona[0]['id'])
        ->where('id_convocatoria','2')
        ->get();
        

        $duplicado = Evaluacion::where('id_persona_convocatoria',$proceso[0]['id'])->first();
        if ($duplicado) {
            $resultado = Evaluacion::select('num_registro')->where('id_persona_convocatoria',$proceso[0]['id'])->get();
            return response()->json(['message' => 'Ya esta registrado', 'persona' => $persona, 'proceso'=>$proceso,'num_registro'=>$resultado[0]['num_registro'],'flag'=>0]);
        }
        else {
            $resultado = DB::select("select MAX(num_registro) as max_num_registro
            from persona_convocatoria pc
            INNER JOIN evaluacion e ON pc.id = e.id_persona_convocatoria
            WHERE id_convocatoria = ".$convocatoria." and id_sede_provincial = ".$proceso[0]['id_sede_provincial']);    
            $evaluacion = Evaluacion::create(['id_persona_convocatoria' => $proceso[0]['id'], 'num_registro' => $resultado[0]->max_num_registro+1,]);
            return response()->json(['message' => 'Se realizo el registro', 'persona' => $persona, 'proceso'=>$proceso,'numero'=>$resultado[0]->max_num_registro+1,'flag'=>1]);
    }        
    }
    
    public function evaluar($dni,$convocatoria){
        $proceso = DB::select("select e.id as id,pc.id as id_persona_convocatoria,p.documento,CONCAT(p.apellido_pat , ' ' , p.apellido_mat , ' ' , p.nombres) as datos,e.num_registro,rnp,office,certificado_lengua,
        profesion,grado,criterio_cv_1,criterio_cv_2,criterio_cv_3,criterio_cv_4,criterio_cv_5,criterio_cv_6,estado_cv, e.updated_at
        from evaluacion e INNER JOIN persona_convocatoria pc on e.id_persona_convocatoria= pc.id
                                            INNER JOIN persona p ON pc.id_persona=p.id 
                                                                WHERE pc.id_sede_provincial=1 and id_convocatoria=" .$convocatoria. " and documento=" .$dni);
        
        return response()->json(['message' => 'Se realizo el registro', 'data' => $proceso]);
        ;
    }
   
    public function listar(){
        $lista = Evaluacion::select()->with([
            'docente:id,id_per', 'docente.persona:id,apellido_pat,apellido_mat,nombres','pregunta'
            ]);
        return $lista->get();
    }

    public function guardar(Request $request){
        $guardar = Evaluacion::findOrFail($request->id);        
        $guardar->update($request->all());
        return response()->json(['message' => 'Guardado correctamente', 'identificador' => $guardar->id]);
    }

    public function mostrar($id){
        $mostrar = DB::select("select e.id,pc.id,p.documento,p.apellido_pat,p.apellido_mat,p.nombres,e.num_registro,sp.nombre_sede as provincia, sr.nombre_sede as region,e.created_at
        from evaluacion e INNER JOIN persona_convocatoria pc on e.id_persona_convocatoria= pc.id
                                            INNER JOIN sede_provincial sp on pc.id_sede_provincial=sp.id
                                            INNER JOIN sede_regional sr on sp.id_sede_regional=sr.id
                                            INNER JOIN persona p ON pc.id_persona=p.id 
                                                                WHERE pc.id_sede_provincial=". 1 ." and id_convocatoria=".$id);
        return $mostrar;
    }
    public function mostrarReporte($id){
        $mostrar = DB::select("select e.id as id,pc.id as id_persona_convocatoria,p.documento,CONCAT(p.apellido_pat , ' ' , p.apellido_mat , ' ' , p.nombres) as datos,e.num_registro,rnp,office,certificado_lengua,
        profesion,grado,criterio_cv_1,criterio_cv_2,criterio_cv_3,criterio_cv_4,criterio_cv_5,criterio_cv_6,estado_cv, e.created_at,sp.nombre_sede as provincia, sr.nombre_sede as region
        from evaluacion e INNER JOIN persona_convocatoria pc on e.id_persona_convocatoria= pc.id
            INNER JOIN sede_provincial sp on pc.id_sede_provincial=sp.id
            INNER JOIN sede_regional sr on sp.id_sede_regional=sr.id
            INNER JOIN persona p ON pc.id_persona=p.id 
                WHERE pc.id_sede_provincial=1 and id_convocatoria=" .$id);
        return $mostrar;
    }

    public function eliminar($id){
        $eliminado = Evaluacion::findOrFail($id);
        $eliminado->delete(); 
        return response()->json(['message' => 'Se Elimino correctamente']);

    }

    public function activar($id){
        $activado = Evaluacion::findOrFail($id);
        $activado->activo = true;
        $activado->save(); 
        return response()->json(['message' => 'Se activó correctamente']);
    }

    public function getDateTimeActual(){
        $fechaActual = date('Y-m-d');
        $horaActual = date('H:i:s');
        return response()->json(compact('fechaActual','horaActual'));
    }

}
