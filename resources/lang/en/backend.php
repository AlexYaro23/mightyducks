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
        'create' => [
            'title' => 'Player',
            'subtitle' => 'Set needed fields',
        ],
        'user_id' => 'User',
        'mls_id' => 'MLS Id',
        'team_id' => 'Team Id',
        'name' => 'Name',
        'date_of_birth' => 'Date of Birth',
        'position' => 'Position',
        'status' => 'Status',
        'tournaments' => 'Tournaments'
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
        'tournament_id' => 'Tournament',
        'mls_id' => 'MLS Id',
        'mls_url' => 'MLS URL',
        'teamA' => 'Team',
        'round' => 'Round',
        'youtube' => 'YouTube Links',
        'description' => 'Description'
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
        'team_id' => 'Team',
        'league' => 'League',
        'players' => "Players"
    ],
    'leagues' => [
        'list' => [
            'title' => 'Leagues List',
            'panel_header' => 'Leagues',
            'subtitle' => 'League current fields',
        ],
        'edit' => [
            'title' => 'Leagues',
            'subtitle' => 'Update needed fields',
        ],
        'add' => [
            'title' => 'Leagues',
            'subtitle' => 'Set needed fields',
        ],
        'id' => 'Id',
        'name' => 'Name',
        'link' => 'League URL',
        'status' => 'Status',
        'info' => 'Info',
        'logo' => 'Logo',
    ],
    'visits' => [
        'list' => [
            'title' => 'Visit List',
            'panel_header' => 'Visits',
            'subtitle' => 'Visits current fields',
        ],
        'edit' => [
            'title' => 'Visit',
            'subtitle' => 'Update needed fields',
        ],
        'id' => 'Id',
        'team' => 'Team',
        'date' => 'Date',
        'tournament_id' => 'Tournament',
        'player_name' => 'Player',
        'game_visit' => 'Game Visit'
    ],
    'trainings' => [
        'list' => [
            'title' => 'Trainings List',
            'panel_header' => 'Trainings',
            'subtitle' => 'Training current fields',
        ],
        'edit' => [
            'title' => 'Trainings',
            'subtitle' => 'Update needed fields',
        ],
        'add' => [
            'title' => 'Trainings',
            'subtitle' => 'Set needed fields',
        ],
        'id' => 'Id',
        'name' => 'Name',
        'address' => 'Address',
        'day_of_week' => 'Day',
        'time' => 'Time',
        'status' => 'Status',
        'team_id' => 'Team'
    ],
    'training_visits' => [
        'list' => [
            'title' => 'Visit List',
            'panel_header' => 'Visits',
            'subtitle' => 'Visits current fields',
        ],
        'edit' => [
            'title' => 'Visit',
            'subtitle' => 'Update needed fields',
        ],
        'id' => 'Id',
        'name' => 'Training',
        'day_of_week' => 'Date',
        'status' => 'Status',
        'player_name' => 'Player',
        'game_training_visit' => 'Visit'
    ],
    'menu' => [
        'teams' => 'Team',
        'users' => 'Users',
        'roles' => 'Roles',
        'players' => 'Players',
        'games' => 'Games',
        'stats' => 'Stats',
        'tournaments' => 'Tournaments',
        'leagues' => 'Leagues',
        'visits' => 'Quick visits',
        'trainings' => 'Trainings',
        'training_visits' => 'Training visits',
        'results' => 'Results'
    ],
    'home' => 'Home',
    'list' => 'List',
];