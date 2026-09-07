<?php

return [
    'page' => [
        'index' => 'My applications',
        'manage' => 'Manage applications',
    ],

    'attributes' => [
        'resume_id' => 'resume',
        'cover_letter' => 'cover letter',
        'status' => 'status',
        'note' => 'note',
    ],

    'fields' => [
        'resume' => 'Attached CV',
        'cover_letter' => 'Cover letter',
        'applied_at' => 'Applied on',
        'status' => 'Status',
    ],

    'status' => [
        'applied' => 'Applied',
        'reviewing' => 'Reviewing',
        'interviewing' => 'Interviewing',
        'offered' => 'Offer sent',
        'hired' => 'Hired',
        'rejected' => 'Rejected',
    ],

    'actions' => [
        'submit' => 'Submit application',
        'change_status' => 'Change status',
    ],

    'messages' => [
        'none_yet' => 'You have not applied to any jobs yet.',
        'submitted' => 'Application submitted.',
        'status_updated' => 'Application status updated.',
        'invalid_transition' => 'Cannot move from :from to :to.',
    ],
];
