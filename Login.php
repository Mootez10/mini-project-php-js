<?php
include("connection.php");
session_start(); // Start the session

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (isset($row['usertype'])) {
            $usertype = $row['usertype'];

            // Store usertype in session
            $_SESSION['usertype'] = $usertype;

            // Redirect based on user type
            if ($usertype == "user") {
                header("Location: home.php");
                exit();
            } elseif ($usertype == "admin") {
                header("Location: adminHome.php");
                exit();
            }
        } else {
            echo "User type not found.";
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginPage</title>
    <link href="./output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <nav class="flex justify-between bg-gray-900 text-white w-full">
        <div class="px-5 xl:px-12 py-6 flex w-full items-center">
            <a class="text-3xl font-bold font-heading" href="home.php">
                3M TECH
            </a>
            <!-- Search Bar -->
            <div class="hidden md:flex flex-grow ml-8">
                <input style="width: 60%; margin-left: 190px;" type="text" placeholder="Search"
                    class="w-full px-4 py-2 bg-gray-800 text-white rounded-md focus:outline-none focus:bg-gray-700">
            </div>
            <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12" style="margin-right: 10%;">
                <li><a class="hover:text-gray-200" href="home.php">Home</a></li>
                <li class="relative" id="dropdownButton">
                    <button class=" hover:text-gray-200 outline-none focus:outline-none flex justify-between" href="#"
                        onclick="toggleDropdown()">
                        Category
                        <img width="35" class="-mt-1" src="./icons.svg" />
                    </button>

                    <div id="dropdown" class="lg:absolute bg-blue-950 rounded-md p-2 lg:w-36  mt-2 hidden">
                        <ul class="space-y-2">
                            <li>
                                <a href="Iphones.html" class="flex p-2 font-medium text-white-950 rounded-md ">Iphones</a>
                            </li>
                            <li>
                                <a href="smartwatch.html" class="flex p-2 font-medium text-white-950 rounded-md ">Smart
                                    Watch</a>
                            </li>
                            <li>
                                <a href="airpods.html" class="flex p-2 font-medium text-white-950 rounded-md ">Airpods</a>
                            </li>
                        </ul>
                    </div>
                    <script>
                        function toggleDropdown() {
                            let dropdown = document.querySelector('#dropdownButton #dropdown');
                            dropdown.classList.toggle("hidden");
                        }
                    </script>
                </li>
                <li><a class="hover:text-gray-200" href="#">Collections</a></li>
                <li><a class="hover:text-gray-200" href="Contact.html">Contact Us</a></li>
            </ul>
            <div class="hidden xl:flex items-center space-x-5 ">
                <a class="hover:text-gray-200" href="login.php">
                    <img width="35" src="./user.svg" />
                </a>
                <a class="hover:text-gray-200" href="#">
                    <img width="40" src="./panier.svg" />
                </a>
            </div>
            <!-- Responsive navbar -->
            <a class="xl:hidden flex mr-6 items-center" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </a>
            <a class="navbar-burger self-center mr-12 xl:hidden" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="bg-white dark:bg-gray-900">
        <div class="flex justify-center h-screen">
            <div class="hidden bg-cover lg:block lg:w-2/3 ml-4"
                style="background-image: url(https://images.unsplash.com/photo-1616763355603-9755a640a287?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80)">
                <div class="flex items-center h-full px-20 bg-gray-900 bg-opacity-40">
                    <div>
                        <h2 class="text-4xl font-bold text-white">3M TECH</h2>
                        <p class="max-w-xl mt-3 text-gray-300">Chez 3M Tech, nous nous engageons à fournir à nos clients les
                            meilleurs produits, sélectionnés avec soin pour leur qualité, leur performance et leur design.
                            Avec notre service client exceptionnel, des options de paiement sécurisées et une livraison
                            rapide</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center w-full max-w-md px-6 mx-auto lg:w-2/6">
                <div class="flex-1 -mt-28">
                    <div class="text-center">
                        <h2 class="text-4xl font-bold text-center text-gray-700 dark:text-white">3M TECH</h2>
                        <p class="mt-3 text-gray-500 dark:text-gray-300">Sign in to access your account</p>
                    </div>

                    <div class="mt-8">
                        <form name="form" action="login.php" onSubmit="return isValid()" method="POST">
                            <div>
                                <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-200">Email
                                    Address</label>
                                <input type="email" name="email" id="email" placeholder="example@example.com"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            <div class="mt-6">
                                <div class="flex justify-between mb-2">
                                    <label for="password" class="text-sm text-gray-600 dark:text-gray-200">Password</label>
                                    <a href="#" class="text-sm text-gray-400 focus:text-blue-500 hover:text-blue-500 hover:underline">Forgot password?</a>
                                </div>

                                <input type="password" name="password" id="password" placeholder="Your Password"
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border border-gray-200 rounded-md dark:placeholder-gray-600 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700 focus:border-blue-400 dark:focus:border-blue-400 focus:ring-blue-400 focus:outline-none focus:ring focus:ring-opacity-40" />
                            </div>

                            <div class="mt-6">
                                <button id="btn" name="submit" value="login" type="submit"
                                    class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-blue-500 rounded-md hover:bg-blue-400 focus:outline-none focus:bg-blue-400 focus:ring focus:ring-blue-300 focus:ring-opacity-50">
                                    Sign in
                                </button>
                            </div>

                        </form>

                        <p class="mt-6 text-sm text-center text-gray-400">Don&#x27;t have an account yet? <a href="Register.php"
                                class="text-blue-500 focus:outline-none focus:underline hover:underline">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
