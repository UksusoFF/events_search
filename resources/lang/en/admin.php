<?php

return [
    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'city_id' => 'City id',
            'token' => 'Token',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',

            //Belongs to many relations
            'roles' => 'Roles',
        ],
    ],

    'source' => [
        'title' => 'Sources',

        'actions' => [
            'index' => 'Sources',
            'create' => 'New Source',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'type' => 'Type',
            'user_id' => 'User id',
            'source' => 'Source',
            'map_id' => 'Map id',
            'map_title' => 'Map title',
            'map_desc' => 'Map desc',
            'map_image' => 'Map image',
            'map_date' => 'Map date',
        ],
    ],

    'event' => [
        'title' => 'Events',

        'actions' => [
            'index' => 'Events',
            'create' => 'New Event',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'vid' => 'Vid',
            'name' => 'Name',
            'description' => 'Description',
            'photo_200' => 'Photo 200',
            'start_date' => 'Start date',
            'ignored' => 'Ignored',
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];