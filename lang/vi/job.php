<?php

return [
    'page' => [
        'index'=> 'Việc làm',
        'detail'=> 'Chi tiết tin tuyển dụng',
        'related'=> 'Tin tuyển dụng liên quan',
    ],

    'attributes' => [
        'title'=> 'tiêu đề',
        'keyword'=> 'từ khoá',
        'location'=> 'địa điểm',
        'category_id'=> 'ngành nghề',
        'employment_type'=> 'Loại hình công việc',
        'experience_level'=> 'Cấp bậc',
        'salary_min'=> 'lương tối thiểu',
        'salary_max'=> 'lương tối đa',
        'quantity'=> 'số lượng tuyển',
        'description'=> 'mô tả công việc',
        'requirements'=> 'yêu cầu',
        'benefits'=> 'quyền lợi',
        'deadline'=> 'hạn nộp',
        'status'=> 'trạng thái',
        'sort' => 'sắp xếp',
    ],

    'fields' => [
        'location'=> 'Địa điểm',
        'category'=> 'Ngành nghề',
        'employment_type'=> 'Loại hình',
        'experience_level'=> 'Cấp bậc',
        'salary'=> 'Mức lương',
        'quantity'=> 'Số lượng',
        'deadline' => 'Hạn nộp:',
        'description'=> 'Mô tả công việc',
        'requirements'=> 'Yêu cầu ứng viên',
        'benefits'=> 'Quyền lợi',
    ],

    'placeholders'=> [
        'keyword'=> 'Tên công việc, kỹ năng...',
    ],

    'employment_type'=> [
        'full_time'=> 'Toàn thời gian',
        'part_time'=> 'Bán thời gian',
        'contract'=> 'Hợp đồng',
        'internship'=> 'Thực tập',
        'freelance'=> 'Tự do',
    ],

    'experience_level' => [
        'intern'=> 'Thực tập sinh',
        'junior'=> 'Junior',
        'middle'=> 'Middle',
        'senior'=> 'Senior',
        'lead'=> 'Trưởng nhóm',
    ],

    'status' => [
        'draft'=> 'Bản nháp',
        'published'=> 'Đang tuyển',
        'closed'=> 'Đã đóng',
    ],

    'sort' => [
        'newest' => 'Mới nhất',
        'oldest'=> 'Cũ nhất',
        'salary_desc'=> 'Lương cao nhất',
        'deadline'=> 'Sắp hết hạn',
    ],

    'actions' => [
        'search'=> 'Tìm kiếm',
        'reset'=> 'Xoá bộ lọc',
        'apply' => 'Nộp hồ sơ',
        'upload_cv'=> 'Tải CV lên',
        'back'=> 'Quay lại danh sách',
    ],

    'messages' => [
        'found'=> 'Tìm thấy :count tin tuyển dụng.',
        'none'=> 'Không có tin tuyển dụng nào phù hợp.',
        'expired'=> 'Tin tuyển dụng đã hết hạn.',
        'need_cv'=> 'Bạn cần tải CV lên trước khi nộp hồ sơ.',
        'already_applied' => 'Bạn đã nộp hồ sơ cho tin này.',
        'negotiable'=> 'Thoả thuận',
    ],
];