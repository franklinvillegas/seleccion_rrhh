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
    
    public function llenarCombo(){
        $select = Evaluacion::select('id', 'Evaluacion')->where('activo',true)->get();
        return $select;
    }
   
    public function listar(){
        $lista = Evaluacion::select()->with([
            'docente:id,id_per', 'docente.persona:id,apellido_pat,apellido_mat,nombres','pregunta'
            ]);
        return $lista->get();
    }

    public function crear(Request $request){
        $nuevo = new Evaluacion($request->all());
        $nuevo->save();
        return response()->json(['message' => 'Registro creado correctamente', 'identificador' => $nuevo->id]);
    }

    public function modificar(Request $request, $id){
        $editado = Evaluacion::findOrFail($id);
        $editado->update($request->all());
        return response()->json(['message' => 'Registro actualizado correctamente']);
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
