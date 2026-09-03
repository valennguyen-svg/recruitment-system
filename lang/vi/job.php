<?php

return [
    'attributes' => [
        'q'=> 'từ khoá',
        'category'=> 'ngành nghề',
        'location'=> 'địa điểm',
        'employment_type'=> 'loại hình công việc',
        'salary_min'=> 'mức lương tối thiểu',
        'sort'=> 'sắp xếp',
        'reason'=> 'lý do',
    ],

    'fields' => [
        'salary'=> 'Mức lương',
        'deadline' => 'Hạn nộp',
        'negotiable'=> 'Thỏa thuận',
        'views'=> ':count lượt xem',
        'description'=> 'Mô tả công việc',
        'requirements'=> 'Yêu cầu ứng viên',
        'benefits'=> 'Quyền lợi',
        'related'=> 'Việc làm tương tự',
        'back'=> '← Quay lại danh sách',
        'currency'=> 'VNĐ',
        'million'=> 'tr',
    ],

    'messages' => [
        'submitted' => 'Đã gửi tin để admin duyệt.',
        'approved'=> 'Đã duyệt tin tuyển dụng.',
        'rejected'=> 'Đã từ chối tin tuyển dụng.',
    ],

    'errors' => [
        'invalid_transition'=> 'Không thể chuyển từ :from sang :to.',
    ],
];