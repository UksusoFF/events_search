<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsersAddPersonalSettings extends Migration
{
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->text('city_id')->nullable();
            $table->text('token')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('city_id');
            $table->dropColumn('token');
        });
    }
}