<?php

return [
    'page' => [
        'index' => 'Jobs',
        'detail' => 'Job details',
        'related' => 'Related jobs',
    ],

    'attributes' => [
        'title' => 'title',
        'keyword' => 'keyword',
        'location' => 'location',
        'category_id' => 'category',
        'employment_type' => 'Employment type',
        'experience_level' => 'Experience level',
        'salary_min' => 'minimum salary',
        'salary_max' => 'maximum salary',
        'quantity' => 'headcount',
        'description' => 'job description',
        'requirements' => 'requirements',
        'benefits' => 'benefits',
        'deadline' => 'deadline',
        'status' => 'status',
        'sort' => 'sort',
    ],

    'fields' => [
        'location' => 'Location',
        'category' => 'Category',
        'employment_type' => 'Employment type',
        'experience_level' => 'Level',
        'salary' => 'Salary',
        'quantity' => 'Headcount',
        'deadline' => 'Deadline:',
        'description' => 'Job description',
        'requirements' => 'Requirements',
        'benefits' => 'Benefits',
    ],

    'placeholders' => [
        'keyword' => 'Job title, skills...',
        'salary_min' => 'Min salary',
    ],

    'employment_type' => [
        'full_time' => 'Full-time',
        'part_time' => 'Part-time',
        'contract' => 'Contract',
        'internship' => 'Internship',
        'freelance' => 'Freelance',
    ],

    'experience_level' => [
        'intern' => 'Intern',
        'junior' => 'Junior',
        'middle' => 'Middle',
        'senior' => 'Senior',
        'lead' => 'Lead',
    ],

    'status' => [
        'draft' => 'Draft',
        'published' => 'Open',
        'closed' => 'Closed',
        'pending_review' => 'Pending review',
        'rejected' => 'Rejected',
    ],

    'sort' => [
        'newest' => 'Newest',
        'oldest' => 'Oldest',
        'salary_desc' => 'Highest salary',
        'deadline' => 'Closing soon',
        'popular' => 'Most view',
    ],

    'actions' => [
        'search' => 'Search',
        'reset' => 'Clear filters',
        'apply' => 'Apply now',
        'upload_cv' => 'Upload CV',
        'back' => 'Back to list',
    ],

    'messages' => [
        'found' => ':count jobs found.',
        'none' => 'No jobs match your filters.',
        'expired' => 'This job posting has expired.',
        'need_cv' => 'You need to upload a CV before applying.',
        'already_applied' => 'You have already applied to this job.',
        'negotiable' => 'Negotiable',
    ],
];
