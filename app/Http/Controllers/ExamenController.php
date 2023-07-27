<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examen;
use App\Models\Persona;
use App\Models\Evaluacion;
use Illuminate\Support\Facades\DB;


class ExamenController extends Controller
{
    
    public function generear($id)
    {   
        return 'hola';
        $evaluacion = DB::select("select e.id_persona_convocatoria, e.resultado_cv, e.total_ponderado
        FROM bd_seleccion_ra.evaluacion e INNER JOIN bd_seleccion_ra.persona_convocatoria pc on e.id_persona_convocatoria = pc.id
                                                                            INNER JOIN bd_seleccion_ra.persona per on pc.id_persona = per.id
            WHERE e.estado_cv = 1 and pc.id_convocatoria =".$request."ORDER BY per.apellido_pat");
        return $evaluacion;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reporte(Request $request)
    {
        $matricula = Matricula::where('id_sec',$request->seccion['id_seccion'])->with(['estudiante:id,id_per','estudiante.persona:id,apellido_pat,apellido_mat,nombres'])->get();
        $criterios = Criterio::where('id_act',$request->seccion['id_competencia'])->get();
        foreach ($matricula as $keyM => $valueM) {
            $arrayCriterio=array();
            foreach ($criterios as $keyC => $valueC) {
                $notaCriterio = Notas::where('id_crit',$valueC->id)->where('id_matric',$valueM->id)->first();
                if ($notaCriterio) {
                    $criterio = new ArrarObject();
                    return $criterio;
                    $criterio->nota=$notaCriterio->nota;
                    return $criterio;
                    $criterio->id=$notaCriterio->id_crit;
                    return $criterio;
                    array_push($arrayCriterio,$criterio);
                }
                
            }
            $valueM->criterio=$arrayCriterio;   
        }   
        return response()->json(['message' => 'Se Genero correctamente la asistencia', 'lista' => $matricula,'criterio' => $criterios]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modificar($id,Request $request)
    {
        $editadoAsistencia = Notas::findOrFail($id);        
        $editadoAsistencia->update($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
