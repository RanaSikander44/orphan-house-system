<?php
return [
    [
        'title' => 'Dashboard',
        'icon' => 'fa fa-tachometer-alt',
        'route' => 'dashboard',
        'is_dropdown' => false,
        'children' => [],
    ],
    [
        'title' => 'Applications',
        'icon' => 'fas fa-envelope',
        'route' => null,
        'is_dropdown' => true,
        'children' => [
            [
                'title' => 'Applications List',
                'route' => 'applications',
            ],
            [
                'title' => 'Add New',
                'route' => 'application.add',
            ],
        ],
    ],
];
