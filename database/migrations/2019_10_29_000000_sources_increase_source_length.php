<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SourcesIncreaseSourceLength extends Migration
{
    public function up()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->longText('source')->change();
        });
    }

    public function down()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->string('source')->change();
        });
    }
}
