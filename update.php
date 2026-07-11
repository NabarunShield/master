<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $result = $conn->query("SELECT * FROM users WHERE id = $id");

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Edit User</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 30px; }
                input { padding: 8px; margin-bottom: 10px; display: block; }
                button { padding: 8px 12px; }
            </style>
        </head>
        <body>
            <h2>Edit User</h2>
            <form method="post" action="update.php">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                <input type="text" name="employee_Id" value="<?= htmlspecialchars($row['employee_Id']) ?>" placeholder="Employee ID" required>
                <button type="submit">Update</button>
            </form>
            <p><a href="index.php">Back</a></p>
        </body>
        </html>
        <?php
    } else {
        header("Location: index.php");
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $employee_Id = trim($_POST['employee_Id'] ?? '');

    if ($id > 0 && $name !== '' && $email !== '' && $employee_Id !== '') {
        $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, employee_Id = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $employee_Id, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
