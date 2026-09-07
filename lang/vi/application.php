<?php

return [
    'page' => [
        'index' => 'Hồ sơ đã nộp',
        'manage' => 'Quản lý hồ sơ ứng tuyển',
    ],

    'attributes' => [
        'resume_id' => 'CV',
        'cover_letter' => 'thư giới thiệu',
        'status' => 'trạng thái',
        'note' => 'ghi chú',
    ],

    'fields' => [
        'resume' => 'CV đính kèm',
        'cover_letter' => 'Thư giới thiệu',
        'applied_at' => 'Ngày nộp',
        'status' => 'Trạng thái',
    ],

    'status' => [
        'applied' => 'Đã nộp',
        'reviewing' => 'Đang xem xét',
        'interviewing' => 'Phỏng vấn',
        'offered' => 'Đã đề nghị',
        'hired' => 'Đã tuyển',
        'rejected' => 'Từ chối',
    ],

    'actions' => [
        'submit' => 'Nộp hồ sơ',
        'change_status' => 'Đổi trạng thái',
    ],

    'messages' => [
        'none_yet' => 'Bạn chưa nộp hồ sơ nào.',
        'submitted' => 'Đã nộp hồ sơ thành công.',
        'status_updated' => 'Đã cập nhật trạng thái hồ sơ.',
        'invalid_transition' => 'Không thể chuyển từ trạng thái :from sang :to.',
    ],
];
