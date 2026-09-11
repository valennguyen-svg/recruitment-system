<?php

return [
    'page' => [
        'index' => 'Jobs',
        'detail' => 'Job details',
        'related' => 'Related jobs',
        'company_index' => 'Company jobs',
        'create' => 'Post a job',
        'edit' => 'Edit job post',
    ],

    'attributes' => [
        'title' => 'title',
        'keyword' => 'keyword',
        'location' => 'location',
        'category_id' => 'category',
        'employment_type' => 'employment type',
        'experience_level' => 'experience level',
        'salary_min' => 'minimum salary',
        'salary_max' => 'maximum salary',
        'quantity' => 'number of openings',
        'description' => 'job description',
        'requirements' => 'requirements',
        'benefits' => 'benefits',
        'deadline' => 'deadline',
        'status' => 'status',
        'sort' => 'sorting',
    ],

    'fields' => [
        'location' => 'Location',
        'category' => 'Category',
        'employment_type' => 'Employment type',
        'experience_level' => 'Experience level',
        'salary' => 'Salary',
        'quantity' => 'Openings',
        'deadline' => 'Deadline:',
        'description' => 'Job description',
        'requirements' => 'Requirements',
        'benefits' => 'Benefits',
        'title' => 'Title',
        'salary_negotiable' => 'Negotiable salary',
        'salary_min' => 'Minimum salary',
        'salary_max' => 'Maximum salary',
    ],

    'placeholders' => [
        'keyword' => 'Job title, skill...',
        'salary_min' => 'Minimum salary',
    ],

    'employment_type' => [
        'full_time' => 'Full time',
        'part_time' => 'Part time',
        'contract' => 'Contract',
        'internship' => 'Internship',
        'freelance' => 'Freelance',
    ],

    'experience_level' => [
        'intern' => 'Intern',
        'junior' => 'Junior',
        'middle' => 'Middle',
        'senior' => 'Senior',
        'lead' => 'Team lead',
    ],

    'status' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'closed' => 'Closed',
        'pending_review' => 'Pending review',
        'rejected' => 'Rejected',
        'expired' => 'Expired',
    ],

    'stats' => [
        'by' => 'Posted by :name',
        'applications' => ':count applications',
    ],

    'sort' => [
        'newest' => 'Newest',
        'oldest' => 'Oldest',
        'salary_desc' => 'Highest salary',
        'deadline' => 'Closing soon',
        'popular' => 'Most viewed',
    ],

    'actions' => [
        'search' => 'Search',
        'reset' => 'Clear filters',
        'apply' => 'Apply',
        'upload_cv' => 'Upload CV',
        'back' => 'Back to list',
        'create' => 'Post a job',
        'save_draft' => 'Save draft',
        'edit' => 'Edit',
        'submit' => 'Submit for review',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
    ],

    'messages' => [
        'found' => 'Found :count jobs.',
        'none' => 'No matching jobs.',
        'expired' => 'This job posting has expired.',
        'need_cv' => 'You need to upload a CV before applying.',
        'already_applied' => 'You have already applied to this job.',
        'negotiable' => 'Negotiable',
        'created' => 'Draft ":title" saved. Submit it for review when ready.',
        'updated' => 'Job post updated.',
        'deleted' => 'Job post deleted.',
        'confirm_delete' => 'Delete this job post? This cannot be undone.',
        'empty' => 'No job posts yet. Create your first one to start receiving applications.',
    ],
];
