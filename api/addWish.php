<?php
require 'config.php';

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    response(false, 'Không có dữ liệu');
}

$name = trim($input['name'] ?? '');
$relation = trim($input['relation'] ?? '');
$wishMessage = trim($input['wish_message'] ?? '');
$predefinedWish = trim($input['predefined_wish'] ?? '');

if ($name === '') {
    response(false, 'Vui lòng nhập tên');
}

if ($wishMessage === '') {
    response(false, 'Vui lòng nhập lời chúc');
}

$list = readJson(WISH_FILE);

$newItem = [
    'id' => nextId($list),
    'name' => $name,
    'relation' => $relation,
    'wish_message' => $wishMessage,
    'predefined_wish' => $predefinedWish,
    'created_at' => date('Y-m-d H:i:s')
];

$list[] = $newItem;

writeJson(WISH_FILE, $list);

response(true, 'Đã lưu lời chúc', $newItem);