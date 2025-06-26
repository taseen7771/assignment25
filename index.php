<?php include "db.php"; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $file = $_FILES["resume"];

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    if (!in_array($ext, ["pdf", "doc", "docx"])) {
        die("Only PDF, DOC, DOCX allowed.");
    }

    if ($file["size"] > 2 * 1024 * 1024) {
        die("File too large (max 2MB).");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    $filename = uniqid() . "." . $ext;
    $destination = "uploads/" . $filename;
    move_uploaded_file($file["tmp_name"], $destination);

    $stmt = $conn->prepare("INSERT INTO users (name, email, resume_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $destination);
    $stmt->execute();

    echo "<p>✅ Application Submitted!</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>User Registration</h2>
<div class="group">
    <form method="post" enctype="multipart/form-data">
        <input name="name" placeholder="Name" required><br>
        <input name="email" type="email" placeholder="Email" required><br>
        <input type="file" name="resume" required><br>
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
