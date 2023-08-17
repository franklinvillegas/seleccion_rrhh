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
        $examen = DB::select("select sr.nombre_sede as region,sp.nombre_sede as provincia,
        concat(p.apellido_pat,' ',p.apellido_mat,' ',p.nombres) as datos, p.documento,
        c.cap_c1,c.cap_c2,c.cap_c3,c.suma_total1,c.asiste_d1,c.asiste_d2,c.asiste_d3,c.asiste_d4,c.asiste_d5,c.suma_total1,c.estado_capa1,
        c.cap_c4,c.cap_c5,c.suma_total2,c.estado_capa2,
        c.ponderado,c.estado_capa_total,c.observacion
     from capacitacion c 
            INNER JOIN persona_convocatoria pc on c.id_persona_convocatoria = pc.id 
            inner join persona p on pc.id_persona=p.id 	
            INNER JOIN sede_provincial sp on pc.id_sede_provincial=sp.id 
            INNER JOIN sede_regional sr on sp.id_sede_regional=sr.id where pc.id_convocatoria = " . $request->convocatoria . " and c.aula= ". $request->aula);
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
    public function guardar(Request $request)
    {   
        return $request;
        $aulas = Capacitacion::select('capacitacion.aula')
        ->join('persona_convocatoria as pc', 'capacitacion.id_persona_convocatoria', '=', 'pc.id')
        ->where('pc.id_convocatoria', $cargo)
        ->groupBy('capacitacion.aula')
        ->get();

        return $aulas;
    }
}
