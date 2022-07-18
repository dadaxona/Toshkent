<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('umumiyps', function (Blueprint $table) {
            $table->id();
            $table->integer('hajm')->nullable();
            $table->integer('summa')->nullable();
            $table->integer('summa2')->nullable();
            $table->integer('foyda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('umumiyps');
    }
};
