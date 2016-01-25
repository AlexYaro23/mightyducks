<?php

return [
    'main' => [
        'title' => 'Welcome to Dashboard'
    ],
    'teams' => [
        'view' => [
            'title' => 'Team Data',
            'panel_header' => 'Settings',
            'subtitle' => 'Team current fields',
        ],
        'edit' => [
            'title' => 'Edit Team',
            'subtitle' => 'Update needed fields',
            'name' => 'Name',
            'mls_id' => 'MLS Id',
            'link' => 'MLS URL',
        ],
        'name' => 'Name',
        'mls_id' => 'MLS Id',
        'link' => 'MLS URL',

    ],
    'users' => [
        'list' => [
            'title' => 'Users List',
            'panel_header' => 'Users',
            'subtitle' => 'User current fields',
        ],
        'edit' => [
            'title' => 'User',
            'subtitle' => 'Update needed fields',
        ],
        'name' => 'Name',
        'email' => 'Email',
        'provider_id' => 'Vk Id',
        'status' => 'Status',
        'screen_name' => 'Vk URL',
        'role_list' => 'Roles'
    ],
    'players' => [
        'list' => [
            'title' => 'Players List',
            'panel_header' => 'Players',
            'subtitle' => 'Player current fields',
        ],
        'edit' => [
            'title' => 'Player',
            'subtitle' => 'Update needed fields',
        ],
        'user_id' => 'User',
        'mls_id' => 'MLS Id',
        'team_id' => 'Team Id',
        'name' => 'Name',
        'date_of_birth' => 'Date of Birth',
        'position' => 'Position'
    ],
    'roles' => [
        'list' => [
            'title' => 'Roles List',
            'panel_header' => 'Roles',
            'subtitle' => 'Role current fields',
        ],
        'edit' => [
            'title' => 'Roles',
            'subtitle' => 'Update needed fields',
        ],
        'add' => [
            'title' => 'Roles',
            'subtitle' => 'Set needed fields',
        ],
        'id' => 'Id',
        'name' => 'Name',
        'description' => 'Description',
        'role' => 'Role',

    ],
    'menu' => [
        'teams' => 'Team',
        'users' => 'Users',
        'roles' => 'Roles',
        'players' => 'Players'
    ],
    'home' => 'Home',
    'list' => 'List',
];