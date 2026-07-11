<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL CRUD</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { margin-bottom: 20px; }
        input { padding: 8px; margin-right: 10px; }
        button { padding: 8px 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>PHP MySQL CRUD Example</h2>

    <form action="create.php" method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="employee_Id" placeholder="Employee ID" required>
        <button type="submit">Add User</button>
    </form>

    <form action="index.php" method="get" style="margin-bottom: 20px;">
        <input type="text" name="employee_Id" placeholder="Search by Employee ID" value="<?= isset($_GET['employee_Id']) ? htmlspecialchars($_GET['employee_Id']) : '' ?>">
        <button type="submit">Search</button>
        <a href="index.php">Reset</a>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Employee ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $searchEmployeeId = trim($_GET['employee_Id'] ?? '');

            if ($searchEmployeeId !== '') {
                $stmt = $conn->prepare("SELECT * FROM users WHERE employee_Id LIKE ? ORDER BY id DESC");
                $searchTerm = "%{$searchEmployeeId}%";
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $sql = "SELECT * FROM users ORDER BY id DESC";
                $result = $conn->query($sql);
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['employee_Id']}</td>
                            <td>
                                <a href='update.php?id={$row['id']}'>Edit</a> |
                                <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Delete this user?')\">Delete</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
