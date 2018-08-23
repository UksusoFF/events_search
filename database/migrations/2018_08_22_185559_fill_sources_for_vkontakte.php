<?php

use Illuminate\Database\Migrations\Migration;

class FillSourcesForVkontakte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('users')->get() as $user) {
            DB::table('sources')->insert([
                'type' => 'json',
                'user_id' => $user->id,
                'title' => 'Vkontakte Samara',
                'source' => 'https://api.vk.com/method/groups.search?' . http_build_query([
                    'q' => '*',
                    'type' => 'event',
                    'city_id' => '123',
                    'future' => '1',
                    'market' => '0',
                    'offset' => '0',
                    'count' => '1000',
                    'fields' => implode(',', ['start_date', 'description']),
                    'access_token' => env('VK_ACCESS_TOKEN'),
                    'v' => '5.71',
                ]),
                'map_items' => 'response.items',
                'map_id' => 'id',
                'map_title' => 'name',
                'map_desc' => 'description',
                'map_image' => 'photo_200',
                'map_date' => 'start_date',
                'map_date_format' => 'timestamp',
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
