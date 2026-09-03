<?php

return [
    'attributes'=>[
        'resume_id'=>'CV',
        'cover_letter'=>'cover letter',
    ],

    'fields'=>[
        'title'=>'Apply',
        'choose_cv'=>'Choose CV',
        'cover_letter'=>'Cover letter',
        'optional'=>'(optional)',
        'submit'=>'Submit application',
        'placeholder'=>'Why are you a good fit for this role?',
    ],

    'messages'=>[
        'applied'=>'Application submitted. The recruiter will contact you.',
        'already_sent'=>'You have already applied for this position.',
        'none_yet'=>'You have not applied for any position yet.',
        'need_cv'=>'You have no CV uploaded. Please add a CV before applying.',
        'staff_connot'=>':role accounts cannot submit applications.',
        'login_first'=>'Log in to apply for this position.',
        'job_closed'=>'This job post is no longer accepting applications.',
        'view_applied'=>'View my applications.',
        'upload_cv'=>'Upload CV',
        'upload_other'=>'+ Upload another CV',
    ],

    'errors'=>[
        'already_applied'=>'You have already applied for this position.',
        'job_closed'=>'This job post is no longer accepting applicaitons.',
        'job_expired'=>'This job post has passed its deadline.',
        'no_profile'=>'You need to register a candidate profile first.',
        'invalid_transition'=>'Cannot change from :from to :to.',
    ],
];