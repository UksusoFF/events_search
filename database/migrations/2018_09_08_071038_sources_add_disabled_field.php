<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SourcesAddDisabledField extends Migration
{
    public function up()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->boolean('disabled')->default(false)->after('map_date_regex');
        });
    }

    public function down()
    {
        Schema::table('sources', function (Blueprint $table) {
            $table->dropColumn('disabled');
        });
    }
}
