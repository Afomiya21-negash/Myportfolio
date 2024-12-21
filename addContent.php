<?php
require_once 'connection/db.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    die("Invalid request method.");
}
if (!isset($_POST['section'], $_POST['title'], $_FILES['image'])) {
    die("Required fields are missing.");
}


$section = $_POST['section'];
$title = $_POST['title'];
$description = $_POST['description'] ?? NULL;
$project_link = $_POST['project_link'] ?? NULL;

// Debug: Print form data
var_dump($section, $title, $description, $project_link);

// Handle File Upload
$image = $_FILES['image'];

if ($image['error'] !== UPLOAD_ERR_OK) {
    die("File upload error: " . $image['error']);
}

$imageFileName = "uploads/" . uniqid() . "-" . basename($image['name']);
move_uploaded_file($image['tmp_name'], $imageFileName);

// Insert Content into Database
if ($db->createContent($section, $title, $description, $imageFileName, $project_link)) {
    echo "Content added successfully!";
    header("Location: admin.php");
    exit;
} else {
    die("Database insertion failed.");
}
?>
