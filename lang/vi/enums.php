<?php

return [
    'user_role' => [
        'admin' => 'Quản trị viên',
        'recruiter' => 'Nhà tuyển dụng',
        'candidate' => 'Ứng viên',
    ],

    'job_status' => [
        'draft' => 'Bản nháp',
        'pending_review' => 'Chờ duyệt',
        'published' => 'Đang đăng',
        'rejected' => 'Bị từ chối',
        'closed' => 'Đã đóng',
        'expired' => 'Hết hạn',
    ],

    'application_status' => [
        'applied' => 'Đã nộp',
        'screening' => 'Đang sàng lọc',
        'interview' => 'Mời phỏng vấn',
        'offer' => 'Đã gửi offer',
        'hired' => 'Trúng tuyển',
        'rejected' => 'Không phù hợp',
        'withdrawn' => 'Đã rút đơn',
    ],

    'employment_type' => [
        'full_time' => 'Toàn thời gian',
        'part_time' => 'Bán thời gian',
        'contract' => 'Hợp đồng',
        'internship' => 'Thực tập',
    ],

    'sort_option' => [
        'newest' => 'Mới nhất',
        'oldest' => 'Cũ nhất',
        'salary_high' => 'Lương cao nhất',
        'deadline' => 'Sắp hết hạn',
        'popular' => 'Xem nhiều nhất',
    ],

    'audit_action' => [
        'job_post.status_changed' => 'Thay đổi trạng thái tin tuyển dụng',
    ],
];
