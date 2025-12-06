<?php
include 'config.php';

// Strict Filter: Audience must start with 'Men' or be exactly 'Men' (avoiding 'Women' substring issue)
// Also ensure Category is PU
$whereClauses = ["(a.name = 'Men' OR a.name = 'Unisex')", "c.name LIKE '%PU%'"];

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
    <title>Men's PU Slippers - Premium Comfort | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50">

    <?php include 'header.php'; ?>

    <div class="relative h-72 bg-gray-900 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/333/gold?text=PU+Comfort+Banner" alt="Men's PU Slippers" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-90"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-wider uppercase shadow-sm">Premium PU Comfort</h1>
            <p class="text-amber-400 mt-2 font-medium text-lg">Soft on feet, tough on streets.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-24 border border-gray-200">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2 text-gray-800">Refine</h3>
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-700 mb-2">Category</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li><label class="flex items-center text-cyan-700 font-bold bg-cyan-50 p-2 rounded"><input type="checkbox" class="mr-2 rounded text-cyan-600" checked disabled> PU Slippers</label></li>
                            <li><a href="men-eva-sports.php" class="flex items-center hover:text-cyan-600 pl-2"><span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> EVA / Sports</a></li>
                            <li><a href="men-hawai-fabrication.php" class="flex items-center hover:text-cyan-600 pl-2"><span class="w-4 h-4 border border-gray-300 rounded mr-2 inline-block"></span> Fabrication</a></li>
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="w-full lg:w-3/4">
                <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r shadow-sm">
                    <h2 class="text-amber-800 font-bold text-lg">The PU Collection</h2>
                    <p class="text-amber-700 text-sm">Premium range of Gents PU slippers for durability and support.</p>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-500 text-sm">Showing <?php echo $result->num_rows; ?> Products</p>
                    <form id="sortForm" method="GET">
                        <select name="sort" onchange="document.getElementById('sortForm').submit()" class="border-gray-300 rounded-md text-sm focus:ring-cyan-500 focus:border-cyan-500 p-2 border">
                            <option value="newest" <?php echo $sortOption=='newest'?'selected':''; ?>>Sort by: Featured</option>
                            <option value="price_low" <?php echo $sortOption=='price_low'?'selected':''; ?>>Price: Low to High</option>
                            <option value="price_high" <?php echo $sortOption=='price_high'?'selected':''; ?>>Price: High to Low</option>
                        </select>
                    </form>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group border border-gray-100">
                            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                                <div class="aspect-[4/3] overflow-hidden bg-gray-50">
                                    <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=Product'">
                                </div>
                                <div class="p-4">
                                    <p class="text-xs text-amber-600 font-bold uppercase"><?php echo $row['brand_name']; ?></p>
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
            </main>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>