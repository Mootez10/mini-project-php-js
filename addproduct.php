<?php
include("connection.php");

try {
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $productName = $_POST['product_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $uploadDir = 'uploads/';
            $imagePath = $uploadDir . $imageName;

            // Create the uploads directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Move uploaded file to the uploads directory
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // Prepare SQL query to insert product data
                $stmt = $conn->prepare("INSERT INTO products (product_name, price, category, description, image) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sdsss", $productName, $price, $category, $description, $imagePath);

                // Execute the statement
                if ($stmt->execute()) {
                    // Redirect to home.php
                    header("Location: adminHome.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                echo "Failed to upload image.";
            }
        } else {
            echo "No image uploaded.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<nav class="flex justify-between bg-gray-900 text-white w-full">
        <div class="px-5 xl:px-12 py-6 flex w-full items-center">
          <a class="text-3xl font-bold font-heading" href="home.php">
            3M TECH
          </a>
          <!-- Search Bar -->
          <div class="hidden md:flex flex-grow ml-8">
            <input style="width: 60%; margin-left: 190px;" type="text" placeholder="Search" class="w-full px-4 py-2 bg-gray-800 text-white rounded-md focus:outline-none focus:bg-gray-700">
          </div>
          <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12" style="margin-right: 10%;">
            <li><a class="hover:text-gray-200" href="home.php">Home</a></li>
            <li class="relative" id="dropdownButton">
                <button class=" hover:text-gray-200 outline-none focus:outline-none flex justify-between" href="#" onclick="toggleDropdown()">
                    Category
                    <img width="35" class="-mt-1"  src="./icons.svg" />
                </button>

            <div id="dropdown"
            class="lg:absolute bg-blue-950 rounded-md p-2 lg:w-36  mt-2 hidden">
                <ul class="space-y-2">
                    <li>
                        <a href="Iphones.html" class="flex p-2 font-medium text-white-950 rounded-md ">Iphones</a>
                    </li>
                    <li>
                        <a href="smartwatch.html" class="flex p-2 font-medium text-white-950 rounded-md ">Smart Watch</a>
                    </li>
                    <li>
                        <a href="airpods.html" class="flex p-2 font-medium text-white-950 rounded-md ">Airpods</a>
                    </li>
                </ul>
            </div>
            <script>
              function toggleDropdown(){
                let   dropdown = document.querySelector('#dropdownButton #dropdown');
                dropdown.classList.toggle("hidden");
              }
            </script>
            </li>
            <li><a class="hover:text-gray-200" href="#">Collections</a></li>
            <li><a class="hover:text-gray-200" href="Contact.html">Contact Us</a></li>
          </ul>
          <div class="hidden xl:flex items-center space-x-5 ">
            <a class="hover:text-gray-200" href="Login.php">
              <!-- Add your Cart icon SVG here -->
              <img width="35" src="./user.svg" />
            </a>
            <a class="hover:text-gray-200" href="#">
              <img width="40" src="./panier.svg" />
            </a>
          </div>
          <!-- Responsive navbar -->
          <a class="xl:hidden flex mr-6 items-center" href="#">
            <!-- Add your Responsive Navbar icon SVG here -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </a>
          <a class="navbar-burger self-center mr-12 xl:hidden" href="#">
            <!-- Add your Navbar Burger icon SVG here -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </a>
        </div>
      </nav>
    <div id="top">

            
                

    <!-- Add Product Form -->
    <div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Product</h2>
        <form action="addproduct.php" method="POST" enctype="multipart/form-data">
            <!-- Product Name -->
            <div class="mb-4">
                <label for="product_name" class="block text-gray-700 font-medium mb-2">Product Name</label>
                <input 
                    type="text" 
                    id="product_name" 
                    name="product_name" 
                    class="w-full px-4 py-2 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:border-blue-300" 
                    placeholder="Enter product name" 
                    required
                />
            </div>

            <!-- Product Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-medium mb-2">Price (DT)</label>
                <input 
                    type="number" 
                    id="price" 
                    name="price" 
                    step="0.01" 
                    class="w-full px-4 py-2 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:border-blue-300" 
                    placeholder="Enter price" 
                    required
                />
            </div>

            <!-- Product Category -->
            <div class="mb-4">
                <label for="category" class="block text-gray-700 font-medium mb-2">Category</label>
                <select 
                    id="category" 
                    name="category" 
                    class="w-full px-4 py-2 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                    required
                >
                    <option value="" disabled selected>Select a category</option>
                    <option value="iphones">Iphones</option>
                    <option value="smartwatches">Smart Watches</option>
                    <option value="airpods">Airpods</option>
                    <option value="tv">TV</option>
                    <option value="cases">Cases</option>
                </select>
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    class="w-full px-4 py-2 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:border-blue-300" 
                    placeholder="Enter product description"
                    required
                ></textarea>
            </div>

            <!-- Upload Image -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium mb-2">Product Image</label>
                <input 
                    type="file" 
                    id="image" 
                    name="image" 
                    class="w-full px-4 py-2 bg-gray-100 border rounded-md focus:outline-none focus:ring focus:border-blue-300" 
                    accept="image/*"
                    required
                />
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button 
                    type="submit" 
                    class="w-full px-4 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded-md font-medium focus:outline-none focus:ring focus:ring-blue-300"
                >
                    Add Product
                </button>
            </div>
        </form>
    </div>

</body>
</html>
