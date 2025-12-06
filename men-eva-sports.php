<?php
include 'config.php';

// Strict Filter: Men OR Unisex
$whereClauses = ["(a.name = 'Men' OR a.name = 'Unisex')", "(c.name LIKE '%EVA%' OR c.name LIKE '%Sport%')"];

$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        LEFT JOIN audiences a ON p.audience_id = a.id
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Men's EVA & Sports | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-indigo-50">

    <?php include 'header.php'; ?>

    <div class="relative h-72 bg-indigo-900 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/1e1b4b/white?text=Active+EVA+Banner" alt="Men's Sports" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 via-transparent to-indigo-900 opacity-90"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-widest uppercase shadow-sm italic">Lightweight Speed</h1>
            <p class="text-indigo-200 mt-2 font-medium text-lg">Men's Sports Shoes & Sliders.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6 bg-indigo-100 border-l-4 border-indigo-600 p-4 rounded-r shadow-sm">
            <h2 class="text-indigo-900 font-bold text-lg">Indus Prime Collection</h2>
            <p class="text-indigo-800 text-sm">High-quality EVA injected footwear for durability and athletic style.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group border border-gray-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-105 transition-transform" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=Product'">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-indigo-600 font-bold uppercase"><?php echo $row['brand_name']; ?></p>
                            <h3 class="text-gray-900 font-medium"><?php echo $row['name']; ?></h3>
                            <p class="text-gray-800 font-bold mt-1">₹<?php echo $row['min_price']; ?></p>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 text-gray-500">No products found.</div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>