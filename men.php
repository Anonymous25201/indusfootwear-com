<?php
include 'config.php';

// --- 1. Filter Logic ---
$whereClauses = [];

// Default: Filter by Audience 'Men' (and 'Unisex' if you have it)
// We use a subquery or join to find the ID for 'Men' if we don't know it, 
// or just join audiences table.
$whereClauses[] = "a.name IN ('Men', 'Unisex')";

// Filter by Brand (from Sidebar)
if (isset($_GET['brand'])) {
    $brandId = intval($_GET['brand']);
    $whereClauses[] = "p.brand_id = $brandId";
}

// Filter by Category (from Sidebar)
if (isset($_GET['cat'])) {
    $catId = intval($_GET['cat']);
    $whereClauses[] = "p.category_id = $catId";
}

// Build WHERE string
$whereSQL = "";
if (count($whereClauses) > 0) {
    $whereSQL = "WHERE " . implode(' AND ', $whereClauses);
}

// --- 2. Sorting Logic ---
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC"; // Default

switch ($sortOption) {
    case 'price_low':
        $orderBy = "min_price ASC";
        break;
    case 'price_high':
        $orderBy = "min_price DESC";
        break;
    case 'popularity':
        // Assuming you might add a 'views' or 'sales' column later, 
        // for now we'll sort by ID (older products first = established) 
        // or just keep random/newest.
        $orderBy = "p.id ASC"; 
        break;
}

// --- 3. Main Product Query ---
// We join brands to get brand name
// We join audiences to filter by 'Men'
// We use a subquery to get the starting price (min_mrp) from variants
$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN audiences a ON p.audience_id = a.id
        LEFT JOIN categories c ON p.category_id = c.id
        $whereSQL
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Collection | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-50">

    <!-- 1. HEADER PLACEHOLDER -->
    <div id="header-placeholder"></div>

    <!-- 2. MAIN PAGE CONTENT -->
    <div class="relative h-64 bg-slate-900 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/1e293b/white?text=Mens+Collection" alt="Men's Collection" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-transparent to-slate-900 opacity-70"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-widest uppercase shadow-sm">Men's Collection</h1>
            <p class="text-slate-200 mt-2">Strength & Comfort Combined</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24 border border-slate-200">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="font-bold text-lg text-slate-700">Filters</h3>
                        <a href="men.php" class="text-xs text-red-500 hover:underline">Reset</a>
                    </div>
                    
                    <!-- Dynamic Categories -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Category</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $cat_res = $conn->query("SELECT * FROM categories");
                            while($c = $cat_res->fetch_assoc()):
                                $isActive = (isset($_GET['cat']) && $_GET['cat'] == $c['id']);
                                $colorClass = $isActive ? 'text-blue-600 font-bold' : 'hover:text-blue-600';
                            ?>
                            <li>
                                <a href="men.php?cat=<?php echo $c['id']; ?><?php echo isset($_GET['brand'])?'&brand='.$_GET['brand']:''; ?>" class="flex items-center <?php echo $colorClass; ?>">
                                    <span class="w-4 h-4 border border-slate-300 rounded mr-2 inline-block <?php echo $isActive ? 'bg-blue-600 border-blue-600' : ''; ?>"></span> 
                                    <?php echo $c['name']; ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <!-- Dynamic Brands -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Brand</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $brand_res = $conn->query("SELECT * FROM brands");
                            while($b = $brand_res->fetch_assoc()):
                                $isActive = (isset($_GET['brand']) && $_GET['brand'] == $b['id']);
                                $colorClass = $isActive ? 'text-blue-600 font-bold' : 'hover:text-blue-600';
                            ?>
                            <li>
                                <a href="men.php?brand=<?php echo $b['id']; ?><?php echo isset($_GET['cat'])?'&cat='.$_GET['cat']:''; ?>" class="flex items-center <?php echo $colorClass; ?>">
                                    <span class="w-4 h-4 border border-slate-300 rounded mr-2 inline-block <?php echo $isActive ? 'bg-blue-600 border-blue-600' : ''; ?>"></span> 
                                    <?php echo $b['name']; ?>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Products</p>
                    
                    <!-- Sorting Form -->
                    <form id="sortForm" method="GET">
                        <!-- Preserve existing filters -->
                        <?php if(isset($_GET['cat'])): ?><input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>"><?php endif; ?>
                        <?php if(isset($_GET['brand'])): ?><input type="hidden" name="brand" value="<?php echo $_GET['brand']; ?>"><?php endif; ?>
                        
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-2 border cursor-pointer">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                            <option value="popularity" <?php echo $sortOption=='popularity'?'selected':''; ?>>Sort by: Popularity</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        
                        <!-- Dynamic Card -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group h-full flex flex-col">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="flex-1">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-50 relative">
                                    <img src="<?php echo $row['image_path']; ?>" 
                                         alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                         class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500"
                                         onerror="this.src='https://placehold.co/400x400/f1f5f9/1e293b?text=No+Image'">
                                         
                                    <!-- Optional: New Badge logic if needed -->
                                    <?php if(strtotime($row['created_at']) > strtotime('-30 days')): ?>
                                        <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded">NEW</span>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-blue-600 font-semibold uppercase mb-1"><?php echo $row['brand_name']; ?></p>
                                    <h3 class="text-gray-900 font-medium text-sm md:text-base leading-tight mb-2"><?php echo $row['name']; ?></h3>
                                    <p class="text-gray-800 font-bold">
                                        <?php echo $row['min_price'] ? '₹' . number_format($row['min_price']) : 'N/A'; ?>
                                    </p>
                                </div>
                            </a>
                        </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- No Products Found State -->
                        <div class="col-span-full py-12 text-center">
                            <div class="inline-block p-4 rounded-full bg-slate-100 mb-4 text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                            <p class="text-gray-500">Try adjusting your filters or come back later.</p>
                            <a href="men.php" class="mt-4 inline-block text-blue-600 hover:underline">Clear all filters</a>
                        </div>
                    <?php endif; ?>

                </div>
            </main>
        </div>
    </div>

    <!-- 3. FOOTER PLACEHOLDER -->
    <div id="footer-placeholder"></div>

    <!-- 4. JAVASCRIPT -->
    <script src="assets/js/main.js"></script>

</body>
</html>