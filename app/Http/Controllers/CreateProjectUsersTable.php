<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectUsersTable extends Migration
{
public function up()
{
Schema::connection('n01534088')->create('project_users', function (Blueprint $table) {
$table->id('user_id')->unique();
$table->string('name');
$table->string('email')->unique();
$table->string('password');
$table->timestamps();
});
}

public function down()
{
Schema::connection('n01534088')->dropIfExists('project_users');
}
}