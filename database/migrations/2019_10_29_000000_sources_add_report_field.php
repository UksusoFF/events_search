<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SourcesAddReportField extends Migration
{
    public function up()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->string('report')->default('none');
        });
    }

    public function down()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->dropColumn('report');
        });
    }
}
