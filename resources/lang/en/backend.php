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
    'games' => [
        'list' => [
            'title' => 'Games List',
            'panel_header' => 'Games',
            'subtitle' => 'Game current fields',
        ],
        'edit' => [
            'title' => 'Game',
            'subtitle' => 'Update needed fields',
        ],
        'create' => [
            'title' => 'Game',
            'subtitle' => 'Update needed fields',
        ],
        'team' => 'Team against',
        'date' => 'Game date',
        'score1' => 'Home Goals',
        'score2' => 'Visitors Goals',
        'home' => 'Home/Visitor',
        'place' => 'Stadium',
        'status' => 'Status',
        'tournament_id' => 'Tournament'
    ],
    'stats' => [
        'list' => [
            'title' => 'Stats List',
            'panel_header' => 'Stats',
            'subtitle' => 'Stat current fields',
        ],
        'edit' => [
            'title' => 'Stats',
            'subtitle' => 'Update needed fields',
        ],
        'add' => [
            'title' => 'Stats',
            'subtitle' => 'Set needed fields',
        ],
        'id' => 'Id',
        'game_id' => 'Game',
        'player_id' => 'Player',
        'parameter' => 'Parameter',
        'value' => 'Value'
    ],
    'tournaments' => [
        'list' => [
            'title' => 'Tournaments List',
            'panel_header' => 'Tournaments',
            'subtitle' => 'Tournament current fields',
        ],
        'edit' => [
            'title' => 'Tournaments',
            'subtitle' => 'Update needed fields',
        ],
        'add' => [
            'title' => 'Tournaments',
            'subtitle' => 'Set needed fields',
        ],
        'id' => 'Id',
        'name' => 'Name',
        'link' => 'Tournament URL',
        'status' => 'Status',
    ],
    'menu' => [
        'teams' => 'Team',
        'users' => 'Users',
        'roles' => 'Roles',
        'players' => 'Players',
        'games' => 'Games',
        'stats' => 'Stats',
        'tournaments' => 'Tournaments'
    ],
    'home' => 'Home',
    'list' => 'List',
];