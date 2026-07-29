<?php
require 'config.php';

$list = readJson(WISH_FILE);

usort($list, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$list = array_slice($list, 0, 20);

$result = array_map(function($item) {
    return [
        'name' => $item['name'],
        'wish_message' => $item['wish_message']
    ];
}, $list);

response(true, '', $result);