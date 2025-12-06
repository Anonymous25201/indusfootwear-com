<?php
include 'config.php';

// Filter: Women + PU
$whereClauses = ["a.name LIKE '%Women%'", "c.name LIKE '%PU%'"];

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
    <title>Women's PU Slippers - Fashion & Comfort | Indus Footwear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-pink-50">

    <?php include 'header.php'; ?>

    <div class="relative h-72 bg-rose-900 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x400/881337/white?text=Ladies+PU+Fashion" alt="Women's PU" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-rose-900 via-transparent to-transparent opacity-90"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-widest uppercase shadow-sm">Chic & Comfortable</h1>
            <p class="text-pink-200 mt-2 font-medium text-lg">Ladies' PU Slippers.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r shadow-sm">
            <h2 class="text-rose-800 font-bold text-lg">The Indus Originals Collection</h2>
            <p class="text-rose-700 text-sm">Our Ladies' PU range blends traditional elegance with modern comfort.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group border border-gray-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="aspect-[4/3] overflow-hidden bg-white">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform" onerror="this.src='https://placehold.co/400x400/f0f0f0/333?text=Product'">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-rose-600 font-bold uppercase"><?php echo $row['brand_name']; ?></p>
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