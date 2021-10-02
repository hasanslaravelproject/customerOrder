<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kots', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('menu_category_id');
            $table->string('food_id');
            $table->string('quantity');
            $table->string('food_group');
            $table->string('group_quantity');
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
        Schema::dropIfExists('kots');
    }
}
