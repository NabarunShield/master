<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $employee_Id = trim($_POST['employee_Id'] ?? '');

    if ($name !== '' && $email !== '' && $employee_Id !== '') {
        $stmt = $conn->prepare("INSERT INTO users (name, email, employee_Id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $employee_Id);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: index.php");
exit;
?>
