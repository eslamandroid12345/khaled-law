<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super-admin' => [
            'users' => 'c,r,u,d',
            'lawyers' => 'c,r,u,d',
            'categories' => 'c,r,u,d',
            'services' => 'c,r,u,d',
            'questions' => 'c,r,u,d',
            'legalforms' => 'c,r,u,d',
            'consultations' => 'c,r,u,d,s',
            'customer-review' => 'c,r,u,d',
            'roles' => 'c,r,u,d',  // Roles && assign permission
            'managers' => 'c,r,u,d',
            'profile' => 'r,u',
            'orders' => 'r,u,d',
            'times' => 'r,u',
            'attachments' => 'r,c,d',
            'appointments' => 'r,c,d',
            'updates' => 'r,c,d',
            'payments' => 'r,c,d',
            'order-chat' => 'r',
            'uses' => 'c,r,u,d',
            'structure' => 'u',
            'setting' => 'r',
            'info' => 'r',
            'transaction' => 'r,u',
        ],
        'admin' => [
            'users' => 'r',
            'profile' => 'r,u',
        ],

    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        's' => 'show',
    ],
];
