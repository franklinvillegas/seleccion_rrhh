<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Capacitacion;
use App\Models\PersonaConvocatoria;
use Illuminate\Support\Facades\DB;


class CapacitacionController extends Controller
{
    //
    public function generar(Request $request)
    {   
        switch ($request->id_user) {
            case '1': //499
                $miArray = [59,60,65,69,73,74,62,77,80,83,61,66,76,67,68,70,78,85,64,71,72,79,84,58,75,81,82,63];
                break;
            case '45': //499
                $miArray = [63,59,60,65,69,73,74];
                break;
            
            case '34':
                $miArray = [62,77,80,83];
                break;
            case '38':
                $miArray = [61,66,76];
                break;
            case '40':
                $miArray = [67,68,70,78,85];
                break;
            case '44':
                $miArray = [64,71,72,79,84];
                break;
            case '54':
                $miArray = [58,75,81,82];
                break;
        }
        $inClause = implode(',', $miArray); 
        $examen = DB::select("select c.id, sr.nombre_sede as region,sp.nombre_sede as provincia,
        concat(p.apellido_pat,' ',p.apellido_mat,' ',p.nombres) as datos, p.documento,
        c.cap_c1,c.cap_c2,c.cap_c3,c.cap_c4,c.asiste_d1,c.asiste_d2,c.asiste_d3,c.asiste_d4,c.asiste_d5,c.estado_capa1,
        c.cap_c5,c.estado_capa2,c.suma_total_minedu,
        c.ponderado,c.estado_capa_total,c.observacion
     from capacitacion c 
            INNER JOIN persona_convocatoria pc on c.id_persona_convocatoria = pc.id 
            inner join persona p on pc.id_persona=p.id 	
            INNER JOIN sede_provincial sp on pc.id_sede_provincial=sp.id 
            INNER JOIN sede_regional sr on sp.id_sede_regional=sr.id 
            where pc.id_convocatoria = " . $request->convocatoria . " and c.aula= ". $request->aula ." and sr.id IN (". $inClause .")");
        return $examen;

    }
    public function aulas($cargo)
    {   
        $aulas = Capacitacion::select('capacitacion.aula')
        ->join('persona_convocatoria as pc', 'capacitacion.id_persona_convocatoria', '=', 'pc.id')
        ->where('pc.id_convocatoria', $cargo)
        ->groupBy('capacitacion.aula')
        ->get();

        return $aulas;
    }
    public function guardarSN(Request $request)
    {   
        foreach ($request->all() as $key => $value) {
            $editado = Capacitacion::findOrFail($value['id']);
           
            $editado->update([
            'cap_c1'=>$value['cap_c1'],
             'cap_c2'=>$value['cap_c2'],
             'cap_c3'=>$value['cap_c3'],
             'suma_total1'=>$value['cap_c3'] + $value['cap_c2'],
             'asiste_d1'=>$value['asiste_d1'],
             'asiste_d2'=>$value['asiste_d2'],
             'asiste_d3'=>$value['asiste_d3'],
             'asiste_d4'=>$value['asiste_d4'],
             'asiste_d5'=>$value['asiste_d5'],
             'cap_c4'=>$value['cap_c4'],
             'cap_c5'=>$value['cap_c5'],
             'suma_total2'=>$value['cap_c5'] + $value['cap_c4'],
             'suma_total_minedu'=>$value['cap_c3'] + $value['cap_c2'],
             'ponderado'=>((($value['cap_c1'] + $value['cap_c2'] + $value['cap_c3']) * 0.7)*0.4) + ((($value['cap_c4'] + $value['cap_c5'])*0.3) *0.6666),
            ]);

        }
        
        return response()->json(['message' => 'Guardado correctamente']);
    }
    public function guardarMN(Request $request)
    {   
        foreach ($request->all() as $key => $value) {
            $editado = Capacitacion::findOrFail($value['id']);
           
            $editado->update([
            'cap_c1'=>$value['cap_c1'],
             'cap_c2'=>$value['cap_c2'],
             'cap_c3'=>$value['cap_c3'],
             'suma_total1'=>$value['cap_c3'] + $value['cap_c2'],
             'asiste_d1'=>$value['asiste_d1'],
             'asiste_d2'=>$value['asiste_d2'],
             'asiste_d3'=>$value['asiste_d3'],
             'asiste_d4'=>$value['asiste_d4'],
             'asiste_d5'=>$value['asiste_d5'],
             'cap_c4'=>$value['cap_c4'],
             'cap_c5'=>$value['cap_c5'],
             'suma_total2'=>$value['cap_c5'] + $value['cap_c4'],
             'suma_total_minedu'=>$value['cap_c3'] + $value['cap_c2'],
             'ponderado'=>((($value['cap_c1'] + $value['cap_c2'] + $value['cap_c3']) * 0.7)*0.4) + ((($value['cap_c4'] + $value['cap_c5'])*0.3) *0.6666),
            ]);

        }
        
        return response()->json(['message' => 'Guardado correctamente']);
    }
    public function guardarCR(Request $request)
    {   
        foreach ($request->all() as $key => $value) {
            $editado = Capacitacion::findOrFail($value['id']);
           
            $editado->update([
            'cap_c1'=>$value['cap_c1'],
             'cap_c2'=>$value['cap_c2'],
             'cap_c3'=>$value['cap_c3'],
             'suma_total1'=>$value['cap_c3'] + $value['cap_c2'] + $value['cap_c1'],
             'asiste_d1'=>$value['asiste_d1'],
             'asiste_d2'=>$value['asiste_d2'],
             'asiste_d3'=>$value['asiste_d3'],
             'asiste_d4'=>$value['asiste_d4'],
             'asiste_d5'=>$value['asiste_d5'],
             'cap_c4'=>$value['cap_c4'],
             'cap_c5'=>$value['cap_c5'],
             'suma_total2'=>$value['cap_c5'] + $value['cap_c4'],
             'suma_total_minedu'=>$value['cap_c3'] + $value['cap_c2'],
             'ponderado'=>(($value['cap_c1'] + $value['cap_c2'] + $value['cap_c3']) * 0.7) + (($value['cap_c4'] + $value['cap_c5'])*0.3),
            ]);

        }
        
        return response()->json(['message' => 'Guardado correctamente']);
    }
    public function guardarTAP(Request $request)
    {   
        foreach ($request->all() as $key => $value) {
            $editado = Capacitacion::findOrFail($value['id']);
           
            $editado->update([
            'cap_c1'=>$value['cap_c1'],
             'cap_c2'=>$value['cap_c2'],
             'cap_c3'=>$value['cap_c3'],
             'cap_c4'=>$value['cap_c4'],
             'ponderado'=>(($value['cap_c1'] * 4) * 0.1) + (($value['cap_c2'] * 4)* 0.2) + ($value['cap_c3'] * 0.4) + ($value['cap_c4'] * 0.3),
             'asiste_d1'=>$value['asiste_d1'],
             'asiste_d2'=>$value['asiste_d2']
            ]);

        }
        
        return response()->json(['message' => 'Guardado correctamente']);
    }
}
