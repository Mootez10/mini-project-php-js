<?php
// Include database connection
include("connection.php");

// Check if an 'id' is provided in the URL
if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

$productId = $_GET['id'];

// Query to delete the product
$query = "DELETE FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productId);

if ($stmt->execute()) {
    header("Location: adminHome.php");
    exit;
} else {
    echo "Error deleting product.";
}
?>
