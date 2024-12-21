<?php
require_once 'connection/db.php';

$id = $_GET['id'];

if ($db->deleteContent($id)) {
    header("Location: admin.php");
} else {
    echo "Error deleting content.";
}
?>
