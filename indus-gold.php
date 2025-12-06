<?php
include 'config.php';

// 1. Filter by Brand 'Indus Gold'
$whereClauses = ["b.name = 'Indus Gold'"];

// Optional: Filter by Category (if clicked from tabs)
// Note: You'll need to know your specific Category IDs to make the tabs strictly functional links
if (isset($_GET['cat'])) {
    $catId = intval($_GET['cat']);
    $whereClauses[] = "p.category_id = $catId";
}

// 2. Sorting
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indus Gold - Premium Men's PU Footwear | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-stone-50 theme-gold">

    <?php include 'header.php'; ?>

    <!-- Indus Gold Hero Banner -->
    <div class="relative bg-gray-900 h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x600/222/gold?text=Indus+Gold+Pattern" alt="Indus Gold Background" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-black opacity-80"></div>
        
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <div class="inline-block bg-white/90 p-3 rounded-lg mb-4 shadow-lg">
                <img src="assets/img/indusgold.png" alt="Indus Gold Logo" class="h-20 md:h-24 w-auto object-contain">
            </div>
            <h1 class="text-2xl md:text-4xl font-bold text-white tracking-widest uppercase">Premium PU Footwear</h1>
            <p class="text-amber-400 mt-2 font-medium tracking-wide">For the Gentle Man</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Description -->
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">The Gold Standard in Comfort</h2>
            <p class="text-gray-600 leading-relaxed">
                Indus Gold represents our premium range of Men's PU (Polyurethane) footwear. Designed for durability and style, these slippers and sandals offer superior cushioning and a classic look perfect for daily wear.
            </p>
        </div>

        <!-- Filters & Sort -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-stone-50 py-4 border-b border-gray-200 md:border-none">
            <div class="flex space-x-2 mb-4 md:mb-0 overflow-x-auto w-full md:w-auto pb-2 md:pb-0">
                <a href="indus-gold.php" class="px-5 py-2 rounded-full bg-amber-600 text-white font-medium shadow-md transition hover:bg-amber-700 whitespace-nowrap">All Products</a>
                <!-- Example links - assumes you might add logic for specific category filtering later -->
                <a href="#" class="px-5 py-2 rounded-full bg-white text-gray-600 font-medium shadow-sm border border-gray-200 hover:bg-gray-50 hover:text-amber-600 transition whitespace-nowrap">PU Slippers</a>
            </div>

            <div class="w-full md:w-auto">
                <form id="sortForm" method="GET">
                    <select name="sort" onchange="document.getElementById('sortForm').submit()" class="block w-full md:w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm rounded-md shadow-sm bg-white cursor-pointer">
                        <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Featured</option>
                        <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-transparent hover:border-amber-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=Product'">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-amber-600 font-semibold tracking-wider uppercase mb-1"><?php echo $row['brand_name']; ?></p>
                            <h3 class="text-gray-900 font-medium text-sm md:text-base mb-2 line-clamp-1"><?php echo $row['name']; ?></h3>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-800">₹<?php echo $row['min_price']; ?></span>
                                <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-amber-100 hover:text-amber-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 text-gray-500">No products found for Indus Gold.</div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>