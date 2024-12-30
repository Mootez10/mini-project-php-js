<?php
// Include database connection
include("connection.php");

// Check if a search term is submitted
$searchTerm = '';
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
}

// Query to fetch products based on the search term
$query = "SELECT * FROM products WHERE product_name LIKE ?";
$stmt = $conn->prepare($query);
$searchTerm = "%$searchTerm%"; // To include the wildcard '%' for searching
$stmt->bind_param("s", $searchTerm); // "s" indicates the parameter type is string
$stmt->execute();
$result = $stmt->get_result();

// Fetch all products
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
        <section class="bg-white dark:bg-gray-900">
            <div class="container px-6 py-6 mx-auto">
                <div class="lg:flex lg:-mx-2 mt-20">
                    <!-- Sidebar -->
                    <div class="space-y-3 lg:w-1/5 lg:px-1 lg:space-y-7">
                        <a href="home.php" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Produits</a>
                        <a href="Iphones.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Iphones</a>
                        <a href="smartwatch.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Smart Watch</a>
                        <a href="airpods.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Airpods</a>
                        <a href="casques.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Casques</a>
                        <a href="charger.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Charger</a>
                        <a href="TV.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">TV</a>
                        <a href="cases.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Cases</a>
                        <a href="microphone.html" class="block font-medium text-gray-500 dark:text-gray-300 hover:text-sky-600">Microphone</a>
                    </div>

                    <!-- Product Grid -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <?php foreach ($products as $product): ?>
                            <div class="relative flex flex-col items-center justify-center w-full max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
                                <!-- Product Image -->
                                <img 
                                    class="object-cover w-full h-72 xl:h-80" 
                                    src="<?php echo $product['image']; ?>" 
                                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                                />
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
