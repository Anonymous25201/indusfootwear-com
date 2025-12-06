<?php
include 'config.php';

// 1. Setup Query Logic
$whereClauses = ["a.name = 'Women'"]; // Force audience to Women

// Filter by Brand
if (isset($_GET['brand'])) {
    $whereClauses[] = "p.brand_id = " . intval($_GET['brand']);
}
// Filter by Category
if (isset($_GET['cat'])) {
    $whereClauses[] = "p.category_id = " . intval($_GET['cat']);
}

$whereSQL = "WHERE " . implode(' AND ', $whereClauses);

// Sorting
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

// Main Query
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
    <title>Women's Collection | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-pink-50">

<?php include 'header.php'; ?>

    <!-- Banner -->
    <div class="relative h-64 bg-pink-900 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/831843/white?text=Womens+Banner" alt="Women's Collection" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-r from-pink-900 via-transparent to-pink-900 opacity-70"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-4xl md:text-5xl font-bold text-white tracking-widest uppercase shadow-sm">Women's Collection</h1>
            <p class="text-pink-100 mt-2">Grace in Every Step</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24 border border-pink-100">
                    <div class="flex justify-between items-center mb-4 border-b border-pink-100 pb-2">
                        <h3 class="font-bold text-lg text-pink-700">Filters</h3>
                        <a href="women.php" class="text-xs text-pink-500 hover:underline">Reset</a>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Category</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $c_res = $conn->query("SELECT * FROM categories");
                            while($c = $c_res->fetch_assoc()):
                                $act = (isset($_GET['cat']) && $_GET['cat'] == $c['id']) ? 'text-pink-600 font-bold' : 'hover:text-pink-600';
                            ?>
                            <li><a href="women.php?cat=<?php echo $c['id']; ?>" class="flex items-center <?php echo $act; ?>"><span class="w-4 h-4 border border-pink-300 rounded mr-2 inline-block"></span> <?php echo $c['name']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Brand</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <?php 
                            $b_res = $conn->query("SELECT * FROM brands");
                            while($b = $b_res->fetch_assoc()):
                                $act = (isset($_GET['brand']) && $_GET['brand'] == $b['id']) ? 'text-pink-600 font-bold' : 'hover:text-pink-600';
                            ?>
                            <li><a href="women.php?brand=<?php echo $b['id']; ?>" class="flex items-center <?php echo $act; ?>"><span class="w-4 h-4 border border-pink-300 rounded mr-2 inline-block"></span> <?php echo $b['name']; ?></a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Grid -->
            <main class="w-full lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Products</p>
                    <form id="sortForm" method="GET">
                        <?php if(isset($_GET['cat'])): ?><input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>"><?php endif; ?>
                        <?php if(isset($_GET['brand'])): ?><input type="hidden" name="brand" value="<?php echo $_GET['brand']; ?>"><?php endif; ?>
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-pink-500 focus:border-pink-500 p-2 border">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Newest</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="aspect-[4/3] overflow-hidden">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform">
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-pink-600 font-semibold uppercase"><?php echo $row['brand_name']; ?></p>
                                    <h3 class="text-gray-900 font-medium"><?php echo $row['name']; ?></h3>
                                    <p class="text-gray-800 font-bold mt-1">₹<?php echo $row['min_price']; ?></p>
                                </div>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center py-10 text-gray-500">No ladies' products found.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>