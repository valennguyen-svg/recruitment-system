<?php

return [
    'page' => [
        'company_index' => 'Staff commissions',
        'recruiter_index' => 'My commissions',
    ],

    'filters' => [
        'status' => 'Status',
        'all_statuses' => 'All statuses',
        'from' => 'From',
        'to' => 'To',
        'staff' => 'Staff member',
        'all_staff' => 'All staff',
    ],

    'actions' => [
        'filter' => 'Filter',
        'reset' => 'Clear filters',
    ],

    'messages' => [
        'updated' => 'Commission moved to :status.',
        'empty' => 'No commission records in this period.',
    ],

    'errors' => [
        'invalid_transition' => 'Cannot move a commission from ":from" to ":to".',
    ],
];
