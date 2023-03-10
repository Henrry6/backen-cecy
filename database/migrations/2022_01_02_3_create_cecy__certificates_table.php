<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCecyCertificatesTable extends Migration
{
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->create('certificates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->morphs('certificateable');

            $table->foreignId('state_id')
                ->comment('Estado del certificado: Firmado,con código, generado, en proceso, sin firma')
                ->constrained('cecy.catalogues');

            $table->string('code')
                ->comment('Código del certificado');

            $table->Date('issued_at')
                ->comment('Fecha de emisión del certificado');
        });
    }

    public function down()
    {
        Schema::connection(env('DB_CONNECTION_CECY'))->dropIfExists('certificates');
    }
}
