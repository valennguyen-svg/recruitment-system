<?php

return [
    'page' => [
        'company_index'   => 'Hoa hồng nhân sự',
        'recruiter_index' => 'Hoa hồng của tôi',
    ],

    'filters' => [
        'status'       => 'Trạng thái',
        'all_statuses' => 'Tất cả trạng thái',
        'from'         => 'Từ ngày',
        'to'           => 'Đến ngày',
        'staff'        => 'Nhân viên',
        'all_status'=>'Tất cả nhân viên',
    ],

    'actions' => [
        'filter' => 'Lọc',
        'reset'=>'Xóa bộ lọc'
    ],

    'messages' => [
        'updated' => 'Đã chuyển hoa hồng sang trạng thái :status.',
        'empty'   => 'Chưa có bản ghi hoa hồng nào trong khoảng thời gian này.',
    ],

    'errors' => [
        'invalid_transition' => 'Không thể chuyển hoa hồng từ ":from" sang ":to".',
    ],
];