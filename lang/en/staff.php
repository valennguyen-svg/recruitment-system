<?php

return [
    'page' => [
        'index' => 'Staff management',
        'create' => 'Add recruiter',
        'edit' => 'Edit staff member',
    ],

    'actions' => [
        'create' => 'Add staff',
        'edit' => 'Edit',
        'save' => 'Save changes',
        'deactivate' => 'Lock',
        'cancel' => 'Cancel',
    ],

    'fields' => [
        'is_active' => 'Account is active',
        'company' => 'Company',
    ],

    'badges' => [
        'locked' => 'Locked',
    ],

    'stats' => [
        'job_count' => ':count job posts',
    ],

    'hints' => [
        'password' => 'Send this password to the staff member privately. They should change it after the first login.',
    ],

    'messages' => [
        'created' => 'Staff account created.',
        'updated' => 'Staff account updated.',
        'deactivated' => 'Staff account locked.',
        'confirm_deactivate' => 'Lock this account? The staff member will no longer be able to sign in.',
        'empty' => 'No staff yet. Add an account so they can post jobs.',
        'no_campany' => 'No company selected',
    ],

    'validation' => [
        'password' => 'Password must be at least 12 characters and include upper and lower case letters, a number and a symbol.',
        'password_confirmation' => 'Password confirmation does not match.',
    ],
];
