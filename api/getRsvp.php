<?php
require 'config.php';

$list = readJson(RSVP_FILE);

usort($list, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

$list = array_slice($list, 0, 50);

$result = array_map(function($item) {
    return [
        'name' => $item['name'],
        'message' => $item['message'],
        'is_attending' => $item['is_attending'],
        'party_side' => $item['party_side'],
        'guest_count' => $item['guest_count']
    ];
}, $list);

response(true, '', $result);