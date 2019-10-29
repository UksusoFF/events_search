<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SourcesAddTagsField extends Migration
{
    public function up()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->longText('tags')->nullable();
        });

        if (Schema::hasTable('tags')) {
            DB::table('sources')->orderBy('id')->chunk(10, function($sources) {
                foreach ($sources as $source) {
                    DB::table('sources')->where('id', $source->id)->update([
                        'tags' => json_encode(DB::table('tags')->where('source_id', $source->id)->pluck('name'), JSON_UNESCAPED_UNICODE),
                    ]);
                }
            });
            Schema::dropIfExists('tags');
        }
    }

    public function down()
    {
        Schema::table('sources', function(Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
}
