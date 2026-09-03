<?php

return [
    'common' => [
        'greeting'=> 'Xin chào :name,',
    ],

    'application_status' => [
        'subject'=> 'Cập nhật đơn ứng tuyển: :job',
        'line'=> "Đơn ứng tuyển vị trí ':job' đã chuyển sang trạng thái: :status.",
        'note'=> 'Ghi chú từ nhà tuyển dụng: :note',
        'action'=> 'Xem chi tiết đơn',
        'short'=> "Đơn ':job' → :status",
    ],

    'new_application' => [
        'subject' => "Ứng viên mới cho tin ':job'",
        'line'=> ":name vừa ứng tuyển vào vị trí ':job'.",
        'action'=> 'Xem hồ sơ ứng viên',
        'short'=> ":name vừa ứng tuyển ':job'.",
    ],

    'job_approved' => [
        'subject' => 'Tin tuyển dụng đã được duyệt',
        'line'=> "Tin ':job' đã được duyệt và xuất bản.",
        'action'=> 'Xem tin',
        'short'=> "Tin ':job' đã được duyệt.",
    ],

    'job_rejected' => [
        'subject'=> 'Tin tuyển dụng chưa được duyệt',
        'line'=> "Tin ':job' chưa được duyệt để xuất bản.",
        'reason'=> 'Lý do: :reason',
        'action'=> 'Xem tin',
        'short' => "Tin ':job' chưa được duyệt.",
    ],

    'messages' => [
        'all_read'=> 'Đã đánh dấu tất cả đã đọc.',
    ],
];