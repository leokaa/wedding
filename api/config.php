<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

define('WISH_FILE', __DIR__ . '/../data/wish.json');
define('RSVP_FILE', __DIR__ . '/../data/rsvp.json');

function readJson($file)
{
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }

    $content = file_get_contents($file);
    $data = json_decode($content, true);

    return is_array($data) ? $data : [];
}

function writeJson($file, $data)
{
    file_put_contents(
        $file,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    );
}

function nextId($list)
{
    if (empty($list)) return 1;

    $ids = array_column($list, 'id');
    return max($ids) + 1;
}

function response($success, $message = '', $data = [])
{
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ], JSON_UNESCAPED_UNICODE);

    exit;
}