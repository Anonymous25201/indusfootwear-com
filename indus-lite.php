<?php
include 'config.php';

$whereClauses = ["b.name = 'Induslite'"];

$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
$orderBy = "p.created_at DESC";
if($sortOption == 'price_low') $orderBy = "min_price ASC";
if($sortOption == 'price_high') $orderBy = "min_price DESC";

$sql = "SELECT p.*, b.name as brand_name, 
        (SELECT MIN(mrp) FROM product_variants WHERE product_id = p.id) as min_price
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id 
        WHERE " . implode(' AND ', $whereClauses) . "
        ORDER BY $orderBy";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Induslite - Everyday Comfort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-teal-50 theme-teal">

    <?php include 'header.php'; ?>

    <div class="relative bg-teal-900 h-64 md:h-80 flex items-center justify-center overflow-hidden">
        <img src="https://placehold.co/1920x600/0f766e/white?text=Induslite+Pattern" class="absolute inset-0 w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 bg-gradient-to-r from-teal-900 via-transparent to-teal-900 opacity-70"></div>
        <div class="relative z-10 text-center px-4 animate-fade-in-up">
            <div class="inline-block bg-white/90 p-3 rounded-lg mb-4 shadow-lg">
                <img src="assets/img/induslite.jpg" class="h-20 md:h-24 w-auto object-contain">
            </div>
            <h1 class="text-3xl md:text-5xl font-bold text-white tracking-widest uppercase">Walk Light</h1>
            <p class="text-teal-100 mt-2 font-medium tracking-wide text-lg">Everyday Comfort for Everyone</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Lightweight & Durable</h2>
            <p class="text-gray-600">Featuring our popular range of Hawai chappals and lightweight EVA footwear.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-transparent hover:border-teal-100">
                    <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                        <div class="relative aspect-[4/3] overflow-hidden bg-white">
                            <img src="<?php echo $row['image_path']; ?>" class="w-full h-full object-contain group-hover:scale-110 transition-transform" onerror="this.src='https://placehold.co/400x400/f5f5f5/333?text=Product'">
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-teal-600 font-semibold uppercase mb-1"><?php echo $row['brand_name']; ?></p>
                            <h3 class="text-gray-900 font-medium text-sm mb-2"><?php echo $row['name']; ?></h3>
                            <span class="text-lg font-bold text-gray-800">₹<?php echo $row['min_price']; ?></span>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12 text-gray-500">No products found for Induslite.</div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>
</html>