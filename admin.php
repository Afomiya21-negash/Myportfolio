<?php
require_once 'connection/db.php';

// Fetch all content from the database
$result = $db->conn->query("SELECT * FROM portfolio_content ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h2>Manage Portfolio</h2>

<!-- Add New Content Form -->
<form action="addContent.php" method="POST" enctype="multipart/form-data">
    <label>Section:</label>
    <select name="section" required>
        <option value="hero">Hero</option>
        <option value="about">About</option>
        <option value="experience">Experience</option>
        <option value="projects">Projects</option>
        
    </select>

    <label>Title:</label>
    <input type="text" name="title">

    <label>Description:</label>
    <textarea name="description"></textarea>

    <label>Image:</label>
    <input type="file" name="image">

    <label>Project Link (if applicable):</label>
    <input type="url" name="project_link">

    <button type="submit" name="add">Add Content</button>
</form>

<!-- Display Current Portfolio Content -->
<h3>Current Content</h3>

<table>
    <tr>
        <th>Section</th>
        <th>Title</th>
        <th>Description</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['section']); ?></td>
            <td><?= htmlspecialchars($row['title']); ?></td>
            <td><?= htmlspecialchars($row['description']); ?></td>
            <td><img src="<?= htmlspecialchars($row['image_url']); ?>" width="100" alt="Image"></td>
            <td>
                <a href="editContent.php?id=<?= $row['id']; ?>">Edit</a> | 
                <a href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
            </td>
        </tr>
    <?php } 
} else { ?>
    <tr>
        <td colspan="5">No content available.</td>
    </tr>
<?php } ?>

</table>

</body>
</html>
