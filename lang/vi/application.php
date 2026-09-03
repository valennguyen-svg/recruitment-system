<?php

return [
    'attributes' => [
        'resume_id'=> 'CV',
        'cover_letter'=> 'thư giới thiệu',
    ],

    'fields' => [
        'title'=> 'Ứng tuyển',
        'choose_cv'=> 'Chọn CV',
        'cover_letter'=> 'Thư giới thiệu',
        'optional'=> '(không bắt buộc)',
        'submit'=> 'Nộp hồ sơ',
        'placeholder' => 'Vì sao bạn phù hợp với vị trí này?',
    ],

    'messages' => [
        'applied'=> 'Nộp hồ sơ thành công. Nhà tuyển dụng sẽ liên hệ với bạn.',
        'already_sent' => 'Bạn đã nộp hồ sơ cho vị trí này.',
        'none_yet'=> 'Bạn chưa nộp hồ sơ cho vị trí nào.',
        'need_cv'=> 'Bạn chưa tải CV nào lên. Hãy bổ sung CV trước khi ứng tuyển.',
        'staff_cannot'=> 'Tài khoản :role không thể nộp hồ sơ.',
        'login_first'=> 'Đăng nhập để nộp hồ sơ cho vị trí này.',
        'job_closed'=> 'Tin tuyển dụng đã hết hạn nộp hồ sơ.',
        'view_applied'=> 'Xem hồ sơ đã nộp',
        'upload_cv'=> 'Tải CV lên',
        'upload_other'=> '+ Tải CV khác lên',
    ],

    'errors' => [
        'already_applied'=> 'Bạn đã ứng tuyển vị trí này rồi.',
        'job_closed'=> 'Tin tuyển dụng này đã ngừng nhận hồ sơ.',
        'job_expired'=> 'Tin tuyển dụng này đã hết hạn nộp.',
        'no_profile'=> 'Bạn cần đăng ký hồ sơ ứng viên trước.',
        'invalid_transition' => 'Không thể chuyển từ :from sang :to.',
    ],
];