<?php
require_once "Student.php";
$student = new Student();

// Handle form actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add"])) {
        $student->addStudent([
            "name" => $_POST["name"],
            "email" => $_POST["email"]
        ]);
    } elseif (isset($_POST["update"])) {
        $student->updateStudent(
            ["name" => $_POST["name"], "email" => $_POST["email"]],
            ["id" => $_POST["id"]]
        );
    } elseif (isset($_POST["delete"])) {
        $student->deleteStudent(["id" => $_POST["id"]]);
    }
}

$students = $student->getStudents();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
</head>
<body>
    <h2>Student Enrollment CRUD</h2>

    <form method="POST">
        <input type="hidden" name="id" value="">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="add">Add Student</button>
    </form>

    <h3>Student List</h3>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s["id"] ?></td>
                <td><?= $s["name"] ?></td>
                <td><?= $s["email"] ?></td>
                <td>
                    <!-- Update Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $s["id"] ?>">
                        <input type="text" name="name" value="<?= $s["name"] ?>" required>
                        <input type="email" name="email" value="<?= $s["email"] ?>" required>
                        <button type="submit" name="update">Update</button>
                    </form>
                    <!-- Delete Form -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $s["id"] ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
