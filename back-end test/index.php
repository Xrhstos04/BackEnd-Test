<?php
// Διαχείριση υποβολής φόρμας
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description'] ?? '');

    if (strlen($title) >= 3) {
        $tasks = file_exists('tasks.json') ? json_decode(file_get_contents('tasks.json'), true) : [];
        $newId = count($tasks) > 0 ? max(array_column($tasks, 'id')) + 1 : 1;

        $tasks[] = [
            'id' => $newId,
            'title' => $title,
            'description' => $description,
            'is_done' => false
        ];

        file_put_contents('tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
    }

    header('Location: index.php');
    exit;
}

$tasks = file_exists('tasks.json') ? json_decode(file_get_contents('tasks.json'), true) : [];
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tasks</h1>

    <form method="post" action="index.php">
        <input type="text" name="title" placeholder="Title" required minlength="3">
        <input type="text" name="description" placeholder="Description">
        <button type="submit">Add Task</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?= $task['is_done'] ? 'done' : '' ?>">
                <input type="checkbox" class="toggle-done" data-id="<?= $task['id'] ?>" <?= $task['is_done'] ? 'checked' : '' ?>>
                <strong><?= htmlspecialchars($task['title']) ?></strong> - <?= htmlspecialchars($task['description']) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <script src="script.js"></script>
</body>
</html>
