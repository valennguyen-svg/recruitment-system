<?php

return [
    'page' => [
        'index' => 'Quản lý nhân sự',
        'create' => 'Thêm nhân viên tuyển dụng',
        'edit' => 'Sửa thông tin nhân viên',
    ],

    'actions' => [
        'create' => 'Thêm nhân viên',
        'edit' => 'Sửa',
        'save' => 'Lưu thay đổi',
        'deactivate' => 'Khoá',
        'cancel' => 'Huỷ',
    ],

    'fields' => [
        'is_active' => 'Tài khoản đang hoạt động',
        'company' => 'Công ty',
    ],

    'badges' => [
        'locked' => 'Đã khoá',
    ],

    'stats' => [
        'job_count' => ':count tin đã đăng',
    ],

    'hints' => [
        'password' => 'Gửi mật khẩu này cho nhân viên qua kênh riêng. Họ nên đổi ngay sau lần đăng nhập đầu tiên.',
    ],

    'messages' => [
        'created' => 'Đã tạo tài khoản nhân viên.',
        'updated' => 'Đã cập nhật thông tin nhân viên.',
        'deactivated' => 'Đã khoá tài khoản nhân viên.',
        'confirm_deactivate' => 'Khoá tài khoản này? Nhân viên sẽ không đăng nhập được nữa.',
        'empty' => 'Chưa có nhân viên nào. Thêm tài khoản để họ đăng tin tuyển dụng.',
        'no_company' => 'Chưa chọn công ty',
    ],

    'validation' => [
        'password' => 'Mật khẩu cần tối thiểu 12 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt.',
        'password_confirmation' => 'Xác nhận mật khẩu không khớp.',
    ],
];
