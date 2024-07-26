<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpsalesTable extends Migration
{
    public function up()
    {
        Schema::create('upsales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->onDelete('cascade');
            $table->string('produit');
            $table->decimal('prix', 8, 2);
            $table->integer('quantite');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('upsales');
    }
}
