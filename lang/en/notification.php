<?php

return [
    'common'=>[
        'greetin'=>'Hello :name',
    ],

    'application_status'=>[
        'subject'=>'Application update: :job',
        'line'=>"Your application for ':job' has moved to: :status.",
        'note'=>'Note from the recuiter: :note',
        'action'=>'View application',
        'short'=>"Application ':job' → :status",
    ],

    'new_application'=>[
        'subject'=>"New applicant for ':job'",
        'line'=>":name has applied for ':job'.",
        'action'=>'View applicant profile',
        'short'=>":name applied for ':job'.",
    ],

    'job_approved'=>[
        'subject'=>'Your job post was approved',
        'line'=>"Job post ':job' has been approved and published.",
        'action'=>'View job post',
        'short'=>"Job post ':job' was not approved.",
    ],
    'messages'=>[
        'all_read'=>'All notifications marked as read.',
    ],
];