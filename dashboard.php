<?php include "db.php"; session_start();
if (!isset($_SESSION["admin"])) die("Access denied");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Admin Dashboard</h2>
<a href="logout.php">Logout</a>
<table border="1">
<tr><th>Name</th><th>Email</th><th>Resume</th><th>Status</th><th>Action</th></tr>
<?php
$result = $conn->query("SELECT * FROM users");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td><a href='{$row['resume_path']}' target='_blank'>View</a></td>
        <td>{$row['status']}</td>
        <td>
            <div class='group'>
            <form method='post'>
                <input type='hidden' name='id' value='{$row['id']}'>
                <select name='status'>
                    <option " . ($row['status'] == "Pending" ? "selected" : "") . ">Pending</option>
                    <option " . ($row['status'] == "Selected" ? "selected" : "") . ">Selected</option>
                    <option " . ($row['status'] == "Rejected" ? "selected" : "") . ">Rejected</option>
                </select>
                <button name='update'>Update</button>
            </form>
            </div>
        </td>
    </tr>";
}
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $status = $_POST["status"];
    $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>
</table>
</body>
</html>
