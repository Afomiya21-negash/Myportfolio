<?php
require_once 'connection/db.php';

// Check if an ID was provided
if (!isset($_GET['id'])) {
    die("No content ID provided.");
}

$content_id = (int)$_GET['id'];

// Fetch existing content from the database
$result = $db->conn->prepare("SELECT * FROM portfolio_content WHERE id=?");
$result->bind_param("i", $content_id);
$result->execute();
$content = $result->get_result()->fetch_assoc();

// Check if content exists
if (!$content) {
    die("Content not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'];
    $title = $_POST['title'];
    $description = $_POST['description'] ?? NULL;
    $project_link = $_POST['project_link'] ?? NULL;

    // Handle file upload if a new file is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $imageFileName = "uploads/" . uniqid() . "-" . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imageFileName);
    } else {
        $imageFileName = $content['image_url']; // Keep the existing image if no new one is uploaded
    }

    // Update the database
    $update = $db->conn->prepare("UPDATE portfolio_content 
        SET section=?, title=?, description=?, image_url=?, project_link=? 
        WHERE id=?");

    $update->bind_param("sssssi", $section, $title, $description, $imageFileName, $project_link, $content_id);

    if ($update->execute()) {
        header("Location: admin.php?update=success");
        exit;
    } else {
        die("Error updating content.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Content</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h2>Edit Content</h2>

<form action="edit_content.php?id=<?= $content['id']; ?>" method="POST" enctype="multipart/form-data">

    <!-- Section Selector -->
    <label>Section:</label>
    <select name="section" required>
        <option value="hero" <?= $content['section'] === 'hero' ? 'selected' : ''; ?>>Hero</option>
        <option value="about" <?= $content['section'] === 'about' ? 'selected' : ''; ?>>About</option>
        <option value="experience" <?= $content['section'] === 'experience' ? 'selected' : ''; ?>>Experience</option>
        <option value="projects" <?= $content['section'] === 'projects' ? 'selected' : ''; ?>>Projects</option>
    
    </select>

    <!-- Title Field -->
    <label>Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($content['title']); ?>" required>

    <!-- Description Field -->
    <label>Description:</label>
    <textarea name="description"><?= htmlspecialchars($content['description']); ?></textarea>

    <!-- Image Upload -->
    <label>Current Image:</label><br>
    <img src="<?= htmlspecialchars($content['image_url']); ?>" width="150" alt="Current Image"><br><br>

    <label>Upload New Image (optional):</label>
    <input type="file" name="image">

    <!-- Project Link Field -->
    <label>Project Link (if applicable):</label>
    <input type="url" name="project_link" value="<?= htmlspecialchars($content['project_link']); ?>">

    <!-- Submit Button -->
    <button type="submit">Save Changes</button>
</form>

</body>
</html>
