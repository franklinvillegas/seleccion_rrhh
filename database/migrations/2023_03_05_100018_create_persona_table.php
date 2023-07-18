<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 250);
            $table->string('apellido_pat', 50);
            $table->string('apellido_mat', 50);
            $table->string('sexo', 50);
            $table->string('telefono2', 50)->nullable();
            $table->date('fecha_nac')->nullable();
            $table->string('documento')->nullable();
            $table->string('direccion',225)->nullable();
            $table->timestamps();
           
        });
        DB::table('persona')->insert(array('nombres'=>'admin', 'apellido_pat'=>'admin', 'apellido_mat'=>'admin', 'sexo'=>'-'));
        /*docentes*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
