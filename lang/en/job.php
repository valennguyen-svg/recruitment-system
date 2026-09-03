<?php

return [
    'attributes'=>[
        'q'=>'keyword',
        'category'=>'category',
        'location'=>'location',
        'employment'=>'employment type',
        'salary_min'=>'minimun salary',
        'sort'=>'sort',
        'reason'=>'reason',
    ],

    'fields'=>[
        'salary'=>'Salary',
        'deadline'=>'Deadline',
        'negotiable'=>'Negotiable',
        'views'=>':count views',
        'description'=>'Job description',
        'requirements'=>'Requirements',
        'benefits'=>'Benefits',
        'related'=>'Similar jobs',
        'back'=>'← Back to list',
        'currency'=>'VND',
        'million'=>'M',
    ],

    'messages'=>[
        'submitted'=>'Job post submitted for review',
        'approved'=>'Job post approved',
        'rejected'=>'Job post rejected',
    ],

    'errors'=>[
        'invalid_transition'=>'Cannot change from :from to :to.',
    ],
];