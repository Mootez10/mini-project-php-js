<?php
session_start(); // Start the session

// Check if the user is logged in and their usertype
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'admin') {
    // Show a 404 error or forbidden page
    http_response_code(403); // Set HTTP status code to 403 Forbidden
    echo "<h1>403 Forbidden</h1>";
    echo "<p>You do not have permission to access this page.</p>";
    exit(); // Stop further script execution
}

// Include database connection
include("connection.php");

// Your existing code to fetch products
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

$query = "SELECT * FROM products WHERE product_name LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchTerm%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$products = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link href="/css/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="flex justify-between bg-gray-900 text-white w-full">
        <div class="px-5 xl:px-12 py-6 flex w-full items-center">
            <a class="text-3xl font-bold font-heading" href="home.php">3M TECH</a>
            <div class="hidden md:flex flex-grow ml-8">
                <!-- Search Bar Form -->
                <form action="home.php" method="GET" class="w-full flex items-center">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" placeholder="Search" class="w-full px-4 py-2 bg-gray-800 text-white rounded-md focus:outline-none focus:bg-gray-700">
                    <button type="submit" class="ml-2 px-4 py-2 bg-gray-600 rounded-md">Search</button>
                </form>
            </div>
            <!-- Other navbar content -->
            <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12" style="margin-right: 10%;">
                <li><a class="hover:text-gray-200" href="home.php">Home</a></li>
                <li><a class="hover:text-gray-200" href="#">Category</a></li>
                <li><a class="hover:text-gray-200" href="Contact.html">Contact Us</a></li>
                <li>
                    <form action="logout.php" method="POST" class="inline">
                        <button type="submit" class="hover:text-gray-200 bg-red-600 px-4 py-1 rounded-md text-white">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div id="top">
        <section class="bg-white dark:bg-gray-900 h-auto">
            <div class="container px-6 py-6 mx-auto"> <!-- Reduced padding (py-4) -->
                <div class="lg:flex lg:-mx-2">
                    <div class="space-y-3 lg:w-1/5 lg:px-1 lg:space-y-7">
                        <!-- Sidebar Links -->
                        <div class="relative">
                            <a href="#" class="block font-medium text-gray-500 py-2 dark:text-gray-300 hover:text-sky-600" onclick="toggleSection('categoriesSection')">Categories</a>
                            <div id="categoriesSection" class="hidden mt-2">
                                <a href="addcategory.php" class="block px-4 py-2 text-gray-700 hover:text-sky-600">Add Category</a>
                            </div>
                        </div>
                        <!-- Products Section -->
                        <div class="relative">
                            <a href="#" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600" onclick="toggleSection('productsSection')">Products</a>
                            <div id="productsSection" class="hidden mt-2">
                                <a href="addproduct.php" class="block px-4 py-2 text-gray-700 hover:text-sky-600">Add Product</a>
                            </div>
                        </div>
                        <div class="relative">
                            <a href="#" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600" onclick="toggleSection('brandsSection')">Brands</a>
                            <div id="brandsSection" class="hidden mt-2">
                                <a href="addbrand.php" class="block px-4 py-2 text-gray-700 hover:text-sky-600">Add Brand</a>
                            </div>
                        </div>
                        <div class="relative">
                            <a href="#" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600" onclick="toggleSection('statisticsSection')">Statistics</a>
                        </div>
                    </div>

                    <script>
                        function toggleSection(sectionId) {
                            const section = document.getElementById(sectionId);
                            section.classList.toggle('hidden');
                        }
                    </script>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-4"> <!-- Reduced margin-top -->
                        <?php foreach ($products as $product): ?>
                            <div class="relative flex flex-col items-center justify-center w-full max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                                <!-- Product Image -->
                                <img
                                    class="object-cover w-full h-72 xl:h-80"
                                    src="<?php echo $product['image']; ?>"
                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>" />

                                <!-- Overlay Button -->
                                <a
                                    href="details.php?id=<?php echo $product['id']; ?>"
                                    class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 bg-black bg-opacity-50 transition-opacity duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12h.01M12 12h.01M9 12h.01M21 12c0-4.418-7.333-8-9-8s-9 3.582-9 8 7.333 8 9 8 9-3.582 9-8zm-9 4v.01V16v.01V16z" />
                                    </svg>
                                </a>

                                <!-- Product Details -->
                                <div class="p-4 w-full text-center">
                                    <h4 class="mt-2 text-lg font-medium text-gray-700 dark:text-gray-200">
                                        <?php echo htmlspecialchars($product['product_name']); ?>
                                    </h4>
                                    <p class="text-blue-500 font-semibold">
                                        <?php echo htmlspecialchars($product['price']); ?> dt
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>