<?php
require 'config.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    response(false, 'Không có dữ liệu');
}

$name = trim($input['name'] ?? '');
$isAttending = trim($input['is_attending'] ?? '');
$partySide = trim($input['party_side'] ?? '');
$guestCount = trim($input['guest_count'] ?? '');
$message = trim($input['message'] ?? '');

if ($name === '') {
    response(false, 'Vui lòng nhập tên');
}

if ($isAttending === '') {
    response(false, 'Vui lòng chọn tham dự hay không');
}

$list = readJson(RSVP_FILE);

$newItem = [
    'id' => nextId($list),
    'name' => $name,
    'is_attending' => $isAttending,
    'party_side' => $partySide,
    'guest_count' => $guestCount,
    'message' => $message,
    'created_at' => date('Y-m-d H:i:s')
];

$list[] = $newItem;

writeJson(RSVP_FILE, $list);

response(true, 'Đã lưu RSVP', $newItem);