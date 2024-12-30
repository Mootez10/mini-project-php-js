<?php
// Include database connection
include("connection.php");

// Check if an 'id' is provided in the URL
if (!isset($_GET['id'])) {
    echo "No product ID provided.";
    exit;
}

$productId = $_GET['id'];

// Query to fetch product details
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $productId); // "i" indicates the parameter type is integer
$stmt->execute();
$result = $stmt->get_result();

// Fetch the product
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="/css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="flex justify-between bg-gray-900 text-white w-full">
        <div class="px-5 xl:px-12 py-6 flex w-full items-center">
            <a class="text-3xl font-bold font-heading" href="home.php">3M TECH</a>
        </div>
    </nav>

    <!-- Product Details Section -->
    <div class="container mx-auto px-6 py-10">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
            <!-- Product Image -->
            <div class="flex justify-center">
                <img class="w-full max-w-md rounded-lg" src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>

            <!-- Product Info -->
            <div class="text-center mt-6">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">
                    <?php echo htmlspecialchars($product['product_name']); ?>
                </h2>
                <p class="text-xl text-blue-500 font-semibold mb-4">
                    <?php echo htmlspecialchars($product['price']); ?> dt
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>

                <!-- Buttons -->
                <div class="flex justify-center gap-4">
                    <a href="adminHome.php" class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition duration-300">
                        Back to Home
                    </a>
                    <a href="updateproduct.php?id=<?php echo $productId; ?>" class="px-6 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-400 transition duration-300">
                        Update
                    </a>
                    <a href="deleteproduct.php?id=<?php echo $productId; ?>" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-400 transition duration-300" onclick="return confirm('Are you sure you want to delete this product?');">
                        Delete
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>