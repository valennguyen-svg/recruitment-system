<?php

return [
    'page' => [
        'register_cv' => 'Đăng ký CV',
        'upload_new' => 'Tải CV mới',
        'my_cv' => 'CV của tôi',
        'personal' => 'Thông tin cá nhân',
        'resume_file' => 'Tệp CV',
        'applied' => 'Hồ sơ đã nộp',
        'profile' => 'Profile',
        'create_cv' => 'Tạo CV mới',
        'edit_cv' => 'Chỉnh sửa CV',
    ],

    'attributes' => [
        'headline' => 'chức danh mong muốn',
        'phone' => 'số điện thoại',
        'date_of_birth' => 'ngày sinh',
        'address' => 'địa chỉ',
        'skills' => 'kỹ năng',
        'education' => 'học vấn',
        'summary' => 'giới thiệu bản thân',
        'experience_years' => 'số năm kinh nghiệm',
        'title' => 'tên CV',
        'file' => 'tệp CV',
    ],

    'fields' => [
        'full_name' => 'Họ tên',
        'headline' => 'Chức danh mong muốn',
        'phone' => 'Số điện thoại',
        'date_of_birth' => 'Ngày sinh',
        'address' => 'Địa chỉ',
        'skills' => 'Kỹ năng',
        'education' => 'Học vấn',
        'summary' => 'Giới thiệu bản thân',
        'experience_years' => 'Số năm kinh nghiệm',
        'title' => 'Tên CV',
        'file' => 'Chọn tệp',
    ],

    'placeholders' => [
        'headline' => 'VD: Backend Developer 2 năm kinh nghiệm',
        'skills' => 'VD: PHP, Laravel, PostgreSQL',
        'education' => 'VD: Đại học ABC — Công nghệ thông tin, 2020–2024',
        'title' => 'VD: CV Backend Developer',
    ],

    'hints' => [
        'skills' => '(cách nhau bằng dấu phẩy)',
        'file' => '(PDF, DOC, DOCX — tối đa :size MB)',
        'name_in_profile' => 'Đổi họ tên ở trang Profile.',
        'keep_old_file' => '(bỏ trống nếu giữ tệp cũ)',
        'sent_with_apply' => 'Thông tin này sẽ được gửi kèm khi bạn ứng tuyển.',
        'finish_upload' => 'Tải lên tệp CV của bạn để hoàn tất đăng ký.',
        'keep_old_cv' => 'Tải lên tệp CV mới. Các CV cũ vẫn được giữ nguyên.',
        'my_cv_desc' => 'Các tệp CV bạn đã tải lên và thông tin đã điền khi đăng ký.',
        'existing_cv' => 'CV hiện có:',
    ],

    'actions' => [
        'finish_register' => 'Hoàn tất đăng ký',
        'upload' => 'Tải lên',
        'update_info' => 'Cập nhật thông tin',
        'edit_info' => 'Sửa thông tin',
        'view_info' => 'Xem thông tin đã điền',
        'edit_file' => 'Sửa tên & tệp CV',
        'download' => 'Tải xuống',
        'delete' => 'Xoá',
        'cancel' => 'Huỷ',
        'add_more' => '+ Thêm CV mới',
        'save_changes' => 'Lưu thay đổi',
        'create_cv' => 'Tạo CV',
        'edit' => 'Sửa',
        'set_default' => 'Đặt mặc định',
        'save' => 'Lưu',
    ],

    'messages' => [
        'cv_registered' => 'Đăng ký CV thành công. CV của bạn đã có trong mục “CV của tôi”.',
        'profile_updated' => 'Cập nhật thông tin CV thành công.',
        'resume_uploaded' => 'Tải CV lên thành công.',
        'resume_updated' => 'Cập nhật CV thành công.',
        'resume_deleted' => 'Đã xoá CV.',
        'no_resume' => 'Chưa có tệp CV nào.',
        'no_cv_hint' => 'Bạn chưa có CV nào. Vào một tin tuyển dụng và bấm “Tải CV lên” để đăng ký.',
        'confirm_delete' => 'Xoá CV này?',
        'default_badge' => 'Mặc định',
        'have_n_cv' => 'Bạn đang có :count CV. Tải thêm CV mới bên dưới.',
        'default_set' => 'Đã đặt làm CV mặc định.',
        'cv_updated' => 'Đã cập nhật CV.',
    ],

    'units' => [
        'cv_count' => ':count CV',
        'application_count' => ':count đơn đã nộp',
    ],
];
