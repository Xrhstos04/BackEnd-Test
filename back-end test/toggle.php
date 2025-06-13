<?php
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

$id = (int)$_GET['id'];
$tasks = file_exists('tasks.json') ? json_decode(file_get_contents('tasks.json'), true) : [];

foreach ($tasks as &$task) {
    if ($task['id'] === $id) {
        $task['is_done'] = !$task['is_done'];
        file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
        echo json_encode($task);
        exit;
    }
}

http_response_code(404);
echo json_encode(['error' => 'Task not found']);
