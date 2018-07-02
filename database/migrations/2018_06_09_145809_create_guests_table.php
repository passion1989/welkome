<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dni', 15)->unique();
            $table->string('name', 150);
            $table->string('last_name', 150);
            
            $table->bigInteger('responsible_of')->default(0);
            
            $table->integer('identification_type_id')->unsigned();
            $table->foreign('identification_type_id')->references('id')
                ->on('identification_types')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')
                ->on('companies')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('guests');
    }
}
