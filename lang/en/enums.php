<?php

return [
    'user_role' => [
        'admin' => 'Administrator',
        'recruiter' => 'Recruiter',
        'candidate' => 'Candidate',
    ],

    'job_status' => [
        'draft' => 'Draft',
        'pending_review' => 'Pending review',
        'published' => 'Published',
        'rejected' => 'Rejected',
        'closed' => 'Closed',
        'expired' => 'Expired',
    ],

    'application_status' => [
        'applied' => 'Applied',
        'screening' => 'Screening',
        'interview' => 'Interview',
        'offer' => 'Offer sent',
        'hired' => 'Hired',
        'rejected' => 'Not a fit',
        'withdrawn' => 'Withdrawn',
    ],

    'employment_type' => [
        'full_time' => 'Full time',
        'part_time' => 'Part time',
        'contract' => 'Contract',
        'internship' => 'Internship',
    ],

    'sort_option' => [
        'newest' => 'Newest',
        'oldest' => 'Oldest',
        'salary_high' => 'Highest salary',
        'deadline' => 'Closing soon',
        'popular' => 'Most viewed',
    ],

    'audit_action' => [
        'job_post.status_changed' => 'Job post status changed',
    ],
];
