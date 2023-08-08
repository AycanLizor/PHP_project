<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id', 5);
            $table->unsignedBigInteger('user_id');
            $table->string('user_name', 50);
            $table->string('type', 50);
            $table->integer('quantity');
            $table->timestamps();
            $table->foreign('user_id')->references('user_id')->on('project_users');
            $table->foreign('inventory_id')->references('inventory_id')->on('project_inventory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_transactions');
    }
}