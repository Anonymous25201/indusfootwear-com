<?php
include 'config.php';

// --- 1. Fetch Safety Shoes (Specific Brand or Category) ---
// Adjust 'Indus Safety' to match your exact Brand Name in DB
$safety_sql = "SELECT p.*, b.name as brand_name, 
               (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
               FROM products p 
               JOIN brands b ON p.brand_id = b.id 
               WHERE b.name LIKE '%Safety%' OR b.name LIKE '%Rhino%'
               ORDER BY p.created_at DESC LIMIT 4";
$safety_res = $conn->query($safety_sql);

// --- 2. Fetch School Shoes ---
$school_sql = "SELECT p.*, b.name as brand_name, 
               (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
               FROM products p 
               JOIN brands b ON p.brand_id = b.id 
               WHERE b.name LIKE '%School%' 
               ORDER BY p.created_at DESC LIMIT 4";
$school_res = $conn->query($school_sql);

// --- 3. Fetch General Collection (Sorting Logic) ---
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";

if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";
if($sortOption == 'popularity') $orderBy = "p.id ASC"; // Placeholder for popularity

$coll_sql = "SELECT p.*, b.name as brand_name, 
             (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
             FROM products p 
             LEFT JOIN brands b ON p.brand_id = b.id 
             ORDER BY $orderBy LIMIT 10";
$coll_res = $conn->query($coll_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indus Footwear - Homepage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-teal-50">

    <!-- 1. HEADER PLACEHOLDER -->
<?php include 'header.php'; ?>
    <!-- 2. MAIN PAGE CONTENT -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Hero Banner Section -->
        <div id="hero-banner" class="mb-12 opacity-0 translate-y-5 transition-all duration-1000 ease-out">
            <a href="#" class="block rounded-lg shadow-md overflow-hidden group">
                <img class="w-full h-auto object-cover transition-transform duration-500 ease-in-out group-hover:scale-105" src="assets/img/banner-22.jpg" alt="Summer Sale Banner" onerror="this.src='https://placehold.co/1200x400/0891b2/white?text=Main+Banner'">
            </a>
        </div>

        <!-- Shop By Category Section -->
        <div class="mb-16 mt-12"> 
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Shop By Category</h2>
            <div class="grid grid-cols-3 md:grid-cols-3 gap-2 md:gap-6">
                <a href="men.php" class="group relative block rounded-lg shadow-lg overflow-hidden">
                    <img src="assets/img/men banner.jpeg" alt="Men's Shoes" class="h-auto w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" onerror="this.src='https://placehold.co/400x400/333/white?text=Men'">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div> 
                    <div class="absolute inset-0 flex items-center justify-center p-2">
                        <h2 class="text-white text-lg md:text-4xl font-extrabold tracking-wider uppercase transition-all duration-300 group-hover:scale-110 text-shadow-heavy">Men</h2>
                    </div>
                </a>

                <a href="women.php" class="group relative block rounded-lg shadow-lg overflow-hidden">
                    <img src="assets/img/womenbanner.jpeg" alt="Women's Shoes" class="h-auto w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" onerror="this.src='https://placehold.co/400x400/555/white?text=Women'">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-2">
                        <h2 class="text-white text-lg md:text-4xl font-extrabold tracking-wider uppercase transition-all duration-300 group-hover:scale-110 text-shadow-heavy">Women</h2>
                    </div>
                </a>

                <a href="kids.php" class="group relative block rounded-lg shadow-lg overflow-hidden">
                    <img src="assets/img/kidsbanner.jpg" alt="Kids' Shoes" class="h-auto w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110" onerror="this.src='https://placehold.co/400x400/777/white?text=Kids'">
                    <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-2">
                        <h2 class="text-white text-lg md:text-4xl font-extrabold tracking-wider uppercase transition-all duration-300 group-hover:scale-110 text-shadow-heavy">Kids</h2>
                    </div>
                </a>
            </div>
        </div>

        <!-- Auto-height Carousel Section -->
        <div id="banner-carousel" class="carousel-container">
            <div class="carousel-slider">
                <div class="carousel-slide">
                    <img src="assets/img/1.webp" alt="New Arrivals Banner" onerror="this.src='https://placehold.co/1200x400/0891b2/white?text=New+Arrivals'">
                </div>
                <div class="carousel-slide">
                    <img src="assets/img/2.webp" alt="Summer Sale Banner" onerror="this.src='https://placehold.co/1200x400/0f766e/white?text=Summer+Sale'">
                </div>
                <div class="carousel-slide">
                    <img src="assets/img/banner-3.jpg" alt="Kids Collection Banner" onerror="this.src='https://placehold.co/1200x400/f97316/white?text=Kids+Collection'">
                </div>
            </div>
            <div class="carousel-dots" id="carousel-dots-container"></div>
        </div>

        <!-- Shop Our Brands Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Shop Our Brands</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
                <!-- Using simple filters for now, ideally these link to brand filtered pages -->
                <a href="men.php?brand=1" class="group brand-card block bg-white p-6 rounded-lg shadow-lg overflow-hidden transition-all duration-500 ease-in-out hover:scale-105 opacity-90 hover:opacity-100 cursor-pointer">
                    <img src="assets/img/indusgold.png" alt="Indus Gold" class="h-28 w-auto mx-auto object-contain" onerror="this.src='https://placehold.co/200x112/ffffff/333?text=Indus+Gold'">
                    <h3 class="text-center mt-4 font-semibold text-gray-700">Indus Gold</h3>
                </a>
                <a href="women.php?brand=2" class="group brand-card block bg-white p-6 rounded-lg shadow-lg overflow-hidden transition-all duration-500 ease-in-out hover:scale-105 opacity-90 hover:opacity-100 cursor-pointer">
                    <img src="assets/img/induslite.jpg" alt="Induslite" class="h-28 w-auto mx-auto object-contain" onerror="this.src='https://placehold.co/200x112/ffffff/333?text=Induslite'">
                    <h3 class="text-center mt-4 font-semibold text-gray-700">Induslite</h3>
                </a>
                <a href="men.php?brand=3" class="group brand-card block bg-white p-6 rounded-lg shadow-lg overflow-hidden transition-all duration-500 ease-in-out hover:scale-105 opacity-90 hover:opacity-100 cursor-pointer">
                    <img src="assets/img/indusprime.png" alt="Indus Prime" class="h-28 w-auto mx-auto object-contain" onerror="this.src='https://placehold.co/200x112/ffffff/333?text=Indus+Prime'">
                    <h3 class="text-center mt-4 font-semibold text-gray-700">Indus Prime</h3>
                </a>
                <a href="women.php?brand=4" class="group brand-card block bg-white p-6 rounded-lg shadow-lg overflow-hidden transition-all duration-500 ease-in-out hover:scale-105 opacity-90 hover:opacity-100 cursor-pointer">
                    <img src="assets/img/indus-logonew.png" alt="Indus Originals" class="h-28 w-auto mx-auto object-contain" onerror="this.src='https://placehold.co/200x112/ffffff/333?text=Indus+Originals'">
                    <h3 class="text-center mt-4 font-semibold text-gray-700">Indus Originals</h3>
                </a>
            </div>
        </div>

        <!-- Safety Shoes Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Explore Our Safety Shoes</h2>
            <div class="horizontal-scroller grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php while($row = $safety_res->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 w-full">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="aspect-square w-full bg-gray-50 overflow-hidden">
                            <img class="w-full h-full object-contain" src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" onerror="this.src='https://placehold.co/400x400/333/white?text=Safety+Boot'">
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-500 text-xs tracking-widest title-font mb-1 uppercase"><?php echo $row['brand_name']; ?></h3>
                            <h2 class="text-base font-medium text-gray-900 mb-1 truncate"><?php echo $row['name']; ?></h2>
                            <p class="text-gray-700 font-bold">₹<?php echo $row['min_price']; ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- School Shoes Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Shop Our School Shoes</h2>
            <div class="horizontal-scroller grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php while($row = $school_res->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 w-full">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                         <div class="aspect-square w-full bg-gray-50 overflow-hidden">
                            <img class="w-full h-full object-contain" src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" onerror="this.src='https://placehold.co/400x400/f0f0f0/black?text=School+Shoe'">
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-gray-500 text-xs tracking-widest title-font mb-1 uppercase"><?php echo $row['brand_name']; ?></h3>
                            <h2 class="text-base font-medium text-gray-900 mb-1 truncate"><?php echo $row['name']; ?></h2>
                            <p class="text-gray-700 font-bold">₹<?php echo $row['min_price']; ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- Product Grid Section -->
        <div class="w-full">
             <main class="w-full">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Our Collection</h1>
                    <div>
                         <form id="sortForm" method="GET">
                            <select name="sort" onchange="document.getElementById('sortForm').submit()" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500 sm:text-sm rounded-md shadow-sm">
                                <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                                <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                                <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                            </select>
                         </form>
                    </div>
                </div>

                <!-- Dynamic Products -->
                <div id="product-grid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <?php while($row = $coll_res->fetch_assoc()): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                        <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                             <div class="aspect-[4/3] w-full bg-gray-50 overflow-hidden">
                                <img class="h-full w-full object-contain" src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['name']; ?>" onerror="this.src='https://placehold.co/400x400/ffffff/333?text=Product+Image'">
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-500 text-xs tracking-widest title-font mb-1 uppercase"><?php echo $row['brand_name']; ?></h3>
                                <h2 class="text-base font-medium text-gray-900 mb-1 truncate"><?php echo $row['name']; ?></h2>
                                <p class="text-gray-700 font-bold">₹<?php echo $row['min_price']; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </main>
        </div>
        
    </div>
    <!-- 2. MAIN PAGE CONTENT ENDS -->

    <!-- 3. FOOTER PLACEHOLDER -->
<?php include 'footer.php'; ?>
    <!-- 4. JAVASCRIPT (Global Logic) -->
    <script src="assets/js/main.js"></script>

</body>
</html>