<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaConvocatoria extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'persona_convocatoria';
    protected $fillable = [
        'id_persona',
        'id_convocatoria',
        'id_sede_provincial',
    ];
    public function user(){
        return $this->hasOne(User::class, 'id_persona','id');
    }
    
    
}
